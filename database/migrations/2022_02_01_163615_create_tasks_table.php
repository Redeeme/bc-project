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
            $table->id('id');
            $table->integer('index');
            $table->integer('spoj_id');
            $table->integer('spoj');
            $table->integer('linka');
            $table->integer('zastavka_start');
            $table->integer('zastavka_finish');
            $table->integer('cas_start');
            $table->integer('cas_finish');
            $table->float('vzdialenost');
            $table->float('spotreba');
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
        Schema::dropIfExists('tasks');
    }
}
