<?php

namespace App\Services\Charity;

use App\Models\Charity;
use App\Events\Charity\Updated;
use App\Events\Charity\Created;

class CharityService
{
    public function get()
    {
        $user = auth()->user();

        return $user->charities->first();
    }

    public function create($data = [])
    {
        $charity = Charity::create([
            "name"                  => $data["name"],
            "registration_number"   => $data["registration_number"] ?? null,
            "max_delivery_capacity" => $data["max_delivery_capacity"] ?? 0,
        ]);

        event(new Created($charity));

        return $charity;
    }

    public function update(Charity $charity, $data)
    {
        $charity->update([
            'name'                  => $data['name'] ?? $charity->name,
            'registration_number'   => $data['registration_number'] ?? $charity->registration_number,
            'max_delivery_capacity' => $data['max_delivery_capacity'] ?? $charity->max_delivery_capacity,
        ]);

        event(new Updated($charity));

        return $charity->fresh();
    }

    public function getFillable($collection)
    {
        return $collection->only(
            with((new Charity())->getFillable())
        );
    }
}
