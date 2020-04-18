<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\User\AuthenticatedRequest;
use App\Services\User\CollectionPointService;

class CollectionPointController extends Controller
{
    //
    public function index(AuthenticatedRequest $request, CollectionPointService $collectionPointService)
    {
        return response()->json([
            'status' => 'success',
            'data'   => [
                'collection_points' => $collectionPointService->list()
            ]
        ]);
    }
}
