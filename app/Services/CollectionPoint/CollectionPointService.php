<?php

namespace App\Services\CollectionPoint;

use App\Models\CollectionPoint;

class CollectionPointService
{
    public function create($data = [])
    {
        return CollectionPoint::create([
          "name"                          => $data["name"],
          "address_line_1"                => $data["address_line_1"],
          "address_line_2"                => $data["address_line_2"],
          "city"                          => $data["city"],
          "county"                        => $data["county"],
          "post_code"                     => $data["post_code"],
          "max_daily_capacity"            => $data["max_daily_capacity"],
        ]);
    }

    public function update(CollectionPoint $collectionPoint, $data = [])
    {
        if (isset($data['name'])) $collectionPoint->name = $data['name'];
        if (isset($data['address_line_1'])) $collectionPoint->address_line_1 = $data['address_line_1'];
        if (isset($data['address_line_2'])) $collectionPoint->address_line_2 = $data['address_line_2'];
        if (isset($data['city'])) $collectionPoint->city = $data['city'];
        if (isset($data['county'])) $collectionPoint->county = $data['county'];
        if (isset($data['post_code'])) $collectionPoint->post_code = $data['post_code'];
        if (isset($data['max_daily_capacity'])) $collectionPoint->max_daily_capacity = $data['max_daily_capacity'];

        $collectionPoint->save();

        return $collectionPoint;
    }
}
