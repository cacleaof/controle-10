@extends('adminlte::page')

@section('title', 'Projetos')

@section('content_header')
    <h1>Tarefas</h1>

    <ol class='breadcrumb'>
      <li><a ref="">Dashboard</a></li>
      <li><a ref="">Tarefa</a></li>
      <li><a ref="">Editar</a></li>
    </ol>
    <hr>
    <hr>
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
      <label for="idp" class="col-sm-1 col-form-label">ID</label>
      <div class="col-sm-1">
        <input type="text" id="idp" class="form-control" maxlength="5" value="{{ $task->id }}" readonly> 
      </div>
      <label for="idtk" class="col-sm-1 col-form-label">Tarefa</label>
        <div class="col-sm-4">
          @if($task->parent == '0')
          <label class="form-control col-xs-4" maxlength="50">{{ $task->text }}</label>
	  <input type="text" style="display:none" id="idtk" class="form-control col-xs-4" name="tarefa" maxlength="50" value="{{ $task->text }}">
          @else
          <input type="text" id="idtk" class="form-control col-xs-4" name="tarefa" maxlength="50" value="{{ $task->text }}">
          @endif
        </div>
        <label class="col-sm-1">Status</label>
        <select name="status">
        <option value="{{$task->status}}">{{$task->status}}</option>
        <option value="Planejando">Planejando</option>
        <option value="Executando">Executando</option>
        <option value="Pendente">Pendente</option>
        <option value="Terminado">Terminado</option>
        <option value="Cancelado">Cancelado</option>
        </select>
    </div>  
  <div class="form-group">
    <div class="form-row">
      <label for="dtk">Detalhe da Tarefa</label>
      <input type="text" id="dtk" name="detalhe" maxlength="80" value="{{ $task->detalhe }}" class="form-control">
    </div>
  </div>
    <div class="form-row">
      <label class="form-group col-md-3">Duração</label>
        <div class="form-group col-md-3">
          <input type="text" name="duration" maxlength="10" value="{{ $task->duration }}" class="form-control"> 
        </div> 
        <label class="form-group col-md-3">Projeto</label>
          <div class="form-group col-md-3">
          <!-- <input type="text" name="proj_id" maxlength="10" value="{{ $task->proj_id }}" class="form-control">  -->
     	 <select class="form-control" name="proj_id">
	@foreach ($projects as $project)
	<option value="{{ $project->id }}" {{ $project->id == $task->proj_id ? 'selected' : ''}}>{{ $project->projeto }}</option>
	@endforeach
	</select>
          </div> 
    </div>
<br>
  <div class="form-group row">
    <div class="col-xs-2">
      <label>Responsável</label>
	    <select name="usuario" maxlength="10" class="form-control">
	      <option value="{{ $task->user_id }}">--Selecione o Responsável--</option>
		    @foreach ($users as $user)
		    <option  {{ $user->id == $task->user_id ? "selected" : ''}} value="{{ $user->id }}">{{ $user->name }}</option>
		    @endforeach
	    </select>
    </div>
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
        <input type="date" name="ini" maxlength="5" value="{{ $task->start_date }}" class="form-control">
      </div>
      <div class="col-xs-3">
        <label>Termino</label>
        <input type="date" name="fim" maxlength="5" value="{{ $task->date_fim }}" class="form-control">
      </div>
  </div>
      <div class="col-xs-2">
        <label>Progresso %</label>
        <input type="text" name="prog" maxlength="5" value="{{ $task->progress*100 }}" class="form-control">
      </div>
	<div class="form-group col-md-5">
		<label class="callout callout-info"  for="file">Arquivos Anexos:</label>
		<input type="file" name="arquivo[]" id="file" multiple>
		<input type="hidden" value="{{ csrf_token() }}" name="_token">
		</div>
      <div class="form-row">  
            <div class="col-xs-12">
                 @if($task->anexos!=null)
                    @forelse($arquivos as $arquivo)
                      @if($task->id == $arquivo->task_id)
                      <p><strong>Arquivo anexo:</strong>{{ $arquivo->arquivo}}</p>  <a href="{{ route('proj.download_T', ['sid' => $arquivo->id, 'cid' => $arquivo->user_id]) }}">
                      <button type="button" class="btn btn-primary">Download</button></a>  
                      @endif                           
                    @empty                               
                        <p>A Tarefa não tem Arquivo anexado!</p>
                    @endforelse
                 @endif
            </div>
      </div>
      <div class="col-xs-3">
      <label style="background-color:#DCDCDC;">Marcar se a Tarefa foi concluida</label>
      <input type="checkbox" name="concluido">
      </div>
    <div class="form-group">
      <button type="submit" class="btn btn-success">Enviar</button> 
      <a href="{{ route('admin.proj.sol_atv') }}" class="btn btn-primary">Incluir Atividade</a>
      <a href="{{ route('proj.deltk', ['trf' => $task->id]) }}" class="btn btn-danger">Apagar Tarefa</a>
    </div>
 </form>
 </div>
</div>
<div class="box box-solid box-info">
  <div class="box-header" with-border>
  <h3>Atividades Realizadas</h3>
  </div>
  <div class="box-body">
  <div class="row">
    <label class="col-xs-2">DIA</label>
		<label class="col-xs-3">ATIVIDADE</label>
    <label class="col-xs-4">LINK</label>
  </div>
  @foreach ($diarios as $diario)
    @if($task->id == $diario->task_id)
    <div class="row col-xs-12">
      <label class="col-xs-2">{{ $diario->ndia }}</label>
      <label class="col-xs-3">{{ $diario->detalhe }}</label>
      <label class="col-xs-6" maxlength="20">{{ $diario->hylink }}</label>
    </div>
    @endif
	@endforeach
  </div>
</div>
@stop