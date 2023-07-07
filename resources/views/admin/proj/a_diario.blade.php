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
		<h4>Atualiza Atividades Diário</h4>
		</div>
		<div class="box-body">
@include('admin.includes.alerts')
			
<form method="POST" action="{{ route('admin.proj.sadiario') }}" enctype="multipart/form-data">
	{!! csrf_field() !!}
			<div class="form-group">
				<div class="form-group col-xs-3" >
				<label  class="form-control" style="background-color:#DCDCDC;">DIA</label>
				<input type="date" class="form-control" value="{{ $diario->ndia }}" name="ndia" maxlength="10">
				</div>
				<div class="form-group col-xs-2" >
				<label  class="form-control" style="background-color:#DCDCDC;">INICIO</label>
				<input type="time" class="form-control" value="{{ $diario->ini }}" name="ini" maxlength="10">
				</div>
				<div class="form-group col-xs-2" >
				<label  class="form-control" style="background-color:#DCDCDC;">FIM</label>
				<input type="time" class="form-control" value="{{ $diario->fim }}"name="fim"  maxlength="10">
				</div>
				<div class="form-group col-xs-2" >
				<label  class="form-control" style="background-color:#D3D3D3;">TAREFA</label>
				<label class="form-control">{{ $tk->task }}</label>
				</div>
				<div class="form-group col-xs-3" >
				<label  class="form-control" style="background-color:#DCDCDC;">PROJETO</label>
				<label  class="form-control">{{ $pj->projeto }}</label>
				</div>
				<div class="form-group col-xs-6" >
				<label  class="form-control"  style="background-color:#DCDCDC;">ATIVIDADE REALIZADA</label>
				<input type="text" class="form-control" value="{{ $diario->detalhe }}"name="detalhe">
				</div>	
				<input type="hidden" name="sid" value="{{ $sid }}">
			</div>
		<button type="submit" class="btn btn-primary">Enviar</button> 
		
		<div class="box-header">
    	<a href="{{ route('admin.proj.deld', ['sid' => $sid]) }}" class="btn btn-danger"><i class="fas fa-shopping-cart"></i>Deletar</a>
		</div>
</form>
			
		</div>
	</div>
@stop