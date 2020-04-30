<?php

namespace App\Services\Admin;

use App\Models\Order;

class OrderService
{
    public function getOrdersToday()
    {
        return Order::where('required_date', today())
            ->with(['collectionPoint','collectionPointTimeSlot']) 
            ->get();
    }
}
