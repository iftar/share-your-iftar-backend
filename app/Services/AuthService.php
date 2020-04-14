<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable;

class AuthService
{
    /**
     * @param User | Authenticatable $user
     *
     * @return mixed
     */
    public function createToken($user)
    {
        $this->revokeAllTokens($user);

        return $user->createToken(config('app.name'));
    }

    public function revokeAllTokens($user)
    {
        foreach ($user->tokens as $token) {
            $token->revoke();
        }
    }

    public function attemptLogin($email, $password)
    {
        return Auth::attempt([
            'email'    => $email,
            'password' => $password
        ]);
    }

    /**
     * @param User | Authenticatable $user
     *
     * @return Authenticatable
     */
    public function login($user)
    {
        Auth::login($user);

        return auth()->user();
    }

    public function validateVerification(User $user, $hash)
    {
        if ( ! hash_equals((string) $user->id, (string) $user->getKey())) {
            return false;
        }

        if ( ! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return false;
        }

        return true;
    }
}
