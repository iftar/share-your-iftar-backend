<?php

namespace App\Http\Controllers\API;

use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Services\PasswordResetService;
use App\Http\Requests\API\User\PasswordResetRequest;

class PasswordResetController extends Controller
{
    public function index(PasswordResetRequest $request, PasswordResetService $passwordResetService, UserService $userService)
    {
        if ($userService->exists($request->input('email'))) {
            $passwordResetService->sendResetEmail($request->input('email'));
        }

        return response()->json([
            'status' => 'success',
            'data'   => [
                'message' => 'A password reset email has been sent if an account is registered with the given email'
            ]
        ]);
    }
}
