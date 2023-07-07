@extends('adminlte::page')

@section('content_header')
<div class="box">
    <p><strong>Usuário Logado: </strong>{{auth()->user()->name }}</p>
</div>
@stop
@section('content')
    @include('admin.includes.alerts')
    <div class="box-body">
    <form method="POST" action="{{ route('admin.cadastro.m_perfil', ['pid' => $pid]) }}" enctype="multipart/form-data">
        {!! csrf_field() !!}
    <div class="form-group col-xs-2" >
						<label for="userperfil">Perfil do Usuário:</label>
						<input type="text" class="form-control" value="{{$perfils->perfil}}" name="userperfil" >
	</div> 		
    <div class="form-group">
        <button type="submit" class="btn btn-success"><i class="fas fa-shopping-cart"></i>Confirmar Alteração</button>
    </div>
    <div class="form-group">
         <a href="{{ route('admin.cadastro.n_perfil', ['pid' => $pid]) }}" class="btn btn-primary"><i class="fas fa-shopping-cart"></i>Incluir novo Perfil</a>
    </div>
    <div class="box-header">
        <a href="{{ route('admin.cadastro.del_perfil', ['pid' => $pid]) }}" class="btn btn-danger"><i class="fas fa-shopping-cart"></i>Deletar</a>
    </div>
    </div>
@endsection