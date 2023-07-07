@extends('adminlte::page')

@section('title', 'Teleconsultoria')

@section('content_header')
    <h1>Teleconsultoria</h1>

    <ol class='breadcrumb'>
    	<li><a ref="">Dashboard</a></li>
    	<li><a ref="">Consult</a></li>
    	<li><a ref="">Entrada</a></li>
    </ol>
@stop

@section('content')
	<div class="container">
        <div class="box">
        <div class="box-header">
            <a href="{{ route('consult.entrada')}}" class="btn btn-danger"><i class="fas fa-shopping-cart"></i>Devolver ao Solicitante</a>
            <a href="{{ route('consult.encaminhar', ['sid' => $sid]) }}" class="btn btn-success"><i class="fas fa-shopping-cart"></i>Preparar a Resposta</a>
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
            <th>MUNICIPIO </th>
            <th>UF</th>
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
            <td>{{ $consult->municipio}} </td>
            <td>{{ $consult->uf}} </td>
            <td>{{$consult->user->name}} </td>
            <td>{{$consult->cons_id}} </td>
            <td>{{$consult->cons_name}} </td>
            <td>{{$consult->tempo}} </td>
            <td>{{$consult->paciente}} </td>
            </tr>    
         @empty
         <p>Você não tem consultas na sua caixa de entrada</p>
         @endforelse
      @endif
    </table>
@stop