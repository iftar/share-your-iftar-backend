<?php

namespace App\Http\Requests\API\User;

use App\Http\Requests\API\Request as APIRequest;

class AuthenticatedRequest extends APIRequest
{
    public function authorize()
    {
        return auth()->check() && auth()->user()->isApproved();
    }

    public function rules()
    {
        return [];
    }
}
