<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diarios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            //$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('proj_id')->unsigned();
            //$table->foreign('proj_id')->references('id')->on('projects')->onDelete('cascade');
            $table->integer('task_id')->unsigned();
            //$table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
            $table->string('detalhe')->nullable();
            $table->string('hylink')->nullable();
            $table->boolean('anexos')->nullable();
            $table->date('ndia')->nullable();
            $table->time('ini')->nullable();
            $table->time('fim')->nullable();
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
        Schema::dropIfExists('diarios');
    }
}
