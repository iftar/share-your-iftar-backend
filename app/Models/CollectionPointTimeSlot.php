<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollectionPointTimeSlot extends Model
{
    //
    protected $table = 'collection_point_time_slots';

    protected $fillable = [
        'collection_point_id',
        'start_time',
        'end_time',
        'max_capacity',
        'type',
    ];
}
