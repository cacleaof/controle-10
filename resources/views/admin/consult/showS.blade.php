@extends('adminlte::page')

@section('title', 'Resposta da Teleconsultoria')

@section('content_header')
    <h1>Resposta da TeleConsultoria</h1>
    <!--<ol class='breadcrumb'>
    	<li><a ref="">Dashboard</a></li>
    	<li><a ref="">Consult</a></li>
    	<li><a ref="">Entrada</a></li>
    </ol>-->
@stop
@section('content')
    <div class="container">
        @include('admin.includes.alerts')
    </div>
    <div id="myDIV1" class="loader" style="display:none"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">TELECONSULTORIA</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->

                        <form role="form">
                    <div class="box-body">
                        <div class="col-md-2">
                            <p><strong>Nro da Solicitação:</strong> {{ $consult->id }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Status:</strong> {{ showstat($consult->status) }}</p>
                        </div>
                        <div class="col-md-2">
                            <p><strong>Duração:</strong> {{ tempo($consult->created_at) }}</p>
                        </div>
                    <!-- /.box-body -->


                </form>
                        <div class="form-group">
                            <div class="col-md-6">
                                <p><strong>Teleconsultor:</strong> {{$consult->cons_name}}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Paciente: </strong> {{$consult->nome_paciente}}</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <p><strong>Descrição: </strong> {{ $consult->consulta}}</p>
                            </div>
                        </div>
                        <div class="box-header with-border">
                            @if ($consult->resposta != null)
                            <div class="col-md-12">
                                <p><strong>Resposta: </strong> {{$consult->resposta}} </p>

                            </div>
                                
                            @else
                            <div class="col-md-12">
                                <p><strong>Resposta: </strong> {{$consult->resposta}} </p>

                            </div>

                            @endif
                            @if ($consult->replica == null)
                            <div class="box-tools pull-right">
                            <p>Caso queira complementar sua Teleconsulta</p>
                            <a href="{{ route('consult.replica', ['sid' => $sid]) }}" class="btn btn-success"><i></i>Solicite uma Replica</a>
                            </div>
                            @endif
                        </div>
                        <div class="box-header with-border">
                            @if ($consult->cons_replica == null)
                            <div class="col-md-12" style="display:none">
                                <p><strong>Replica: </strong> {{$consult->cons_replica}} </p>

                            </div>
                                
                            @else
                            <div class="col-md-12">
                                <p><strong>Replica: </strong> {{$consult->cons_replica}} </p>

                            </div>

                            @endif
                        </div>
                        <div class="box-header with-border">
                            @if ($consult->replica == null)
                            <div class="col-md-12" style="display:none">
                                <p><strong>Replica do Consultor: </strong> {{$consult->replica}} </p>

                            </div>
                                
                            @else
                            <div class="col-md-12">
                                <p><strong>Replica do Consultor: </strong> {{$consult->replica}} </p>

                            </div>

                            @endif
                        </div>
                    
                        <div class="form-group">
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
                        
                        <br>
                        @if($consult->servico == 'Tele-ECG')
                            <div class="form-group">
                                <div class="col-md-6">
                                    <a href="laudo/{{$consult->id}}" type="button" class="btn btn-danger">         
                                        Baixar Laudo
                                    </a>
                                    
                                </div>
                            </div>
                        @else
                            <div class="form-group" style="display:none">
                                <div class="col-md-6">
                                    <a href="laudo/{{$consult->id}}" type="button" class="btn btn-danger">         
                                        Baixar Laudo
                                    </a>
                                    
                                </div>
                            </div>

                        @endif
                        <div class="form-group">
                            <div class="col-md-12">
                                <br>
                                <a href="#" class="btn btn-success" onClick="modalshow({{ $consult }})"> Detalhar a Teleconsultoria</a>
                            </div>
                        </div>

                    </div>
            </div>
        </div>
    </div>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Avaliação da Satisfação do Solicitante</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form method="POST" action="{{ route('consult.show_store', ['sid' => $consult->id]) }}" enctype="multipart/form-data">
            {!! csrf_field() !!}
            <div class="box-body">
                <div class="form-row">
                    @include('admin.includes.alerts')
                    <div class="form-group col-md-6">
                        <label>Sua dúvida foi esclarecida?</label>
                        <select type="text" class="form-control" name="av_duvida">
                            <option value="">Selecione</option>
                            <option value="Sim, totalmente">Sim, totalmente</option>
                            <option value="Sim, parcialmente">Sim, parcialmente</option>
                            <option value="Não foi esclarecida">Não foi esclarecida</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Gostaríamos de saber sua opinião sobre o serviço?</label>
                        <select type="text" class="form-control" name="avaliaçao">
                            <option value="">Selecione</option>
                            <option value="5">Muito Satisfeito</option>
                            <option value="4">Satisfeito</option>
                            <option value="3">Indiferente</option>
                            <option value="2">Insatisfeito</option>
                            <option value="1">Muito Insatisfeito</option>
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <textarea type="text" name="av_comment" rows="5" cols="80" placeholder="Você gostaria de fazer algum comentário, crítica, elogio, sugestão ou reclamação? Caso negativo escreva não!" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Enviar</button>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </form>
    </div>

    @include('admin.includes.modelo')
@endsection
<script type="text/javascript">
    function modalshow($consult){
      $("#modalshow").modal();
    }
</script>