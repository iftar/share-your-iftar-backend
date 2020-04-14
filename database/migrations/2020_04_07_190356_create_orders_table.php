<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');

            // order details
            $table->string('type')->default('collection');
            $table->unsignedInteger('quantity');
            $table->date('required_date');
            $table->string('collection_point_id');
            $table->string('collection_timeslot_id')->nullable(); // only needed for collection

            // user details
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');

            // only needed for delivery
            $table->string('phone')->nullable();
            $table->string('address_line_1')->nullable();
            $table->string('address_line_2')->nullable();
            $table->string('town')->nullable();
            $table->string('county')->nullable();
            $table->string('post_code')->nullable();

            $table->text('notes')->nullable();
            $table->string('status')->default('accepted');
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
        Schema::dropIfExists('orders');
    }
}
