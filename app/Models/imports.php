<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class imports extends Model
{

  protected $fillable = ['cpf', 'name', 'email', 'cns', 'nacionalidade', 'data_nascimento', 'sexo', 'telefone_residencial', 'telefone_celular', 'conselho', 'num_conselho', 'razao_social', 'nome_fantasia', 'cnes', 'cnpj', 'cep', 'logradouro', 'uf', 'cidade', 'cbo_codigo', 'especialidade', 'ocupacao', 'nome_cargo', 'ine', 'password'];

    public function imports()
    {
    	return $this->belongsTo(imports::class);
    }  //
}
