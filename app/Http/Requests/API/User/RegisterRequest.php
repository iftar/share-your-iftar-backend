<?php

namespace App\Http\Requests\API\User;

use App\Http\Requests\API\Request;

class RegisterRequest extends Request
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
