@extends('adminlte::page')

@section('content_header')
<hr>
<hr>
<div class="box">
    <p><strong>Usuário Logado: </strong>{{auth()->user()->name }}</p>
</div>
@stop
@section('content')
    @include('admin.includes.alerts')
    <div class="container">
        <div class="box">
        <div class="box-header">
            <a href="{{ route('admin.proj.n_proj') }}" class="btn btn-primary"><i class="fas fa-shopping-cart"></i>Novo Projeto</a>
            <a href="{{ route('admin.proj.n_task')}}" class="btn btn-primary"><i class="fas fa-shopping-cart"></i>Nova Tarefa</a>
            <a href="{{ route('admin.proj.diario')}}" class="btn btn-primary"><i class="fas fa-shopping-cart"></i>Diário</a>
        </div>
        </div>
    </div>
          <table id="example1" class="display" style="width:100%">
        <thead>
            <tr>
            <th>ID </th>
            <th>PROJETO </th>
            <th>DESCRIÇÃO</th>
            <th>INICIO</th>
            <th>STATUS</th>
            <th>IMP + URG</th>
           
            </tr>
        </thead>
        <tbody>
            <tr>
                @forelse($projects as $project)
                <td>{{ $project->id}} </td>
                <td><a href="{{ route('proj.showpj', ['prj' => $project->id]) }}"> {{ $project->projeto }}</a></td>
                <td>{{ $project->proj_detalhe}} </td>
                <td>{{ date('d-m-Y', strtotime($project->date_ini)) }}</td>
                <td>{{ $project->status}} </td>
                <td>{{ $project->imp + $project->urg }}</td>
               
                </tr> 
                @empty
            <p>Você não tem projetos na sua caixa de entrada</p>  
                @endforelse
        </tbody>        
            <tfoot>
            <tr>
                <th>ID</th>
                <th>PROJETO</th>
                <th>DESCRIÇÃO</th>
                <th>INICIO</th>
                <th>STATUS</th>
                <th>IMP + URG</th>
               
            </tr>
        </tfoot>
    </table>
    <table id="example" class="display responsive nowrap" width="100%">
        <thead>
            <tr>
            <hr>
            <th>ID </th>
            <th>TAREFA </th>
            <th>DESCRIÇÃO </th>
            <th>DATA </th>
            <th>STATUS</th>
            <th>DURAÇÃO </th>
            <th>URG +IMP</th>
            <th>PROJETO </th>
            </tr> 
        </thead>
        <tbody>
            <tr>
         @if ($tasks!=null)      
         @forelse($tasks as $task)
            <td>{{ $task->id}} </td>
            <td><a href="{{ route('proj.showtk', ['trf' => $task->id]) }}"
            > {{ $task->text }}</a></td>
            <td>{{ $task->detalhe}} </td>
            <td>{{ date('d-m-Y', strtotime($task->start_date)) }}</td>
            <td>{{ $task->status}} </td>
            <td>{{ $task->duration}} </td>
            <td>{{ $task->urg + $task->imp}} </td>
            <td>{{ $task->proj_id}} </td>
            </tr>    
        @empty
        <p>Você não tem tarefas na sua caixa de entrada</p>
        @endforelse
        @endif
        </tbody>
        </table>
@endsection

