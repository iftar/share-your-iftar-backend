<?php

namespace App\Http\Controllers\API;

use App\Models\CollectionPoint;
use App\Http\Controllers\Controller;
use App\Services\User\CollectionPointService;
use App\Http\Requests\API\User\AuthenticatedRequest;

class CollectionPointController extends Controller
{
    public function index(AuthenticatedRequest $request, CollectionPointService $collectionPointService)
    {
        return response()->json([
            'status' => 'success',
            'data'   => [
                'collection_points' => $collectionPointService->list()
            ]
        ]);
    }

    public function indexNearMe(AuthenticatedRequest $request, CollectionPointService $collectionPointService)
    {
        $userLat = $request->get('lat');
        $userLong = $request->get('long');

        if( !$userLat || !$userLong )
        {
            return response()->json([
                'status' => 'error',
                'message' => 'lat and long paramaters are required.',
            ]);
        }

        return response()->json([
            'status' => 'success',
            'data'   => [
                'collection_points' => $collectionPointService->listNearLatLong($userLat, $userLong)
            ]
        ]);
    }

    public function show(AuthenticatedRequest $request, CollectionPointService $collectionPointService, CollectionPoint $collectionPoint)
    {
        return response()->json([
            'status' => 'success',
            'data'   => [
                'collection_point' => $collectionPointService->get($collectionPoint)
            ]
        ]);
    }
}
