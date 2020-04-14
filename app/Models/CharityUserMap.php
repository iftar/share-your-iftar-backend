<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CharityUserMap extends Model
{
    //
    protected $table = 'charity_user_maps';

    protected $fillable = [
        'charity_id',
        'user_id',
    ];
}