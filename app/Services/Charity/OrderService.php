<?php

namespace App\Services\Charity;

use App\Models\Order;
use App\Support\Queryable;

class OrderService
{
    protected $queryable;

    public function __construct()
    {
        $this->queryable = new Queryable(Order::class);
    }

    public function queryable()
    {
        return $this->queryable;
    }

    public function get($filters = null, $orderBy = null)
    {
        $result = [];

        $filters = $filters ?: [];

        if ( ! count(preg_grep('/^required_date/i', $filters))) {
            $today     = today()->format('Y-m-d');
            $filters[] = "required_date,$today,=,whereDate";
        }

        $user = auth()->user();

        $charityCollectionPoints = $user->charities->first()->collectionPoints;

        $orders = Order::with('collectionPoint')
                       ->whereIn('collection_point_id', $charityCollectionPoints->pluck('id'))
                       ->whereHas('collectionPointTimeSlot', function ($query) {
                           return $query->where('type', 'charity_pickup');
                       });

        $orders = $this->queryable->filter($orders, $filters);
        $orders = $this->queryable->orderBy($orders, $orderBy);
        $orders = $orders->get();

        foreach ($orders as $order) {
            $type     = $order->collectionPoint->name;
            $timeSlot = $order->collectionPointTimeSlot->start_time . ' - ' . $order->collectionPointTimeSlot->end_time;

            $result[$type][$timeSlot][] = $order;
        }

        return $result;
    }
}
