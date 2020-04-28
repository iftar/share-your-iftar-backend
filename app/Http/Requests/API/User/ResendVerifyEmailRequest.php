<?php

namespace App\Http\Requests\API\User;

use App\Http\Requests\API\UnauthenticatedRequest;

class ResendVerifyEmailRequest extends UnauthenticatedRequest
{
    public function rules()
    {
        return [
            'email'    => 'required',
        ];
    }
}
