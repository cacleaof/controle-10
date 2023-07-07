@extends('adminlte::page')

@section('title', 'Teleconsultoria')

@section('content_header')
    <h1>Teleconsultoria</h1>

    <!--<ol class='breadcrumb'>
    	<li><a ref="">Dashboard</a></li>
    	<li><a ref="">Consult</a></li>
    	<li><a ref="">Entrada</a></li>
    </ol> -->
@stop
@include('admin.includes.modelo')
@section('content')
<div class="col-md-12">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Dados da TeleConsultoria</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form method="POST" action="{{ route('consult.cons_store', ['sid' => $sid])}}" enctype="multipart/form-data">
                {!! csrf_field() !!}
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
                    @if ($consult->consulta == null)
                    <div class="col-md-12" style="display:none">
                        <p><strong>Resposta: </strong> {{ $consult->resposta}}</p>
                    </div>
                    @else
                    <div class="col-md-12">
                        <p><strong>Resposta: </strong> {{ $consult->resposta}}</p>
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
                    <div class="col-md-6">
                            <h4><strong>Arquivos Anexados na TeleConsultoria: </strong></h4>
                            
                            @forelse($files as $file)

                            @if( $file->user_id == auth()->user()->id )

                            <p><strong>ARQUIVO DO SOLICITANTE: </strong></p>  <a href="{{ route('consult.download_S', ['sid' => $file->id, 'cid' => $file->user_id]) }}">
                            
                                <button type="button" class="btn btn-primary">
                                 
                                        Baixar o Arquivo: {{ $file->file}}
                                   </button>
                            </a>

                            @else

                            <p><strong>ARQUIVO DO TELECONSULTOR: </strong></p>  <a href="{{ route('consult.download_C', ['sid' => $file->id, 'cid' => $file->user_id]) }}">
                            
                                <button type="button" class="btn btn-primary">
                                 
                                        Baixar o Arquivo: {{ $file->file}}
                                   </button>
                            </a>

                            @endif

                        @empty
                            <p>A Consultoria não tem Arquivos anexados!</p>
                            @endforelse                                    
                    </div>  
                </div>
        </div>
                <div class="box-body">
                    <label class="callout callout-info" for="cons_replica" >REPLICA - Complemente informações da sua Teleconsultoria :</label>
                    <textarea class="form-group col-xs-12 col-md-12" type="longtext" name="cons_replica" rows="4" cols="80" placeholder="Complemente informações da sua solicitação ou a pedido do teleconsultor " class="form-control"></textarea>
                        <div class="form-group col-xs-10 col-md-8">
                            <label class="callout callout-info" for="file" >Anexe os Arquivos com dados que complementem sua teleconsulta :</label>
                            <input type="file"  name="arquivo[]" id="file" multiple>
                            <input type="hidden" value="{{ csrf_token() }}" name="_token">
                            <hr></hr>
                            <div class="callout callout-warning">
                            <h5><i class="fa fa-fw fa-warning"></i>A soma do tamanho dos arquivos anexados podem ter no máximo 1 MB(megabyte)</h5>
                        </div>
                </div>
                <div class="form-group col-md-6">
                            <button type="submit" class="btn btn-success">Clique para enviar sua replica</button>
                </div>
        </form>
    </div>
</div>


@stop
<script type="text/javascript">
  function modalshow($consult){
      $("#modalshow").modal();
    }
</script>

