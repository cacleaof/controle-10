@extends('adminlte::page')

@section('title', 'Projeto')

@section('content_header')
<script type="text/javascript">
function func17(){
var inicio = new Date(document.getElementById("inicio").value);
var fim = new Date(document.getElementById("fim").value);
var sd = document.getElementById("inicio").value;
var duration = parseInt(document.getElementById("duration").value);
var time = inicio.getTime(); 
var nt = time + (86400000*(1 + duration));
var date = new Date(time); 
var df = new Date(nt); 
var dz = df.toLocaleDateString();
var dd = dz.substr(0, 2);
var dm = dz.substr(-7, 2);
var dy = dz.substr(-4);
var dk = dy + "-" + dm + "-" + dd;
var ds = new Date(dk);
$('input[name="fim"]').val(dk);
}
function func19(){
	var agora = new Date();
$('input[name="fim"]').val(agora);}
</script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
	$(document).ready(function() {
	$('#func21').click(function(){ 
	var start_date = document.getElementById("inicio").value;
	var duration = parseInt(document.getElementById("duration").value);
	inicio.setDate(inicio.getDate() + duration);
	})
	})
	$(document).ready(function() {
	$('#func18').click(function(){ 
	$('input[name="inicio"]').val('2021-01-01');
	})
	})
	$(document).ready(function() {
	$('#func20').click(function(){ 
	var agora = new Date();
	$('input[name="fim"]').val('2021-12-31');
	})
	})
	$(document).ready(function() {
	$('#func22').click(function(){ 
	var agora = new Date();
	$('input[name="date_fim"]').val('2021-12-31');
	})
	})
	$(document).ready(function() {
	$('#func23').click(function(){ 
		
		var agora = new Date();

		var id = document.getElementsByName( "inicio" ) ;
		console.log(id);
		var s = n.toDateString();
		a.setDate(a.getDate() + 1);
		var pd = Date.parse(n);
	$('input[name="d"]').val(n);
	})
	})
</script>
<hr>
<hr>
<hr>
@stop
@section('content')
<div class="box box-solid box-info">
	<div class="box-header" with-border>
	<h1>ESCOLHA O PROJETO QUE DESEJA COPIAR</h1>
	@if( $projcp == null )
	<div class="form-group col-md-6">
				 <form method="GET" action="{{ route('admin.proj.cpproj') }}"  enctype="multipart/form-data">
				{!! csrf_field() !!} 
				<label>PRIMEIRO PASSO:</label>
              	<select name="projcp" class="form-control">
              	<option value="{{ $projeto !=null ? $projeto : '' }}">-- Selecione o Projeto -- </option>
              	@foreach ($projects as $project)
              	<option value="{{ $project->id }}">{{ $project->projeto }}</option>
              	@endforeach
            	</select>
    			<button type="submit" class="btn btn-primary">Selecionar</button> 
   				</form>
	</div>
	</div>
	@else
	@foreach ($projects as $project)
	@if( $project->id == $projcp )
	<h1>PROJETO:{{ $project->projeto }}</h1>
	@endif
	@endforeach
</div>	
	@endif
<div class="box box-solid box-info">
		<div class="box-header" with-border>
			<h3>Digite um novo projeto para copiar os dados</h3>
		</div>
		<div class="box-body">
			<form method="get" action="{{ route('admin.proj.store_p')}}" enctype="multipart/form-data">
					{!! csrf_field() !!}
				<div class="form-row">
					@include('admin.includes.alerts')
						<div class="form-group" >
							<input type="text" class="form-control" name="projeto" maxlength="50" placeholder="Nome do Projeto">
						</div>
						<div class="form-group">
						<textarea type="text" name="detalhe" rows="5" cols="80" placeholder="Descreva o detalhe do projeto" class="form-control"></textarea>
						<div class="form-group">
							<label>Gerente do Projeto:</label>
						<select name="gerente">
							@foreach ($users as $user)
							<option value="{{ $user->id }}">{{ $user->name }}</option>
							@endforeach
						</select>
					</div>
						<div class="form-group col-md-2" >	
							<label>Urgência:</label>
							<input type="texto" class="form-control" name="urg" placeholder="Número de 1 a 5">
						</div>
						<div class="form-group col-md-2" >	
							<label>Importância:</label>
							<input type="texto" class="form-control" name="imp" placeholder="Número de 1 a 5">
						</div>
						<div class="form-group col-md-6" >
							<label>Data de Inicio:</label>
							<input type="date" class="form-controle" value="{{ $inicio !=null ? $inicio : date('Y-m-d') }}" id="inicio" name="inicio" placeholder="Data de Inicio" maxlength="15">
							<a id="func18" class="btn btn-primary">01/01/2021</a> 
						</div>
							<div class="form-group col-md-6" >	
								<label class="form-group col-md-3">Previsão de Conclusão da tarefa em Dias</label>
								<input type="number" class="form-group col-md-2" value="{{ $duration !=null ? $duration : 0 }}" name="duration" id="duration" required placeholder="Previsão em dias"> 
								<a onclick="func17()" class="btn btn-primary">Atualizar Data de Conclusão</a> 
							</div>
							<div class="form-group col-md-3" >
							<label>Obs: Você pode preencher a data de conclusão da tarefa ou digitar a duração em dias e clicar em calcular</label>
							</div>
							<div class="form-group col-md-6" >	
							<input type="date" class="form-controle"  id="fim" name="fim" value="{{ $fim !=null ? $fim : date('Y-m-d') }}"  >
							<a id="func20" class="btn btn-primary">31/12/2021</a> 
							</div>
						</div>
						<input type="hidden" name="projcp" value="{{ $projcp }}">
						<div class="form-group col-md-3">
						<button type="submit" class="btn btn-success">Enviar</button> 
						</div>
				</div>
			</form>
		</div>
	</div>
	@endsection