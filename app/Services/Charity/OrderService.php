<?php

namespace App\Services\Charity;

use App\Models\Order;

class OrderService
{
    public function list()
    {
        return Order::paginate(15);
    }
}
