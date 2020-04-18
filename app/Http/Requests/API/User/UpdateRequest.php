<?php

namespace App\Http\Requests\API\User;

class UpdateRequest extends AuthenticatedRequest
{
    public function authorize()
    {
        return auth()->check()
            && auth()->user()->isApproved()
            && auth()->user()->id == $this->route('user')->id;
    }

    public function rules()
    {
        return [
            'email' => 'required|email',
        ];
    }
}
