@extends('adminlte::page')

@section('title', 'Home Dashboard')


@section('content_header')

    @include('admin.includes.alerts')

@stop

@section('content')
<div class="col-md-12">
            <h4>Bem-vindo ao Sistema de Projetos</h4>
            <h4>Selecione abaixo as opções principais ou click nos menus acima</h4>
    <div class="col-md-3">
        <a href="/diario">
                <div class="small-box bg-aqua">  
                    <div class="inner">
                    <h4>EXECUÇÃO - DIARIO</h4>
                    <h5>Entre as atividades que você está executando diariamente. Elas devem estar associadas a uma tarefa planejada</h5>
                    </div>
                    <div class="icon" style="margin-top: 3%;">
                    <i class="glyphicon glyphicon-plus-sign"></i>
                    </div>
                </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="/task" class="small-box-footer">
            <div class="small-box bg-yellow">
                <div class="inner">
				<h4>PLANO - Atividades e Projetos</h4>
				<h5>Lista de atividades e projetos planejados</h5>
                </div>
                <div class="icon">
                <i class="glyphicon glyphicon-log-out"></i>
                </div>
            
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="/n_proj" class="small-box-footer">
            <div class="small-box bg-red">
                <div class="inner">
				<h4>PLANO - Novo Projeto</h4>
				<h5>Entre com o planejamento de um novo projeto para o Nucleo.
                </div></h5>
                <div class="icon">
                <i class="glyphicon glyphicon-retweet"></i>
                </div>
            </div>
        </a>
    </div>
	<div class="col-md-3">
        <a href="/n_task" class="small-box-footer">
            <div class="small-box bg-green">
                <div class="inner">
				<h4>PLANO - Nova Tarefa</h4>
                <h5>Entre com o planejamento de uma nova tarefa a seus projetos</h5>
                </div>
                <div class="icon">
                <i class="glyphicon glyphicon-ok"></i>
                </div> 
            </div>
        </a>
    </div>
    <br></br>
    <div class="col-md-12">
    <h5>Esse sistema foi desenvolvido para controlar Processos e Projetos. O primeiro passo é o Planejamento Anual de Atividades e Projetos. Cada Projeto deve ter um único gerente, responsável pela execução e atualização das atividades definidas. Estas atividades podem ser gerais
    ou definida para um único colaborador. </h5>
    <h4>LISTA DAS TAREFAS ATRIBUIDAS AO SEU USUÁRIO: {{auth()->user()->name}}</h4>
    </div>
    <br></br>
    <div class="table">
    <table id="example" class="display" style="width:100%">
      <thead>
     <tr>
      <th>Status</th>
      <th>Projeto</th>
      <th>Tarefa</th>
      <th>Início</th>
      <th>Fim</th>
      <th>Urg</th>
      <th>Imp</th>
     </tr>
     </thead>
     <tbody>
     @foreach($tasks as $task)
     @if( $task->user_id == auth()->user()->id && $task->status == 'Executando'||$task->user_id == auth()->user()->id && $task->status == 'Pendente' )
      <tr>
      <td>{{ $task->status}} </td>
        @foreach ($projects as $project)
	        @if( $project->id == $task->proj_id )
            <td><a href="{{ route('proj.showpj', ['prj' => $task->proj_id]) }}">{{ $project->projeto }} </td>
            @endif
	    @endforeach
      <td><a href="{{ route('proj.showtk', ['trf' => $task->id]) }}"> {{ $task->text }}</a></td>
      <td>{{ \Carbon\Carbon::parse($task->start_date)->format('d/m/Y') }} </td>
      <td>{{ \Carbon\Carbon::parse($task->date_fim)->format('d/m/Y') }} </td>
      <td>{{ $task->urg}} </td>
      <td>{{ $task->imp}} </td>
     </tr>
     @endif
     @endforeach
     </tbody>
    </table>
    </div> 
</div>
@endsection