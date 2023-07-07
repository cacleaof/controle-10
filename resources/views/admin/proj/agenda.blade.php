@extends('adminlte::page')

@section('content')

<table id="example2"  class="display" style="width:100%">
    <thead>
        <tr>
        <th>ID </th>
        <th>TAREFA </th>
        <th>DESCRIÇÃO</th>
        <th>INICIO</th>
        <th>FIM</th>
       <th>IMPORTANCIA</th>

       
        </tr>
    </thead>
    <tbody>
        <tr>
            @forelse($tarefas as $t)
            <td>{{ $t->id}} </td>
            <td>{{ $t->text}} </td>
            <td>{{ $t->detalhe}} </td>
            <td>{{ $t->start_date }} </td>
            <td>{{ $t->date_fim}} </td>
            <td>{{ $t->imp}} </td>

           
            </tr> 
            @empty
        <p>Você não tem projetos na sua caixa de entrada</p>  
            @endforelse
    </tbody>
    <tfoot>
        <tr>
            <th>ID</th>
            <th>TAREFA</th>
            <th>DESCRIÇÃO</th>
            <th>INICIO</th>
            <th>FIM</th>
	    <th>IMPORTANCIA</th>

           
        </tr>
    </tfoot>
</table>


@endsection