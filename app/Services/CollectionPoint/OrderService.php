<?php

namespace App\Services\CollectionPoint;

use App\Models\Order;

class OrderService
{
    public function list()
    {
        return Order::paginate(15);
    }
}
