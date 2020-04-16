<?php

namespace App\Services\User;

use App\Models\Order;
use App\Traits\Queryable;
use App\Events\Order\Created;

class OrderService
{
    use Queryable;

    public function __construct()
    {
        $this->setModel(Order::class);
    }

    public function get($filters = null, $orderBy = null)
    {
        $orders = auth()->user()->orders();

        $orders = $this->applyFilters($orders, $filters);
        $orders = $this->applyOrderBy($orders, $orderBy);

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
