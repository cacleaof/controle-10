<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use app\models\user;

class Post extends Model
{
    public function user()
    {
    	return $this->belongsTo(User::class);
    }
 }