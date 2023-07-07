<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('text');
            $table->integer('duration')->default(0);
            $table->float('progress')->default(0);
            $table->dateTime('start_date')->default('2020-01-01 00:00:00');
            $table->integer('parent')->default(0);
            $table->longtext('dep')->nullable();
            $table->longtext('jdep')->nullable();
            $table->timestamps();
            $table->string('task')->nullable();
            $table->string('detalhe')->nullable();
            $table->string('status')->nullable();
            $table->date('date_fim')->nullable();
            $table->integer('urg')->nullable();
            $table->integer('imp')->nullable();
            $table->integer('user_id')->nullable()->default(1);
            $table->integer('proj_id')->nullable();
            $table->integer('sortorder')->nullable()->default(0);
            //$table->foreign('proj_id')->references('id')->on('projects')->onDelete('cascade');
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
