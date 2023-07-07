<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conselho extends Model
{
    protected $fillable = ['nome_entidade', 'cnpj', 'segmento', 'cidade', 'endereco_entidade', 'estado_entidade',
     'cep_entidade', 'fax_entidade', 'telefone', 'email','nome_presidente','nome_delegado','nome_social_delegado',
    'identidade_delegado','cpf_delegado','endereco_delegado','estado_delegado','cep_delegado','fax_delegado',
     'telefone_delegado','email_delegado','deficiencia','participacao','status','justificativa','file','file1','file2','file3','file4','file5'];

}