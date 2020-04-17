<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Charity extends Model
{
    protected $table = 'charities';

    protected $fillable = [
        'name',
        'registration_number',
        'max_delivery_capacity',
    ];

    public function collectionPoints()
    {
        return $this->belongsToMany(CollectionPoint::class, 'charity_collection_points');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'charity_users');
    }
}
