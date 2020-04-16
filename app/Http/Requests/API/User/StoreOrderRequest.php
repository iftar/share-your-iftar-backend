<?php

namespace App\Http\Requests\API\User;

use App\Http\Requests\API\Request;

class StoreOrderRequest extends Request
{
    public function rules()
    {
        return [
            'required_date'                 => 'required|date_format:Y-m-d H:i:s',
            'quantity'                      => 'required|numeric|gt:0',
            'collection_point_id'           => 'required|exists:collection_points,id',
            'collection_point_time_slot_id' => 'sometimes|exists:collection_point_time_slots,id',
            'first_name'                    => 'required',
            'last_name'                     => 'required',
            'email'                         => 'required|email',
        ];
    }
}
