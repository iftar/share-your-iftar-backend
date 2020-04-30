<?php

namespace App\Http\Requests\API\Admin;

use App\Http\Requests\API\Request as APIRequest;

class AuthenticatedRequest extends APIRequest
{
    public function authorize()
    {
        if ( ! auth()->check()) {
            return false;
        }

        $user = auth()->user();

        return $user->isApproved()
            && $user->isType('admin');
    }

    public function rules()
    {
        return [];
    }
}
