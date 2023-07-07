<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imports', function (Blueprint $table) {
            
            $table->increments('id');
            $table->boolean('admin')->nullable();
            $table->timestamps();
            $table->string('cpf')->unique();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('cns', 25)->nullable();
            $table->string('nacionalidade', 255)->nullable();
            $table->date('data_nascimento', 10)->nullable();
            $table->string('sexo', 10)->nullable();
            $table->string('telefone_residencial', 30)->nullable();
            $table->string('telefone_celular', 30)->nullable();
            $table->string('conselho', 255)->nullable();
            $table->string('num_conselho', 30)->nullable();
            $table->string('razao_social', 255)->nullable();
            $table->string('nome_fantasia', 255)->nullable();
            $table->string('cnes', 25)->nullable();
            $table->string('cnpj', 25)->nullable();
            $table->string('cep', 10)->nullable();
            $table->string('logradouro', 255)->nullable();
            $table->string('uf', 2)->nullable();
            $table->string('cidade', 60)->nullable();
            $table->string('cbo_codigo', 15)->nullable();
            $table->string('especialidade', 255)->nullable();
            $table->string('ocupacao', 255)->nullable();
            $table->string('nome_cargo', 255)->nullable();
            $table->string('ine', 255)->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('imports');
    }
}
