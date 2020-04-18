<?php

namespace App\Models;

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
}
