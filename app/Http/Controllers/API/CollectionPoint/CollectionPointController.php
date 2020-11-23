<?php

namespace App\Http\Controllers\API\CollectionPoint;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\CollectionPoint\UpdateRequest;
use App\Services\CollectionPoint\CollectionPointService;
use App\Http\Requests\API\CollectionPoint\AuthenticatedRequest;
use App\Models\CollectionPoint;

class CollectionPointController extends Controller
{
    public function index(AuthenticatedRequest $request, CollectionPointService $collectionPointService)
    {
        return response()->json([
            'status' => 'success',
            'data'   => [
                'collection_point' => $collectionPointService->get()
            ]
        ]);
    }

    public function getMealDetails(CollectionPoint $collectionPoint, AuthenticatedRequest $request, CollectionPointService $collectionPointService) {

        return response()->json([
            'status' => 'success',
            'data'   => [
                'collection_point' => $collectionPointService->getMealDetails($collectionPoint)
            ]
        ]);
    }

    public function updateMealDetails (CollectionPoint $collection_point_id, CollectionPointService $collectionPointService) {


        return response()->json([
            'status' => 'success',
            'data'   => [
                'collection_point' => $collectionPointService->get($id)
            ]
        ]);
    }

    public function update(UpdateRequest $request, CollectionPointService $collectionPointService)
    {
        $collectionPoint = auth()->user()->collectionPoint();
        $collectionPoint = $collectionPointService->update($collectionPoint, $collectionPointService->getFillable($request));

        return response()->json([
            'status' => 'success',
            'data'   => [
                'collection_point' => $collectionPoint
            ]
        ]);
    }
}
