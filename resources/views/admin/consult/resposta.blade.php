@extends('adminlte::page')

@section('title', 'Teleconsultoria')

@section('content_header')
    <h1>Teleconsultoria e Tele-ECG</h1>

    <!--<ol class='breadcrumb'>
    	<li><a ref="">Dashboard</a></li>
    	<li><a ref="">Consult</a></li>
    	<li><a ref="">Entrada</a></li>
    </ol> -->
@stop
@include('admin.includes.modelo')
@section('content')
	<div class="container col-md-9">
        <div class="box">
        <div class="box-header">
            <a href="{{ route('consult.dev_cons', ['sid' => $sid]) }}" class="btn btn-danger"><i class="fa fa-fw fa-exchange"></i>Devolver ao Regulador</a>
            <a href="{{ route('consult.respcons', ['sid' => $sid]) }}" class="btn btn-success"><i class="fa fa-fw fa-paper-plane-o"></i>Preparar a Resposta</a>
        </div>
        </div>
    </div>
    <div class="col-md-12">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Dados da TeleConsultoria Selecionada</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form">
            <div class="box-body">
                <div class="form-group">
                        <p><strong>Identificação: </strong> {{ $consult->id}}</p>
                    </div>
                    <div class="form-group">
                        <p><strong>Tempo: </strong>{{ tempo($consult->created_at) }}</p>
                    </div>
                    <div class="form-group">
                        <p><strong>Status: </strong>{{ showstat($consult->status) }}</p>
                    </div> 
                    <div class="col-md-6">
                        <p><strong>Solicitante:</strong> {{ $consult->user->name}} </p>
                    </div>
                    <div class="col-md-3">
                                <p><strong>Profissão:</strong> {{ $consult->user->ocupacao}} </p>
                    </div>
                    <div class="col-md-3">
                            <p><strong>Especialidade:</strong> {{ $consult->user->especialidade}} </p>
                    </div>
                    <div class="col-md-3">
                        <p><strong>Conselho:</strong> {{ $consult->user->conselho}} </p>
                    </div>
                    <div class="col-md-2">
                        <p><strong>Numero:</strong> {{ $consult->user->num_conselho}} </p>
                    </div>
                    <div class="col-md-2">
                        <p><strong>Nascimento:</strong> {{ $consult->user->data_nascimento}} </p>
                    </div>
                    <div class="col-md-3">
                        <p><strong>Unidade de Saúde:</strong> {{ $consult->user->nome_fantasia}} </p>
                    </div>

                    @if ($consult->nome_paciente == null)
                        <div class="col-md-6">
                            <p><strong>Paciente:</strong> {{ $consult->nome_paciente}} </p>
                        </div>
                    @else
                        <div class="col-md-6">
                            <p><strong>Paciente:</strong> {{ $consult->nome_paciente}} </p>
                        </div>      
                    @endif                       
                
                <div class="form-group ">
                    @if ($consult->fatores == null)
                        <div class="col-md-12" style="display:none">
                            <p><strong>Fatores:</strong> {{ $consult->fatores}} </p>
                        </div>
                    @else
                        <div class="col-md-12">
                            <p><strong>Fatores:</strong> {{ $consult->fatores}} </p>
                        </div>
                    @endif

                </div>
                <div class="form-group ">
                    @if ($consult->medicamento == null)
                        <div class="col-md-12" style="display:none"> 
                            <p><strong>Medicamentos:</strong> {{ $consult->medicamento}} </p>
                        </div>   
                    @else
                        <div class="col-md-12">
                            <p><strong>Medicamentos:</strong> {{ $consult->medicamento}} </p>
                        </div> 
                    @endif
                    
                </div>
                <div class="form-group ">
                    @if ($consult->pressao == null)
                        <div class="col-md-3" style="display:none">
                            <p><strong>Pressão:</strong> {{ $consult->pressao}} </p> 
                        </div>
                    @else
                        <div class="col-md-3">
                            <p><strong>Pressão:</strong> {{ $consult->pressao}} </p> 
                        </div>
                    @endif
                   
                    @if ($consult->peso == null)
                        <div class="col-md-3" style="display:none">
                            <p><strong>Peso:</strong> {{ $consult->peso}} </p>
                        </div>
                    @else
                        <div class="col-md-3">
                            <p><strong>Peso:</strong> {{ $consult->peso}} </p>
                        </div>    
                    @endif
                   
                    @if ($consult->altura == null)
                        <div class="col-md-3" style="display:none">
                            <p><strong>Altura:</strong> {{ $consult->altura}} </p>
                        </div>
                    @else
                        <div class="col-md-3">
                            <p><strong>Altura:</strong> {{ $consult->altura}} </p>
                        </div>
                    @endif
                    
                    @if ($consult->intensidade == null)
                        <div class="col-md-3" style="display:none">
                            <p><strong>Intensidade:</strong> {{ $consult->intensidade}} </p>
                        </div>
                    @else
                        <div class="col-md-3">
                            <p><strong>Intensidade:</strong> {{ $consult->intensidade}} </p>
                        </div>  
                    @endif
                    
                </div>
                
                <div class="form-group">
                    @if ($consult->irradiacao == null)
                        <div class="col-md-12" style="display:none">
                            <p><strong>Irradiação:</strong> {{$consult->irradiacao}}</p>
                        </div>
                    @else
                        <div class="col-md-12">
                            <p><strong>Irradiação:</strong> {{$consult->irradiacao}}</p>
                        </div> 
                    @endif
                    
                </div>
               
                <div class="form-group">
                    @if ($consult->consulta == null)
                    <div class="col-md-12" style="display:none">
                        <p><strong>Solicitação: </strong> {{ $consult->consulta}}</p>
                    </div>
                    @else
                    <div class="col-md-12">
                        <p><strong>Solicitação: </strong> {{ $consult->consulta}}</p>
                    </div>   
                    @endif
                    
                </div>
                 <div class="form-group">
                    @if ($consult->resposta == null)
                    <div class="col-md-12" style="display:none">
                        <p><strong>Resposta do Consultor: </strong> {{ $consult->resposta}}</p>
                    </div>
                    @else
                    <div class="col-md-12">
                        <p><strong>Resposta do Consultor: </strong> {{ $consult->resposta}}</p>
                    </div>   
                    @endif
                    
                </div>
                 <div class="form-group">
                    @if ($consult->cons_replica == null)
                    <div class="col-md-12" style="display:none">
                        <p><strong>Replica do Solicitante: </strong> {{ $consult->cons_replica}}</p>
                    </div>
                    @else
                    <div class="col-md-12">
                        <p><strong>Replica do Solicitante: </strong> {{ $consult->cons_replica}}</p>
                    </div>   
                    @endif
                    
                </div>
                <div class="form-group">
                    @if ($consult->replica == null)
                    <div class="col-md-12" style="display:none">
                        <p><strong>Replica do Consultor: </strong> {{ $consult->replica}}</p>
                    </div>
                    @else
                    <div class="col-md-12">
                        <p><strong>Replica do Consultor: </strong> {{ $consult->replica}}</p>
                    </div>   
                    @endif
                    
                </div>
                <div class="form-group">
                    @if ($consult->caracteristica == null)
                        <div class="col-md-12" style="display:none">
                            <p><strong>Característica da dor: </strong> {{$consult->caracteristica}} </p>
                        </div>
                    @else
                        <div class="col-md-12">
                            <p><strong>Característica da dor: </strong> {{$consult->caracteristica}} </p>
                        </div>   
                    @endif
                    
                </div>
                <div class="form-group">
                    @if ($consult->episodio == null)
                    <div class="col-md-6" style="display:none">
                        <p><strong>Data do últimp episódio: </strong> {{ date( 'd/m/Y' , strtotime($consult->episodio))}} </p>
                    </div>
                    @else
                    <div class="col-md-6">
                        <p><strong>Data do últimp episódio: </strong> {{ date( 'd/m/Y' , strtotime($consult->episodio))}} </p>
                    </div>   
                    @endif

                    @if ($consult->duracao == null)
                    <div class="col-md-6" style="display:none">
                        <p><strong>Duração: </strong> {{ $consult->duracao}} </p>
                    </div>
                    @else
                    <div class="col-md-6">
                        <p><strong>Duração: </strong> {{ $consult->duracao}} </p>
                    </div>
                        
                    @endif

                </div>
                <div class="form-group">
                    @if ($consult->recidiva == null)
                    <div class="col-md-12" style="display:none">
                        <p><strong>Recidiva da dor há quanto tempo: </strong> {{ $consult->recidiva}} </p>
                    </div>
                    @else
                    <div class="col-md-12">
                        <p><strong>Recidiva da dor há quanto tempo: </strong> {{ $consult->recidiva}} </p>
                    </div>
                        
                    @endif
                   
                </div>
                <div class="form-group">
                    @if ($consult->sintomas == null)
                    <div class="col-md-12" style="display:none">
                        <p><strong>Sintomas Associados: </strong> {{ $consult->sintomas}} </p>
                    </div>
                    @else
                    <div class="col-md-12">
                        <p><strong>Sintomas Associados: </strong> {{ $consult->sintomas}} </p>
                    </div>   
                    @endif   
                </div>

                <div class="form-group">
                    @if ($consult->idade == null)
                    <div class="col-md-6" style="display:none">
                        <p><strong>Idade: </strong> {{ $consult->idade}} </p>
                    </div>
                    @else
                    <div class="col-md-6">
                        <p><strong>Idade: </strong> {{ $consult->idade}} </p>
                    </div>   
                    @endif   
                </div>

                <div class="form-group">
                    @if ($consult->servico == null)
                    <div class="col-md-6" style="display:none">
                        <p><strong>Serviço: </strong> {{ $consult->servico}} </p>
                    </div>
                    @else
                    <div class="col-md-6">
                        <p><strong>Serviço: </strong> {{ $consult->servico}} </p>
                    </div>   
                    @endif   
                </div>

                <div class="form-group">
                    @if ($consult->queixa == null)
                    <div class="col-md-12" style="display:none">
                        <p><strong>Patologia e ou Comorbidade: </strong> {{ $consult->queixa}} </p>
                    </div>
                    @else
                    <div class="col-md-12">
                        <p><strong>Patologia e ou Comorbidade: </strong> {{ $consult->queixa}} </p>
                    </div>   
                    @endif   
                </div>

                <div class="form-group">
                    @if ($consult->instituiçao == null)
                    <div class="col-md-6" style="display:none">
                        <p><strong>Instituição: </strong> {{ $consult->instituiçao}} </p>
                    </div>
                    @else
                    <div class="col-md-6">
                        <p><strong>Instituição: </strong> {{ $consult->instituiçao}} </p>
                    </div>   
                    @endif   
                </div>

                <div class="form-group">
                    @if ($consult->municipio_sol == null)
                    <div class="col-md-6" style="display:none">
                        <p><strong>Município: </strong> {{ $consult->municipio_sol}} </p>
                    </div>
                    @else
                    <div class="col-md-6">
                        <p><strong>Município: </strong> {{ $consult->municipio_sol}} </p>
                    </div>   
                    @endif   
                </div>

                <div class="form-group">
                    @if ($consult->area == null)
                    <div class="col-md-6" style="display:none">
                        <p><strong>Área: </strong> {{ $consult->area}} </p>
                    </div>
                    @else
                    <div class="col-md-6">
                        <p><strong>Área: </strong> {{ $consult->area}} </p>
                    </div>   
                    @endif   
                </div>

                <div class="form-group">
                    <div class="col-md-12">
                        @if($consult->anexos!=null)

                        @forelse($files as $file)

                            @if( $file->user_id == auth()->user()->id )

                            <p><strong>ARQUIVO DO TELECONSULTOR: </strong></p>  <a href="{{ route('consult.download_C', ['sid' => $file->id, 'cid' => $file->user_id]) }}">
                            
                                <button type="button" class="btn btn-primary">
                                 
                                        Baixar o Arquivo: {{ $file->file}}
                                   </button>
                            </a>

                            @else

                            <p><strong>ARQUIVO DO SOLICITANTE: </strong></p>  <a href="{{ route('consult.download_S', ['sid' => $file->id, 'cid' => $file->user_id]) }}">
                            
                                <button type="button" class="btn btn-primary">
                                 
                                        Baixar o Arquivo: {{ $file->file}}
                                   </button>
                            </a>

                            @endif

                        @empty
                            <p>A Consultoria não tem Arquivo anexado!</p>
                            @endforelse

                            
                        @endif
                    </div>
                    
                </div>
               <!-- <div class="form-group">
                    <a href="#" class="btn btn-success" onClick="modalshow({{ $consult }})"><i class="fa fa-pencil" aria-hidden="true"></i> Detalhar a Teleconsultoria</a>
                </div>-->


            </div>
            <!-- /.box-body -->

        </form>
    </div>
    </div>


@stop
<script type="text/javascript">
  function modalshow($consult){
      $("#modalshow").modal();
    }
</script>

