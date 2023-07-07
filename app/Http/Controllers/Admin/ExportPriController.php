<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin;
use App\Exports\PriExport;
use Maatwebsite\Excel\Concerns\FromCollection;
use DB;
use Excel;

class ExportPriController extends Controller
{
   function index()
    {

     $pri_data = DB::table('pris')->paginate(10);

     return view('export_pri')->with('pri_data', $pri_data);
    }

    function excel()
    {
     
     return Excel::download( new PriExport, 'dados_pri.xlsx');
    
         }// //
}
