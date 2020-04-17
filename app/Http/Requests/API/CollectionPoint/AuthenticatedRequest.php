<?php

namespace App\Http\Requests\API\CollectionPoint;

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
            && $user->isType('collection-point')
            && $user->collectionPointUser
            && $user->collectionPoint();
    }

    public function rules()
    {
        return [];
    }
}
