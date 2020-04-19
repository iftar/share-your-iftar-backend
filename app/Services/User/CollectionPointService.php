<?php

namespace App\Services\User;

use App\Models\CollectionPoint;

class CollectionPointService
{
    public function list()
    {
        return CollectionPoint::with('collectionPointTimeSlots')->paginate(15);
    }

    public function get(CollectionPoint $collectionPoint)
    {
        return CollectionPoint::with(['collectionPointTimeSlots'])
                              ->where('id', $collectionPoint->id)
                              ->first();
    }
}
