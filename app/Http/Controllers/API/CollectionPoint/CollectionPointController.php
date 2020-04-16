<?php

namespace App\Http\Controllers\API\CollectionPoint;

use App\Http\Controllers\Controller;
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

    public function update(Request $request)
    {
        //
    }
}
