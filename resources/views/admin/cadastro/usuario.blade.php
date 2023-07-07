@extends('adminlte::page')

@section('title', 'Usuário')

@section('content_header')
    <h1>Usuário Selecionado</h1>

    <ol class='breadcrumb'>
    	<li><a ref="">Admin</a></li>
    	<li><a ref="">usuario</a></li>
    </ol>
@stop
@section('content')
	<div class="box box-solid box-info">
		<div class="box-header" with-border>
			<h3>Altere os Dados do Usuário e Confirme em Enviar</h3>
		</div>
		<div class="box-body">
			<form method="POST" action="{{ route('admin.cadastro.store', ['cid' => $cid])}}" enctype="multipart/form-data">
					{!! csrf_field() !!}
				<div class="form-row">
					@include('admin.includes.alerts')
						<div class="form-group col-xs-5 ">
							<label for="nome">Nome do Usuário:</label>
							<input type="text" name="nome" class="form-control" value="{{$users->name}}"> 
						</div>
						<div class="form-group col-xs-2" >
							<label for="cpf">Número do CPF:</label>
							<input type="text" class="form-control" value="{{$users->cpf}}" name="cpf" readonly>
						</div>
						<div class="form-group col-xs-3" >
							<label for="email">Email:</label>
							<input type="text" class="form-control" value="{{$users->email}}" name="email" >
						</div>
						<div class="form-group col-xs-2" >
							<label for="cns">CNS:</label>
							<input type="text" class="form-control" value="{{$users->cns}}" name="cns" >
						</div>
						<div class="form-group col-xs-2" >
							<label for="nacionalidade">Nacionalidade:</label>
							<input type="text" class="form-control" value="{{$users->nacionalidade}}" name="nacionalidade" >
						</div>
						<div class="form-group col-xs-2" >
							<label for="data_nascimento">Data de Nascimento:</label>
							<input type="text" class="form-control" value="{{$users->data_nascimento}}" name="data_nascimento" >
						</div>
						<div class="form-group col-xs-2" >
							<label for="sexo">Sexo:</label>
							<input type="text" class="form-control" value="{{$users->sexo}}" name="sexo" >
						</div>
			            <div class="form-group col-xs-2" >
			            	<label for="telefone_residencial">Telefone Residencial:</label>
							<input type="text" class="form-control" value="{{$users->telefone_residencial}}" name="telefone_residencial">
						</div>
						<div class="form-group col-xs-2" >
							<label for="telefone_celular">Telefone Celular:</label>
							<input type="text" class="form-control" value="{{$users->telefone_celular}}" name="telefone_celular">
						</div>
						<div class="form-group col-xs-2" >
							<label for="conselho">Conselho:</label>
							<input type="text" class="form-control" value="{{$users->conselho}}" name="conselho">
						</div>
						<div class="form-group col-xs-2" >
							<label for="num_conselho">Número do Conselho:</label>
							<input type="text" class="form-control" value="{{$users->num_conselho}}" name="num_conselho" >
						</div>
						<div class="form-group col-xs-5" >
							<label for="razao_social">Razão Social:</label>
							<input type="text" class="form-control" value="{{$users->razao_social}}" name="razao_social" >
						</div>
						<div class="form-group col-xs-3" >
							<label for="nome_fantasia">Nome Fantasia:</label>
							<input type="text" class="form-control" value="{{$users->nome_fantasia}}" name="nome_fantasia" >
						</div>
						<div class="form-group col-xs-2" >
							<label for="cnes">CNES:</label>
							<input type="text" class="form-control" value="{{$users->cnes}}" name="cnes" >
						</div>
						<div class="form-group col-xs-2" >
							<label for="cnes">ESPECIALIDADE:</label>
							<input type="text" class="form-control" value="{{$users->especialidade}}" name="especialidade" >
						</div>
						<div class="form-group col-xs-2" >
							<label for="cnes">OCUPAÇÃO:</label>
							<input type="text" class="form-control" value="{{$users->ocupacao}}" name="ocupacao" >
						</div>
						<div class="form-group col-xs-2" >
							<label for="cnes">NOME DO CARGO:</label>
							<input type="text" class="form-control" value="{{$users->nome_cargo}}" name="nome_cargo" >
						</div>
            			<div class="form-group col-xs-2" >
						<label for="userperfil">Fonte do Usuário:</label>
						<input type="text" class="form-control" value="{{$users->fonte}}" name="userfonte" >
						</div> 
						<div class="form-group col-xs-2" >
						<label for="userperfil">Perfil do Usuário:</label>
						<input type="text" class="form-control" value="{{$perfils->perfil}}" name="userperfil" >
						</div> 				
						<div class="form-group">
                        <button type="submit" class="btn btn-success">Enviar</button> 
                        </div>
                        <div class="box-header">
            			<a href="{{ route('admin.cadastro.deletar', ['cid' => $cid]) }}" class="btn btn-danger"><i class="fas fa-shopping-cart"></i>Deletar</a>
            			</div>
			</form>
		</div>
	</div>
 @stop
