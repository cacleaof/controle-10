<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use App\Models\Link;
use App\Models\Diario;
use App\Models\file;
use App\Models\Arquivo;
use DB;

class ProjControl extends Controller
{
    public function entrada(task $task, project $project)
    { 
        $tasks = Task::where('user_id', auth()->user()->id)->get();
        //$tasks = Task::where('user_id', auth()->user()->id)->orderBy('duration')->get();
        //dd($tasks);
        $projects = Project::where('gerente', auth()->user()->id)->get();

    return view('admin.proj.entrada', compact('tasks', 'projects'));

    }
    public function index(Project $project)
    {
        $tasks = DB::select("SELECT * FROM tasks ORDER BY urg DESC, imp DESC");
        $projects = $project->all();
               
        return view('admin.proj.index' , compact('tasks', 'projects'));
    }
    public function ganttproj(project $project, Request $request){
        
        $pj = $request->projeto;
        
            if($pj != null){ $gantt =  DB::select("Select id as id, text as text, parent as parent, Year(start_date) as asd , month(start_date) as msd, 
                day(start_date) as dsd, Year(date_fim) as adf , month(date_fim) as mdf, day(date_fim) as ddf, duration as duration, 
                progress as prog, progress as prog, dep as dep, proj_id as proj from tasks WHERE proj_id ='$pj'" );
            }
            else{
            $gantt =  DB::select("Select id as id, text as text, parent as parent, Year(start_date) as asd , month(start_date) as msd, 
                day(start_date) as dsd, Year(date_fim) as adf , month(date_fim) as mdf, day(date_fim) as ddf, duration as duration, 
                progress as prog, dep as dep, proj_id as proj from tasks");
            }
            $projects = $project->all();
            
            $projeto = null;
            //$gantt = $gantt->where('proj', $pj )->first();
        //dd($gantt);
        $jsonStr = json_encode($gantt);
        return view('admin.proj.ganttchart', compact('gantt', 'projects', 'projeto'));
    }
    public function agenda(task $task, project $project, Request $request, Diario $diario){

        $id = auth()->user()->id;
        $tarefas = DB::select('SELECT * FROM telessaude.tasks where user_id = '.$id.' ');

        return view('admin.proj.agenda', compact('tarefas'));

    }
    public function diario(task $task, project $project, Request $request, Diario $diario)
    {

    if(!empty($request->projeto)) {
    //$projects = Project::where('gerente', auth()->user()->id)
     //           ->where('id' , $request->projeto)->paginate(12);
    //$tarefas = Task::where('user_id', auth()->user()->id)
                //->where('proj_id' , $request->projeto)->paginate(6);
    $tarefas = Task::where('proj_id' , $request->projeto)->get();
    $projeto = $request->projeto;
    $dia = $request->dia;
    $ini = $request->ini;
    $fim = $request->fim;
    $ndia = $request->ndia;
    $nini = $request->nini;
    $nfim = $request->nfim;
    }
    else {
    $tarefas = $task->all();
    $dia = null;
    $ini = null;
    $fim = null;
    $projeto = null;
    $ndia = null;
    $nini = null;
    $nfim = null;
    }

      if(!empty($request->dia) or !empty($request->ndia)) {
    $dia = $request->dia;
    $ini = $request->ini;
    $fim = $request->fim;
    $ndia = $request->ndia;
    $nini = $request->nini;
    $nfim = $request->nfim;
    $projeto = $request->projeto;
    $diarios = Diario::where('user_id', auth()->user()->id)
                ->where('ndia' , $dia)->get();
    }
    else {
    $diarios = Diario::where('user_id', auth()->user()->id)->get();
    }
    $proj = $project->all();
    $projects = $proj->sortBy('projeto');
    $users = DB::table('users')->get();

     
    return view('admin.proj.diario', compact('tarefas', 'projects', 'users', 'diarios', 'dia', 'ini', 'fim', 'projeto', 'ndia', 'nini', 'nfim'));
       
    }
    public function sol_atv(task $task, project $project, Request $request, Diario $diario)
    {

    if(!empty($request->projeto)) {
    //$projects = Project::where('gerente', auth()->user()->id)
     //           ->where('id' , $request->projeto)->paginate(12);
    //$tarefas = Task::where('user_id', auth()->user()->id)
                //->where('proj_id' , $request->projeto)->paginate(6);
    $tarefas = Task::where('proj_id' , $request->projeto)->get();
    $projeto = $request->projeto;
    $dia = $request->dia;
    $ini = $request->ini;
    $fim = $request->fim;
    $ndia = $request->ndia;
    $nini = $request->nini;
    $nfim = $request->nfim;
    }
    else {
    $tarefas = $task->all();
    $dia = null;
    $ini = null;
    $fim = null;
    $projeto = null;
    $ndia = null;
    $nini = null;
    $nfim = null;
    }

      if(!empty($request->dia) or !empty($request->ndia)) {
    $dia = $request->dia;
    $ini = $request->ini;
    $fim = $request->fim;
    $ndia = $request->ndia;
    $nini = $request->nini;
    $nfim = $request->nfim;
    $projeto = $request->projeto;
    $diarios = Diario::where('user_id', auth()->user()->id)
                ->where('ndia' , $dia)->get();
    }
    else {
    $diarios = Diario::where('user_id', auth()->user()->id)->get();
    }
    $proj = $project->all();
    $projects = $proj->sortBy('projeto');
    $users = DB::table('users')->get();

     
    return view('admin.proj.sol_atv', compact('tarefas', 'projects', 'users', 'diarios', 'dia', 'ini', 'fim', 'projeto', 'ndia', 'nini', 'nfim'));
       
    }
    public function store_diario(task $task, Request $request)
    {
    if(!empty($request->tarefa)) {
        $arquivos = $request->file('arquivo');
        $dataForm = new Diario;
        $dataForm->user_id = auth()->user()->id;
        $dataForm->proj_id = $request->projeto;
        $dataForm->task_id = $request->tarefa;
        $dataForm->detalhe = $request->detalhe;
        $dataForm->hylink = $request->hylink;
        $dataForm->ndia = $request->ndia;
        $dataForm->ini = $request->nini;
        $dataForm->fim = $request->nfim;
        $nome = $request->arquivo;
        $dataForm->save();
        $idc = $dataForm->id;
        if(!empty($arquivos)):
                $dataForm->anexos = '1';
                $dataForm->update();
            foreach ($arquivos as $arquivo):
            //dd($idc);
                $data = new arquivo;
                $data->diario_id = $idc;
                // $data->size = $arquivo->getClientSize();
                $data->size = storage::size($arquivo);
                $nome = $arquivo->getClientOriginalName();
                $nome = $idc.'-'.$nome;
                $data->arquivo = $nome;
                $data->user_id = auth()->user()->id;
                $data->save();
                Storage::putfileAs('diario'.'/'.$dataForm->user_id.'/'.$idc, $arquivo, $nome);
            endforeach;
        endif;
        $rt = $request->tarefa;
        if($request->concluido != "null"){
            $dataform = Task::find($rt);
            $dataform->status = 'Terminado';
            $dataform->progress = '1';
            $dataform->save();
            $tks = Task::where('parent', $rt)->get();
            foreach ($tks as $tk):
               $tk->status = 'Executando';
               $tk->save();
            endforeach;    
        }

        return redirect()
                    ->route('admin.proj.diario')
                    ->with('success', 'Atividade Concluida');
    }
    else {
        return redirect()
                    ->back()
                    ->with('error', 'Erro na entrada de dados');
    }
    }
    public function download_T(Arquivo $arquivo, Task $task, Request $request, User $user)
   	 {
        $sid = $request->sid;
        $cid = $request->cid;
        $dl = Arquivo::find($sid);
        $ui = $dl->user_id;
        $ci = $dl->task_id;
        $dl = $dl->arquivo;

        $file= storage_path()."/app/public/task/".$ui."/".$ci."/".$dl;

        return Response::download($file, $dl);
        
   	 }


    public function a_diario(Request $request, Diario $diario, task $task, project $project)
    {
        $diario = Diario::find($request->sid);

        $tk = Task::find($diario->task_id);
        
        $pj = Project::find($diario->proj_id);
        
        $sid = $request->sid;

        return view('admin.proj.a_diario', compact('diario', 'tk', 'pj', 'sid'));

    }
    public function deld(Request $request, Diario $diario, task $task, project $project)
{
    $diario = Diario::find($request->sid);

    $tk = Task::find($diario->task_id);
    
    $pj = Project::find($diario->proj_id);
    
    $sid = $request->sid;

    $diario->delete();

    return redirect()
          ->route('admin.proj.a_diario')
          ->with('success', 'Consultoria Deletada');
}
    public function sadiario(Request $request)
    {
    if(!empty($request->detalhe)) {
        $dataForm = Diario::find($request->sid);
        $dataForm->ndia = $request->ndia;
        $dataForm->ini = $request->ini;
        $dataForm->fim = $request->fim;
        $dataForm->detalhe = $request->detalhe;
        $dataForm->save();
        return redirect()
                    ->route('admin.proj.diario')
                    ->with('success', 'Atividade Concluida');
    }
    else {
        return redirect()
                    ->back()
                    ->with('error', 'Erro na entrada de dados');
    }
    }
     public function status_task(Task $task, Project $project, Request $request, User $user)
    {

      $taref = project::select('projects.projeto', 'projects.proj_detalhe' , 'tasks.id', 'tasks.text', 'tasks.detalhe', 'tasks.status', 'tasks.progress', 'tasks.duration', 'tasks.start_date', 'tasks.date_fim', 'tasks.imp', 'tasks.urg', 'tasks.user_id', 'tasks.proj_id', 'users.name')->join('tasks', 'tasks.proj_id', 'projects.id')->join('users', 'users.id', 'tasks.user_id')->get();     
      $tarefas = $taref->sortByDesc('urg');

      $us = $user->all();
      $users = $us->sortBy('name');

          //$users = DB::table('users')->paginate(12);

  	        // $proj = DB::table('projects')->get();
	
	     // $projects = $proj->sortBy('projeto');

         $proj = $project->all();
         $projects = $proj->sortBy('projeto');

         $projeto = null;

         if(!empty($request->projeto)) {

         $projeto = $request->projeto;
        
         $taref = project::select('projects.projeto', 'projects.proj_detalhe' , 'tasks.id', 'tasks.text', 'tasks.detalhe', 'tasks.progress', 'tasks.status', 'tasks.duration', 'tasks.start_date', 'tasks.date_fim', 'tasks.imp', 'tasks.urg', 'tasks.user_id', 'tasks.proj_id')
         ->join('tasks', 'tasks.proj_id', 'projects.id')->where('tasks.proj_id', $projeto)->get();  
        
         $tarefas = $taref->sortByDesc('urg');
         }
          if(!empty($request->usuario)) {

             $usu = $request->usuario;

             $tarus = $taref->where('user_id', $usu);

             $tarefas = $tarus->sortByDesc('urg'); 
            
         }

        return view('admin.proj.status_task', compact('tarefas', 'projects', 'users', 'projeto'));
        
    }

    public function dep_task(Task $task, Project $project, Request $request, User $user)
    {

    //$tarefas = project::select('projects.projeto', 'projects.proj_detalhe' , 'tasks.text', 'tasks.detalhe', 'tasks.proj_id')->join('tasks', 'tasks.proj_id', 'projects.id' );  
     $taref = project::select('projects.projeto', 'projects.proj_detalhe' , 'tasks.id', 'tasks.text', 'tasks.detalhe', 'tasks.duration', 'tasks.start_date', 'tasks.date_fim', 'tasks.imp', 'tasks.urg', 'tasks.user_id', 'tasks.proj_id')->join('tasks', 'tasks.proj_id', 'projects.id')->join('dependencias', 'dependencias.task_id', 'dependencias.antes')->paginate(12);     
     $tarefas = $taref->sortByDesc('urg');

     $users = $user->all();

     //$users = DB::table('users')->paginate(12);

     $projects = DB::table('projects')->paginate(12);

        if(!empty($request->projeto)) {

        $projeto = $request->projeto;
        $taref = DB::table('tasks')->where('proj_id', $projeto)->paginate(12);
        $tarefas = $taref->sortByDesc('urg');
        }
         if(!empty($request->usuario)) {

            $usu = $request->usuario;

            $tarus = $taref->where('user_id', $usu);

            $tarefas = $tarus->sortByDesc('urg');
            
        }

        return view('admin.proj.status_task', compact('tarefas', 'projects', 'users'));
    }

    public function status_diario(Task $task, Project $project, Request $request)
    {
    $diaj = project::select('projects.projeto', 'projects.proj_detalhe' , 'diarios.task_id', 'diarios.detalhe', 'diarios.proj_id', 'diarios.ndia', 'diarios.ini', 'diarios.fim', 'diarios.user_id', 'users.name')->join('diarios', 'diarios.proj_id', 'projects.id' )->join('users', 'users.id', 'diarios.user_id')->get();  
    
    //dd($diaj);

        $diarios = $diaj->sortByDesc('ndia');

        $users = DB::table('users')->get();
    
         if(!empty($request->projeto)) {

            $proj = $request->projeto;

            $diajp = $diaj->where('proj_id', $proj);

            $diarios = $diajp->sortByDesc('ndia');
        }

            if(!empty($request->usuario)) {

            $usu = $request->usuario;

            $diajp = $diaj->where('user_id', $usu);

            //dd($diajp);

            $diarios = $diajp->sortByDesc('ndia');
            
        }

        $proj = DB::table('projects')->get();

	    $projects = $proj->sortBy('projeto');

        return view('admin.proj.status_diario', compact('diarios', 'projects', 'users'));
    }

    public function status_proj(Task $task, Project $project)
    {
    $tarefas = project::select('projects.id', 'projects.projeto', 'projects.proj_detalhe' , 'tasks.text', 'tasks.detalhe')->join('tasks', 'tasks.proj_id', 'projects.id' )->paginate(12);  

        $proj = $project->all();

        $projs = $proj->sortBy('projeto');

        $projects = $project->all();

        return view('admin.proj.status_proj', compact('tarefas', 'projects'));
    }

     public function showpj(Task $task, Project $project, Request $request, User $user, Diario $diario)
    {
    $tarefas = project::select('projects.id', 'projects.projeto', 'projects.proj_detalhe' , 'projects.duracao' , 'tasks.text', 'tasks.detalhe', 'tasks.start_date', 'tasks.status', 'tasks.user_id')->join('tasks', 'tasks.proj_id', 'projects.id' )->join('users', 'users.id', 'projects.gerente')->get();  
    $prj = $request->prj;
    $tasks = $task->all();

    foreach($tasks as $tk):
        if($prj == $tk->proj_id){
            $jdep = "";
            $idt = "";
        //foreach($tk['jdep'] as $jd ):
        //   $jdep = $jd.','.$jdep;
        //   $idt = $tk->id;
        //endforeach;
        $dataForm = Task::find($idt);
        //$dataForm->dep = $jdep;
        //$dataForm->save();
    }
    endforeach;
        // dd($gantt);
        
        if($prj != null){ $gantt =  DB::select("Select id as id, text as text, parent as parent, Year(start_date) as asd , month(start_date) as msd, 
            day(start_date) as dsd, Year(date_fim) as adf , month(date_fim) as mdf, day(date_fim) as ddf, duration as duration, 
            progress as prog, progress as prog, parent as parent, dep as dep , jdep as jdep, proj_id as proj from tasks WHERE proj_id ='$prj'" );
        }
        else{
        $gantt =  DB::select("Select id as id, text as text, parent as parent, Year(start_date) as asd , month(start_date) as msd, 
            day(start_date) as dsd, Year(date_fim) as adf , month(date_fim) as mdf, day(date_fim) as ddf, duration as duration, 
            progress as prog, parent as parent, dep as dep, jdep as jdep, proj_id as proj from tasks");
        }
        
        $projeto = null;
        
        $dv = "1,2,3";
        $sp = explode(",", $dv);
        $jsonStr = json_encode($gantt);

        

        $proj = $request->prj;

        $tks = Task::where('proj_id', $proj)->get();

        //$co = explode(",",$tks->dep);
        //$co = explode(",", $tks->dep);

        //dd($co[0]);

        $project = Project::where( 'id', $proj)->first();

        $diarios = Diario::select('diarios.id', 'diarios.ndia', 'diarios.proj_id', 'diarios.hylink', 'diarios.anexos', 'diarios.detalhe', 'users.name')->join('users', 'users.id', 'diarios.user_id')->get()->sortByDesc('ndia');
        
        $users = User::where('nome_fantasia', 'telessaude')->get();
        
        //$tasks = Task::select('tasks.start_date', 'tasks.date_fim','tasks.id', 'tasks.text', 'tasks.proj_id', 'tasks.status' , 'tasks.parent', 'tasks.dep' , 'tasks.jdep', 'users.name')->join('users', 'users.id', 'tasks.user_id')->get()->sortBy('parent');

        //$tasks = Task::where( 'proj_id', '88')->get();

        $tasks = $task->all();

        return view('admin.proj.showpj', compact( 'project', 'tks', 'users', 'tasks', 'diarios', 'gantt', 'projeto', 'prj'));
    }
     public function showtk(Task $task, Project $project, Request $request, Arquivo $arquivo)
    {
    $tarefas = project::select('projects.id', 'projects.projeto', 'projects.proj_detalhe' , 'tasks.text', 'tasks.detalhe')->join('tasks', 'tasks.proj_id', 'projects.id' )->paginate(12);  

        //dd($tarefas);
        $taref = $request->trf;

        $task = Task::where( 'id', $taref)->first();

        //$users = DB::table('users')->paginate(100);
        $users = User::where('nome_fantasia', 'telessaude')->get();

	$projects = $project->all();

        $diarios = DB::table('diarios')->get()->sortByDesc('ndia');

        $arquivos = DB::table('arquivos')->get();

        return view('admin.proj.showtk', compact('tarefas', 'task', 'users', 'diarios', 'arquivos', 'projects'));
    }
    public function gantt(Task $task, Project $project, Request $request)
    {
    $tarefas = project::select('projects.id', 'projects.projeto', 'projects.proj_detalhe' , 'tasks.text', 'tasks.detalhe')->join('tasks', 'tasks.proj_id', 'projects.id' )->paginate(12);  

        //dd($tarefas);
        $taref = $request->trf;

        $task = Task::where( 'id', $taref)->first();

        //dd($project);

        return view('admin.proj.gantt', compact('tarefas', 'task'));
    }
    public function showdp(Task $task, Project $project, Request $request)
    {
    $tarefas = project::select('projects.id', 'projects.projeto', 'projects.proj_detalhe' , 'tasks.text', 'tasks.detalhe')->join('tasks', 'tasks.proj_id', 'projects.id' )->paginate(12);  

        //dd($tarefas);
        $taref = $request->trf;

        $task = Task::where( 'id', $taref)->first();

        //dd($project);

        return view('admin.proj.showdp', compact('tarefas', 'task'));
    }

    public function task(Task $task, Project $project)
    {
        $tarefas = project::select('projects.id', 'projects.projeto', 'projects.proj_detalhe' , 'tasks.text', 'tasks.detalhe', 'tasks.urg')->join('tasks', 'tasks.proj_id', 'projects.id' )->orderBy('urg', 'DESC')->get(); 

        $tasks = $task->all(); 

        //$projects = DB::table('projects')->paginate(5);
        //$projects = DB::table('projects');
        $projects = $project->all();

        //$tarefas = $taref->sortByDesc('urg')->paginate(5);

        //dd($tarefas);

        return view('admin.proj.entrada', compact('tasks', 'tarefas', 'projects'));
    }

    public function p_proj(Task $task, Project $project)
    {
        $tarefas = project::select('projects.id', 'projects.projeto', 'projects.proj_detalhe' , 'tasks.text', 'tasks.detalhe', 'tasks.urg')->join('tasks', 'tasks.proj_id', 'projects.id' )->orderBy('urg', 'DESC')->get(); 

        $tasks = $task->all(); 
        

        $p5 = DB::select("SELECT * FROM `projects` WHERE imp = 5 ORDER BY urg");
        $p4 = DB::select("SELECT * FROM `projects` WHERE imp = 4 ORDER BY urg");
        $p3 = DB::select("SELECT * FROM `projects` WHERE imp = 3 ORDER BY urg");
        $p2 = DB::select("SELECT * FROM `projects` WHERE imp = 2 ORDER BY urg");
        $p1 = DB::select("SELECT * FROM `projects` WHERE imp = 1 ORDER BY urg");
        $p0 = DB::select("SELECT * FROM `projects` WHERE imp = 0 ORDER BY urg");
        
        
        $projects = array_merge($p5, $p4, $p3, $p2, $p1, $p0);

        

        return view('admin.proj.p_proj', compact('tasks', 'tarefas', 'projects'));
    }

    public function m_task(Task $task, Project $project, Request $request, User $user)
    {
        $tarefas = project::select('projects.id', 'projects.projeto', 'projects.proj_detalhe' , 'tasks.text', 'tasks.detalhe', 'tasks.urg')->join('tasks', 'tasks.proj_id', 'projects.id' )->orderBy('urg', 'DESC')->get(); 

        $proj = $project->all(); 
        $projects = $proj->sortBy('projeto');
        
        $usu = $request->usuario;

        $pj = $request->projeto;

        $st = $request->status;        


        if($usu != null){
            $t5 = DB::select("SELECT * FROM `tasks` WHERE imp = 5 AND user_id=$usu ORDER BY urg");
            $t4 = DB::select("SELECT * FROM `tasks` WHERE imp = 4 AND user_id=$usu ORDER BY urg");
            $t3 = DB::select("SELECT * FROM `tasks` WHERE imp = 3 AND user_id=$usu ORDER BY urg");
            $t2 = DB::select("SELECT * FROM `tasks` WHERE imp = 2 AND user_id=$usu ORDER BY urg");
            $t1 = DB::select("SELECT * FROM `tasks` WHERE imp = 1 AND user_id=$usu ORDER BY urg");
            $t0 = DB::select("SELECT * FROM `tasks` WHERE imp = 0 AND user_id=$usu ORDER BY urg");
        }

        if($pj != null){
            $t5 = DB::select("SELECT * FROM `tasks` WHERE imp = 5 AND proj_id=$pj ORDER BY urg");
            $t4 = DB::select("SELECT * FROM `tasks` WHERE imp = 4 AND proj_id=$pj ORDER BY urg");
            $t3 = DB::select("SELECT * FROM `tasks` WHERE imp = 3 AND proj_id=$pj ORDER BY urg");
            $t2 = DB::select("SELECT * FROM `tasks` WHERE imp = 2 AND proj_id=$pj ORDER BY urg");
            $t1 = DB::select("SELECT * FROM `tasks` WHERE imp = 1 AND proj_id=$pj ORDER BY urg");
            $t0 = DB::select("SELECT * FROM `tasks` WHERE imp = 0 AND proj_id=$pj ORDER BY urg");
        }
        if($usu == null AND $pj == null){
            $t5 = DB::select("SELECT * FROM `tasks` WHERE imp = 5 ORDER BY urg");
            $t4 = DB::select("SELECT * FROM `tasks` WHERE imp = 4 ORDER BY urg");
            $t3 = DB::select("SELECT * FROM `tasks` WHERE imp = 3 ORDER BY urg");
            $t2 = DB::select("SELECT * FROM `tasks` WHERE imp = 2 ORDER BY urg");
            $t1 = DB::select("SELECT * FROM `tasks` WHERE imp = 1 ORDER BY urg");
            $t0 = DB::select("SELECT * FROM `tasks` WHERE imp = 0 ORDER BY urg");}

        if($st != null){
                $t5 = DB::select("SELECT * FROM `tasks` WHERE imp = 5 AND status= '$st' ORDER BY urg");
                $t4 = DB::select("SELECT * FROM `tasks` WHERE imp = 4 AND status= '$st' ORDER BY urg");
                $t3 = DB::select("SELECT * FROM `tasks` WHERE imp = 3 AND status= '$st' ORDER BY urg");
                $t2 = DB::select("SELECT * FROM `tasks` WHERE imp = 2 AND status= '$st' ORDER BY urg");
                $t1 = DB::select("SELECT * FROM `tasks` WHERE imp = 1 AND status= '$st' ORDER BY urg");
                $t0 = DB::select("SELECT * FROM `tasks` WHERE imp = 0 AND status= '$st' ORDER BY urg");
            }
        
        $tasks = array_merge($t5, $t4, $t3, $t2, $t1, $t0);

        $us = $user->all();
        $users = $us->sortBy('name');

            //dd($tasks);

        return view('admin.proj.m_task', compact('tasks', 'tarefas', 'projects', 'users', 'usu', 'pj', 'st'));
    }

    public function n_proj(Task $task, Project $project)
    {
    $tarefas = project::select('projects.id', 'projects.projeto', 'projects.proj_detalhe' , 'tasks.text', 'tasks.detalhe')->join('tasks', 'tasks.proj_id', 'projects.id' )->paginate(4);  

         $users = DB::table('users')->paginate(100);

         $inicio = null;

         $fim = null;

         $duration = null;

        //dd($users);

        return view('admin.proj.n_proj', compact('tarefas', 'users', 'inicio', 'fim', 'duration'));
    }
    
    public function n_task(task $task, project $project, Request $request)
    {
    $tarefas = project::select('projects.id', 'projects.projeto', 'projects.proj_detalhe' , 'projects.date_ini', 'projects.date_fim', 'projects.duracao', 'tasks.text', 'tasks.detalhe')->join('tasks', 'tasks.proj_id', 'projects.id' )->get(); 

      $start_date = null;

      $date_fim = null;

      $duration = null;

      $d = null;

      if(!empty($request->projeto)) {

        $projeto = $request->projeto; }
       else {
        if(!empty($request->trf)) {
            $projeto = $request->trf;
            }
        else {
      $projeto = null;}
       }

    $proj = $project->all();
    $projects = $proj->sortBy('projeto');

    $tasks = $task->all();

     $users = DB::table('users')->paginate(100);
    //dd($projects);

    //$search = $request->projeto;
    //$pesquisa = Project::where('id', '=',$search)->get();

    //$task = Task::where('proj_id','=', $search)->get();
       
        
        return view('admin.proj.n_task', compact('tarefas', 'tasks', 'start_date', 'date_fim', 'projeto', 'duration', 'projects', 'users'));
    }
    public function cpproj(task $task, project $project, Request $request)
    {
    $tarefas = project::select('projects.id', 'projects.projeto', 'projects.proj_detalhe' , 'projects.date_ini', 'projects.date_fim', 'projects.duracao', 'tasks.text', 'tasks.detalhe')->join('tasks', 'tasks.proj_id', 'projects.id' )->get(); 
  
    $users = DB::table('users')->paginate(100);

    $inicio = null;

    $fim = null;

    $duration = null;

    $projeto = null;

    if(!empty($request->projcp)) {

        $projcp = $request->projcp; 
       
        // DB::statement("CREATE TABLE new_tbl SELECT * FROM tasks where proj_id = '$projcp'");
        // DB::insert('insert into tasks (text, duration, progress, start_date, parent, created_at, updated_at, task, detalhe, status, date_fim, urg, imp, user_id, proj_id, anexos, sortorder) SELECT text, duration, progress, 
        // start_date, parent, created_at, updated_at, task, detalhe, status, date_fim, urg, imp, user_id, 
        // proj_id, anexos, sortorder  FROM new_tbl');
        // DB::statement("DROP TABLE new_tbl");
    }
    
        else{ $projcp = null;}


    $proj = $project->all();
    
    $projects = $proj->sortBy('projeto');

    $tasks = $task->all();

     $users = DB::table('users')->paginate(100);
           
        return view('admin.proj.cpproj', compact('tarefas', 'inicio', 'fim', 'tasks', 'projeto', 'duration', 'projects', 'users', 'projcp'));
    }
    public function upd_d(Request $request)
    {
        $dataForm = Task::find($request->trf);
        $dataForm->dep = $request->dep;
        $dataForm->jdep = $request->jdep;
        $dataForm->save();
        return redirect()
                    ->back()
                    ->with('success', 'Alteração da dependencia com sucesso');
    }
    public function upd_p(Request $request)
    {
        //dd($request->prj);

    if(!empty($request->projeto)) {
        $df = $request->date_fim;
            $df = date('Y-m-d H:i:s',strtotime($df));
            $di = $request->date_ini;
            $di = date('Y-m-d H:i:s',strtotime($di));
            $duracao = (strtotime($df)-strtotime($di))/86400;
        $dataForm = Project::find($request->prj);
        $sta = $dataForm->status;
        $dataForm->projeto = $request->projeto;
        $dataForm->gerente = $request->gerente;
        $dataForm->proj_detalhe = $request->detalhe;
        $dataForm->urg = $request->urg;
        $dataForm->imp = $request->imp;
        $dataForm->date_ini = $request->date_ini;
        $dataForm->date_fim = $request->date_fim;
        $dataForm->duracao = $duracao;
        $tk = DB::select("SELECT * FROM `tasks` WHERE proj_id = $request->prj ORDER BY date_fim desc");
        $idd = $tk[0]->id;
        if($sta == "Planejando" and $request->status == "Executando"){
        $dataForm->status = $request->status;
        $dataFim = new Task;
        $dataFim->user_id = $request->gerente;
        $dataFim->proj_id = $request->prj;
        $dataFim->detalhe = "Tarefa de finalização do projeto";
        $dataFim->text = "FIM";
        $dataFim->parent = 0;
        $dataFim->dep = $idd;
        $dataFim->start_date = date('Y-m-d', strtotime('-1 days', strtotime($request->date_fim))); 
        $dataFim->date_fim = $request->date_fim;
        $dataFim->duration = '1';
        $dataFim->urg = '0';
        $dataFim->imp = '0';
        $dataFim->status = 'Planejando';
        $dataFim->save();
        };
        $dataForm->progress = $request->prog/100;
        $dataForm->save();
        

        return redirect()
                    ->back()
                    ->with('success', 'Projeto enviado com sucesso');
    }
    else {
        return redirect()
                    ->back()
                    ->with('error', 'Os campos do Projeto devem ser preenchidos');
    }
    }
    public function upd_t(Request $request)
    {
       //dd($request->trf);

    if(!empty($request->tarefa)) {
        $dataForm = Task::find($request->trf);
        $dataForm->text = $request->tarefa;
        $dataForm->user_id = $request->usuario;
        $dataForm->detalhe = $request->detalhe;
        $dataForm->urg = $request->urg;
        $dataForm->imp = $request->imp;
        if(empty($request->ini)){
            $dataForm->start_date = now();}
            else{$dataForm->start_date = $request->ini;}
        $dataForm->date_fim = $request->fim;
        $dur = strtotime($request->fim) - strtotime($request->ini);
        $dataForm->duration = floor($dur / (60 * 60 * 24));
        $dataForm->status = $request->status;
        $dataForm->proj_id = $request->proj_id;
        $dataForm->progress = $request->prog/100;
        $dataForm->dep = $request->dep;
        $dataForm->save();
        $rt = $request->trf;
        if($request->concluido == "on"){
            $dataform = Task::find($rt);
            $dataform->status = 'Terminado';
            $dataform->progress = '1';
            $dataform->save();
            //SELECT * FROM `tasks` WHERE `dep` LIKE '%66%';
            $tks = Task::where('parent', $rt)->get();
            foreach ($tks as $tk):
               $tk->status = 'Executando';
               $tk->save();
            endforeach; }   

        return redirect()
                    ->route('admin.proj.index')
                    ->with('success', 'Tarefa atualizada com sucesso');
    }
    else {
        return redirect()
                    ->back()
                    ->with('error', 'Os campos da tarefa devem ser preenchidos');
    }
    }
    public function delpj(Request $request)
    {
        $prj = $request->prj;
        $tt = DB::select("SELECT * FROM `tasks` WHERE proj_id = '$prj'");
        foreach($tt as $t){
            $stem = $t->text;
         }
         if(!empty($stem)){
            //dd($npj);
            return redirect()
                        ->back()
                        ->with('error', 'Você só pode deletar o projeto depois de apagar as tarefas dele');
            }  

        $pj = Project::find($prj);

        $pj->delete();

        return redirect()
                    ->route('admin.proj.task')
                    ->with('success', 'Projeto Deletado');
    }
    public function deltk(Request $request)
    {
        $trf = $request->trf;
        $tt = DB::select("SELECT * FROM `diarios` WHERE task_id = '$trf'");
        foreach($tt as $t){
            $stem = $t->detalhe;
         }
         if(!empty($stem)){
            //dd($npj);
            return redirect()
                        ->back()
                        ->with('error', 'Você só pode deletar a tarefa depois de apagar o diario dele');
            }  

        $tk = Task::find($trf);

        $tk->delete();

        return redirect()
                    ->back()
                    ->with('success', 'Tarefa Deletada');
    }
    public function store_p(Request $request)
    {
       //dd($request->projeto);
    if(!empty($request->projeto)) {
        //$npj = Project::where('projeto', $request->projeto)->get();
        $pj = $request->projeto;
        //$contem = DB::select("select * from projects where projeto = '$pj'");
        $contem = DB::select("select * from projects where projeto = '$pj'");
        //dd($contem);
        foreach($contem as $c){
           $stem = $c->projeto;
        }
        //$npj = DB::SELECT("SELECT COUNT(*) FROM `projects`");
        //dd(json_decode($npj));
        if(!empty($stem)){
        //dd($stem);
        return redirect()
                    ->back()
                    ->with('error', 'Esse nome de Projeto já existe, digite outro');
        }
            $df = $request->fim;
            $df = date('Y-m-d H:i:s',strtotime($df));
            $di = $request->inicio;
            $di = date('Y-m-d H:i:s',strtotime($di));
            $duracao = (strtotime($df)-strtotime($di))/86400;
            $idpj = $request->projcp;
            //dd($idpj);
        $dataForm = new Project;
        $dataForm->projeto = $request->projeto;
        $dataForm->gerente = $request->gerente;
        $dataForm->proj_detalhe = $request->detalhe;
        if($request->urg != null){
        $dataForm->urg = $request->urg;}
        else{$dataForm->urg = '0';}
        if($request->imp != null){
        $dataForm->imp = $request->imp;}
        else{$dataForm->imp = '0';}
        $dataForm->date_ini = $request->inicio;
        $dataForm->date_fim = $request->fim;
        $dataForm->duracao = $duracao;
        $dataForm->status = 'Planejando';
        $dataForm->progress = 0;
        $dataForm->save();
        $proj = $request->projeto;
        $projects = DB::Select("select id from projects where projeto = '$proj' ");
        $idp = $projects[0]->id;
            $dataForm = new Task;
            $dataForm->user_id = $request->gerente;
            $dataForm->proj_id = $idp;
            $dataForm->detalhe = $request->detalhe;
            $dataForm->text = $request->projeto;
            $dataForm->parent = 0;
            $dataForm->dep = 0;
            $dataForm->start_date = $request->inicio;
            $dataForm->date_fim = date('Y-m-d', strtotime('1 days', strtotime($request->inicio)));
            $dataForm->duration = '1';
            $dataForm->urg = '0';
            $dataForm->imp = '0';
            $dataForm->status = 'Planejando';
            $dataForm->save();

        if(!empty($idpj)) {
          DB::statement("CREATE TABLE new_tbl SELECT * FROM tasks where proj_id = '$idpj'");
          DB::statement("UPDATE `new_tbl` SET proj_id = '$idp'");
          DB::statement("DELETE FROM `new_tbl` WHERE parent = '0'");
          DB::insert('insert into tasks (text, duration, progress, start_date, parent, created_at, task, detalhe, status, date_fim, urg, imp, user_id, proj_id, anexos, sortorder) SELECT text, duration, progress, 
         start_date, parent, created_at, task, detalhe, status, date_fim, urg, imp, user_id, 
         proj_id, anexos, sortorder  FROM new_tbl');
         DB::statement("DROP TABLE new_tbl");
        }
        
        return redirect()
            ->route('admin.proj.index');
      
    }
    else {
        return redirect()
                    ->back()
                    ->with('error', 'Os campos do Projeto devem ser preenchidos');
    }
    }
    public function store_t(Request $request)
    {
        
        if(!empty($request->tarefa)) {
            $arquivos = $request->file('arquivo');
            $dataForm = new Task;
            $dataForm->proj_id = $request->projeto;
            $dataForm->user_id = $request->gerente;
            $dataForm->detalhe = $request->detalhe;
            $dataForm->text = $request->tarefa;
            $dataForm->parent = $request->tdep;
            $dataForm->dep = $request->tdep;
            $dataForm->status = "Planejando";
            if(empty($request->start_date)){
            $dataForm->start_date = now();}
            else{$dataForm->start_date = $request->start_date;}
            if(empty($request->date_fim)){
            $dataForm->date_fim = $request->start_date + $request->duration;}
            else{
                $dataForm->date_fim = $request->date_fim;
            }
            if(empty($request->duration)){
            $dur = strtotime($request->date_fim) - strtotime($request->start_date);
            $dataForm->duration = floor($dur / (60 * 60 * 24));}
            else{$dataForm->duration = $request->duration;}
            if($request->urg != null){
                $dataForm->urg = $request->urg;}
                else{$dataForm->urg = '0';}
                if($request->imp != null){
                $dataForm->imp = $request->imp;}
                else{$dataForm->imp = '0';}
            $dataForm->save();
            $idc = $dataForm->id;
            if(!empty($arquivos)):
                $dataForm->anexos = '1';
                $dataForm->update();
            foreach ($arquivos as $arquivo):
                $data = new arquivo;
                $data->task_id = $idc;
                $data->size = $arquivo->getClientSize();
                $nome = $arquivo->getClientOriginalName();
                $nome = $idc.'-'.$nome;
                $data->arquivo = $nome;
                $data->user_id = auth()->user()->id;
                $data->save();
                Storage::putfileAs('task'.'/'.$dataForm->user_id.'/'.$idc, $arquivo, $nome);
            endforeach;
        endif;

        return redirect()
                    ->back()
                    ->with('success', 'Tarefa enviada com sucesso');
        }
        else {
            return redirect()
                    ->back()
                    ->with('error', 'Os campos devem ser preenchidos');
    }
    }

    
}