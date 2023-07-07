<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use app\models\user;

class Profissoe extends Model
{
	protected $connection = 'assist';

	public function user()
	{
    	return $this->belongsTo(User::class);
	}
}
