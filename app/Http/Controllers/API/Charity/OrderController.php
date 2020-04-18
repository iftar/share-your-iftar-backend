<?php

namespace App\Http\Controllers\API\Charity;

use App\Http\Controllers\Controller;
use App\Services\Charity\OrderService;
use App\Http\Requests\API\Charity\AuthenticatedRequest;

class OrderController extends Controller
{
    public function index(AuthenticatedRequest $request, OrderService $orderService)
    {
        return response()->json([
            'status' => 'success',
            'data'   => [
                'charities' => $orderService->get()
            ]
        ]);
    }
}
