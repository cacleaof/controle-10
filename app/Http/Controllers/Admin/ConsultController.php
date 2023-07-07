<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Consult;
use App\Models\Perfil;
use App\Models\file;
use App\Models\Profissoe;
use App\Models\Especialidade;
use DB;
use App\Library\Curls;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\SolicitacaoConsultoria;
use App\Mail\consultor;
use App\Mail\solicitante;
use BigBlueButton\Parameters\CreateMeetingParameters;
use JoisarJignesh\Bigbluebutton\Facades\Bigbluebutton;


class ConsultController extends Controller
{

   public function entrada(Consult $consult, Perfil $perfil, User $user)
   { 
     $solS=null;
     $nomeconsultor=null;
     //dd(date("Y-m-d"));
 
 
 if (perfil()['solS']) {
 
$consults = Consult::where('user_id', auth()->user()->id)
                     ->wherein('status', ['S', 'A', 'D'])->get();
                 
 
 }
 else{$consults=null;}
 if (perfil()['solA']) {
 
 $consults = $consult->all()->reverse();
 
 }
 if (perfil()['solR']) {
 $conreg = Consult::where('status', 'R')->get();
 
 }
 else{$conreg=null;}
 if (perfil()['solC']) {
 $conscons = Consult::where('cons_id', auth()->user()->id)
                     ->wherein('status', ['C', '2'])->get();
 }
 else{$conscons=null;}
 	return view('admin.consult.entrada', compact('consults', 'conreg', 'solS', 'conscons', 'nomeconsultor' ));
 }
    public function saida(Consult $consult, Perfil $perfil, User $user)
    {
 
        if (perfil()['solS']) 
        {  
        $consults = Consult::where('user_id', auth()->user()->id)->wherein('status', ['R', 'C'])->get()->reverse();

         
         return view('admin.consult.saida', compact('consults'));

        }
        if (perfil()['solA']) 
        {  
        $consults = Consult::where('status', ['R', 'C'])->get()->reverse();

         
         return view('admin.consult.saida', compact('consults'));

        }
        if (perfil()['solC']) 
        {  
        $consults = Consult::where('cons_id', auth()->user()->id)->wherein('status', ['R', 'S', 'A'])->get();

         
         return view('admin.consult.saida', compact('consults'));

        }
        if (perfil()['solR'])
        {
            $consults = Consult::where('reg_id', auth()->user()->id)->wherein('status', ['C', 'S', 'A'])->get();    
                                    
        return view('admin.consult.saida', compact('consults'));
        }
    }
    public function finalizada(Consult $consult)
    {
        $perfils = Perfil::where('user_id', auth()->user()->id)->get()->first();

    if (is_null($perfils)) {
                $perfils = new perfil;
                $perfils->user_id = auth()->user()->id;
                $perfils->perfil = 'S';
                $perfils->save();
            }else{}


        $id = auth()->user()->id;
        
        if (perfil()['solR']) {
            $consults = Consult::where('reg_id', $id)->get();
            }
        if (perfil()['solC']) {
                $consults = Consult::where('cons_id', $id)->get();
            }
        if (perfil()['solS']) {
                $consults = Consult::where('user_id', $id)->get()->reverse();
            }
        if (perfil()['solA']) {
                $consults = $consult->all()->reverse();
            }           
        return view('admin.consult.finalizada', compact('consults'));
    }
    public function nova(Consult $consult, Perfil $perfil)
    {
        //if($perfil->select('perfil')->where( 'user_id' , auth()->user()->id)->first()->perfil == 'S')
        if(perfil()['solS'])
        {
        $consults = $consult->all();

        return view('admin.consult.nova', compact('consults'));
        }
        else
        {
         return redirect()
                    ->route('consult.entrada')
                    ->with('error', 'Seu perfil não pode solicitar uma TeleConsultoria');   
        }
    } 
    public function novaecg(Consult $consult, Perfil $perfil)
    {
        //if($perfil->select('perfil')->where( 'user_id' , auth()->user()->id)->first()->perfil == 'S')
        if(perfil()['solS'])
        {
        $consults = $consult->all();

        return view('admin.consult.novaecg', compact('consults'));
        }
        else
        {
         return redirect()
                    ->route('consult.entrada')
                    ->with('error', 'Seu perfil não pode solicitar uma TeleConsultoria');   
        }
    } 

    public function WordsSearch() 
    {
        $client = new Client([
            'headers' => ['content-type' => 'application/xml' , 'Accept' => 'application/xml' ]]);
        $response = $client->request('GET', 'http://decs.bvsalud.org/cgi-bin/mx/cgi=@vmx/decs/?words=dengue');
        $data = $response->getBody();
        $data = simplexml_load_string($data);
        dd($data);

    return view('admin.consult.wordssearch', compact('data'));
    //return $content;
    }
    public function get_cep(Request $request)
    {
    $cep = $request->cep;
    $url = 'https://viacep.com.br/ws/'.$cep.'/json/';
    return redirect()
                    ->back();
    }

    public function store(Request $request)
    {
    if(!empty($request->consulta)) {
        $arquivos = $request->file('arquivo');
        $dataForm = new Consult;
        $dataForm->consulta = $request->consulta;
        $dataForm->servico = $request->servico;
        $dataForm->ativo = $request->ativo;
        $dataForm->nome_paciente = $request->nome_paciente;
        $dataForm->idade = $request->idade;
        $dataForm->queixa = $request->queixa;
        $dataForm->instituiçao = $request->instituiçao;
        $dataForm->municipio_sol = $request->municipio_sol;
        $dataForm->area = $request->area;
        $nome = $request->file;
        $dataForm->status = 'R';
        $dataForm->user_id = auth()->user()->id;
        $dataForm->save();
        $idc = $dataForm->id;
        if(!empty($arquivos)):
                $dataForm->anexos = '1';
                $dataForm->update(); 
            $t_t = '0' ;  
            foreach ($arquivos as $arquivo):
            $t_arq = $arquivo->getClientSize();
            $t_t = $t_arq + $t_t;
            endforeach;
        
            if($t_t < '1000000'){
            foreach ($arquivos as $arquivo):
                //dd($arquivo->getClientSize());
        
                $data = new file;
                $data->consult_id = $idc;
                $data->size = $arquivo->getClientSize();
                $nome = $arquivo->getClientOriginalName();
                $nome = $idc.'-'.$nome;
                $data->file = $nome;
                $data->user_id = auth()->user()->id;
                $data->save();
                Storage::putfileAs($dataForm->user_id.'/'.$idc, $arquivo, $nome);
        
            endforeach;
            }
            else {
                return redirect()
                    ->back()
                    ->with('error', 'Os arquivos que você anexou excedem o tamanho máximo permitido de 1 MB (Megabyte). Tente transformar seu arquivo em .PDF ou diminua a resolução de fotos. Você também pode enviar o link do arquivo. Caso necessite suporte envie email para telessaude.contato@saude.pe.gov.br que vamos ajudá-lo');
            }
            endif;
        return redirect()
                    ->route('consult.entrada')
                    ->with('success', 'TeleConsultoria enviada com sucesso - Prazo Máximo de resposta 72 horas');
    }
    else {
        return redirect()
                    ->back()
                    ->with('error', 'O campo descreva sua dúvida ou questionamento, e deve ser preenchido para envio da consultoria');
    }
    }
  public function cons_store(Consult $consult, Request $request)
    {
    if(!empty($request->cons_replica)) {
        $sid = $request->sid;
        $consult = Consult::find($sid);
        $arquivos = $request->file('arquivo');
        $consult->cons_replica = $request->cons_replica;
        $nome = $request->file;
        $consult->status = '2';
        $consult->save();
        if(!empty($arquivos)):
                $consult->anexos = '1';
                $consult->update();
            foreach ($arquivos as $arquivo):

                $data = new file;
                $data->consult_id = $sid;
                $data->size = $arquivo->getClientSize();
                $nome = $arquivo->getClientOriginalName();
                $nome = $sid.'-'.$nome;
                $data->file = $nome;
                $data->user_id = auth()->user()->id;
                $data->save();
                Storage::putfileAs($consult->user_id.'/'.$sid, $arquivo, $nome);
            endforeach;
        endif;

        return redirect()
                    ->route('consult.entrada')
                    ->with('success', 'Replica da TeleConsultoria enviada com sucesso');
    }
    else {
        return redirect()
                    ->back()
                    ->with('error', 'O campo replica deve ser preenchido para envio da consultoria');
    }
    }
    public function storeecg(Request $request)
    {
    if(!empty($request->consulta)) {
        $arquivos = $request->file('arquivo');
        $dataForm = new Consult;
        $dataForm->consulta = $request->consulta;
        $dataForm->servico = $request->servico;
        $dataForm->ativo = $request->ativo;
        $dataForm->idade = $request->idade;
        $dataForm->queixa = $request->queixa;
        $dataForm->instituiçao = $request->instituiçao;
        $dataForm->municipio_sol = $request->municipio_sol;
        $dataForm->area = $request->area;
        $dataForm->nome_paciente = $request->nome_paciente;
        $dataForm->data_nascimento = $request->data_nascimento;
        $dataForm->sexo = $request->sexo;
        $dataForm->cpf = $request->cpf;
        $dataForm->cns = $request->cns;
        $dataForm->peso = $request->peso;
        $dataForm->telefone = $request->telefone;
        $dataForm->endereco = $request->endereco;
        $dataForm->bairro = $request->bairro;
        $dataForm->cidade = $request->cidade;


        //$dataForm->motivo = $request->motivo;

        $dataForm->motivo = $request->input('motivo');
        $dataForm->motivo = implode(',', $dataForm->motivo);

        $input = $request->except('motivo');
        //Assign the "mutated" news value to $input
        $input['motivo'] = $dataForm->motivo;

        //$dataForm->fatores = $request->except('fatores');
        //$input['fatores'] = $fatores;

        $dataForm->fatores = $request->input('fatores');
        $dataForm->fatores = implode(',', $dataForm->fatores);

        $input = $request->except('fatores');
        //Assign the "mutated" news value to $input
        $input['fatores'] = $dataForm->fatores;
        

       // $dataForm->medicamento = $request->medicamento;

        $dataForm->medicamento = $request->input('medicamentos');
        $dataForm->medicamento = implode(',', $dataForm->medicamento);

        $input = $request->except('medicamentos');
        //Assign the "mutated" news value to $input
        $input['medicamentos'] = $dataForm->medicamento;

        $dataForm->pressao = $request->pressao;
        $dataForm->altura = $request->altura;
        $dataForm->localizacao = $request->localizacao;
        $dataForm->intensidade = $request->intensidade;
        $dataForm->irradiacao = $request->irradiacao;

        //$dataForm->caracteristica = $request->caracteristica;

        $dataForm->caracteristica = $request->input('caracteristica');
        $dataForm->caracteristica = implode(',', $dataForm->caracteristica);

        $input = $request->except('caracteristica');
        //Assign the "mutated" news value to $input
        $input['caracteristica'] = $dataForm->caracteristica;

        //
        $dataForm->sintomas = $request->input('sintomas');
        $dataForm->sintomas = implode(',', $dataForm->sintomas);

        $input = $request->except('sintomas');
        //Assign the "mutated" news value to $input
        $input['sintomas'] = $dataForm->sintomas;

        $dataForm->solicitante = $request->solicitante;
        $dataForm->episodio = $request->episodio;
        $dataForm->duracao = $request->duracao;
        $dataForm->recidiva= $request->recidiva;
        $dataForm->consulta = $request->consulta;
        $dataForm->servico = $request->servico;
        $dataForm->ativo = $request->ativo;
        $dataForm->idade = $request->idade;
        $dataForm->queixa = $request->queixa;
        $dataForm->instituiçao = $request->instituiçao;
        $dataForm->municipio_sol = $request->municipio_sol;
        $dataForm->area = $request->area;
        $nome = $request->file;
        $dataForm->status = 'R';
        $dataForm->user_id = auth()->user()->id;
        $dataForm->save();
        
        $idc = $dataForm->id;
        if(!empty($arquivos)):
                $dataForm->anexos = '1';
                $dataForm->update();
            foreach ($arquivos as $arquivo):

                $data = new file;
                $data->consult_id = $idc;
                $data->size = $arquivo->getClientSize();
                $nome = $arquivo->getClientOriginalName();
                $nome = $idc.'-'.$nome;
                $data->file = $nome;
                $data->user_id = auth()->user()->id;
                $data->save();
                Storage::putfileAs($dataForm->user_id.'/'.$idc, $arquivo, $nome);
            endforeach;
        endif;

        return redirect()
                    ->route('consult.entrada')
                    ->with('success', 'Tele-ECG enviado com sucesso - Prazo Máximo de Retorno 72 horas');
    }
    else {
        return redirect()
                    ->back()
                    ->with('error', 'O campo descreva sua dúvida ou questionamento, e deve ser preenchido para envio');
    }
    }
    public function regular(consult $consult, Request $request, Perfil $perfil, User $user, file $file, Especialidade $especialidade, Profissoe $profissoe )
    {
        $sid = $request->sid;
        $cid = $request->cid;
        $consult = Consult::find($request->sid);
        
        $files = $file->where('consult_id', $sid)->get();
        $consults = $consult->where('id', $request->sid)->get();
        
        //$solRs = Perfil::Select('user_id')->where('perfil', 'C')->get($perfil->user_id)->toArray();
        //dd($solRs);

            $consults = $consult->where('id', $request->sid)->get();
            $solRs = Perfil::select('perfils.user_id', 'users.name', 'users.email' , 'users.telefone_celular', 'users.ocupacao', 'users.especialidade')->join('users', 'users.id', 'perfils.user_id' )->where('perfil', 'C' )->get();  
            //$ft = User::select('users.user_id', 'users.fonte')->join('consults', 'consults.user_id')->where('fonte', 'C' )->get();   
            //dd($solRs);

        if($perfil->select('perfil')->where( 'user_id' , auth()->user()->id)->first()->perfil == 'R')
        {


        $downloads=DB::table('files')->get();
        
        return view('admin.consult.regular', compact('consult','consults', 'solRs',  'sid', 'cid', 'files', 'downloads' ));
        }
        else
        {
         return redirect()
                    ->route('consult.entrada')
                    ->with('error', 'Você não tem autorização para ver essa TeleConsultoria');   
        }
    } 

    public function showS(consult $consult, Request $request, Perfil $perfil, User $user, file $file)
    {
        $sid = $request->sid;
        $consult = Consult::find($request->sid);

        //if (perfil()['solA']) {
          //  return view('admin.consult.showS', compact('consult', 'solRs', 'users', 'sid', 'files', 'downloads'));   
        //}   

        if(perfil()['solA']|$consult->user_id == auth()->user()->id)
        {
        //$files = $file->where('consult_id', $sid)->where('user_id', $consult->cons_id)->get();
        $files = $file->where('consult_id', $sid)->get();

        //dd($files);

        $solRs = $perfil->where('perfil', 'C')->get($perfil->user_id);
        
        $users = $user->all();    

        $downloads=DB::table('files')->get();
        
        return view('admin.consult.showS', compact('consult', 'solRs', 'users', 'sid', 'files', 'downloads'));
        }
        else
        {
         return redirect()
                    ->route('consult.entrada')
                    ->with('error', 'Você não tem autorização para ver essa TeleConsultoria');   
        }
    } 
public function showSA(consult $consult, Request $request, Perfil $perfil, User $user, file $file)
    {
        $sid = $request->sid;
        $consult = Consult::find($request->sid);
        if(perfil()['solA'])
        {
        $files = $file->where('consult_id', $sid)->get();
        $solRs = $perfil->where('perfil', 'C')->get($perfil->user_id);
        
        $users = $user->all();    

        $downloads=DB::table('files')->get();
        
        return view('admin.consult.showSA', compact('consult', 'solRs', 'users', 'sid', 'files', 'downloads'));
        }
        else
        {
         return redirect()
                    ->route('consult.entrada')
                    ->with('error', 'Voc� n�o tem autoriza��o para ver essa TeleConsultoria');   
        }
    } 
    public function deletar(Request $request, file $file)
    {
            $sid = $request->sid;
            
            $consult = Consult::find($sid);

            $files = $file->all();

            foreach ($files as $file):

            if($sid == $file->consult_id){
                
                //Storage::delete($file->user_id.'/'.$file->consult_id.'/'.$file->file);
                Storage::deleteDirectory($file->user_id.'/'.$file->consult_id);
            }
            endforeach;

            $consult->delete();

              return redirect()
                    ->route('consult.entrada')
                    ->with('success', 'Consultoria Deletada');
            
    }
    public function show_store(Request $request)
    {

    if(!empty($request->sid)) {
        $dataForm = Consult::find($request->sid);
        $dataForm->av_duvida = $request->av_duvida;
        $dataForm->avaliaçao = $request->avaliaçao;
        $dataForm->av_comment = $request->av_comment;
        $dataForm->status = 'F';
        $dataForm->update();

        return redirect()
                    ->route('consult.entrada')
                    ->with('success', 'TeleConsultoria Avaliada pelo Solicitante e Finalizada');
    }
    else {
        return redirect()
                    ->back()
                    ->with('error', 'Problemas na avaliaçao');
    }
    }
    public function consultor(Consult $consult, Request $request, User $user)
    {
        
        $cid = $request->cid;
        $sid = $request->sid;
        
        $user = User::find($cid);
        DB::table('consults')
                    ->where('id', $request->sid)
                    ->update(['cons_id' => $request->cid, 'cons_name' => $user->name ]);
         return redirect()->back();           
    }
    public function modelo(Consult $consult, Request $request)
    {
        $sid = $request->sid;
        
        $consult = Consult::find($sid);
        
         return view('admin.consult.modelo', compact('consult'));          
    }
    public function encaminhar(Consult $consult, Request $request, User $user)
    {
        $consult = consult::find($request->sid);
        $cn = $consult->cons_name;

        if (!empty($cn)) {

        DB::table('consults')
                    ->where('id', $request->sid)
                    ->update(['status' => 'C','reg_id' => auth()->user()->id ,'reg_name' => auth()->user()->nome ]);

        return redirect(route('consult.entrada'))
                    ->with('success', 'Teleconsultoria regulada com sucesso');  
                }
        else { 
            return redirect()
                    ->back()
                    ->with('error', 'Você tem que escolher um Teleconsultor para atender esta solicitação antes de enviá-la');
        }          
    }
    public function selecresp(consult $consult, Request $request, Perfil $perfil, User $user, File $file)
    {
        
        $sid = $request->sid;
        $cid = $request->cid;
        $files = $file->where('consult_id', $sid)->get();
        
        $consult = Consult::find($request->sid);
        
        $solRs = $perfil->where('perfil', 'C')->get($perfil->user_id);
        
        $users = $user->all();

        $downloads=DB::table('files')->get();

        if($consult->cons_id == auth()->user()->id)
        {
        if($consult->servico == 'Tele-ECG')
            {
            return view('admin.consult.respostaecg', compact('consult', 'solRs', 'users', 'sid', 'cid', 'files', 'downloads'));
            }
        else
            {
            return view('admin.consult.resposta', compact('consult', 'solRs', 'users', 'sid', 'cid', 'files', 'downloads'));
            }
        }
        else
        {
         return redirect()
                    ->route('consult.entrada')
                    ->with('error', 'Você não tem autorização para ver essa TeleConsultoria');   
        }
    }

    public function respcons(File $file, Consult $consult, Request $request, Perfil $perfil, User $user)
    {
        //dd($consult->cons_id);
        
        $sid = $request->sid;
        $cid = $request->cid;
        $files = $file->where('consult_id', $sid)->get();
        $consult = Consult::find($request->sid);

               
        $solRs = $perfil->where('perfil', 'C')->get($perfil->user_id);
        $users = $user->all();
        $downloads=DB::table('files')->get();
        $dl = File::find($sid);
        if($consult->cons_id == auth()->user()->id)
        {

        return view('admin.consult.respcons', compact('consult', 'solRs', 'users', 'sid', 'cid', 'files', 'downloads'));
        }
        else
        {
         return redirect()
                    ->route('consult.entrada')
                    ->with('error', 'Você não tem autorização para ver essa TeleConsultoria');   
        }
        
    }
    public function respecg(File $file, Consult $consult, Request $request, Perfil $perfil, User $user)
    {
        //dd($consult->cons_id);
        
        $sid = $request->sid;
        $cid = $request->cid;
        $files = $file->where('consult_id', $sid)->get();
        
        $consult = Consult::find($request->sid);
        $solRs = $perfil->where('perfil', 'C')->get($perfil->user_id);
        $users = $user->all();
        $downloads=DB::table('files')->get();
        $dl = File::find($sid);
        if($consult->cons_id == auth()->user()->id)
        {

        return view('admin.consult.respecg', compact('consult', 'solRs', 'users', 'sid', 'cid', 'files', 'downloads'));
        }
        else
        {
         return redirect()
                    ->route('consult.entrada')
                    ->with('error', 'Você não tem autorização para ver esse Tele-ECG');   
        }
        
    }
	public function storecons(Request $request)
        {
        if(!empty($request->replica)||!empty($request->resposta))
        {
            $arquivos = $request->file('arquivo');
            $sid = $request->sid;
            $dataForm = Consult::find($request->sid);
            if(!empty($request->replica)) 
            {
             $dataForm->replica = $request->replica;   
            }
            if(!empty($request->resposta)) 
            {
            $dataForm->resposta = $request->resposta;
            }
            $dataForm->l_recom = $request->l_recom;
            $dataForm->dec1 = $request->dec1;
            $dataForm->dec2 = $request->dec2;
            $dataForm->dec3 = $request->dec3;
            

            $nome = $request->file;
            $dataForm->status = 'A';
            $dataForm->tempo = tempo($dataForm->created_at);
            $dataForm->update();
            $idc = $dataForm->id;
            if(!empty($arquivos)):
                $dataForm->anexos = '1';
                $dataForm->update();
            foreach ($arquivos as $arquivo):

                $data = new file;
                $data->consult_id = $idc;
                $data->size = $arquivo->getClientSize();
                $nome = $arquivo->getClientOriginalName();
                $nome = $idc.'-'.$nome;
                $data->file = $nome;
                $data->user_id = auth()->user()->id;
                $data->save();
                Storage::putfileAs($dataForm->user_id.'/'.$idc, $arquivo, $nome);
            endforeach;
            endif;

            return redirect()
                        ->route('consult.entrada')
                        ->with('success', 'Resposta da TeleConsultoria enviada com sucesso');
        }
        else {
        return redirect()
                    ->back()
                    ->with('error', 'O campo de resposta deve ser preenchido antes do envio');
    }
    }
        /*esta � a vers�o com o teleecg que est� dando erro no implode	    
            $dataForm->ritmo = $request->input('ritmo');
            $dataForm->ritmo = implode(', ', $dataForm->ritmo);

            $dataForm->frequencia = $request->input('frequencia');
            $dataForm->frequencia = implode(', ', $dataForm->frequencia);

            $dataForm->eixo = $request->input('eixo');
            $dataForm->eixo = implode(', ', $dataForm->eixo);

            $dataForm->onda_p = $request->input('onda_p');
            $dataForm->onda_p = implode(', ', $dataForm->onda_p);

            $dataForm->pr = $request->input('pr');
            $dataForm->pr = implode(', ', $dataForm->pr);

            $dataForm->qrs = $request->input('qrs');
            $dataForm->qrs = implode(', ', $dataForm->qrs);

            $dataForm->st = $request->input('st');
            $dataForm->st = implode(', ', $dataForm->st);

            $dataForm->onda_t = $request->input('onda_t');
            $dataForm->onda_t = implode(', ', $dataForm->onda_t);

            $dataForm->qt = $request->input('qt');
            $dataForm->qt = implode(', ', $dataForm->qt);
	    */
     public function download(File $file, Consult $consult, Request $request, User $user)
    {
        $sid = $request->sid;
        $cid = $request->cid;
        $dl =  file::find($sid);
        $ui = $dl->user_id;
        $ci = $dl->consult_id;
        $dl = $dl->file;

        $file= storage_path()."/app/public/".$ui."/".$ci."/".$dl;

        return Response::download($file, $dl);
        
    }
    public function downloadfim(File $file, Consult $consult, Request $request, User $user)
    {
        //$consult = Consult::find($request->sid);   
        
        $sid = $request->sid;
        $cid = $request->cid;
        $dl =  $file::find($sid);
        
        $ui = $dl->user_id;
        $ci = $dl->consult_id;
        //$ci = $sid;
        $dl = $dl->file;

        $file= storage_path()."/app/public/".$ui."/".$ci."/".$dl;

        return Response::download($file, $dl);
        
    }

    public function show()
    {
    //PDF file is stored under project/public/download/info.pdf
    //dd(storage_path());

    $file= storage_path()."/app/public/3/"."5filhos.jpg";

    $headers = array(
              'Content-Type: image/jpg',
            );

    return Response::download($file, '5filhos.jpg', $headers);
    }

    public function resposta(Consult $consult, Request $request, User $user)
    {
        dd($request->sid);

        DB::table('consults')
                    ->where('id', $request->sid)
                    ->update(['status' => 'C','reg_id' => auth()->user()->id ,'reg_name' => auth()->user()->nome ]);

         return redirect('/admin');           
    }
 	public function replica(File $file, Consult $consult, Request $request, User $user)
    {
        $sid = $request->sid;
        $consult = Consult::find($request->sid);
        $files = $file->where('consult_id', $sid)->get();
        $consults = $consult->where('id', $sid)->get();
        

         return view('admin.consult.replica', compact('consult', 'sid', 'files'));           
    }
    public function devolver(consult $consult, Request $request, Perfil $perfil, User $user)
    {  
        if($perfil->select('perfil')->where( 'user_id' , auth()->user()->id)->first()->perfil == 'R')
        {
        $consults = $consult->where('id', $request->sid)->get();
        
        $solRs = $perfil->where('perfil', 'C')->get($perfil->user_id);
        
        $sid = $request->sid;
        $users = $user->all();
        
        return view('admin.consult.devolver', compact('consults', 'solRs', 'users', 'sid'));
        }
        else
        {
         return redirect()
                    ->route('consult.entrada')
                    ->with('error', 'Você não tem perfil para Regular esta TeleConsultoria');   
        }
    } 
    public function dev_cons(consult $consult, Request $request, Perfil $perfil, User $user)
    {  
        $sid = $request->sid;
        $consult = Consult::find($request->sid);

        if($consult->cons_id == auth()->user()->id)
        {
        
        return view('admin.consult.dev_cons', compact('consult', 'sid'));

        }
        else
        {
         return redirect()
                    ->route('consult.entrada')
                    ->with('error', 'Você não tem autorização para ver essa TeleConsultoria');   
        }

    }
    public function devstore(Consult $consult, Request $request, User $user)
    {
       
        $cid = $request->cid;
        $sid = $request->sid;

        DB::table('consults')
                    ->where('id', $request->sid)
                    ->update(['devolutiva' => $request->devolutiva, 'status' => 'D' ]);

         return redirect(route('consult.entrada'));   
    }
    public function dev_con_store(Consult $consult, Request $request)
    {
        $sid = $request->sid;
        DB::table('consults')
                    ->where('id', $request->sid)
                    ->update(['devolutiva_cons' => $request->devolutiva, 'status' => 'R' ]);

         return redirect(route('consult.entrada'));   
    }

    public function laudo($id){
        $consults = Consult::find($id);

        //return view('admin.consult.laudo');
 
        return \PDF::loadView('admin.consult.laudo', compact('consults'))
                // Se quiser que fique no formato a4 retrato: ->setPaper('a4', 'landscape')
        ->download('laudo.pdf');
    }


    public function storeconsulta(Request $request)
    {
    if(!empty($request->resposta)) {
        $arquivos = $request->file('arquivo');
        $sid = $request->sid;
        $dataForm = Consult::find($request->sid);
        $dataForm->resposta = $request->resposta;
        $dataForm->l_recom = $request->l_recom;
        $dataForm->dec1 = $request->dec1;
        $dataForm->dec2 = $request->dec2;
        $dataForm->dec3 = $request->dec3;

        //dd($dataForm->ritmo);

        $nome = $request->file;
        $dataForm->status = 'A';
        $dataForm->tempo = tempo($dataForm->created_at);
        $dataForm->update();
        $idc = $dataForm->id;
        if(!empty($arquivos)):
            $dataForm->anexos = '1';
            $dataForm->update();
        foreach ($arquivos as $arquivo):

            $data = new file;
            $data->consult_id = $idc;
            $data->size = $arquivo->getClientSize();
            $nome = $arquivo->getClientOriginalName();
            $nome = $idc.'-'.$nome;
            $data->file = $nome;
            $data->user_id = auth()->user()->id;
            $data->save();
            Storage::putfileAs($data->user_id.'/'.$idc, $arquivo, $nome);
        endforeach;
        endif;

        return redirect()
                    ->route('consult.entrada')
                    ->with('success', 'Resposta da TeleConsultoria enviada com sucesso');
    }
    else {
    return redirect()
                ->back()
                ->with('error', 'O campo descreva sua dúvida ou questionamento, e deve ser preenchido para envio da consultoria');
    }
    }
	public function sala(){

        $nuser = auth()->user()->name;
        $random = Str::random(5);
       
        $url = \Bigbluebutton::start([
            'meetingID' => $random,
            //'name' => 'Teste',
            //'moderatorPW' => 'moderator', //moderator password set here
            //'attendeePW' => 'attendee', //attendee password here
            'userName' => $nuser,//for join meeting 
            'avatarURL' => '#8566',
            //'redirect' => false // only want to create and meeting and get join url then use this parameter 
        ]);
        
        return view('admin.consult.sala', compact('url'));
    }
}
