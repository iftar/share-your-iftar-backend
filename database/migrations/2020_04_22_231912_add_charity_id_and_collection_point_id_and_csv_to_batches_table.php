<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCharityIdAndCollectionPointIdAndCsvToBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('batches', function (Blueprint $table) {
            $table->unsignedInteger('collection_point_id')->nullable()->after('id');
            $table->unsignedInteger('charity_id')->nullable()->after('collection_point_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('batches', function (Blueprint $table) {
            $table->dropColumn(['collection_point_id', 'charity_id']);
        });
    }
}
