<?php

namespace App\Services\User;

use App\Models\Order;
use App\Support\Queryable;
use App\Events\Order\Created;

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
        $orders = auth()->user()->orders();

        $orders = $this->queryable->filter($orders, $filters);
        $orders = $this->queryable->orderBy($orders, $orderBy);

        return $orders->get();
    }

    public function create($data)
    {
        $user = auth()->user();

        $order = $user->orders()->create($data);

        event(new Created($order));

        return $order;
    }
}
