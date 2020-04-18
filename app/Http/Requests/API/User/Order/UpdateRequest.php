<?php

namespace App\Http\Requests\API\User\Order;

use App\Http\Requests\API\User\AuthenticatedRequest;

class UpdateRequest extends AuthenticatedRequest
{
    public function authorize()
    {
        return auth()->check()
            && auth()->user()->isApproved()
            && auth()->user()->orders->pluck('id')->contains($this->route('order')->id);
    }

    public function rules()
    {
        return [
            'required_date'                 => 'required|date_format:Y-m-d H:i:s',
            'quantity'                      => 'required|numeric|gt:0',
            'collection_point_id'           => 'required|exists:collection_points,id',
            'collection_point_time_slot_id' => 'required|exists:collection_point_time_slots,id',
            'first_name'                    => 'required',
            'last_name'                     => 'required',
            'email'                         => 'required|email',
        ];
    }
}
