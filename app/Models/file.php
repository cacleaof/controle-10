<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
	protected $connection = 'assist';

    public function consult()
    {
    	return $this->belongsTo(consult::class);
    }//
}
