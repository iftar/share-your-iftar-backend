<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CollectionPoint extends Model
{
    protected $table = 'collection_points';

    protected $fillable = [
        'name',
        'address_line_1',
        'address_line_2',
        'city',
        'county',
        'post_code',
        'max_daily_capacity',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'max_daily_capacity' => 'integer',
    ];

    protected $appends = [
        'available_capacity',
        'accepting_orders',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'collection_point_users');
    }

    public function charity()
    {
        return $this->belongsToMany(Charity::class, 'charity_collection_points');
    }

    public function collectionPointTimeSlots()
    {
        return $this->hasMany(CollectionPointTimeSlot::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getAvailableCapacityAttribute()
    {
        return $this->max_daily_capacity - $this->orders()->whereDate('created_at', Carbon::today())->count();
    }

    public function getAcceptingOrdersAttribute()
    {
        return $this->available_capacity > 0;
    }
}
