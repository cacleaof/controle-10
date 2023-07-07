<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Project;

class TaskController extends Controller
{
public function store(Request $request){

		$task = new Task();
		$task->text = $request->text;
		$task->start_date = $request->start_date;
		$task->duration = $request->duration;
		$task->progress = $request->has("progress") ? $request->progress : 0;
		$task->parent = $request->parent;
		$task->sortorder = Task::max("sortorder") + 1;
		$task->save();
		if($request->parent =='0'){
			$proj = new Project();
			$proj->projeto = $task->text;
			$proj->save();
			$task->proj_id = $proj->id; 
			$task->save();
		} else { 
			$ti = $task->id;
			$tp = $task->parent;
			$tk = Task::find($tp);
			$pid = $tk->proj_id ;
			$task = Task::find($ti);
			$task->proj_id = $pid; 
			$task->save();
		}

		return response()->json([
			"action"=> "inserted",
			"tid" => $task->id
		]);
	}

	public function update($id, Request $request){
		$task = Task::find($id);
		$task->text = $request->text;
		//$task->task = $request->text;
		$task->start_date = $request->start_date;
		$task->duration = $request->duration;
		$task->progress = $request->has("progress") ? $request->progress : 0;
		$task->parent = $request->parent;
		$task->user_id = $auth->user->id();
		if($request->has("target")){
			$this->updateOrder($id, $request->target);
		}

		$task->save();

		return response()->json([
			"action"=> "updated"
		]);
	}

	private function updateOrder($taskId, $target){
		$nextTask = false;
		$targetId = $target;

		if(strpos($target, "next:") === 0){
			$targetId = substr($target, strlen("next:"));
			$nextTask = true;
		}

		if($targetId == "null")
			return;

		$targetOrder = Task::find($targetId)->sortorder;
		if($nextTask)
			$targetOrder++;

		Task::where("sortorder", ">=", $targetOrder)->increment("sortorder");

		$updatedTask = Task::find($taskId);
		$updatedTask->sortorder = $targetOrder;
		$updatedTask->save();
	}


	public function destroy($id){
		$task = Task::find($id);
		if($task->parent =='0'){
		$pid = $task->proj_id;
		$project = Project::find($pid);
		$project->delete();
		}
		$task->delete();

		return response()->json([
			"action"=> "deleted"
		]);	
}
}