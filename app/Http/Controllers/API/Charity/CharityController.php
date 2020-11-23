<?php

namespace App\Http\Controllers\API\Charity;

use App\Http\Controllers\Controller;
use App\Services\Charity\CharityService;
use App\Http\Requests\API\Charity\UpdateRequest;
use App\Http\Requests\API\Charity\AuthenticatedRequest;

class CharityController extends Controller
{
    public function index(AuthenticatedRequest $request, CharityService $charityService)
    {
        return response()->json([
            'status' => 'success',
            'data'   => [
                'charity' => $charityService->get()
            ]
        ]);
    }

    public function show($id, AuthenticatedRequest $request, CharityService $charityPointService) {
         return response()->json([
            'status' => 'success',
            'data'   => [
                'charity' => $charityPointService->show($id)
            ]
        ]);
    }

    public function update(Charity $id, AuthenticatedRequest $request, CharityService $CharityService)
    {
        $charity = $CharityService->update($id, $CharityService->getFillable($request));

        return response()->json([
            'status' => 'success',
            'data'   => [
                'charity' => $charity
            ]
        ]);
    }
}
