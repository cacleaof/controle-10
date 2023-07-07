<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pri;

class Pri extends Model
{
    protected $fillable = ['nome','cpf','email','telefone','cidade','instituicao','cargo','funcao','regional','macro','confirma'];

    public function pri()
    {
    	return $this->belongsTo(Pri::class);
    }
}
