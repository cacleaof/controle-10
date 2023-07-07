<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Arquivo extends Model
{
	//protected $connection = 'assist';

  public function Diario()
    {
    return $this->belongsTo(Diario::class);
    }
}
