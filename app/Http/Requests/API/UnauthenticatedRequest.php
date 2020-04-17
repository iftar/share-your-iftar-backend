<?php

namespace App\Http\Requests\API;

use App\Http\Requests\API\Request as APIRequest;

class UnauthenticatedRequest extends APIRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [];
    }
}
