<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollectionPointDaysOpen extends Model
{
    public function collectionPoint()
    {
        return $this->belongsTo(CollectionPoint::class);
    }

    public function days_open()
    {
        return $this->hasMany(DaysOpen::class);
    }
}
