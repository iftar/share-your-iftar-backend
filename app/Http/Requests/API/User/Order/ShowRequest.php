<?php

namespace App\Http\Requests\API\User\Order;

use App\Http\Requests\API\User\AuthenticatedRequest;

class ShowRequest extends AuthenticatedRequest
{
    public function authorize()
    {
        return auth()->check()
            && auth()->user()->isApproved()
            && auth()->user()->orders->pluck('id')->contains($this->route('order')->id);
    }
}
