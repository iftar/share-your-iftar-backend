<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\User\CollectionPointService;
use App\Http\Requests\API\User\AuthenticatedRequest;
use App\Services\All\PostcodeService;

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

    public function indexNearMe(AuthenticatedRequest $request, CollectionPointService $collectionPointService, PostcodeService $postcodeService)
    {
        $postCode = $request->input('postcode');

        if( !$postCode)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Postcode paramaters are required.',
            ]);
        }

        $userLocation = $postcodeService->getLatLongForPostCode($postCode);

        if( isset($userLocation["error"]) )
        {
            return response()->json([
                'status' => 'error',
                'message' => $userLocation["error"],
            ]);
        }

        return response()->json([
            'status' => 'success',
            'data'   => [
                'collection_points' => $collectionPointService->listNearLatLong(
                    $userLocation["latitude"], $userLocation["longitude"]
                )
            ]
        ]);
    }

    public function show($id, AuthenticatedRequest $request, CollectionPointService $collectionPointService)
    {
        return response()->json([
            'status' => 'success',
            'data'   => [
                'collection_point' => $collectionPointService->get($id)
            ]
        ]);
    }

    public function canDeliverToLocation($collectionPointId, AuthenticatedRequest $request, CollectionPointService $collectionPointService, PostcodeService $postcodeService)
    {
        $postCode = $request->input('postcode');

        if( !$postCode)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Postcode paramaters are required.',
            ]);
        }

        $userLocation = $postcodeService->getLatLongForPostCode($postCode);

        if( isset($userLocation["error"]) )
        {
            return response()->json([
                'status' => 'error',
                'message' => $userLocation["error"],
            ]);
        }

        $canDeliverToLocation = $collectionPointService->canDeliverToLocation(
            $collectionPointId, $userLocation["latitude"], $userLocation["longitude"]
        );

        return response()->json([
            'status' => 'success',
            'data'   => [
                'can_deliver_to_location' => $canDeliverToLocation,
            ]
        ]);
    }
}
