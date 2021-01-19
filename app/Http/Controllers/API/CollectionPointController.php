<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\User\CollectionPointService;
use App\Services\CollectionPoint\CollectionPointService as MainCollectionPointService;
use App\Http\Requests\API\User\AuthenticatedRequest;
use App\Http\Requests\API\Charity\AuthenticatedRequest as CharityAuthenticatedRequest;
use App\Services\All\PostcodeService;
use App\Models\CollectionPoint;
use App\Models\MealDetails;
use Illuminate\Http\Response;

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

    public function getMealDetails($id, AuthenticatedRequest $request, MainCollectionPointService $collectionPointService) {

        return response()->json([
            'status' => 'success',
            'data'   => [
                'collection_point' => $collectionPointService->getMealDetails($id)
            ]
        ]);
    }

    public function updateMealDetails ($id, AuthenticatedRequest $request, MainCollectionPointService $collectionPointService) {

        foreach ($request->all() as $value) {
            if($value["type_of_meal"] !== MealDetails::HOT_FOOD && $value["type_of_meal"] !== MealDetails::HOME_ESSENTIALS && $value["type_of_meal"] !== MealDetails::SCHOOL_MEAL ) {
                 return response()->json([
                    'status' => 'error',
                    'data'   => [],
                    "message" => "Provide valid type_of_meal, valid type_of_meal are: " . MealDetails::HOT_FOOD . ", " .  MealDetails::SCHOOL_MEAL . ", " . MealDetails::HOME_ESSENTIALS
                ], Response::HTTP_BAD_REQUEST );
            }   
        }


        return response()->json([
            'status' => 'success',
            'data'   => [
                'collection_point' => $collectionPointService->updateMealDetails($id, $request->all())
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

    public function update($id, CharityAuthenticatedRequest $request, MainCollectionPointService $collectionPointService) {
        $collection_points = auth()->user()->charities->map->collectionPoints->flatten();
        if(!$collection_points->contains("id", $id)) {
            return response()->json([
                'status' => 'error',
                'data'   => [],
                "message" => "You are not part of this charity so you are not authorized to update this collection point. "
            ], Response::HTTP_UNAUTHORIZED );
        }

        $collection_point =  $collection_points->firstWhere('id', $id);
        $result = $collectionPointService->update($collection_point, $request->all());

        return response()->json([
            'status' => 'success',
            'data'   => $result,
        ], Response::HTTP_OK );
    }
}
