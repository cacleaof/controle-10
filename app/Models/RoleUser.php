<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    protected $connection = 'assist';
    protected $table = 'role_user';
    public $timestamps = false;
}
