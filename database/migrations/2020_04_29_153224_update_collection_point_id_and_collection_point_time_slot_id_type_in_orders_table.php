<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateCollectionPointIdAndCollectionPointTimeSlotIdTypeInOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE orders ALTER COLUMN collection_point_id TYPE INT USING collection_point_id::integer;');
        DB::statement('ALTER TABLE orders ALTER COLUMN collection_point_time_slot_id TYPE INT USING collection_point_time_slot_id::integer;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE orders ALTER COLUMN collection_point_id TYPE VARCHAR USING collection_point_id::varchar;');
        DB::statement('ALTER TABLE orders ALTER COLUMN collection_point_time_slot_id TYPE VARCHAR USING collection_point_time_slot_id::varchar;');
    }
}
