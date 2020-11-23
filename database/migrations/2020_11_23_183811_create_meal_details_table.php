<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMealDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meal_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("collection_point_id");
            $table->text("type_of_meal");
            $table->integer("halal_qty");
            $table->integer("vegetarian_qty");
            $table->integer("vegan_qty");
            $table->integer("gluten_free_qty");
            $table->integer("nut_free_qty");
            $table->string("description");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meal_details');
    }
}
