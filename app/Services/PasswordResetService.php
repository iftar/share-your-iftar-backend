<?php

namespace App\Services;

use App\Events\User\PasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class PasswordResetService
{
    public function sendResetEmail($email)
    {
        $response = $this->broker()->sendResetLink([
            'email' => $email
        ]);

        return $response == Password::RESET_LINK_SENT;
    }

    public function reset(Request $request)
    {
        $credentials = $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );

        $response = $this->broker()->reset($credentials, function (User $user, $password) {
            $user->update([
                'password' => bcrypt($password)
            ]);


            event(new PasswordReset($user->fresh()));
        });

        return $response == Password::PASSWORD_RESET;
    }

    /**
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    protected function broker()
    {
        return Password::broker();
    }
}
