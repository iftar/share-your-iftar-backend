<?php

namespace App\Http\Requests\API\Charity;

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
            && $user->isType('charity')
            && $user->charityUser
            && $user->charity();
    }

    public function rules()
    {
        return [];
    }
}
