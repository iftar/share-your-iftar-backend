<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pickup extends Model
{
    //
    protected $table = 'pickups';
    protected $dates = ["pickup_at"];
}
