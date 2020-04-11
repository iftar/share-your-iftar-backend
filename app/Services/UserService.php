<?php

namespace App\Services;

use App\Models\User;
use App\Events\User\Registered;

class UserService
{
    public function exists($email)
    {
        return User::where('email', $email)->first();
    }

    public function create($data)
    {
        $user = User::create([
            'first_name' => $data['first_name'] ?? null,
            'last_name'  => $data['last_name'] ?? null,
            'email'      => $data['email'],
            'password'   => bcrypt($data['password']),
            'type'       => $data['type'] ?? 'user',
            'status'     => 'approved',
        ]);

        event(new Registered($user));

        return $user;
    }
}
