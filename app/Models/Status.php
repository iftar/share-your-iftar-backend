<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'statuses';

    protected $statuses = [
        'awaiting_acceptance',
        'order_accepted',
        'order_declined',
        'order_pickup_accepted',
        'order_delivery_accepted',
        'order_delivery_in_progress',
        'order_delivery_picked_up',
        'waiting_for_acceptance',
    ];

    protected $fillable = [
        'order_id',
        'pickup_id',
        'delivery_id',
        'status'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function pickup()
    {
        return $this->belongsTo(Pickup::class);
    }

    public function delivery()
    {
        return $this->belongsTo(Delivery::class);
    }
}
