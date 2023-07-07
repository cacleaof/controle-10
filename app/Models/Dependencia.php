<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Dependencia;

class Dependencia extends Model
{
	//protected $connection = 'assist';

    public function dependencia()
    {
    	return $this->belongsTo(Dependencia::class);
    }
}
