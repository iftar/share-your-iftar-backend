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

    protected $casts = [
        'max_delivery_capacity' => 'integer',
    ];

    public function collectionPoints()
    {
        return $this->belongsToMany(CollectionPoint::class, 'charity_collection_points');
    }

    public function charityUsers()
    {
        return $this->hasMany(CharityUser::class);
    }

    public function batches()
    {
        return $this->hasMany(Batch::class);
    }

    public function notifyAllUsers($notification)
    {
        foreach ($this->charityUsers as $charityUser) {
            $charityUser->user->notify($notification);
        }
    }
}
