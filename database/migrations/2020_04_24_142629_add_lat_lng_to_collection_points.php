<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLatLngToCollectionPoints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('collection_points', function (Blueprint $table) {
            // defaults to London
            $table->float('lat', 10, 6)->default('51.509865')->after('post_code');
            $table->float('lng', 10, 6)->default('-0.118092')->after('lat');
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
            $table->dropColumn(['lat', 'lng']);
        });
    }
}
