<?php

namespace App\Http\Controllers\API\CollectionPoint;

use Illuminate\Http\Request;
use App\Services\CollectionPoint\OrderService;
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

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
