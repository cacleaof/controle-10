<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin;
use App\Exports\ConsultExport;
use Maatwebsite\Excel\Concerns\FromCollection;
use DB;
use Excel;

class ExportExcelController extends Controller
{
   function index()
    {
     $consults_data = DB::table('consults')->paginate(6);
     
     return view('export_excel')->with('consults_data', $consults_data);
    }

    function excel()
    {
     
     return Excel::download( new ConsultExport, 'dados_consultorias.xlsx');
    
         }// //
}
