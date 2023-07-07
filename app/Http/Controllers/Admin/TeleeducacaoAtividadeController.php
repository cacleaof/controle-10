<?php

namespace App\Http\Controllers\Admin;

use App\Models\Atividade;
use App\Models\TeleeducacaoAtividade;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeleeducacaoAtividadeController extends Controller
{
    const URL = 'https://smart.homolog.lais.ufrn.br/';
    const TOKEN = 'c74eff9ef4086a8ff418ced9a8f73588e9aa9505';
    const COD_NUCLEO = '7818211';
    public function index()
   {

   }

   public function store(Request $request)
   {
       $data = $request->input('data');
       //dd($data);
       $integra = new \Integra(self::TOKEN);
       $teleeducacao = TeleeducacaoAtividade::all();
       $ativi = Atividade::all();
       echo '<fieldset>';
       echo '<legend>Atividades de Tele-educação</legend>';

       $atividade = new \TeleeducacaoAtividade("","");

       foreach ($teleeducacao as $tele){
           $atividade->addAtividade("$tele->id_curso","$tele->dtdispo","$tele->cargah","$tele->tipo","$tele->decs");
       }

       foreach ($ativi as $ativ){
           $atividade->addParticipacaoAtividade("$ativ->id_curso","$ativ->dtparti","$ativ->cpf","$ativ->cbo","$ativ->cnes","$ativ->ine","$ativ->satif");
       }

       $dados_serializados_atividade = \Integra::serializar(\TipoDeDados::JSON, $atividade);
       echo "<h3>.: Dados Serializados - Atividades de Tele-educação :.</h3>";
       echo $dados_serializados_atividade;

       $resposta_atividade = $integra->enviarDados(\TipoDeDados::JSON, self::URL."api/v2/atividades-teleeducacao/?format=json",$dados_serializados_atividade);
       echo "<h3>.: Resposta do Servidor - Atividades de Tele-educação :.</h3>";
       echo $resposta_atividade;
       echo "</fieldset>";

   }
}
