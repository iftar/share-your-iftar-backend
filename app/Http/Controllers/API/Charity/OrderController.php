<?php

namespace App\Http\Controllers\API\Charity;

use Illuminate\Http\Request;
use App\Services\Charity\OrderService;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index(OrderService $orderService)
    {
        return response()->json([
            'status' => 'success',
            'data'   => $orderService->list()
        ]);
    }

    
}
