<?php

namespace App\Services\Admin;

use App\Models\Order;

class OrderService
{
    public function get()
    {
        return Order::paginate();
    }

    public function getOrdersToday()
    {
        return Order::where('required_date', today())->paginate();
    }
}
