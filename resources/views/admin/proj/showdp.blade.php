@extends('adminlte::page')

@section('title', 'Projetos')

@section('content_header')
    <h1>Tarefas</h1>

    <ol class='breadcrumb'>
      <li><a ref="">Dashboard</a></li>
      <li><a ref="">Tarefa</a></li>
      <li><a ref="">Editar</a></li>
    </ol>
@stop

@section('content')
<div class="box box-solid box-info">
 <div class="box-header" with-border>
  <h3>Altere os dados da sua Tarefa</h3>
 </div>
 <div class="box-body">
 <form method="POST" action="{{ route('proj.upd_t', ['trf' => $task->id]) }}" enctype="multipart/form-data">
 {!! csrf_field() !!}
  @include('admin.includes.alerts')
  <div class="form-group row">
    <label for="idp" class="col-sm-2 col-form-label">ID</label>
    <div class="col-sm-2">
      <input type="text" id="idp" class="form-control" maxlength="5" value="{{ $task->id }}" readonly> 
    </div>
  </div>
    <div class="form-group">
      <label for="idtk">Tarefa</label>
      <div class="form-group">
        <input type="text" id="idtk" class="form-control col-xs-4" name="tarefa" maxlength="50" value="{{ $task->task }}">
      </div>
    </div>
  <div class="form-group">
    <div class="form-row">
      <label for="dtk">Detalhe do Projeto</label>
      <input type="text" id="dtk" name="detalhe" maxlength="80" value="{{ $task->detalhe }}" class="form-control">
    </div>
  </div>
    <div class="form-row">
      <label class="form-control">Duração</label>
        <div class="form-row">
          <input type="text" name="duration" maxlength="10" value="{{ $task->duration }}" class="form-control"> 
        </div> 
    </div>
<br>
  <div class="form-group row">
    <div class="col-xs-2">
      <label>Responsável</label>
      <input type="text" name="usuario" maxlength="10" value="{{ $task->user_id }}" class="form-control">
    </div>
    <div class="form-row">
      <div class="col-xs-2">
        <label>Urgencia</label>
        <input type="text" name="urg" maxlength="5" value="{{ $task->urg }}" class="form-control">
      </div>
      <div class="col-xs-2">
       <label>Importancia</label>
       <input type="text" name="imp" maxlength="5" value="{{ $task->imp }}" class="form-control">
      </div>
      <div class="col-xs-3">
        <label>Inicio</label>
        <input type="date" name="inicio" maxlength="5" value="{{ $task->date_ini }}" class="form-control">
      </div>
      <div class="col-xs-3">
        <label>Termino</label>
        <input type="date" name="termino" maxlength="5" value="{{ $task->date_fim }}" class="form-control">
      </div>
      <div class="col-xs-1">
        <label>Status %</label>
        <input type="text" name="status" maxlength="5" value="{{ $task->status }}" class="form-control">
      </div>
    </div>
  </div>
    <div class="form-group">
      <button type="submit" class="btn btn-success">Enviar</button> 
    </div>
 </form>
 </div>
</div>
@stop