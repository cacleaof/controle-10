<?php

namespace App\Http\Controllers\Admin;


use App\Models\ProfissionalSaude;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\User;
use App\Models\Auser;


require("classes/integra.class.php");

class SmartController extends Controller
{
    public function index()
    {
        $profissional = ProfissionalSaude::all();
        return view('admin.smart.e-profissional',compact('profissional'));
    }

    public function consultoria()
    {
        $profissional = ProfissionalSaude::all();
        return view('admin.smart.e-profissional',compact('profissional'));
    }


    public function nprof()
    {
        $profissional = ProfissionalSaude::all();
        return view('admin.smart.nprof',compact('profissional'));
    }

    public function eatividade()
    {
        $profissional = DB::connection('moodle')->table('mdl_user')->get();
	//$profissional = DB::connection('moodle')->select('select * from mdl_user');

        dd($profissional);
        return view('admin.smart.nprof',compact('profissional'));
    }
    public function impprof()
    {
        
	$users = user::all()->reverse();
        $profissional = ProfissionalSaude::all();
        return view('admin.smart.nprof',compact('profissional'));
    }
    public function implist(Request $request)
    { 
	$data = $request->data; 

	$Ausers = DB::connection('assist')->table('users')->get(); 
    	//$Ausers = DB::table('users')->get(); 	
         //$Ausers = Auser::all()->reverse();
	 
       	return view('admin.smart.implist', compact('Ausers', 'data'));
     }
     public function usuario(Request $request)
    { 
	$data = $request->data; 

	$cid = $request->cid;

	$Ausers = DB::connection('assist')->table('users')->find($cid); 	
	
       	return view('admin.smart.usuario', compact('Ausers', 'cid', 'data'));
     }

	public function store(User $user, Request $request)
    {
    		
           // $dataForm = User::where('cpf', $request->cpf)->get()->first();

	    //if(!empty($request->consulta)) {
            
	    $dataForm = new ProfissionalSaude;
            $dataForm->cpf = $request->cpf;
            $dataForm->nome = $request->nome;
            $dataForm->cns = $request->cns;
            $dataForm->cnes = $request->cnes;
            $dataForm->cbo = $request->cbo;
            $dataForm->sexo = $request->sexo[0];
	    $dataForm->tprof = $request->profsaude;
	    $dataForm->data = $request->data;

       	    $dataForm->save();

            $data = $request->data; 

              return redirect()
                    ->route('admin.smart.implist', compact('Ausers', 'data'))
                    ->with('success', 'Smart Atualizado');
    }



    public function storenprof(Request $request)
    {
        if(!empty($request->nomeprof)) {
            $dataForm = new ProfissionalSaude;
            $dataForm->nome = $request->nomeprof;
            $dataForm->tprof = $request->tipoprof;
            $dataForm->cns = $request->cns;
            $dataForm->cnes = $request->cnes;
            $dataForm->cbo = $request->cbo;
            $dataForm->cpf = $request->cpf;
            $dataForm->sexo = $request->sexo;
            $dataForm->ine= $request->ine;
            $dataForm->data = $request->data;
            $dataForm->save();
        }
        $profissional = ProfissionalSaude::all();
        return view('admin.smart.e-profissional',compact('profissional'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProfissionalSaude  $profissionalSaude
     * @return \Illuminate\Http\Response
     */
    public function show(ProfissionalSaude $profissionalSaude)
    {


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProfissionalSaude  $profissionalSaude
     * @return \Illuminate\Http\Response
     */
    public function edit(ProfissionalSaude $profissionalSaude)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProfissionalSaude  $profissionalSaude
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProfissionalSaude $profissionalSaude)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProfissionalSaude  $profissionalSaude
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProfissionalSaude $profissionalSaude)
    {
        //
    }
}
