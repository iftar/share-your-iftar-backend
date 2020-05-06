<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\OrderService;
use App\Http\Requests\API\Admin\AuthenticatedRequest;
use Illuminate\Support\Facades\Cache;

class OrderController extends Controller
{
    public function index(AuthenticatedRequest $request, OrderService $orderService)
    {
        $cache_key = 'admin_todays_orders';

        $data = Cache::get($cache_key);

        if ( ! $data ) {
            $data = [
                'orders' => $orderService->getOrdersToday(),
                'last_updated' => now('Europe/London')->format('H:m a'),
            ];
            Cache::put($cache_key, $data, 300); // 5 mins
        }

        return response()->json([
            'status' => 'success',
            'data'   => $data
        ]);
    }
}
