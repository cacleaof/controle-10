@extends('adminlte::page')


@section('title', 'Tele-ECG')

@section('content_header')
    <h1>Tele-ECG</h1>

    <ol class='breadcrumb'>
    	<li><a ref="">Dashboard</a></li>
    	<li><a ref="">Consult</a></li>
    	<li><a ref="">Entrada</a></li>
    </ol>
@stop

@section('content')
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title">Digite informações relevantes para seu tele-diagnóstico</h3>
		</div>
		<div class="box-header with-border">
			<div id="myDIV2">
				<div class="col-md-12">
				
				<h3 class="text-center">Paciente apresenta dor torácica aguda</h3>		
				</div>
			<br>
				<div class="col-md-3">

				</div>
				<div class="col-md-3">
					<button type="button" onclick="myFunction()" class="btn btn-block btn-success btn-xs">SIM</button>
				</div>
				<div class="col-md-3">
					<button type="button" onclick="myFunction1()" class="btn btn-block btn-danger btn-xs">NÃO</button>
				</div>
			</div>
			
		</div>

		
		<script>
		function myFunction() {
		document.getElementById("myDIV").style.display = "none";
		document.getElementById("myDIV1").style.display = "block";
		}
		</script>

		<script>
		function myFunction1() {
		document.getElementById("myDIV").style.display = "block";
		document.getElementById("myDIV2").style.display = "none";
		document.getElementById("myDIV3").style.display = "block";
		}
		</script>

		<div id="myDIV1" style="display:none">
			<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true" onClick="window.location.reload();">×</button>
                <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                <h4 class="text-center">Sim: Paciente deverá ser encaminhado a urgência cardiológica.</h4>
              </div>	
		</div>
		
		<div id="myDIV3" style="display:none">
			<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                <h4 class="text-center">Preencha todas as informações do formulário.</h4>
              </div>	
		</div>	
		
		
		<!-- /.box-header -->
		<!-- form start -->
		<div id="myDIV" style="display:none">
			
	  	<form method="POST" action="{{ route('consult.storeecg')}}" enctype="multipart/form-data">
			{!! csrf_field() !!}
			<div class="box-body">
				@include('admin.includes.alerts')
				<div class="box-header with-border">
					<h4 class="box-title">Dados do Paciente</h4>
				</div>
				<div class="form-group col-md-6"style="display:none">
					<label></label>
					<input type="text" id="servico" name="servico" value="Tele-ECG">
				</div>
				<div class="form-group col-md-6" style="display:none">
					<label>Médico Solicitante:</label>
					<input type="text" id="solicitante" name="solicitante" value="{{auth()->user()->name}}" class="form-control">
				</div>
				<div class="form-group col-md-6">
					<label>Médico Solicitante:</label>
					<input type="text" id="solicitante" name="solicitante" value="{{auth()->user()->name}}" class="form-control" disabled>
				</div>
				<div class="form-group col-md-6">
					<label>Nome do paciente</label>
					<input type="text" name="nome_paciente" placeholder="Nome do paciente" class="form-control">
				</div>
				<div class="form-group col-md-4">
					<label>Data de Nascimento</label>
					<input type="date" name="data_nascimento" placeholder="Data de Nascimento" class="form-control">
				</div>
				<div class="form-group col-md-4">
					<label>Sexo</label>
					<select name="sexo" id="sexo" class="form-control">
						
						<option value="Femenino">Feminino</option>
						<option value="Masculino">Masculino</option>
					</select>
				</div>
				<div class="form-group col-md-4">
					<label>CPF</label>
					<input type="text" id="cpf" name="cpf" placeholder="CPF" class="form-control">
				</div>
				<div class="form-group col-md-4">
					<label>CNS</label>
					<input type="text" id="cns" name="cns" placeholder="CNS" class="form-control">
				</div>
				<div class="form-group col-md-4">
					<label>Telefone</label>
					<input type="text" id="telefone" name="telefone" placeholder="Telefone" class="form-control">
				</div>
				<div class="form-group col-md-12">
					<label>Endereço</label>
					<input type="text" id="endereco" name="endereco" placeholder="Endereço" class="form-control">
				</div>
				<div class="form-group col-md-6">
					<label>Bairro</label>
					<input type="text" id="bairro" name="bairro" placeholder="Bairro" class="form-control">
				</div>
				<div class="form-group col-md-6">
					<label>Cidade</label>
					<input type="text" id="cidade" name="cidade" placeholder="Cidade" class="form-control">
				</div>
				<div class="form-group col-md-6">
					<label for="exampleFormControlSelect2">Motivo da Solicitação</label>
					<select multiple  class="form-control" name="motivo[]" id="motivo[]">
					  <option value="eletiva">Eletiva</option>
					  <option value="risco cirúrgico">Risco Cirúrgico</option>
					  <option value="dispinéia">Dispinéia</option>
					  <option value="palpitacao">Palpitação</option>
					  <option value="outros">Outros</option>
					</select>
				</div>

				<div class="form-group col-md-6">
					<label for="exampleFormControlSelect2">Fatores de Riscos</label>
					<select multiple class="form-control" name="fatores[]" id="fatores[]">
					  <option value="obesidade">Obesidade</option>
					  <option value="doenca de chagas">Doenca de chagas</option>
					  <option value="diabetes melitus">Diabetes Melitus</option>
					  <option value="hipertensao arterial">Hipertensão Arterial</option>
					  <option value="revascularizacao miocardica previa">Revascularização Miocárdica Prévia</option>
					  <option value="dislipidemia">Dislipidemia</option>
					  <option value="infarto miocardio previo">Infarto Miocárdio Prévio</option>
					  <option value="tabagismo">Tabagismo</option>
					  <option value="historico familiar de doenca coronariana">Histórico Familiar de Doença Coronáriana</option>
					  <option value="nenhum">Nenhum</option>
					  <option value="doenca pulmonar cronica">Doença Pulmonar Crônica</option>
					  <option value="uso de marca passo">Uso de Marca Passo</option>
					  <option value="outros">Outros</option>
					</select>
				</div>

				<div class="form-group col-md-6">
					<label for="exampleFormControlSelect2">Medicamentos em Uso</label>
					<select multiple class="form-control" id="medicamentos[]" name="medicamentos[]">
					  <option value="ass">ASS</option>
					  <option value="diureticos">Diuréticos</option>
					  <option value="estatina">Estatina</option>
					  <option value="inibidoras de enzima">Inibidoras de Enzima</option>
					  <option value="amiodarona">Amiodarona</option>
					  <option value="hipoglicemiantes oral">Hipoglicemiantes Oral</option>
					  <option value="digoxina">Digoxina</option>
					  <option value="insulina">Insulina</option>
					  <option value="betabloqueadores de calcio">Betabloqueadores de Cálcio</option>
					  <option value="nenhum">Nenhum</option>
					   <option value="outros">Outros</option>
					</select>
				</div>
				<div class="form-group col-md-6">
				</div>
				<div class="form-group col-md-12">
					<div class="box-header with-border">
						<h4 class="box-title">Dados do Paciente</h4>
					</div>
				</div>
				
				<div class="form-group col-md-4">
					<label>Pressão arterial</label>
					<input type="text" id="pressao" name="pressao" placeholder="Pressão arterial" class="form-control">
				</div>
				<div class="form-group col-md-4">
					<label>Peso</label>
					<input type="number" id="peso" name="peso" placeholder="Peso" class="form-control">
				</div>
				<div class="form-group col-md-4">
					<label>Altura</label>
					<input type="number" id="altura" name="altura" placeholder="Altura" class="form-control">
				</div>
				<div class="form-group col-md-6">
					<label>Queixa de dor?</label>
					<input type="text" id="queixa" name="queixa" placeholder="Queixa de dor?" class="form-control">
				</div>
				<div class="form-group col-md-6">
					<label>Localização de dor?</label>
					<input type="text" id="localizacao" name="localizacao" placeholder="Localização" class="form-control">
				</div>
				<div class="form-group col-md-6">
					<label>Intensidade</label>
					<input type="text" id="intensidade" name="intensidade" placeholder="Intensidade" class="form-control">
				</div>
				<div class="form-group col-md-6">
					<label>Irradiação</label>
					<input type="text" id="irradiacao" name="irradiacao" placeholder="Irradiação" class="form-control">
				</div>
				<div class="form-group col-md-6">
					<label for="exampleFormControlSelect2">Característica da dor <span class="dashicons dashicons-rss"></span></label>
					<select multiple class="form-control" id="caracteristica[]" name="caracteristica[]">
					  <option value="provocado por esforco">Provocado por Esforço</option>
					  <option value="provocado por emocao">Provocado por Emoção</option>
					  <option value="desconforto precordial">Desconforto Precordial</option>
					  <option value="alivia com o repouso">Alivia com o Repouso</option>
					 
					</select>
				</div>
				<div class="form-group col-md-6">
					<label>Data do último episódio</label>
					<input type="date" id="episodio" name="episodio" class="form-control">
				</div>
				<div class="form-group col-md-6">
					<label>Duração</label>
					<input type="text" id="duracao" name="duracao" placeholder="Duração" class="form-control">
				</div>
				<div class="form-group col-md-6">
					<label>Recidiva da dor há quanto tempo</label>
					<input type="text" id="recidiva" name="recidiva" placeholder="Recidiva da dor há quanto tempo" class="form-control">
				</div>
				<div class="form-group col-md-6">
					<label for="exampleFormControlSelect2">Sintomas Associados<span class="dashicons dashicons-rss"></span></label>
					<select multiple class="form-control" id="sintomas[]" name="sintomas[]">
					  <option value="dispneia">Dispneia</option>
					  <option value="palpitacao">Palpitação</option>
					  <option value="sincope">Sincope</option>
					  <option value="tonteira">Tonteira</option>
					  <option value="sudorese">Sudorese</option>
					  <option value="nausea ou vomito">Náusea ou Vômito</option>
					  <option value="outros">Outros</option>
					 
					</select>
				</div>
				
				<div class="form-group col-md-6">
					<label>Hipótese Diagnóstica</label>
					<textarea type="text" name="consulta" rows="8" cols="90" placeholder="Hipótese Diagnóstica" class="form-control"></textarea>
				</div>
				<div class="form-group col-md-6">
					<label for="file">Arquivos Anexos:</label>
					<input type="file" name="arquivo[]" id="file" multiple>
					<input type="hidden" value="{{ csrf_token() }}" name="_token">
				</div>
				<div class="form-group col-md-6">

					<div class="callout callout-danger">
						<h5><i class="fa fa-fw fa-warning"></i>
							Informe dados do paciente como nome, idade indicando unidade(Anos, Meses, dias), Queixa, Instituiçao e Município
						</h5>

					</div>
				</div>
				
				<div class="col-md-12">
					<hr>
				</div>
				
				<div class="form-group col-md-6">
					<input type="text" name="instituiçao" maxlength="191" placeholder="Instituiçao onde está o paciente" class="form-control">
				</div>
				<div class="form-group col-md-6">
					<input type="text" name="municipio_sol" maxlength="50" placeholder="Municipio do paciente" class="form-control">
				</div>

			</div>
			<!-- /.box-body -->

			<div class="box-footer">
				<button type="submit" class="btn btn-primary">Enviar</button>
			</div>
		</form>
		</div>
		
	
	</div>

	

@stop