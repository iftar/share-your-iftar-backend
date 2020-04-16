<?php

namespace App\Http\Controllers\API\Charity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Charity\CharityService;

class CharityController extends Controller
{
    public function index()
    {
        //
        $user = auth()->user();
        return response()->json([
            'status' => 'success',
            'data'   => ['charity' => $user->charity()],
        ]);
    }

    public function update(Request $request, CharityService $charityService)
    {
        //
        $data = [
            "name"                  => $request->input('name'),
            "registration_number"   => $request->input('registration_number'),
            "max_delivery_capacity" => $request->input('max_delivery_capacity'),
        ];

        $charity = auth()->user()->charity();
        $charity = $charityService->update($charity, $data);

        return response()->json([
            'status' => 'success',
            'data'   => ['charity' => $charity],
        ]);
    }
}
