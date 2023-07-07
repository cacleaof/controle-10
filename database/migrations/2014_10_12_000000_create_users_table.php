<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->increments('id');
            $table->boolean('admin')->nullable();
            $table->string('cpf')->unique();
            $table->string('name')->nullable();
	        $table->string('fonte', 1)->nullable();
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
            $table->string('image', 100)->nullable();
            $table->string('password')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
