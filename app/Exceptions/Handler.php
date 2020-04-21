<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param \Throwable $exception
     *
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        if (app()->bound('sentry') && $this->shouldReport($exception)) {
            app('sentry')->captureException($exception);
        }

        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable               $exception
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        $exception = $this->prepareException($exception);

        if ($exception instanceof HttpResponseException) {
            return $exception->getResponse();
        } elseif ($exception instanceof AuthenticationException) {
            return $this->unauthenticated($request, $exception);
        } elseif ($exception instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($exception, $request);
        } elseif ($exception instanceof AccessDeniedHttpException) {
            return $this->accessDenied($request, $exception);
        } elseif ($exception instanceof MethodNotAllowedHttpException) {
            return $this->invalidMethod($request, $exception);
        }

        if ($request->wantsJson()) {
            return $this->jsonRender($request, $exception);
        }

        return $this->prepareResponse($request, $exception);
    }

    protected function jsonRender($request, Throwable $exception)
    {
        $response = [
            'status'  => 'error',
            'message' => 'Sorry, something went wrong'
        ];

        if (config('app.debug')) {
            $response['exception']   = get_class($exception);
            $response['message']     = $exception->getMessage();
            $response['stack_trace'] = $exception->getTrace();
        }

        $status = $this->isHttpException($exception) ? $exception->getStatusCode() : Response::HTTP_BAD_REQUEST;

        return response()->json($response, $status);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Unauthenticated'
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $this->prepareResponse($request, $exception);
    }

    protected function accessDenied($request, AccessDeniedHttpException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Access Denied'
            ], Response::HTTP_FORBIDDEN);
        }

        return $this->prepareResponse($request, $exception);
    }

    protected function invalidMethod($request, MethodNotAllowedHttpException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Invalid Method / URL'
            ], Response::HTTP_METHOD_NOT_ALLOWED);
        }

        return $this->prepareResponse($request, $exception);
    }
}
