<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileFormRequest;
use App\Models\Colaborador; 
use DB;

class GecadControl extends Controller 
{
	public function lista()
	    { 
    	//$qualquer = DB::select('select * from gecad.colaboradors');	
         $colaboradors = DB::connection('cadastro')->table('colaboradors')->get(); 
	//dd($qualquer); 

          	return view('admin.gecad.lista', compact('colaboradors')); 
		 
	//return view('admin.gecad.lista');

          }
  }
