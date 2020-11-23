<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollectionPointMealType extends Model
{
    public function collectionPoint()
    {
        return $this->belongsTo(CollectionPoint::class);
    }

    public function meal_types()
    {
        return $this->hasMany(MealType::class);
    }
}
