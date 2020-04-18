<?php

namespace App\Services\User;

use App\Models\Charity;

class CharityService
{
    public function list()
    {
        return Charity::with('collectionPoints')->paginate(15);
    }
}
