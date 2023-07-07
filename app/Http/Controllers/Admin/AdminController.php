<?php

namespace App\Http\Controllers\Admin;

use App\Models\Consult;
use App\Models\User;
use App\Models\Perfil;
use App\Models\Registro;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index(User $user, Project $project)
    {
        //$user = auth()->user();
        $reg = new registro;
        $reg->data = date('Y-m-d H:i');
        $reg->acao = 'Login Controle';
        $reg->user_id = auth()->user()->id;
        $reg->nome = auth()->user()->name;
        $reg->save();

        //$tasks = DB::table('tasks')->get();
        $tasks = DB::select("SELECT * FROM tasks ORDER BY urg DESC, imp DESC");
        $projects = $project->all();
               
        return view('admin.proj.index' , compact('tasks', 'projects'));
    }
}
