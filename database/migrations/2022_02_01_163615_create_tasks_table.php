<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id('index');
            $table->integer('task_id');
            $table->string('processid');
            $table->time('start');
            $table->time('end');
            $table->integer('loc_start');
            $table->integer('loc_end');
            $table->integer('distance');
            $table->float('consumption');
            $table->integer('linka');
            $table->string('dataset_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
