<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CharityCollectionPointMap extends Model
{
    //
    protected $table = 'charity_collection_point_maps';

    protected $fillable = [
        'charity_id',
        'collection_point_id',
    ];
}
