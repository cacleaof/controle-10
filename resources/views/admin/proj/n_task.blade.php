@extends('adminlte::page')

@section('title', 'Projeto')

@section('content_header')
	<script type="text/javascript">
	function func14(){
	var start_date = new Date(document.getElementById("start_date").value);
	var date_fim = new Date(document.getElementById("date_fim").value);
	var sd = document.getElementById("start_date").value;
	var duration = parseInt(document.getElementById("duration").value);
	var time = start_date.getTime(); 
	//var time = new Date().getTime(); 
	var nt = time + (86400000*(1 + duration));
	var date = new Date(time); 
	var df = new Date(nt); 
	var dz = df.toLocaleDateString();
	var dd = dz.substr(0, 2);
	var dm = dz.substr(-7, 2);
	var dy = dz.substr(-4);
	var dk = dy + "-" + dm + "-" + dd;
	var ds = new Date(dk);
	$('input[name="date_fim"]').val(dk);
	var agora = new Date();
	var s = new Date();
	
	var n = Date.parse(agora);
	var sd = Date.parse(sd);
	s.setDate(start_date.getDate() + duration +1);
	sd = new Date(sd+1440000);
	}
</script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
	$(document).ready(function() {
	$('#func15').click(function(){ 
	var start_date = document.getElementById("start_date").value;
	var duration = parseInt(document.getElementById("duration").value);
	//var st = start_date.toDateString();
	start_date.setDate(start_date.getDate() + duration);
	console.log(start_date);
	console.log(duration);
	})
	})
	$(document).ready(function() {
	$('#func12').click(function(){ 
	$('input[name="start_date"]').val('2021-01-01');
	})
	})
	$(document).ready(function() {
	$('#func13').click(function(){ 
	var agora = new Date();
	$('input[name="date_fim"]').val('2021-12-31');
	})
	})
	$(document).ready(function() {
	$('#func16').click(function(){ 
	var agora = new Date();
	$('input[name="date_fim"]').val('2021-12-31');
	})
	})
	$(document).ready(function() {
	$('#func16').click(function(){ 
		
		var agora = new Date();
		
		var id = document.getElementsByName( "start_date" ) ;
		console.log(id);
		var s = n.toDateString();
		a.setDate(a.getDate() + 1);
		var pd = Date.parse(n);
	//	$('input[name="d"]').val(agora.getDate() + "/" + agora.getMonth() + "/" + agora.getFullYear());
	$('input[name="d"]').val(n);
	})
	})
</script>
<hr>
<hr>
@stop
@section('content')
<div class="box box-solid box-info">
	<div class="box-header" with-border>
	<h1>INCLUIR UMA NOVA TAREFA EM UM PROJETO</h1>
	@if( $projeto == null )
	<div class="form-group col-md-6">
				<form method="GET" action="{{ route('admin.proj.n_task') }}"  enctype="multipart/form-data">
				{!! csrf_field() !!}
				<label>PRIMEIRO PASSO:</label>
              	<select name="projeto" class="form-control">
              	<option value="{{ $projeto !=null ? $projeto : '' }}">-- Selecione o Projeto -- </option>
              	@foreach ($projects as $project)
              	<option value="{{ $project->id }}">{{ $project->projeto }}</option>
              	@endforeach
            	</select>
    			<button type="submit" class="btn btn-primary">Selecionar</button> 
   				</form>
	</div>
	@else
	@foreach ($projects as $project)
	@if( $project->id == $projeto )
	<h1>PROJETO:{{ $project->projeto }}</h1>
	@endif
	@endforeach
	@endif
	</div>
</div>
@if( $projeto != null )
		<div class="box box-solid box-info">	
		<div class="box-header" with-border>
			<h3>Digite os dados da Tarefa</h3>
		</div>
		<div class="box-body">
			<form method="POST" action="{{ route('admin.proj.store_t')}}" enctype="multipart/form-data">
					{!! csrf_field() !!}
				<div class="form-row">
					<label>Selecione a Tarefa dependente:</label>
					@include('admin.includes.alerts')
					<div class="form-group col-xs-12 col-md-12">
					<label>Tarefa:</label>
						<select name="tdep">
							@foreach ($tasks as $task)
							@if( $task->proj_id == $projeto )
							<option value="{{ $task->id }}">{{ $task->text }}</option>
      						@else
      						@endif
							@endforeach
						</select>
					</div>
					<input type="hidden" name="projeto" value="{{ $projeto }}">
					<div class="form-group col-md-6">
							<label>Responsavel da Tarefa:</label>
						<select name="gerente" class="form-control">
						<!-- <option value="">--Selecione o Responsável--</option> -->
							@foreach ($users as $user)
							<option value="{{ $user->id }}">{{ $user->name }}</option>
							@endforeach
						</select>
					</div>
						<div class="form-group col-md-8" >
						<label>Nome da Tarefa:</label>
							<input type="text" class="form-control" name="tarefa" maxlength="50" placeholder="Nome da Tarefa">
						</div>
						<div class="form-group col-md-8">
						<textarea type="text" name="detalhe" rows="6" cols="80" placeholder="Descreva o detalhe da tarefa a ser executada" class="form-control"></textarea>
						<div class="form-group col-md-12" >
							<label class="form-group col-md-2">Urgência:</label>
							<input type="texto" class="form-group col-md-2" name="urg" placeholder="Número de 1 a 5">
							<label class="form-group col-md-2">Importância:</label>
							<input type="texto" class="form-group col-md-2" name="imp" placeholder="Número de 1 a 5">
						</div>
						<div class="form-group col-md-12" >
							<label class="form-group col-md-2">Data de Início:</label>
							<input type="date" class="form-controle" value="{{ $start_date !=null ? $start_date : date('Y-m-d') }}" id="start_date" name="start_date" placeholder="Data de Inicio" maxlength="15">
							<a id="func12" class="btn btn-primary">01/01/2021</a> 
						</div>
						<div class="form-group col-md-12" >	
							<label class="form-group col-md-3">Previsão de Conclusão da tarefa em Dias</label>
							<input type="number" class="form-group col-md-2" value="{{ $duration !=null ? $duration : 0 }}" name="duration" id="duration" required placeholder="Previsão em dias"> 
							<a onclick="func14()" class="btn btn-primary">Atualizar Data de Conclusão</a> 
						</div>
						<label class="form-group col-md-12">Obs: Você pode preencher a data de conclusão da tarefa ou digitar a duração em dias e clicar em calcular</label>

						<div class="form-group col-md-12" >	
							<label class="form-group col-md-2">Data de Conclusão:</label>
							<input type="date" class="form-controle"  id="date_fim" name="date_fim" value="{{ $date_fim !=null ? $date_fim : date('Y-m-d') }}"  >
						<a id="func13" class="btn btn-primary">31/12/2021</a> 
						
						</div>
						<div class="form-group col-md-5">
						<label class="callout callout-info"  for="file">Arquivos Anexos:</label>
						<input type="file" name="arquivo[]" id="file" multiple>
						<input type="hidden" value="{{ csrf_token() }}" name="_token">
						</div>
						<div class="form-group">
						<button type="submit" class="btn btn-success">Enviar</button> 
						</div>
				</div>
			</form>
			
		</div>
	</div>
@endif
	@endsection