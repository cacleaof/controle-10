<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auser extends Model
{
     protected $connection = 'assist';

protected $fillable = ['cpf', 'name', 'email', 'cns', 'nacionalidade', 'data_nascimento', 'sexo', 'telefone_residencial', 'telefone_celular', 'conselho', 'num_conselho', 'razao_social', 'nome_fantasia', 'cnes', 'cnpj', 'cep', 'logradouro', 'uf', 'cidade', 'cbo_codigo', 'especialidade', 'ocupacao', 'nome_cargo', 'ine', 'fonte', 'password', 'password_confirmation'  
];

    public function Auser() 
    {
        return $this->belongsTo(User::class);
    }  

     protected $hidden = [
        'password', 'remember_token',
    ];

}
