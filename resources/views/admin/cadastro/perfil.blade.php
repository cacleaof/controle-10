@extends('adminlte::page')

@section('content_header')
<div class="box">
    <p><strong>Usuário Logado: </strong>{{auth()->user()->name }}</p>
</div>
@stop
@section('content')
    @include('admin.includes.alerts')

        <table id="example" class="display responsive nowrap" width="100%">
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
            <th>SEXO </th>
            </tr> 
        </thead>  
         @forelse($users as $user)
        <tr>
            <td><a href="{{ route('admin.cadastro.editperfil', ['cid' => $user->id] )}}"> {{ $user->id}}</a></td>
            <td>{{ $user->cpf }} </td>
            <td>{{ $user->name}} </td>
	        <td>{{ $user->nome_cargo}} </td>
            <td>{{ $user->ocupacao}} </td>
            <td>{{ $user->email}} </td>
            <td>{{ $user->cns}} </td>
            <td>{{ $user->telefone_celular}} </td>
            <td>{{ $user->cidade}} </td>
            <td>{{ $user->nome_fantasia}} </td>
            <td>{{ $user->conselho }} </td>
            <td>{{ $user->sexo}} </td>
        </tr>    
        @empty
        <p>Sistema sem usuários</p>
        @endforelse
                 </table>
@endsection