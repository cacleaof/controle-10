<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Task;

class Task extends Model
{
    public function task()
    {
    	return $this->belongsTo(Task::class);
    }
    public function project()
    {
    	return $this->belongsTo(Project::class);
    }
}
