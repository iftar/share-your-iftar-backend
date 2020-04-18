<?php

namespace App\Http\Requests\API\User;

use App\Http\Requests\API\UnauthenticatedRequest;

class RegisterRequest extends UnauthenticatedRequest
{
    public function rules()
    {
        return [
            'email'    => 'required|email',
            'password' => 'required',
            'confirm'  => 'required|same:password',
        ];
    }
}
