@extends('adminlte::page')

@section('title', 'Smart')

@section('content_header')

	
@stop

@section('content')

	<div class="box box-solid box-info">
		<div class="box-header" with-border>
			<h3 class="text-center"><i class="fa fa-fw fa-comment-o"></i> Digite as informações do Profissional de Saúde</h3>
		</div>
		<div class="box-body">
			<form method="POST" action="{{ route('admin.smart.storenprof')}}" enctype="multipart/form-data">
				{!! csrf_field() !!}
				<div class="form-row">
					@include('admin.includes.alerts')
					<div class="form-group col-xs-12 col-md-12">
					<input type="text" class="form-control" id="nomeprof" name="nomeprof" maxlength="50" placeholder="Nome do Profissional">
					</div> 
			        </div>
				
					<div class="form-group col-md-6">
						<input type="text" class="form-control" id="tipoprof" name="tipoprof" maxlength="50" placeholder="Tipo de Profissional">
						</div>
						<div class="form-group col-md-3">
							<input type="text" name="cns" maxlength="30" placeholder="CNS" class="form-control">
						</div>
						<div class="form-group col-md-3">
							<input type="text" name="sexo" maxlength="30" placeholder="Informe o sexo do paciente" class="form-control">
						</div>

					<div class="form-row">
						<div class="form-group col-md-12">
							<input type="text" name="cnes" maxlength="30" placeholder="CNES" class="form-control">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<input type="text" name="cbo" maxlength="10" placeholder="CBO" class="form-control">
						</div>
						<div class="form-group col-md-6">
							<input type="text" name="cpf" maxlength="12" placeholder="CPF" class="form-control">
						</div>
						<div class="form-group col-md-6">
							<input type="text" name="ine" maxlength="15" placeholder="INE" class="form-control">
						</div>
						<div class="form-group col-md-6">
							<input type="text" name="data" maxlength="6" placeholder="Mes e Ano" class="form-control">
						</div>
						<div class="form-group col-md-6">
							<button type="submit" class="btn btn-success">Clique para enviar o cadastro</button>
						</div>
					</div>
			</form>
		</div>
	</div>
@stop