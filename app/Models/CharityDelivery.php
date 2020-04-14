<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CharityDelivery extends Model
{
    //
    protected $table = 'charity_deliveries';

    protected $fillable = [
        'delivery_date',
        'collection_point_id',
        'collection_time_slot_id',
    ];

    protected $casts = [
        'delivery_date' => 'date',
    ];
}
