<?php

namespace App\Services\Charity;

use App\Models\Charity;

class CharityService
{
    public function create($data = [])
    {
        return Charity::create([
          "name"                  => $data["name"],
          "registration_number"   => $data["registration_number"],
          "max_delivery_capacity" => $data["max_delivery_capacity"],
        ]);
    }

    public function update(Charity $charity, $data = [])
    {
        if (isset($data['name'])) $charity->name = $data['name'];
        if (isset($data['registration_number'])) $charity->registration_number = $data['registration_number'];
        if (isset($data['max_delivery_capacity'])) $charity->max_delivery_capacity = $data['max_delivery_capacity'];

        $charity->save();

        return $charity;
    }
}
