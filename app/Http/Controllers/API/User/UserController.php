<?php

namespace App\Http\Controllers\API\User;

use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\User\AuthenticatedRequest;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function index(AuthenticatedRequest $request, UserService $userService)
    {
        return response()->json([
            'status' => 'success',
            'data'   => [
                'user' => $userService->get()
            ]
        ]);
    }

    public function update(AuthenticatedRequest $request, UserService $userService)
    {
        if ($userService->emailTaken($request->input('email'))) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Email address unavailable'
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = $userService->update($userService->getFillable($request));

        return response()->json([
            'status' => 'success',
            'data'   => [
                'user' => $user
            ]
        ]);
    }
}
