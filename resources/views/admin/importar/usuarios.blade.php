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
	<div class="box box-solid box-info">
		<div class="box-header" with-border>
			<h3>Selecione o Arquivo de Usuários a ser Importado</h3>
		</div>
		<div class="box-body">
			<form method="POST" action="{{ route('importar.save_usuarios')}}" enctype="multipart/form-data">
					{!! csrf_field() !!}
				<div class="form-row">
					@include('admin.includes.alerts')
						<div class="form-group">
						<div class="form-row">
							<label for="file">Arquivo de Usuários Anexo:</label>
							<input type="file" name="arquivo" id="file">
							<input type="hidden" value="{{ csrf_token() }}" name="_token">
						</div>
						<div class="form-group">
						<button type="submit" class="btn btn-success">Enviar</button> 
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
@stop