<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id('schedule_id');
            $table->integer('schedule_index');
            $table->integer('charger_index')->nullable();;
            $table->integer('start');
            $table->integer('finish');
            $table->float('energy_before');
            $table->float('energy_after');
            $table->float('consumption');
            $table->integer('location_start')->unsigned();
            $table->integer('location_finish')->unsigned();
            $table->string('type');
            $table->string('schedule_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
