<?php

namespace App\Http\Requests\API\User;

class UpdateRequest extends AuthenticatedRequest
{
    public function rules()
    {
        return [
            'email'    => 'required|email',
            'password' => 'required',
        ];
    }
}
