<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Concerns\FromCollection;
use DB;
use Excel;

class ExportUserController extends Controller
{
   function index()
    {

     $users_data = DB::table('users')->paginate(6);

     return view('export_users')->with('users_data', $users_data);
    }

    function excel()
    {
     
     return Excel::download( new UsersExport, 'dados_usuarios.xlsx');
    
         }// //
}
