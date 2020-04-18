<?php

namespace App\Services\CollectionPoint;

use App\Models\CollectionPoint;
use App\Models\CollectionPointTimeSlot;

class OrderService
{
    public function get()
    {
        $result = [
            'user_pickup'    => [],
            'charity_pickup' => []
        ];

        /** @var CollectionPoint $userCollectionPoint */
        $userCollectionPoint = auth()->user()->collectionPoints->first();

        $collectionTimeSlots = CollectionPointTimeSlot::where('collection_point_id', $userCollectionPoint->id)
                                                      ->with([
                                                          'orders' => function ($query) {
                                                              $query->whereDate('required_date', today()->format('Y-m-d'));
                                                          }
                                                      ])->get();

        foreach ($collectionTimeSlots as $timeSlot) {
            $result[$timeSlot->type][] = $timeSlot;
        }

        return $result;
    }
}
