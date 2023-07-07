@extends('adminlte::page')
@section('content')
  <br />
  <div class="container">
   <h3 align="center">Lista de Atividades Executadas e Programadas</h3><br />
   <div align="center">
    <a href="{{ route('admin.proj.task') }}" class="btn btn-success">Voltar</a>
   </div>
   <br />
   <input type="hidden" name="projeto" value='1'>
   <form action="" method="GET" class="form form-inline" enctype="multipart/form-data">
                {!! csrf_field() !!}
              <select name="projeto" class="form-control">
              <option value="">--Selecione o Projeto--  OU</option>
              @foreach ($projects as $project)
              <option value="{{ $project->id }}">{{ $project->projeto }}</option>
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
    <table id="example" class="display responsive nowrap" width="100%">
    <thead>
     <tr>
      <td>Data</td>
      <td>Responsável</td>
      <td>Projeto</td>
      <td>Tarefa</td>
      <td>Realizado</td>
      <td>Dia</td>
      <td>Inicio</td>
      <td>Fim</td>
     </tr>
     </thead>
     <tbody>
     @foreach($diarios as $diario)
      <tr>
      <td>{{ \Carbon\Carbon::parse($diario->ndia)->format('d/m/Y') }}</td>
      
      <td>{{ $diario->name}} </td>
      <td>{{ $diario->projeto}} </td>
      <td>{{ $diario->task_id}} </td>
      <td style="background-color: #FFF633">{{ $diario->detalhe}}</td>
       <td>{{ \Carbon\Carbon::parse($diario->ndia)->format('d/m/Y') }}</td>
      <td>{{ $diario->ini }}</td>
      <td>{{ $diario->fim }}</td>
     </tr>
     @endforeach
     </tbody>
    </table>
  </div>
@stop