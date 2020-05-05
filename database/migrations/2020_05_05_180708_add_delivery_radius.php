<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeliveryRadius extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('collection_points', function (Blueprint $table) {
            //
            $table->unsignedInteger('delivery_radius')->default(3)->after('lng');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('collection_points', function (Blueprint $table) {
            //
            $table->dropColumn('delivery_radius');
        });
    }
}
