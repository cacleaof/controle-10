<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin;
use App\Exports\TaskExport;
use Maatwebsite\Excel\Concerns\FromCollection;
use DB;
use Excel;

class ExportTaskController extends Controller
{
   function index()
    {

     $task_data = DB::table('tasks')->paginate(12);

     return view('export_task')->with('task_data', $task_data);
    }

    function excel()
    {
     
     return Excel::download( new TaskExport, 'dados_tarefas.xlsx', \Maatwebsite\Excel\Excel::XLSX);

    
         }// //
}
