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
         @forelse($Ausers as $Auser)
            <td><a href="{{ route('admin.smart.usuario', ['cid' => $Auser->id, 'data' => $data ] )}}"> {{ $Auser->id}}</a></td> 
            <td>{{ $Auser->cpf }} </td>
            <td>{{ $Auser->name}} </td>
	    <td>{{ $Auser->nome_cargo}} </td>
        <td>{{ $Auser->ocupacao}} </td>
            <td>{{ $Auser->email}} </td>
            <td>{{ $Auser->cns}} </td>
            <td>{{ $Auser->telefone_celular}} </td>
            <td>{{ $Auser->cidade}} </td>
            <td>{{ $Auser->nome_fantasia}} </td>
            <td>{{ $Auser->conselho }} </td>
            <td>{{ $Auser->sexo}} </td>
            </tr>    
        @empty
        <p>Sistema sem usuários</p>
        @endforelse
                 </table>
@endsection