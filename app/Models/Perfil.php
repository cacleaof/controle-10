<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\user;

class Perfil extends Model
{
	protected $connection = 'assist';

	public function user()
	{
    	return $this->belongsTo(User::class);
	}
}
