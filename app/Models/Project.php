<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Project;
use App\Models\Diario;
use App\Models\User;

class Project extends Model
{
	protected $fillable = ['proj_id', 'projeto', 'proj_detalhe', 'duracao', 'gerente', 'urg', 'imp'];

    public function user()
    {
        return $this->belongsTo(User::class, 'gerente');
    }
	
	 public function project()
    {
    	return $this->belongsTo(Project::class);
    }
    public function diarios()
    {
        return $this->hasMany(Diario::class, 'proj_id');
    }
}
