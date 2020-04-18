<?php

namespace App\Services\User;

use App\Models\Order;
use App\Events\Order\Created;
use App\Events\Order\Updated;

class OrderService
{
    public function list()
    {
        return auth()->user()->orders()->get();
    }

    public function get(Order $order)
    {
        return Order::with(['collectionPoint', 'collectionPointTimeSlot'])
                    ->where('id', $order->id)
                    ->get();
    }

    public function create($data)
    {
        $user = auth()->user();

        $order = $user->orders()->create($data);

        event(new Created($order));

        return $order;
    }

    public function update(Order $order, $data)
    {
        $order->update($data);

        event(new Updated($order));

        return $order->fresh();
    }

    public function delete(Order $order)
    {
        $order->delete();
    }

    public function getFillable($collection)
    {
        return $collection->only(
            with((new Order())->getFillable())
        );
    }
}
