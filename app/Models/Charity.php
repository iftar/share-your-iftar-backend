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
        return $this->hasManyThrough(CollectionPoint::class, CharityCollectionPoint::class);
    }

    public function users()
    {
        return $this->hasManyThrough(User::class, CharityUser::class);
    }
}
