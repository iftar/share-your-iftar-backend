<?php

namespace App\Services\CollectionPoint;

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

        $userCollectionPoint = auth()->user()->collectionPoint();

        $orders = Order::where('collection_point_id', $userCollectionPoint->id);
        $orders = $this->queryable->filter($orders, $filters);
        $orders = $this->queryable->orderBy($orders, $orderBy);
        $orders = $orders->get();

        foreach ($orders as $order) {
            $type     = $order->collectionPointTimeSlot->type;
            $timeSlot = $order->collectionPointTimeSlot->start_time . ' - ' . $order->collectionPointTimeSlot->end_time;

            $result[$type][$timeSlot] = $order;
        }

        return $result;
    }
}
