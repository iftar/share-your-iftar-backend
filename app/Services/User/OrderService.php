<?php

namespace App\Services\User;

use App\Models\Order;

class OrderService
{
    public function list()
    {
        return Order::paginate(15);
    }
}
