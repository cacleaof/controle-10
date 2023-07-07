@extends('adminlte::page')

@section('title', 'Projetos')

@section('content_header')
    <h1>Projetos</h1>

    <ol class='breadcrumb'>
      <li><a ref="">Dashboard</a></li>
      <li><a ref="">Proj</a></li>
      <li><a ref="">Editar</a></li>
    </ol>
    <br>
<br>
@stop

@section('content')
<div class="box box-solid box-info">
  <div class="box-header" with-border>
  <h3>Altere os dados do seu Projeto</h3>
  </div>
    <div class="box-body">
    <form method="POST" action="{{ route('proj.upd_p', ['prj' => $project->id]) }}" enctype="multipart/form-data">
    {!! csrf_field() !!}
    @include('admin.includes.alerts')
      <div class="form-group row">
        <label for="idp" class="col-sm-1 col-form-label">ID</label>
        <div class="col-sm-1">
        <input type="text" id="idp" class="form-control" maxlength="5" value="{{ $project->id }}" readonly> 
      </div>
        <label for="idprojeto" class="col-sm-1 col-form-label">Projeto</label>
      <div class="col-sm-4">
          <input type="text" id="idprojeto" class="form-control col-xs-4" name="projeto" maxlength="50" value="{{ $project->projeto }}">
      </div>
        <label class="col-sm-1">Status</label>
        <select name="status">
        <option value="{{$project->status}}">{{$project->status}}</option>
        <option value="Planejando">Planejando</option>
        <option value="Executando">Executando</option>
        <option value="Pendente">Pendente</option>
        <option value="Terminado">Terminado</option>
        <option value="Cancelado">Cancelado</option>
        </select>  
    </div>  
  <div class="form-group">
    <div class="form-row">
      <label for="dproj">Detalhe do Projeto</label>
      <input type="text" id="dproj" name="detalhe" maxlength="80" value="{{ $project->proj_detalhe }}" class="form-control">
    </div>
  </div>
  <div class="form-group row"> 
      <div class="col-xs-2">
        <label>Gerente</label>
        <select name="gerente" maxlength="10" class="form-control">
            <option value="{{ $project->user_id }}">{{ $project->user_id }}</option>
              @foreach ($users as $user)
              <option value="{{ $user->id }}">{{ $user->name }}</option>
              @endforeach
            </select>
      </div>
      <div class="col-xs-2">
        <label>Urgencia</label>
        <input type="text" name="urg" maxlength="5" value="{{ $project->urg }}" class="form-control">
      </div>
      <div class="col-xs-2">
       <label>Importancia</label>
       <input type="text" name="imp" maxlength="5" value="{{ $project->imp }}" class="form-control">
      </div>
  </div>
      <div class="col-xs-3">
        <label>Inicio</label>
        <input type="date" name="date_ini" maxlength="5" value="{{ $project->date_ini }}" class="form-control">
      </div>
      <div class="col-xs-3">
        <label>Termino</label>
        <input type="date" name="date_fim" maxlength="5" value="{{ $project->date_fim }}" class="form-control">
      </div>
      <div class="col-xs-2">
        <label>Duração</label>
        <input type="text" name="duracao" maxlength="10" value="{{ $project->duracao }}" class="form-control"> 
      </div> 
      <div class="col-xs-2">
        <label>Progresso %</label>
        <input type="number" name="prog" maxlength="5" value="{{ $project->progress*100 }}" class="form-control">
      </div>
</div>
  
    <div class="form-group">
    <div class="col-md-2">
      <button type="submit" class="btn btn-success">
				        <h4>Enviar Alteração</h4>
      </button> 
    </div>
      <div class="col-md-2">
        <a href="{{ route('proj.delpj', ['prj' => $project->id]) }}">
            <div class="small-box bg-red">
                <div class="inner">
				        <h4>Apagar Projeto</h4>
                </div>
                <div class="icon">
                <i class="glyphicon glyphicon-ok"></i>
                </div> 
            </div>
        </a>
      </div>
    <div class="col-md-2">
        <a href="{{ route('admin.proj.n_task', ['trf' => $project->id]) }}" class="small-box-footer">
            <div class="small-box bg-blue">
                <div class="inner">
				        <h4>Nova Tarefa</h4>
                </div>
                <div class="icon">
                <i class="glyphicon glyphicon-ok"></i>
                </div> 
            </div>
        </a>
    </div>
    
      <form>
      <!-- <button onclick="window.location='{{ route("admin.proj.task") }}'" id="myButton" class="btn btn-success"> -->
      <!-- <input class="MyButton" type="button" value="SAIR" 
      onclick="window.location.href='http://telessaude.pe.gov.br/'"/> -->
      <input class="btn btn-success btn-lg" type="button" value="SAIR" 
      onclick="window.location.href='{{ route("admin.proj.task") }}'"/>
      </form>
    </div>
    <br><br>
    </form>
        <div class="box box-solid box-info">
          <div class="box-header" with-border>
          <h3>Tarefas Planejadas deste Projeto</h3>
          </div>
          <div class="box-body">
            <div class="row">
            <label class="col-xs-1">INICIO</label>
            <label class="col-xs-1">FIM</label>
            <label class="col-xs-1">RESPONSÁVEL</label>
            <label class="col-xs-4">TAREFA</label>
            <label class="col-xs-2">STATUS</label>
            </div>
            @foreach ($tasks as $task)
            @if($project->id == $task->proj_id)
            <div class="row">
              <label class="col-xs-1">{{ \Carbon\Carbon::parse($task->start_date)->format('d/m/Y') }}</label>
              <label class="col-xs-1">{{ \Carbon\Carbon::parse($task->date_fim)->format('d/m/Y') }}</label>
              <label class="col-xs-1">{{ $task->name}}</label>
              <label class="col-xs-4"><a href="{{ route('proj.showtk', ['trf' => $task->id]) }}"
            > {{ $task->text }}</a></label>
              <label class="col-xs-2" maxlength="20">{{ $task->status }}</label>
            </div>
            @endif
            @endforeach
          </div>
        </div>
    </div>
 
  <div class="box box-solid box-info">
    <div class="box-header" with-border>
    <h3>DIARIO - Atividades Realizadas</h3>
    </div>
    <div class="box-body">
      <div class="row">
      <label class="col-xs-1">DIA</label>
		  <label class="col-xs-3">ATIVIDADE</label>
      <label class="col-xs-2">COLABORADOR</label>
      <label class="col-xs-2">LINK</label>
      <label class="col-xs-2">ARQUIVOS</label>
    </div>
      @foreach ($diarios as $diario)
      @if($project->id == $diario->proj_id)
      <div class="row">
      <label class="col-xs-1">{{ \Carbon\Carbon::parse($diario->ndia)->format('d/m/Y') }}</label>
      <label class="col-xs-3">{{ $diario->detalhe }}</label>
      <label class="col-xs-2">{{ $diario->name }}</label>
      <div class="col-xs-2">
      @if($diario->hylink!=null)
      <a href="{{ $diario->hylink }}" target="_blank">Click para Acesso o link</a>
      @endif
      </div>
      <div class="col-xs-2">
      @if($diario->anexos=='1')
      <label class="col-xs-2">Tem arquivo anexo</label>
      @endif
      </div>
      </div>
      @endif
	    @endforeach
  </div>
  </div>
</div>
@stop