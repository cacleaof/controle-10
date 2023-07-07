@extends('adminlte::page')

@section('title', 'Teleconsultoria')

@section('content_header')

	
@stop

@section('content')

	<div class="box box-solid box-info">
		<div class="box-header" with-border>
			<h3 class="text-center"><i class="fa fa-fw fa-comment-o"></i> Digite as informações da sua Teleconsultoria</h3>
		</div>
		<div class="box-body">
			<form method="POST" action="{{ route('consult.store')}}" enctype="multipart/form-data">
				{!! csrf_field() !!}
				<div class="form-row">
					@include('admin.includes.alerts')
					<div class="form-group col-xs-12 col-md-12">
							<!-- <select class="form-control" name="servico">
								<option>Escoha o tipo de Teleconsultoria</option>
								<option value="Assíncrona">Mensagem - Preencher formulário abaixo</option>
								<option value="Síncrona">Online - Aguardar email</option>
							</select> -->
					</div> 
			        </div>
				<div class="box-body">
					<textarea class="form-group col-xs-12 col-md-12" type="text" name="consulta" rows="4" cols="80" placeholder="Descreva sua teleconsultoria para esclarecer dúvidas sobre procedimentos clínicos, ações de saúde e questões relativas ao processo de trabalho" class="form-control"></textarea>
						<div class="form-group col-xs-10 col-md-8">
							<label class="callout callout-info" for="file" >Anexe os Arquivos com dados que complementem sua teleconsulta :</label>
							<input type="file"  name="arquivo[]" id="file" multiple>
							<input type="hidden" value="{{ csrf_token() }}" name="_token">
							<hr></hr>
							<div class="callout callout-warning">
						    <h5><i class="fa fa-fw fa-warning"></i>A soma do tamanho dos arquivos anexados podem ter no máximo 1 MB(megabyte)</h5>
						    </div>
						</div>
						
				</div>
				<div class="form-group col-xs-12 col-md-12">
						<div class="callout callout-info">
							<h5><i class="fa fa-fw fa-warning"></i> Caso considere relevante informe abaixo os dados do paciente como nome, idade indicando unidade(Anos, Meses, dias), Queixa, Instituiçao e Município</h5>
						</div>

				</div>
					<div class="form-group col-md-6">
						<input type="text" class="form-control" id="nome_paciente" name="nome_paciente" maxlength="50" placeholder="Nome do Paciente">
						</div>
						<div class="form-group col-md-3">
							<input type="text" name="idade" maxlength="30" placeholder="Idade do Paciente" class="form-control">
						</div>
						<div class="form-group col-md-3">
							<input type="text" name="sexo" maxlength="30" placeholder="Informe o sexo do paciente" class="form-control">
						</div>



					<div class="form-row">

						<div class="form-group col-md-12">
							<textarea class="form-group col-xs-12 col-md-12" type="text"name="queixa" maxlength="300" rows="4" cols="80" placeholder="Patologia e/ou comorbidade do paciente" class="form-control"></textarea>

						</div>


					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<input type="text" name="instituiçao" maxlength="191" placeholder="Localizacao do paciente(Ex. Hospital, Unidade de Saude, Casa)" class="form-control">
						</div>
						<div class="form-group col-md-6">
							<input type="text" name="municipio_sol" maxlength="50" placeholder="Municipio onde está o paciente" class="form-control">
						</div>
						<!-- <div class="form-group col-md-6">
							<input type="text" name="area" maxlength="50" placeholder="Área de Saúde da Teleconsultoria" class="form-control">
						</div> -->
						<div class="form-group col-md-6">
							<button type="submit" class="btn btn-success">Clique para enviar sua solicitação</button>
						</div>
					</div>
			</form>
		</div>
	</div>
@stop