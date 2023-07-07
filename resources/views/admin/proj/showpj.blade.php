@extends('adminlte::page')

@section('title', 'Projetos')

@section('content_header')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

   
<script type="text/javascript">
    google.charts.load('current', {'packages':['gantt'], 'language': 'pt-br'});
    google.charts.setOnLoadCallback(drawChart);
   
    function daysToMilliseconds(days) {
      return days * 24 * 60 * 60 * 1000;
    }
    function Func30(){
  	  
      console.log(projeto);
	      }
    function drawChart() {
      
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Task ID');
      data.addColumn('string', 'Task Name');
      data.addColumn('string', 'Resource');
      data.addColumn('date', 'Start Date');
      data.addColumn('date', 'End Date');
      data.addColumn('number', 'Duration');
      data.addColumn('number', 'Percent Complete');
      data.addColumn('string', 'Dependencies');

     
      data.addRows([
        @forelse($gantt as $ga)
        @if($ga->parent == 0)
          ['{{ $ga->id }}', '{{ $ga->text }}', null,
          new Date({{ $ga->asd }}, {{ $ga->msd-1 }}, {{ $ga->dsd }}), new Date({{ $ga->adf }}, {{ $ga->mdf-1 }}, {{ $ga->ddf }}), null, {{ ($ga->prog)*100 }}, null],
          @else
          ['{{ $ga->id }}', '{{ $ga->text }}', '{{ $ga->id }}' ,
          new Date({{ $ga->asd }}, {{ $ga->msd-1 }}, {{ $ga->dsd }}), new Date({{ $ga->adf }}, {{ $ga->mdf-1 }}, {{ $ga->ddf }}), null, {{ ($ga->prog)*100 }}, '{{ $ga->parent }}'],
          //['{{ $ga->id }}', '{{ $ga->text }}', '{{ $ga->text }}',
          // null, new Date({{ $ga->adf }}, {{ $ga->mdf-1 }}, {{ $ga->ddf }}), daysToMilliseconds({{ $ga->duration }}), {{ ($ga->prog)*100 }}, '{{ $ga->dep }}'],
          @endif 
        @empty
       @endforelse
                  ]);
      
                  var options = {
          gantt: {
            criticalPathEnabled: true,
            criticalPathStyle: {
              stroke: '#e64a19',
              strokeWidth: 5
            }
          }
        };
      // var options = {
      //   height: 800,
      //   gantt: {
      //    criticalPathEnabled: true,
      //    //shadowEnabled: true,
      //    //shadowColor: 'red',
      //    innerGridHorizLine: {
      //       stroke: '#ffe0b2',
      //       strokeWidth: 2
      //     },
      //     innerGridTrack: {fill: '#fff3e0'},
      //     innerGridDarkTrack: {fill: '#ffcc80'},
      //    arrow: {
      //         //angle: 100,
      //         width: 3,
      //         color: 'black',
      //         radius: 0
      //       },
      //      criticalPathStyle: {
      //         stroke: '#e64a19',
      //         strokeWidth: 5 },
      //     trackHeight: 30,
      //     defaultStartDateMillis: new Date(2021, 1, 1)
      //   }
      // };

      var chart = new google.visualization.Gantt(document.getElementById('chart_div'));

      chart.draw(data, options);
    }
  </script>
    <h1>Projetos</h1>
    <br>
<br>
@stop

@section('content')
<div class="box box-solid box-info">
  <div class="box-header" with-border>
  <h3>Altere os dados do seu Projeto</h3>
  </div>
    <div class="box-body">
    <form method="POST" action="{{ route('proj.upd_p', ['prj' => $project->id]) }}" enctype="multipart/form-data">
    {!! csrf_field() !!}
    @include('admin.includes.alerts')
      <div class="form-group row">
        <label for="idp" class="col-sm-1 col-form-label">ID</label>
        <div class="col-sm-1">
        <input type="text" id="idp" class="form-control" maxlength="5" value="{{ $project->id }}" readonly> 
      </div>
        <label for="idprojeto" class="col-sm-1 col-form-label">Projeto</label>
      <div class="col-sm-4">
        <input name="projeto" type="text" class="form-control col-xs-4" maxlength="50" value="{{ $project->projeto}}" readonly>
          
      </div>
        <label class="col-sm-1">Status</label>
        <select name="status">
        <option value="{{$project->status}}">{{$project->status}}</option>
        <option value="Planejando">Planejando</option>
        <option value="Executando">Executando</option>
        <option value="Pendente">Pendente</option>
        <option value="Terminado">Terminado</option>
        <option value="Cancelado">Cancelado</option>
        </select>  
    </div>  
  <div class="form-group">
    <div class="form-row">
      <label for="dproj">Detalhe do Projeto</label>
      <input type="text" id="dproj" name="detalhe" maxlength="80" value="{{ $project->proj_detalhe }}" class="form-control">
    </div>
  </div>
  <div class="form-group row"> 
      <div class="col-xs-2">
        <label>Gerente</label>
        <select name="gerente" maxlength="10" class="form-control">
        <option value="{{ $project->gerente }}">--Selecione o Responsável--</option>
		    @foreach ($users as $user)
		    <option  {{ $user->id == $project->gerente ? "selected" : ''}} value="{{ $user->id }}">{{ $user->name }}</option>
		    @endforeach
            <!-- <option value="{{ $project->gerente }}">{{ $project->gerente }}</option>
              @foreach ($users as $user)
              <option value="{{ $user->id }}">{{ $user->name }}</option>
              @endforeach -->
            </select>
      </div>
      <div class="col-xs-2">
        <label>Urgencia</label>
        <input type="text" name="urg" maxlength="5" value="{{ $project->urg }}" class="form-control">
      </div>
      <div class="col-xs-2">
       <label>Importancia</label>
       <input type="text" name="imp" maxlength="5" value="{{ $project->imp }}" class="form-control">
      </div>
  </div>
      <div class="col-xs-3">
        <label>Inicio</label>
        <input type="date" name="date_ini" maxlength="5" value="{{ $project->date_ini }}" class="form-control">
      </div>
      <div class="col-xs-3">
        <label>Termino</label>
        <input type="date" name="date_fim" maxlength="5" value="{{ $project->date_fim }}" class="form-control">
      </div>
      <div class="col-xs-2">
        <label>Duração</label>
        <input type="text" name="duracao" maxlength="10" value="{{ $project->duracao }}" class="form-control"> 
      </div> 
      <div class="col-xs-2">
        <label>Progresso %</label>
        <input type="number" name="prog" maxlength="5" value="{{ $project->progress*100 }}" class="form-control">
      </div>
</div>
  
    <div class="form-group">
    <div class="col-md-2">
      <button type="submit" class="btn btn-success">
				        <h4>Enviar Alteração</h4>
      </button> 
    </div>
      <div class="col-md-2">
        <a href="{{ route('proj.delpj', ['prj' => $project->id]) }}">
            <div class="small-box bg-red">
                <div class="inner">
				        <h4>Apagar Projeto</h4>
                </div>
                <div class="icon">
                <i class="glyphicon glyphicon-ok"></i>
                </div> 
            </div>
        </a>
      </div>
    <div class="col-md-2">
        <a href="{{ route('admin.proj.n_task', ['trf' => $project->id]) }}" class="small-box-footer">
            <div class="small-box bg-blue">
                <div class="inner">
				        <h4>Nova Tarefa</h4>
                </div>
                <div class="icon">
                <i class="glyphicon glyphicon-ok"></i>
                </div> 
            </div>
        </a>
    </div>
    
      <form>
      <!-- <button onclick="window.location='{{ route("admin.proj.task") }}'" id="myButton" class="btn btn-success"> -->
      <!-- <input class="MyButton" type="button" value="SAIR" 
      onclick="window.location.href='http://telessaude.pe.gov.br/'"/> -->
      <input class="btn btn-success btn-lg" type="button" value="SAIR" 
      onclick="window.location.href='{{ route("admin.proj.index") }}'"/>
      </form>
    </div>
    <br><br>
    </form>
    <div class="box box-solid box-info">
          <div class="box-header" with-border>
          <h3>Dependencias de Tarefas</h3>
          </div>
         
    <div id="chart_div" style="width: 100%; height: 500px"></div>
         
        </div>
        <div class="box box-solid box-info">
          <div class="box-header" with-border>
          <h3>Tarefas Planejadas deste Projeto</h3>
          </div>
          <div class="box-body">
            <div class="row">
            <label class="col-xs-1">ID</label>
            <label class="col-xs-1">INICIO</label>
            <label class="col-xs-1">FIM</label>
            <label class="col-xs-1">RESPONSÁVEL</label>
            <label class="col-xs-3">TAREFA</label>
            <label class="col-xs-2">STATUS</label>
            <label class="col-xs-2">DEPENDENCIAS</label>
            <label class="col-xs-1">UPD</label>
            
            </div>
            
           
            @foreach ($tasks as $task)
            @if($prj == $task->proj_id)
            <form method="POST" action="{{ route('proj.upd_t', ['trf' => $task->id]) }}">
            {!! csrf_field() !!}
            <div class="row">
              <label class="col-xs-1" maxlength="20">{{ $task->id}}</label>
              <label class="col-xs-1">{{ \Carbon\Carbon::parse($task->start_date)->format('d/m/Y') }}</label>
              <label class="col-xs-1">{{ \Carbon\Carbon::parse($task->date_fim)->format('d/m/Y') }}</label>
              <label class="col-xs-1" maxlength="20">{{ $task->name}}</label>
              <label class="col-xs-3" maxlength="20"><a href="{{ route('proj.showtk', ['trf' => $task->id]) }}"
            > {{ $task->text }}</a></label>
              <label class="col-xs-2" maxlength="15">{{ $task->status }}</label>
              <input type="longtext" name="dep" class="col-xs-2" maxlength="20" value="{{ $task->dep }}"></input>
              <label class="col-xs-1" maxlength="3"><a href="javascript:document.querySelector('form').submit();">Upd</a></label>
              <!-- @foreach ($tks as $tk)
              @if($tk->id == $task->dep)
              <label class="col-xs-2" maxlength="20">{{ $tk->text }}</label>
              @endif
              @endforeach -->
            </div>
            </form>
            @endif
            @endforeach
            
          </div>
          <div class="form-group">
          <div class="col-md-2">
          <button type="submit" class="btn btn-success">
				        <h4>Enviar Alteração</h4>
      </button> 
    </div>
        </div>
    </div>
 
  <div class="box box-solid box-info">
    <div class="box-header" with-border>
    <h3>DIARIO - Atividades Realizadas</h3>
    </div>
    <div class="box-body">
      <div class="row">
      <label class="col-xs-1">DIA</label>
		  <label class="col-xs-3">ATIVIDADE</label>
      <label class="col-xs-2">COLABORADOR</label>
      <label class="col-xs-2">LINK</label>
      <label class="col-xs-2">ARQUIVOS</label>
    </div>
      @foreach ($diarios as $diario)
      @if($project->id == $diario->proj_id)
      <div class="row">
      <label class="col-xs-1">{{ \Carbon\Carbon::parse($diario->ndia)->format('d/m/Y') }}</label>
      <label class="col-xs-3">{{ $diario->detalhe }}</label>
      <label class="col-xs-2">{{ $diario->name }}</label>
      <div class="col-xs-2">
      @if($diario->hylink!=null)
      <a href="{{ $diario->hylink }}" target="_blank">Click para Acesso o link</a>
      @endif
      </div>
      <div class="col-xs-2">
      @if($diario->anexos=='1')
      <label class="col-xs-2">Tem arquivo anexo</label>
      @endif
      </div>
      </div>
      @endif
	    @endforeach
  </div>
  </div>
</div>
@stop