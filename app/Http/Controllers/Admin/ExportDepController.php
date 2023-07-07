<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin;
use App\Exports\DepExport;
use Maatwebsite\Excel\Concerns\FromCollection;
use DB;
use Excel;

class ExportDepController extends Controller
{
   function index()
    {

     $dep_data = DB::table('dependencias')->paginate(6);

     return view('export_dep')->with('dep_data', $dep_data);
    }

    function excel()
    {
     
     return Excel::download( new DepExport, 'dados_dependencias.xlsx');
    
         }// //
}
