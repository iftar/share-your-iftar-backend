<?php

namespace App\Http\Requests\API\User;

use App\Http\Requests\API\UnauthenticatedRequest;

class PasswordResetRequest extends UnauthenticatedRequest
{
    public function rules()
    {
        return [
            'email' => 'required|email',
        ];
    }
}
