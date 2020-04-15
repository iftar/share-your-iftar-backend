<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderBatch extends Model
{
    protected $table = 'order_batches';

    protected $fillable = [
        'date',
        'collection_point_id',
        'collection_point_time_slot_id¬',
        'charity_id',
    ];

    protected $casts = [
        'date' => 'date',
    ];
}
