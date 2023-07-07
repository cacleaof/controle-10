@extends('adminlte::page')

@section('title', 'Pesquisa de Satisfação')

@section('content_header')
    <h1>Pesquisa de Satisfação</h1>
    <ol class='breadcrumb'>
    	<li><a ref="">Dashboard</a></li>
    	<li><a ref="">Consult</a></li>
    	<li><a ref="">Entrada</a></li>
    </ol>
@stop
@section('content')
<div class="container">       
        @include('admin.includes.alerts')
    </div>
	<div class="table-responsive">
            <table class="table table-condensed table table-striped">
            <th>ID </th>
            <th>STATUS </th>
            <th>DESCRIÇÃO </th>
            <th>TELECONSULTOR </th>
            <th>TEMPO </th>
            <th>PACIENTE </th>
            <th>DEVOLUÇÃO </th>
            </tr> 
            <tr>   
            <td>{{ $consult->id}}</a></td>
            <td>{{ showstat($consult->status) }} </td>
            <td>{{ $consult->consulta}} </td>
            <td>{{$consult->cons_name}} </td>
            <td>{{ tempo($consult->created_at) }} </td>
            <td>{{$consult->paciente}} </td>
            <td>{{$consult->devolutiva}} </td>
            </tr>  
    </table>
            <div class="table-responsive">
            <table class="table table-condensed table table-striped">
            <tr>
            <th>RESPOSTA DO TELECONSULTOR</th>
            <th>LEITURA RECOMENDADA </th>
            <th>CIAP </th>
            </tr>
            <tr>
            <td>{{$consult->resposta}} </td>
            <td>{{$consult->l_recom}} </td>
            <td>{{$consult->ciap}} </td>
            </tr> 
            <div class="box-tools pull-right">
                    <a href="#" class="btn btn-success" onClick="modalshow({{ $consult }})"><i class="fa fa-pencil" aria-hidden="true"></i>Detalhar a Teleconsultoria</a>
            </div>
            </table> 
    <h4>Arquivos Anexados a Teleconsultoria</h4>   
    @if($consult->anexos!=null)    
    <table class="table table-striped">
        <tr>
            <th>ID </th>
            <th>arquivo </th>
        </tr>       
          @forelse($files as $file)  
            <tr>
            <td>{{ $file->id}}</td>
            <td>{{ $file->file}}</td>
            <td>
            <div class="form-group">
            <a href="{{ route('consult.download', ['sid' => $file->id, 'cid' => $consult->user_id]) }}">
                <button type="button" class="btn btn-primary">
                    <i class="glyphicon glyphicon-download">
                        Download
                    </i></button>
            </a>  
            </div>
            </td>
            </tr>
        @empty
        <p>A Consultoria não tem Arquivo anexado!</p>
        @endforelse
        <div class="box-tools pull-right">
            <a href="{{ route('consult.nova')}}" class="btn btn-success"><i class="fas fa-pencil"></i>Replica da Consultoria</a>
        </div>
    </table> 
    @endif
    <div class="box box-solid box-info">
        <div class="box-header" with-border>
            <h3>Avaliação da Satisfação</h3>
        </div>
        <div class="box-body">
            <form method="POST" action="{{ route('consult.show_store', ['sid' => $consult->id]) }}" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                <div class="form-row">
                    @include('admin.includes.alerts')
                    <div class="form-group col-xs-7">
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
                    <div class="form-group col-xs-7">
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
                    <div class="form-group">
                        <textarea type="text" name="av_comment" rows="5" cols="80" placeholder="Você gostaria de fazer algum comentário, crítica, elogio, sugestão ou reclamação? Caso negativo escreva não!" class="form-control" required></textarea>
                    </div>
                        <div class="form-group">
                        <button type="submit" class="btn btn-success">Enviar</button> 
                        </div>
                </div>
            </form>
        </div>  
        </div>  
    @include('admin.includes.modelo')
@endsection
<script type="text/javascript">
    function modalshow($consult){
      $("#modalshow").modal();
    }
</script>