<?php

namespace App\Http\Controllers\Admin;


use App\Models\ProfissionalSaude;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

require("classes/integra.class.php");

class ProfissionalSaudeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    const URL = 'https://smart.telessaude.ufrn.br/';
    const TOKEN = 'c74eff9ef4086a8ff418ced9a8f73588e9aa9505';
    const COD_NUCLEO = '7818211';

    public function index()
    {
        $profissional = ProfissionalSaude::all();
        return view('admin.smart.profissional',compact('profissional'));
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
    public function store(Request $request)
    {
        $data = $request->input('data');
        //dd($data);
        $integra = new \Integra(self::TOKEN);
        $profissionalSaude = ProfissionalSaude::all();
        echo '<br/><br/>';
        echo '<fieldset>';
        echo '<legend>Profissionais de Saúde</legend>';

        $profissional = new \ProfissionalSaude("7818211","$data");

        foreach ($profissionalSaude as $p){
            $profissional->addProfissionalSaude("$p->cns","$p->cpf","$p->nome","$p->cnes"
                ,"$p->cbo","$p->ine","$p->tprof","$p->sexo");
        }

        $dados_serializados_profissional = \Integra::serializar(\TipoDeDados::JSON, $profissional);
        echo "<h3>.: Dados Serializados - Profissional de Saúde :.</h3>";
        echo $dados_serializados_profissional;

        $resposta_profissional = $integra->enviarDados(\TipoDeDados::JSON, self::URL."api/v2/profissionais-saude/?format=json", $dados_serializados_profissional);
        echo "<h3>.: Resposta do Servidor - Profissional de Saúde :.</h3>";
        echo $resposta_profissional;
    }


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
