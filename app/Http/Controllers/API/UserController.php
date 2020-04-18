<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\User\UpdateRequest;
use App\Http\Requests\API\User\AuthenticatedRequest;

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

    public function update(UpdateRequest $request, UserService $userService, User $user)
    {
        $user = $userService->update($user, $userService->getFillable($request));

        return response()->json([
            'status' => 'success',
            'data'   => [
                'user' => $user
            ]
        ]);
    }
}
