<?php

namespace App\Services\All;

use Illuminate\Support\Facades\Http;

class PostcodeService
{
    public function __construct()
    {
        $this->base_url = "http://api.postcodes.io/postcodes";
    }

    public function validate($postCode)
    {
        return Http::get("{$this->base_url}/{$postCode}/validate")->json();
    }

    public function get($postCode)
    {
        return Http::get("{$this->base_url}/{$postCode}")->json();
    }

    public function getLatLongForPostCode($postCode)
    {
        $response = $this->get($postCode);
        if (isset($response["error"])) return $response;

        return [
            "latitude" => $response["result"]["latitude"],
            "longitude" => $response["result"]["longitude"],
        ];
    }
}
