<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfissionalSaude extends Model
{

    protected $connection = 'smart';

    protected $fillable = ['cpf', 'name', 'email', 'cns', 'nacionalidade', 'data_nascimento', 'sexo', 'telefone_residencial', 'telefone_celular', 'conselho', 'num_conselho', 'razao_social', 'nome_fantasia', 'cnes', 'cnpj', 'cep', 'logradouro', 'uf', 'cidade', 'cbo_codigo', 'especialidade', 'ocupacao', 'nome_cargo', 'ine', 'password'];

}
