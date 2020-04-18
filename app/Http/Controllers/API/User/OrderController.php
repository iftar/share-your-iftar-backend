<?php

namespace App\Http\Controllers\API\User;

use App\Models\Order;
use App\Services\User\OrderService;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\User\Order\ShowRequest;
use App\Http\Requests\API\User\Order\StoreRequest;
use App\Http\Requests\API\User\Order\UpdateRequest;
use App\Http\Requests\API\User\Order\DeleteRequest;
use App\Http\Requests\API\User\AuthenticatedRequest;

class OrderController extends Controller
{
    public function index(AuthenticatedRequest $request, OrderService $orderService)
    {
        return response()->json([
            'status' => 'success',
            'data'   => [
                'orders' => $orderService->list()
            ]
        ]);
    }

    public function show(ShowRequest $request, Order $order, OrderService $orderService)
    {
        return response()->json([
            'status' => 'success',
            'data'   => [
                'order' => $orderService->get($order)
            ]
        ]);
    }

    public function store(StoreRequest $request, OrderService $orderService)
    {
        $order = $orderService->create($orderService->getFillable($request));

        return response()->json([
            'status' => 'success',
            'data'   => [
                'order' => $order
            ]
        ]);
    }

    public function update(UpdateRequest $request, OrderService $orderService, Order $order)
    {
        $order = $orderService->update($order, $orderService->getFillable($request));

        return response()->json([
            'status' => 'success',
            'data'   => [
                'order' => $order
            ]
        ]);
    }

    public function destroy(DeleteRequest $request, OrderService $orderService, Order $order)
    {
        $orderService->delete($order);

        return response()->json([
            'status' => 'success',
            'data'   => []
        ]);
    }
}
