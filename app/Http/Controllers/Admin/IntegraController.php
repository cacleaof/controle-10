<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\TeleeducacaoAtividadeResource;
use App\Models\Atividade;
use App\Models\CursoTeleeducacao;
use App\Models\Integra;
use App\Models\ObjetoAprendizagem;
use App\Models\ProfissionalSaude;
use App\Models\EstabelecimentoSaude;
use App\Models\TeleeducacaoAtividade;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProfissionalSaudeResource;
use Illuminate\Support\Facades\DB;

use phpDocumentor\Reflection\Types\String_;
use Symfony\Component\Console\Input\ArrayInput;
use function GuzzleHttp\json_decode;
use function GuzzleHttp\json_encode;
use function GuzzleHttp\Promise\all;

require("classes/integra.class.php");


class IntegraController extends Controller 
{
    //const URL = 'https://smart.homolog.lais.ufrn.br/';
    const URL = 'https://smart.telessaude.ufrn.br/';
    const TOKEN = 'c74eff9ef4086a8ff418ced9a8f73588e9aa9505';
    const COD_NUCLEO = "7818211";

    function enviarCadastroProfissional(Request $request) {

        $data = $request->input('data');
        //dd($data);
        $integra = new \Integra(self::TOKEN);
        //$profissionalSaude = ProfissionalSaude::all();
        $profissionalSaude = DB::table('smart.profissional_saudes')->where('data', '=', $data)->get();
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

    function enviarTeleeducacaoObjetoAprendizagem(Request $request){

        $data = $request->input('data');
        $integra = new \Integra(self::TOKEN);
        $cod = self::COD_NUCLEO;
       // $objeto = ObjetoAprendizagem::all();
        $objeto = DB::table('smart.objeto_aprendizagems')->where('data', '=', $data)->get();
        echo '<br/><br/>';
        echo '<fieldset>';
        echo '<legend>Objetos de Aprendizagem</legend>';
        $objeto_aprendizagem = new \TeleeducacaoObjetoAprendizagem("$cod","$data");

        //dd($objeto);
        foreach ($objeto as $obj){
            $objeto_aprendizagem->addObjetoAprendizagem("$obj->id_curso","$obj->dtdispo",
                "$obj->dpltaf","$obj->dares","$obj->davasus",
                "$obj->drsociais","$obj->doutros","$obj->tipo","$obj->desc",
                "$obj->url","$obj->num_acess");
        }
        $dados_serializados_objeto_aprendizagem = \Integra::serializar(\TipoDeDados::JSON, $objeto_aprendizagem);
        echo "<h3>.: Dados Serializados - Objeto de Aprendizagem :.</h3>";
        echo $dados_serializados_objeto_aprendizagem;
        $resposta_objeto_aprendizagem = $integra->enviarDados(\TipoDeDados::JSON,self::URL."api/v2/objetos-aprendizagem/?format=json", $dados_serializados_objeto_aprendizagem);
        echo "<h3>.: Resposta do Servidor - Objeto de Aprendizagem :.</h3>";
       // dd($resposta_objeto_aprendizagem);
        echo $resposta_objeto_aprendizagem;
        echo "</fieldset>";

    }

    function enviarCursos(Request $request){

        $data = $request->input('data');
        $integra = new \Integra(self::TOKEN);
        $cod = self::COD_NUCLEO;
        echo '<br/><br/>';
        echo '<fieldset>';
        echo '<legend>Cursos</legend>';
        //$repro = DB::select("Select cpfs_repro from smart.curso_teleeducacaos where `data` = '$data'");

        $cur = DB::table('smart.curso_teleeducacaos')->where('data', '=', $data)->get();
        //$cur->toArray();
        $curso = new \TeleeducacaoCurso("$cod","$data");

        foreach ($cur as $c){
            //$cpf = $c->cpfs_repro->toArray();
            //dd($cpf);
            $curso->addCurso("$c->id_curso","$c->dtini","$c->dtfim","$c->vagas",
                "$c->desc","$c->cargah","$c->cpfs_matri","$c->cpfs_forma","$c->cpfs_evadi"
                ,"$c->cpfs_repro");
        }

        $dados_serializados_curso = \Integra::serializar(\TipoDeDados::JSON, $curso);
        echo "<h3>.: Dados Serializados - Curso :.</h3>";
        echo $dados_serializados_curso;

        $resposta_curso = $integra->enviarDados(\TipoDeDados::JSON, self::URL."api/v2/cursos-teleeducacao/?format=json", $dados_serializados_curso);
        echo "<h3>.: Resposta do Servidor - Curso :.</h3>";
        echo $resposta_curso;
        echo '</fieldset>';
    }

    function enviarAtualizacaoEstabelecimento(Request $request){

        $data = $request->input('data');
        $integra = new \Integra(self::TOKEN);
        $cod = self::COD_NUCLEO;
        echo '<br/><br/>';
        echo '<fieldset>';
        echo '<legend>Estabelecimentos</legend>';

        $estab = DB::table('smart.estabelecimento_saudes')->where('data', '=', $data)->get();
        dd($estab);
        $estabelecimento = new \EstabelecimentoSaude("$cod","$data");

        foreach ($estab as $est){
            $estabelecimento->atualizarEstabelecimentoSaude("$est->cnes","$est->tconsult",
                "$est->teduca","$est->tdiagn");

        }

        $dados_serializados_estabelecimento = \Integra::serializar(\TipoDeDados::JSON,$estabelecimento);
        echo "<h3>.: Dados Serializados - Estabelecimentos :.</h3>";
        echo $dados_serializados_estabelecimento;

	

        $resposta_estabelecimento = $integra->enviarDados(\TipoDeDados::JSON,self::URL."api/v2/dados-estabelecimentos-saude/?format=json", $dados_serializados_estabelecimento);
        echo "<h3>.: Resposta do Servidor - Estabelecimentos :.</h3>";
        echo $resposta_estabelecimento;
        echo "</fieldset>";

    }

    function enviarTeleeducacaoAtividade(Request $request){
        $data = $request->input('data');
        $integra = new \Integra(self::TOKEN);
        $cod = self::COD_NUCLEO;

        echo '<fieldset>';
        echo '<legend>Atividades de Tele-educação</legend>';

        //$ativ = TeleeducacaoAtividade::all();
        $ativ = DB::select("Select * from smart.teleeducacao_atividades where `data` = '$data'");
        $ativi = DB::select("Select * from smart.atividades where `data` = '$data'");
        
        $atividade = new \TeleeducacaoAtividade("$cod","$data");
        foreach($ativi as $ativi){
            $atividade->addAtividade("$ativi->id_curso","$ativi->dtdispo","$ativi->cargah","$ativi->tipo","$ativi->decs");
        
        }
     
        foreach ($ativ as $at){
            //$atividade->addAtividade("$at->id_curso","$at->dtdispo","$at->cargah","$at->tipo","$at->decs");
            $atividade->addParticipacaoAtividade("$at->id_curso","$at->dtparti","$at->cpf","$at->cbo","$at->cnes","$at->ine","$at->satisf");
        
        }

        $dados_serializados_atividade = \Integra::serializar(\TipoDeDados::JSON, $atividade);
        //dd($dados_serializados_atividade);
        echo "<h3>.: Dados Serializados - Atividades de Tele-educação :.</h3>";
        echo $dados_serializados_atividade;

        $resposta_atividade = $integra->enviarDados(\TipoDeDados::JSON, self::URL."api/v2/atividades-teleeducacao/?format=json",$dados_serializados_atividade);
        //dd($resposta_atividade);
        echo "<h3>.: Resposta do Servidor - Atividades de Tele-educação :.</h3>";
        echo $resposta_atividade;
        echo "</fieldset>";

    }

    function enviarTeleconsultoria(Request $request){
        $data = $request->input('data');
        $integra = new \Integra(self::TOKEN);
        $cod = self::COD_NUCLEO;

        echo '<br/><br/>';
        echo '<fieldset>';
        echo '<legend>Teleconsultoria</legend>';

        $telecon = DB::select("Select * from smart.teleconsultoria_envios where `data` = '$data'");

        $teleconsultoria = new \Teleconsultoria("$cod","$data");

        foreach ($telecon as $tele){

            $teleconsultoria->addSolicitacao("$tele->dtsol","$tele->tipo","$tele->canal",
                "$tele->solicitante_cpf","$tele->solicitante_cbo",
                "$tele->solicitante_cnes","$tele->equipe_solicitante",
                "$tele->solicitante_tipo",array($tele->cids),array($tele->ciaps,$tele->ciaps1),
                "$tele->dtresposta","$tele->evitou_encaminha",
                "$tele->inten_ecaminha","$tele->satisf","$tele->resp_duvida","$tele->possi_sof");
        }

        $dados_serializados_teleconsultoria = \Integra::serializar(\TipoDeDados::JSON,$teleconsultoria);
        echo "<h2>.: Dados Serializados - Teleconsultoria :.</h2>";
        echo $dados_serializados_teleconsultoria;

        $resposta_teleconsultoria = $integra->enviarDados(\TipoDeDados::JSON, self::URL."api/v2/teleconsultorias/?format=json",$dados_serializados_teleconsultoria);

        echo "<h2>.: Resposta do Servidor - Teleconsultoria :.</h2>";
        echo $resposta_teleconsultoria;
        echo "</fieldset>";

    }

    function enviarTelediagnostico(Request $request){
        $data = $request->input('data');
        $integra = new \Integra(self::TOKEN);
        $cod = self::COD_NUCLEO;

        echo '<br/><br/>';
        echo '<fieldset>';
        echo '<legend>Telediagnóstico</legend>';

        $teledia = DB::select("Select * from smart.telediagnostico_envios where `data` = '$data'");

        $telediagnostico =  new \Telediagnostico("$cod","$data");
        foreach ($teledia as $tel){
            $telediagnostico->addSolicitacao("$tel->dh_realizado_exame","$tel->codigo_tipo_exame",
                "$tel->codigo_equip"
            ,"$tel->tipo_justif","$tel->ponto_telediagnostico",
                "$tel->cpf_solicitante","$tel->especialidade_solicitante",
                "$tel->ponto_solicitacao","$tel->dh_laudo","$tel->cpf_laudista",
                "$tel->especialidade_laudista","$tel->ponto_laudista","$tel->cpf_paciente"
            ,"$tel->cns_paciente","$tel->cidade_paciente");
        }

        $dados_serializados_telediagnostico = \Integra::serializar(\TipoDeDados::JSON, $telediagnostico);
        echo "<h3>.: Dados Serializados - Telediagnóstico :.</h3>";
        echo $dados_serializados_telediagnostico;

        $resposta_telediagnostico = $integra->enviarDados(\TipoDeDados::JSON,self::URL."api/v2/telediagnosticos/?format=json",$dados_serializados_telediagnostico);
        echo "<h3>.: Resposta do Servidor - Telediagnóstico :.</h3>";
        echo $resposta_telediagnostico;
        echo "</fieldset>";

    }


}