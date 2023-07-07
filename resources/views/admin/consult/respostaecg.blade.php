@extends('adminlte::page')

@section('title', 'Teleconsultoria')

@section('content_header')
    <h1>Tele-ECG</h1>

    <ol class='breadcrumb'>
    	<li><a ref="">Dashboard</a></li>
    	<li><a ref="">Consult</a></li>
    	<li><a ref="">Entrada</a></li>
    </ol>
@stop
@include('admin.includes.modelo')
@section('content')
    <div class="container">
        <div class="box">
        <div class="box-header">
            <a href="{{ route('consult.dev_cons', ['sid' => $sid]) }}" class="btn btn-danger"><i class="fa fa-fw fa-exchange"></i>Devolver ao Regulador</a>
            <a href="{{ route('consult.respcons', ['sid' => $sid]) }}" class="btn btn-success"><i class="fa fa-fw fa-paper-plane-o"></i>Preparar a Resposta</a>
        </div>
        </div>
    </div>
    <div class="col-md-3">
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

                </div>

            </form>
        </div>
    </div>
    <div class="col-md-9">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Dados da TeleConsultoria Selecionada</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form">
                <div class="box-body">
                    <div class="form-group ">
                        <div class="col-md-6">
                            <p><strong>Médico:</strong> {{ $consult->solicitante}} </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Paciente:</strong> {{ $consult->nome_paciente}} </p>
                        </div>
                       
                    </div>
                    
                    <div class="form-group ">
                        <div class="col-md-12">
                            <p><strong>Fatores:</strong> {{ $consult->fatores}} </p>
                        </div>
                        
                    </div>
                    <div class="form-group ">
                        <div class="col-md-12">
                            <p><strong>Medicamentos:</strong> {{ $consult->medicamento}} </p>
                        </div>    
                    </div>
                    <div class="form-group ">
                        <div class="col-md-3">
                            <p><strong>Pressão:</strong> {{ $consult->pressao}} </p> 
                        </div>
                        <div class="col-md-3">
                            <p><strong>Peso:</strong> {{ $consult->peso}} </p>
                        </div>
                        <div class="col-md-3">
                            <p><strong>Altura:</strong> {{ $consult->altura}} </p>
                        </div>
                        <div class="col-md-3">
                            <p><strong>Intensidade:</strong> {{ $consult->intensidade}} </p>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-12">
                            <p><strong>Irradiação:</strong> {{$consult->irradiacao}}</p>
                        </div>
                    </div>
                   
                    <div class="form-group">
                        <div class="col-md-12">
                            <p><strong>Descrição: </strong> {{ $consult->consulta}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <p><strong>Característica da dor: </strong> {{$consult->caracteristica}} </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <p><strong>Data do últimp episódio: </strong> {{ date( 'd/m/Y' , strtotime($consult->episodio))}} </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Duração: </strong> {{ $consult->duracao}} </p>
                        </div>
                        
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <p><strong>Recidiva da dor há quanto tempo: </strong> {{ $consult->recidiva}} </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <p><strong>Sintomas Associados: </strong> {{ $consult->sintomas}} </p>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            @if($consult->anexos!=null)
                            @forelse($files as $file)

                                <p><strong>Arquivo anexos da teleconsultoria:</strong></p>  <a href="{{ route('consult.download', ['sid' => $file->id, 'cid' => $consult->user_id]) }}">
                                    <button type="button" class="btn btn-primary">
                                     
                                            Download
                                       </button>
                                </a>

                            @empty
                                <p>A Consultoria não tem Arquivo anexado!</p>
                                @endforelse

                                </table>
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
    