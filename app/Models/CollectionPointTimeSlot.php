<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CollectionPointTimeSlot extends Model
{
    protected $table = 'collection_point_time_slots';

    protected $types = [
        'user_pickup'    => 'User Pickup',
        'charity_pickup' => 'Charity Pickup',
    ];

    protected $fillable = [
        'collection_point_id',
        'start_time',
        'end_time',
        'max_capacity',
        'type',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'collection_point_id' => 'integer',
        'max_capacity'        => 'integer',
    ];

    protected $appends = [
        'available_capacity',
        'accepting_orders',
    ];

    public function collectionPoint()
    {
        return $this->belongsTo(CollectionPoint::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getAvailableCapacityAttribute()
    {
        return $this->max_capacity - $this->orders()->whereDate('created_at', Carbon::today())->sum('quantity');
    }

    public function getAcceptingOrdersAttribute()
    {
        return $this->available_capacity > 0;
    }
}
