<?php

namespace App\Services\Charity;

use App\Models\Charity;

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
                                 $query->whereDate('required_date', today()->format('Y-m-d'));
                             },
                         ])
                         ->whereIn('id', $user->charities->pluck('id'))
                         ->first();

        return $result;
    }
}
