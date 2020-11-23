<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollectionPointDietaryRequirements extends Model
{
    public function collectionPoint()
    {
        return $this->belongsTo(CollectionPoint::class);
    }

    public function dietary_requirements()
    {
        return $this->hasMany(DietaryRequirements::class);
    }
}
