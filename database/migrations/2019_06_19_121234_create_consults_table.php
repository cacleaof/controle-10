<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consults', function (Blueprint $table) {
            $table->timestamps();
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('servico')->nullable();
            $table->longText('consulta');
            $table->longText('cons_replica')->nullable();
            $table->longText('cons_treplica')->nullable();
            $table->string('convenio', 20)->nullable();
            $table->string('municipio', 50)->nullable();
            $table->string('ibge', 7)->nullable();
            $table->string('UF', 2)->nullable();
            $table->string('status', 1);
            $table->string('sol_name', 50)->nullable();
            $table->string('reg_name', 50)->nullable();
            $table->integer('reg_id')->nullable();
            $table->string('cons_name', 50)->nullable();
            $table->string('cons_cpf', 11)->nullable();
            $table->integer('cons_id')->nullable();
            $table->string('tempo', 20)->nullable();
            $table->string('solicitaçao', 50)->nullable();
            $table->boolean('ativo')->nullable();
            $table->string('idade')->nullable();
            $table->longText('queixa')->nullable();
            $table->string('instituiçao')->nullable();
            $table->string('municipio_sol', 50)->nullable();
            $table->string('area', 50)->nullable();
            $table->string('ibge_sol', 7)->nullable();
            $table->boolean('anexos')->nullable();
            $table->text('devolutiva')->nullable();
            $table->text('devolutiva_cons')->nullable();
            $table->text('dev_reg')->nullable();
            $table->longText('resposta')->nullable();
            $table->longText('replica')->nullable();
            $table->longText('treplica')->nullable();
            $table->text('l_recom')->nullable();
            $table->string('ciap', 50)->nullable();
            $table->string('dec1', 50)->nullable();
            $table->string('dec2', 50)->nullable();
            $table->string('dec3', 50)->nullable();
            $table->string('av_duvida', 20)->nullable();
            $table->string('avaliaçao', 1)->nullable();
            $table->text('av_comment')->nullable();
            $table->string('solicitante')->nullable();
            $table->string('nome_paciente')->nullable();
            $table->date('data_nascimento')->nullable();
            $table->string('sexo')->nullable();
            $table->string('cpf')->nullable();
            $table->string('cns')->nullable();
            $table->string('telefone')->nullable();
            $table->string('endereco')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cidade')->nullable();
            $table->string('motivo')->nullable();
            $table->text('fatores')->nullable();
            $table->string('medicamento')->nullable();
            $table->string('pressao')->nullable();
            $table->string('peso')->nullable();
            $table->string('altura')->nullable();
            $table->string('localizacao')->nullable();
            $table->string('intensidade')->nullable();
            $table->string('irradiacao')->nullable();
            $table->string('caracteristica')->nullable();
            $table->string('episodio')->nullable();
            $table->string('duracao')->nullable();
            $table->string('recidiva')->nullable();
            $table->string('sintomas')->nullable();
            $table->string('ritmo')->nullable();
            $table->string('frequencia')->nullable();
            $table->string('eixo')->nullable();
            $table->string('onda_p')->nullable();
            $table->string('pr')->nullable();
            $table->string('qrs')->nullable();
            $table->string('st')->nullable();
            $table->string('onda_t')->nullable(); 
            $table->string('qt')->nullable();           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consults');
    }
}
