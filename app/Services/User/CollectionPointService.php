<?php

namespace App\Services\User;

use App\Models\CollectionPoint;

class CollectionPointService
{
    public function list()
    {
        return CollectionPoint::with('collectionPointTimeSlots')->paginate(15);
    }
}
