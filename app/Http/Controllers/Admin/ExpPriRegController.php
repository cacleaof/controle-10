<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin;
use App\Exports\PriRegExport;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use App\Models\Pri;
use App\Models\Registro;
use DB;
use Excel;

class ExpPriRegController extends Controller
{
   function index(Registro $registro, Pri $pri)
    {

    $pri_data = DB::select("SELECT registros.id, registros.data, registros.acao, registros.nome_p , registros.nome , registros.cpf_p, pris.instituicao FROM registros LEFT JOIN pris ON registros.cpf_p=pris.cpf ORDER BY `id` ASC");  
     //$pri_data = registro::select('registros.data', 'registros.acao', 'pris.id', 'pris.nome', 'pris.cpf' )->Join('pris', 'pris.id', 'registros.user_id' )->get();

    //dd($pri_data);

     return view('exp_prireg')->with( 'pri_data', $pri_data);
    }

    function excel()
    {
     
     return Excel::download( new PriRegExport, 'registros_pri.xlsx');
    
         }// //
}
