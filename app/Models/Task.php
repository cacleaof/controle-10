<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Task extends Model
{
	protected $fillable = ['task', 'detalhe', 'progress', 'start_date', 'date_fim', 'prevdias', 'jdep', 'urg', 'imp', 'proj_id', 'user_id'];

	protected $appends = ["open"];

    protected $casts = [
        'jdep' => 'array'
    ];

	public function getOpenAttribute(){
        return true;
    }
    public function task()
    {
        return $this->belongsTo(task::class);
    }  
	public function usuario()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
    public function diarios()
    {
        return $this->hasMany(Diario::class);
    }
 }
