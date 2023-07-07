@extends('adminlte::page')

@section('content_header')
<div class="box">
    <p><strong>Usuário Logado: </strong>{{auth()->user()->name }}</p>
</div>
@stop
@section('content')
    @include('admin.includes.alerts')
    <table id="example1" class="display responsive nowrap" width="100%">
            <thead>
            <tr>
            <th>ID </th>
            <th>CPF </th>
            <th>NOME </th>
	        <th>PROFISSÃO </th>
            <th>OCUPAÇÃO </th>
            <th>EMAIL </th>
            <th>CNS </th>
            <th>CELULAR  </th>
            <th>CIDADE</th>
            <th>VINCULO </th>
            <th>CONSELHO </th>
            </tr> 
        </thead>  
        <tr>
            <td>{{ $users->id}}</td>
            <td>{{ $users->cpf }} </td>
            <td>{{ $users->name}} </td>
	        <td>{{ $users->nome_cargo}} </td>
            <td>{{ $users->ocupacao}} </td>
            <td>{{ $users->email}} </td>
            <td>{{ $users->cns}} </td>
            <td>{{ $users->telefone_celular}} </td>
            <td>{{ $users->cidade}} </td>
            <td>{{ $users->nome_fantasia}} </td>
            <td>{{ $users->conselho }} </td>
        </tr>    
       
    </table>
    <a>Selecione abaixo o perfil para atualizar </a>
    <table id="example" class="display responsive nowrap" width="100%">
    <thead>
            <tr>
            <th>ID </th>
            <th>PERFIL </th>
    </thead>
        @forelse($perfils as $perfil)

        @if ($perfil->user_id == $users->id)
        <tr>
        <td><a href="{{ route('admin.cadastro.muda_perfil', ['pid' => $perfil->id, 'cid' => $users->id] )}}"> {{ $perfil->id}}</a></td>
            <td>{{ $perfil->perfil }} </td>
        </tr>
        @endif   
        @empty
        <p>Usuário sem Perfil</p>
        @endforelse 
        </table>
        <div class="form-group">
         <a href="{{ route('admin.cadastro.n_perfil', ['cid' => $users->id]) }}" class="btn btn-primary"><i class="fas fa-shopping-cart"></i>Incluir novo Perfil</a>
        </div>
        
@endsection