<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChargerTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charger_tasks', function (Blueprint $table) {
            $table->id('charger_task_id');
            $table->integer('charger_id');
            $table->string('process_id');
            $table->time('start');
            $table->time('end');
            $table->string('speed');
            $table->string('loc');
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
        Schema::dropIfExists('charger_tasks');
    }
}
