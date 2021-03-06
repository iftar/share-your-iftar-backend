<?php

namespace App\Services\CollectionPoint;

use App\Models\CollectionPoint;
use App\Events\CollectionPoint\Created;
use App\Events\CollectionPoint\Updated;

class CollectionPointService
{
    public function get()
    {
        $user = auth()->user();

        return $user->collectionPoints->first();
    }

    public function create($data)
    {
        $collectionPoint = CollectionPoint::create([
            "name"               => $data["name"],
            "address_line_1"     => $data["address_line_1"],
            "address_line_2"     => $data["address_line_2"],
            "city"               => $data["city"],
            "county"             => $data["county"],
            "post_code"          => $data["post_code"],
            "max_daily_capacity" => $data["max_daily_capacity"],
        ]);

        event(new Created($collectionPoint));

        return $collectionPoint;
    }

    public function update(CollectionPoint $collectionPoint, $data)
    {
        $collectionPoint->update([
            'name'               => $data['name'] ?? $collectionPoint->name,
            'address_line_1'     => $data['address_line_1'] ?? $collectionPoint->address_line_1,
            'address_line_2'     => $data['address_line_2'] ?? $collectionPoint->address_line_2,
            'city'               => $data['city'] ?? $collectionPoint->city,
            'county'             => $data['county'] ?? $collectionPoint->county,
            'post_code'          => $data['post_code'] ?? $collectionPoint->post_code,
            'max_daily_capacity' => $data['max_daily_capacity'] ?? $collectionPoint->max_daily_capacity,
        ]);

        event(new Updated($collectionPoint));

        return $collectionPoint->fresh();
    }

    public function getFillable($collection)
    {
        return $collection->only(
            with((new CollectionPoint())->getFillable())
        );
    }
}
