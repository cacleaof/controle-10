<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin;
use App\Exports\ProjExport;
use Maatwebsite\Excel\Concerns\FromCollection;
use DB;
use Excel;

class ExportProjController extends Controller
{
   function index()
    {

     $proj_data = DB::table('projects')->paginate(6);

     return view('export_proj')->with('proj_data', $proj_data);
    }

    function excel()
    {
     
     return Excel::download( new ProjExport, 'dados_projetos.xlsx');
    
         }// //
}
