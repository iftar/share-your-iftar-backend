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
        return $this->hasManyThrough(User::class, CollectionPointUser::class);
    }

    public function charityCollectionPoint()
    {
        return $this->hasOne(CharityCollectionPoint::class);
    }

    public function charity()
    {
        return $this->charityCollectionPoint->charity;
    }

    public function collectionPointTimeSlots()
    {
        return $this->hasMany(CollectionPointTimeSlot::class);
    }
}
