<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CharityCollectionPoint extends Model
{
    protected $table = 'charity_collection_points';

    protected $fillable = [
        'charity_id',
        'collection_point_id',
    ];

    public function charity()
    {
        return $this->belongsTo(Charity::class);
    }

    public function collectionPoint()
    {
        return $this->belongsTo(CollectionPoint::class);
    }
}
