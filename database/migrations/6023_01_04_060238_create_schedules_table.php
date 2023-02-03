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
            $table->string('schedule_index');
            $table->integer('charger_index')->nullable();;
            $table->time('start');
            $table->time('end');
            $table->string('energy_before');
            $table->string('energy_after');
            $table->float('consumption');
            $table->integer('location_start')->unsigned();
            $table->integer('location_finish')->unsigned();
            $table->string('type');
            $table->string('schedule_no');
            $table->integer('dataset');
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
