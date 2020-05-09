<?php

namespace App\Services\Charity;

use App\Models\Charity;
use App\Models\CollectionPoint;

class OrderService
{
    public function get()
    {
        $user = auth()->user();

        $result = Charity::with('collectionPoints', 'collectionPoints.collectionPointTimeSlots')
                         ->with([
                             'collectionPoints',
                             'collectionPoints.collectionPointTimeSlots'        => function ($query) {
                                 $query->where('type', 'charity_pickup');
                             },
                             'collectionPoints.collectionPointTimeSlots.orders' => function ($query) {
                                 $query->whereDate('required_date', today('Europe/London')->format('Y-m-d'));
                             },
                         ])
                         ->whereIn('id', $user->charities->pluck('id'))
                         ->first();

        return $result;
    }

    public function getOrdersToday(Charity $charity)
    {
        return CollectionPoint::whereIn('id', $charity->collectionPoints->pluck('id'))
                              ->with([
                                  'orders' => function ($query) {
                                      $query->whereDate('required_date', today('Europe/London')->format('Y-m-d'))
                                            ->whereType('charity_pickup')
                                            ->whereStatus('accepted');
                                  },
                                  'orders.collectionPointTimeSlot'
                              ])
                              ->get();
    }
}
