@extends('adminlte::page')

@section('title', 'Regulação da Teleconsultoria')

@section('content_header')
    <h1>Devolução da Teleconsultoria</h1>
    <!--<ol class='breadcrumb'>
    	<li><a ref="">Dashboard</a></li>
    	<li><a ref="">Consult</a></li>
    	<li><a ref="">Entrada</a></li>
    </ol>-->
@stop
@section('content')
<div class="container">
        <div class="box">
        <div class="box-header">
            <a href="{{ route('consult.regular', ['sid' => $sid])}}" class="btn btn-danger"><i class="fa fa-fw fa-close"></i> Cancelar</a>
        </div>
        </div>
    </div>

	<table class="table table-striped">
            <tr>
            <hr>
            <th>ID </th>
            <th>STATUS </th>
            <th>SERVIÇO </th>
            <th>DESCRIÇÃO </th>
            <th>NOME SOLICITANTE </th>
            <th>ID</th>
            <th>TELECONSULTOR </th>
            <th>TEMPO </th>
            <th>PACIENTE </th>
            </tr> 
            <tr>
      @if ($consults!=null)  
          <h4>Dados da TeleConsultoria Selecionada</h4>    
         @forelse($consults as $consult)
            <td>{{ $consult->id}}</a></td>
            <td>{{ showstat($consult->status) }} </td>
            <td>{{ $consult->servico}} </td>
            <td>{{ $consult->consulta}} </td>
            <td>{{$consult->user->name}} </td>
            <td>{{$consult->cons_id}} </td>
            <td>{{$consult->cons_name}} </td>
            <td>{{$consult->tempo}} </td>
            <td>{{$consult->nome_paciente}} </td>
            </tr>    
         @empty
         <p>Você não tem consultas na sua caixa de entrada</p>
         @endforelse
      @endif
    </table>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Digite o Motivo da Devolução da Teleconsultoria</h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
   

            <div class="form-group">
                <form method="POST" action="{{ route('consult.devstore', ['sid' => $sid]) }}" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="form-row">
                        <div class="form-group">
                            <textarea type="text" id="devolutiva" name="devolutiva" rows="5" cols="80" placeholder="Descreva o motivo da Devolução da Teleconsultoria" class="form-control"></textarea>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </div>
                    </div>
                </form>
            </div>

      
</div>

@endsection