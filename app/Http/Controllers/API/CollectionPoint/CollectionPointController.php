<?php

namespace App\Http\Controllers\API\CollectionPoint;

use App\Http\Controllers\Controller;
use App\Services\CollectionPoint\CollectionPointService;
use Illuminate\Http\Request;

class CollectionPointController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user = auth()->user();
        return response()->json([
            'status' => 'success',
            'data'   => ['collection_point' => $user->collectionPoint()],
        ]);
    }

    public function update(Request $request, CollectionPointService $collectionPointService)
    {
        //
        
        $data = [
            "name"                          => $request->input("name"),
            "address_line_1"                => $request->input("address_line_1"),
            "address_line_2"                => $request->input("address_line_2"),
            "city"                          => $request->input("city"),
            "county"                        => $request->input("county"),
            "post_code"                     => $request->input("post_code"),
            "max_daily_capacity"            => $request->input("max_daily_capacity"),
        ];

        $collectionPoint = auth()->user()->collectionPoint();
        $collectionPoint = $collectionPointService->update($collectionPoint, $data);

        return response()->json([
            'status' => 'success',
            'data'   => ['collection_point' => $collectionPoint],
        ]);
    }
}
