<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Equipe extends Model
{
	//protected $connection = 'assist';

	protected $fillable = ['user_id'];
    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
