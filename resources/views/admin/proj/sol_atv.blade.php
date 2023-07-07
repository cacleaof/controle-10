@extends('adminlte::page')

@section('title', 'Projeto')

@section('content_header') 
    <script type="text/javascript">
    function Func9(){
  	$('input[name="ini"]').val('09:00');
  	$('input[name="fim"]').val('17:00');
	}
	function Func10(){
	$('input[name="ini"]').val('08:00');
	$('input[name="fim"]').val('16:00');
	}
	</script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script>
		$(document).ready(function() {
		$('#func8').click(function(){ 
			var agora = new Date();
			$('input[name="ini"]').val(agora.getHours() + ":" + agora.getMinutes());
  			$('input[name="fim"]').val(agora.getHours() + ":" + agora.getMinutes());
		})
		})
	</script>
	<hr>
	<hr>
@stop

@section('content')
	<div class="box box-solid box-info">
	<div class="box-header" with-border>
	<h4>REGISTRO DE ATIVIDADES DIÁRIAS - Agendar ou Registrar seu Trabalho</h4>
	</div>
	<div class="box-body">
	<div class="form-group">
<form method="POST" action="{{ route('admin.proj.diario') }}" enctype="multipart/form-data">
	{!! csrf_field() !!}
	<div class="form-row"> 
		<h5>ENTRADA MANUAL COM A DATA PARA LISTAR ATIVIDADES AGENDADAS/OU ENTRAR NOVAS - SELECIONE UM BOTÃO EM AZUL</h5>
	</div>
	<a id="func8" class="btn btn-primary">Agora</a> 
	<button class="btn btn-primary" onclick="Func10()">8-16</button> 
	<button class="btn btn-primary" onclick="Func9()">9-17</button> 
	<input type="date" class="form-group col-xs-3" value="{{ $dia !=null ? $dia : date('Y-m-d') }}" name="dia" maxlength="5">
	<input type="time" class="form-group col-xs-2" value="{{ $ini !=null ? $ini : '' }}" name="ini" maxlength="10">
	<input type="time" class="form-group col-xs-2" value="{{ $fim !=null ? $fim : '' }}" name="fim"  maxlength="10">
	<button type="submit" class="btn btn-primary">Entrada Manual de Data e Hora</button> 
</form>
	</div>
	<table class="table table-striped">
	<div class="form-group"> 
	<h5><strong>Editar------- DATA REALIZADA ----------PROJETO--------------------------------------------TAREFA--------------------------  ATV REALIZADA----------------------------  INICIO ------  FIM </strong></h5>
	</div>
	<div class="form-group"> 
	<tr>
	@forelse ($diarios as $diario)
	@if($diario->ndia == $dia) 
	<td><a href="{{ route('admin.proj.a_diario', ['sid' => $diario->id] ) }}"><i class="fa fa-fw fa-search"></i></a> </td>
	<td>{{ $diario->ndia }}</td>
	<td>
	{{ $diario->project->projeto }}
	</td>
	<td>{{ $diario->task->task }}</td>
	<td>{{ $diario->detalhe }}</td>
	<td>{{ $diario->ini }}</td>
	<td>{{ $diario->fim }}</td>
	<td></td>
	</tr>
	@endif
	@empty
	<p>Sem tarefas planejadas para hoje</p>
	@endforelse
	</div>
	</table>
	@if($dia !=null ) 
	<div class="form-row col-md-12">
	<div class="callout callout-warning col-md-6">
		<h5><i class="fa fa-fw fa-warning"></i>ENTRAR NOVA ATIVIDADE DIARIA</h5>
	</div>
	</div>
	<div class="form-row">
@include('admin.includes.alerts')
	<div class="form-group">
<form method="POST" action="{{ route('admin.proj.diario') }}" enctype="multipart/form-data">
	{!! csrf_field() !!}
	<div class="form-group col-xs-3" >
	<label  class="form-control" style="background-color:#DCDCDC;">DIA</label>
	@if($projeto == null)
	<input type="date" class="form-control" value="{{ $ndia !=null ? $ndia : $dia }}" name="ndia" maxlength="10">
	@endif
	</div>
	<div class="form-group col-xs-2" >
	<label  class="form-control" style="background-color:#DCDCDC;">INICIO</label>
	@if($projeto == null)
	<input type="time" class="form-control" value="{{ $nini !=null ? $nini : $ini }}" name="nini" maxlength="10">
	@endif
	</div>
	<div class="form-group col-xs-2" >
	<label  class="form-control" style="background-color:#DCDCDC;">FIM</label>
	@if($projeto == null)
	<input type="time" class="form-control" value="{{ $nfim !=null ? $nfim : $fim }}"name="nfim"  maxlength="10">
	@endif
	</div>
	<div class="form-group">
	<div class="form-group col-xs-4">
	<label  class="form-control" style="background-color:#DCDCDC;">PROJETO</label>
	<select name="projeto">
	@foreach ($projects as $project)
	<option value="{{ $project->id }}" {{ $project->id == $projeto ? 'selected' : ''}}>{{ $project->projeto }}</option>
	@endforeach
	</select>
	</div>
	<input type="hidden" name="dia" value="{{ $dia }}">
	<input type="hidden" name="ini" value="{{ $ini }}">
	<input type="hidden" name="fim" value="{{ $fim }}">
	<button type="submit" class="btn btn-primary">Enviar</button> 
</form>
@if($ndia !=null ) 
<form method="POST" action="{{ route('admin.proj.store_diario') }}" enctype="multipart/form-data">
	{!! csrf_field() !!}
	<div class="form-group col-xs-12">
	<div class="form-group col-xs-3">
	<input class="form-control" type="date" name="ndia" value="{{ $ndia }}">
	</div>
	<div class="form-group col-xs-2">
	<input class="form-control" type="time" name= "nini" value="{{ $nini }}">
	</div>
	<div class="form-group col-xs-2">
	<input class="form-control" type="time" name="nfim" value="{{ $nfim }}">
	</div>
	<div class="form-group col-xs-4">
	<label  class="form-control" style="background-color:#DCDCDC;">TAREFA</label>
	<select name="tarefa">
@foreach ($tarefas as $tarefa)
	<option value="{{ $tarefa->id }}" max-width ="10">{{ $tarefa->text }}</option>
@endforeach
	</select>
	<input type="hidden" name="projeto" value="{{ $projeto }}">
	<div class="form-row">
	<label style="background-color:#DCDCDC;">Marcar se a Tarefa foi concluida</label>
	<input type="checkbox" name="end">
	<label style="background-color:#DCDCDC;"><a href="{{ route('admin.proj.n_task', ['trf' => $projeto]) }}">Click para Incluir nova Tarefa neste Projeto</a></label>
	</div>
	</div>
	</div>
	<div class="form-group col-md-12">
	<textarea type="text" width="400" name="detalhe" rows="5" cols="80" placeholder="Descreva o que foi realizado" class="form-control"></textarea>
	</div>
	<div class="form-group col-md-12">
	<div class="form-group col-md-5">
	<label class="callout callout-info"  for="file">Arquivos Anexos:</label>
	<input type="file" name="arquivo[]" id="file" multiple>
	<input type="hidden" value="{{ csrf_token() }}" name="_token">
	</div>
	<div class="form-group col-xs-6" >
	<label  class="form-control" style="background-color:#DCDCDC;">Hyperlink</label>
	<input type="text" class="form-control" name="hylink">
	</div>
	</div>
	<hr></hr>
	<div class="form-group">
		<div class="callout callout-warning col-xs-12">
		<h5><i class="form-group col-xs-2 fa fa-fw fa-warning"></i>A soma do tamanho dos arquivos anexados podem ter no máximo 1 MB(megabyte)</h5>
		</div>
	</div>
	
	<div class="form-group">
	<button type="submit" class="btn btn-success">Enviar</button> 
	</div>
</form>
@endif
	</div>
	</div>
	@endif
	</div>
@stop