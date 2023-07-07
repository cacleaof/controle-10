<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('projeto')->unique();
            $table->string('proj_detalhe')->nullable();
            $table->string('status')->nullable();
            $table->integer('duracao')->nullable();
            $table->integer('gerente')->nullable()->references('id')->on('users');
            $table->integer('urg')->nullable();
            $table->integer('imp')->nullable();
            $table->date('date_ini')->nullable();
            $table->date('date_fim')->nullable();
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
        Schema::dropIfExists('projects');
    }
}
