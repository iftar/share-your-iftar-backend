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
                                                      ])
                                                      ->orderBy('start_time')
                                                      ->get();

        foreach ($collectionTimeSlots as $timeSlot) {
            $result[$timeSlot->type][] = $timeSlot;
        }

        return $result;
    }

    public function getOrdersToday(CollectionPoint $collectionPoint)
    {
        return CollectionPointTimeSlot::where('collection_point_id', $collectionPoint->id)
                                      ->with([
                                          'orders' => function ($query) {
                                              $query->whereDate('required_date', today()->format('Y-m-d'));
                                          }
                                      ])
                                      ->orderBy('start_time')
                                      ->orderBy('type')
                                      ->get();
    }
}
