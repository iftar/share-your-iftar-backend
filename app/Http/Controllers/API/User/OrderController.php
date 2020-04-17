<?php

namespace App\Http\Controllers\API\User;

use App\Services\User\OrderService;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\User\AuthenticatedRequest;
use App\Http\Requests\API\User\StoreOrderAuthenticatedRequest;

class OrderController extends Controller
{
    public function index(AuthenticatedRequest $request, OrderService $orderService)
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

    public function store(StoreOrderAuthenticatedRequest $request, OrderService $orderService)
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
