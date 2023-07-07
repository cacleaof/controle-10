@extends('adminlte::page')
@section('content')
<!DOCTYPE html>
<html>
 <head>
  <title>Tarefas</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style type="text/css">
   .box{
    width:600px;
    margin:0 auto;
    border:1px solid #ccc;
   }
  </style>
 </head>
 <body>
  <br />
  <div class="container">
   <h3 align="center">Lista de Tarefas</h3><br />
   <div align="center">
    <a href="{{ route('admin.proj.task') }}" class="btn btn-success">Voltar</a>
   </div>
   <form action="" method="GET" class="form form-inline" enctype="multipart/form-data">
                {!! csrf_field() !!}
              <select name="projeto" class="form-control">
              @foreach ($projects as $project)
              <option value="{{ $project->id }}" {{ $project->id == $projeto ? 'selected' : ''}}>{{ $project->projeto }}</option>
              @endforeach
            </select>
            <select name="usuario" class="form-control">
            <option value="">--Selecione o Usuario--</option>
              @foreach ($users as $user)
              <option value="{{ $user->id }}">{{ $user->name }}</option>
              @endforeach
            </select>
    <button type="submit" class="btn btn-primary">Enviar</button> 
   </form>
   <br />
   <div class="table-responsive">
    <table id="example" class="display" style="width:100%">
      <thead>
     <tr>
      <th>Status</th>
      <th>Projeto</th>
      <th>Tarefa</th>
      <th>Detalhe</th>
      <th>Progresso</th>
      <th>Início</th>
      <th>Conclusão</th>
      <th>Previsão</th>
      <th>Urg</th>
      <th>Gerente</th>
     </tr>
     </thead>
     <tbody>
      @foreach($tarefas as $tarefa)
      <tr>
      <td>{{ $tarefa->status}} </td>
      <td>{{ $tarefa->projeto}} </td>
      <td><a href="{{ route('proj.showtk', ['trf' => $tarefa->id]) }}"
            > {{ $tarefa->text }}</a></td>
            @if( $tarefa->urg > 2 )
            <td bgcolor="red">{{ $tarefa->detalhe }}</td>
            @else
            <td>{{ $tarefa->detalhe }}</td>
            @endif
      <td style="background-color: #FFF633">{{ $tarefa->progress*100}}</td>
      <td>{{ \Carbon\Carbon::parse($tarefa->start_date)->format('d/m/Y') }}</td>
      <td>{{ \Carbon\Carbon::parse($tarefa->date_fim)->format('d/m/Y') }}</td>
      <td>{{ $tarefa->duration}}</td>
      <td>{{ $tarefa->urg}} </td>
      <td>{{ $tarefa->name }} </td>
    
     </tr>
     @endforeach 
     </tbody>
    </table>
       </div> 
  </div>
 </body>
</html>
@stop