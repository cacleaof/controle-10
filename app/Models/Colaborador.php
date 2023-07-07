<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Colaborador extends Model
{
    protected $connection = 'cadastro';
	
    protected $fillable = ['id','cns','conselho'];

}
