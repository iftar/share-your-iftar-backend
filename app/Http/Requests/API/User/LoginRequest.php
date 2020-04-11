<?php

namespace App\Http\Requests\API\User;

use App\Http\Requests\API\Request;

class LoginRequest extends Request
{
    public function rules()
    {
        return [
            'email'    => 'required',
            'password' => 'required'
        ];
    }
}
