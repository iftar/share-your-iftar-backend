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

    public function get($id)
    {
        return Charity::find($id);
    }

    public function collectionPoints($charity_id)
    {
        return $this->get($charity_id)->collectionPoints();
    }

    public function charityUsers($charity_id)
    {
        return $this->get($charity_id)->users();
    }
}
