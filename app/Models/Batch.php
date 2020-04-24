<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $table = 'batches';

    protected $fillable = [
        'collection_point_id',
        'charity_id',
        'csv'
    ];

    public function batchOrders()
    {
        return $this->hasMany(BatchOrder::class);
    }

    public function charity()
    {
        return $this->belongsTo(Charity::class);
    }

    public function collectionPoint()
    {
        return $this->belongsTo(CollectionPoint::class);
    }
}
