<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MealDetails extends Model
{
    const SCHOOL_MEAL = "School Meal";
    const HOME_ESSENTIALS = "Home Essentials";
    const HOT_FOOD = "Hot Food";

    public function collection_point() {
    	return $this->belongsTo(Collection::class);
    }
}
