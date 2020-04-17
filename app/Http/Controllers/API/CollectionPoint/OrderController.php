<?php

namespace App\Http\Controllers\API\CollectionPoint;

use App\Http\Controllers\Controller;
use App\Services\CollectionPoint\OrderService;
use App\Http\Requests\API\CollectionPoint\AuthenticatedRequest;

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
}
