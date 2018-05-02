<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlaygroundSlotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('playground_slot', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('playground_id')->unsigned();
            $table->integer('slot_id')->unsigned();
            $table->primary(['playground_id','slot_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('playground_slot1');

    }
}
