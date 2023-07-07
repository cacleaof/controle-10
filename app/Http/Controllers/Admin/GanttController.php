<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Link;
use App\Models\Project;
use DB;
 
class GanttController extends Controller
{
    public function get(){
        $tasks = new Task();
        $links = new Link();
 
        return response()->json([
        	//"data" => $tasks->orderBy('sortorder')->get(),
        	"data" => $tasks->all(),
            "links" => $links->all()
        ]);
    }
    public function ganttchart(project $project, Request $request){
        
        $pj = $request->projeto;
        //$pj = null;
        //$gantt = Task::all();
       // foreach ($gantt as $key => $value) {
            //$x = $value->start_date;
            //$result[++$key] = [$value->id, $value->text, $value->parent, Year($x)];
            if($pj != null){ $gantt =  DB::select("Select id as id, text as text, parent as parent, Year(start_date) as asd , month(start_date) as msd, 
                day(start_date) as dsd, Year(date_fim) as adf , month(date_fim) as mdf, day(date_fim) as ddf, duration as duration, 
                progress as prog, progress as prog, parent as parent, proj_id as proj from tasks WHERE proj_id ='$pj'" );
            }
            else{
            $gantt =  DB::select("Select id as id, text as text, parent as parent, Year(start_date) as asd , month(start_date) as msd, 
                day(start_date) as dsd, Year(date_fim) as adf , month(date_fim) as mdf, day(date_fim) as ddf, duration as duration, 
                progress as prog, parent as parent, proj_id as proj from tasks");
            }
            $projects = $project->all();
            
            $projeto = null;
            //$gantt = $gantt->where('proj', $pj )->first();
        //dd($gantt);
        $jsonStr = json_encode($gantt);
        return view('admin.proj.ganttchart', compact('gantt', 'projects', 'projeto'));
    }
    public function ganttmano(project $project, Request $request){
        
        $pj = $request->projeto;
        //$pj = null;
        //$gantt = Task::all();
       // foreach ($gantt as $key => $value) {
            //$x = $value->start_date;
            //$result[++$key] = [$value->id, $value->text, $value->parent, Year($x)];
            if($pj != null){ $gantt =  DB::select("Select id as id, text as text, parent as parent, Year(start_date) as asd , month(start_date) as msd, 
                day(start_date) as dsd, Year(date_fim) as adf , month(date_fim) as mdf, day(date_fim) as ddf, duration as duration, 
                progress as prog, progress as prog, parent as parent, proj_id as proj from tasks WHERE proj_id ='$pj'" );
            }
            else{
            $gantt =  DB::select("Select id as id, text as text, parent as parent, Year(start_date) as asd , month(start_date) as msd, 
                day(start_date) as dsd, Year(date_fim) as adf , month(date_fim) as mdf, day(date_fim) as ddf, duration as duration, 
                progress as prog, parent as parent, proj_id as proj from tasks");
            }
            $projects = $project->all();
            
            $projeto = null;
            //$gantt = $gantt->where('proj', $pj )->first();
        //dd($gantt);
        $jsonStr = json_encode($gantt);
        return view('admin.proj.ganttmano', compact('gantt', 'projects', 'projeto'));
    }
}