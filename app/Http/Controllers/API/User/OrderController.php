<?php

namespace App\Http\Controllers\API\User;

use Illuminate\Http\Request;
use App\Services\User\OrderService;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\User\StoreOrderRequest;

class OrderController extends Controller
{
    public function index(Request $request, OrderService $orderService)
    {
        return response()->json([
            'status' => 'success',
            'data'   => [
                'orders' => $orderService->get(
                    $request->get('filter'),
                    $request->get('orderBy')
                )
            ]
        ]);
    }

    public function store(StoreOrderRequest $request, OrderService $orderService)
    {
        $order = $orderService->create(
            $orderService->queryable()->getFillable($request)
        );

        return response()->json([
            'status' => 'success',
            'data'   => [
                'order' => $order
            ]
        ]);
    }
}
