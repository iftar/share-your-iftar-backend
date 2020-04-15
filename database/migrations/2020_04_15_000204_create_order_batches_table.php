<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_batches', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedInteger('collection_point_id');
            $table->unsignedInteger('collection_time_slot_id');
            $table->unsignedInteger('charity_id')->nullable();
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
        Schema::dropIfExists('order_batches');
    }
}
