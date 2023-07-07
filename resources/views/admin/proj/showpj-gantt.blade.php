@extends('adminlte::page')

@section('title', 'Projetos')

@section('content_header')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script>.gantt{width=10%;} 
#chart_div {
  overflow-x: scroll;
} </script>

   
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
          // @if($ga->parent == 0)
          // ['{{ $ga->id }}', '{{ $ga->text }}', null,
          // new Date({{ $ga->asd }}, {{ $ga->msd-1 }}, {{ $ga->dsd }}), new Date({{ $ga->adf }}, {{ $ga->mdf-1 }}, {{ $ga->ddf }}), null, {{ ($ga->prog)*100 }}, null],
          // @else
          // ['{{ $ga->id }}', '{{ $ga->text }}', '{{ $ga->id }}' ,
          // new Date({{ $ga->asd }}, {{ $ga->msd-1 }}, {{ $ga->dsd }}), new Date({{ $ga->adf }}, {{ $ga->mdf-1 }}, {{ $ga->ddf }}), null, {{ ($ga->prog)*100 }}, '{{ $ga->parent }}'],
          //['{{ $ga->id }}', '{{ $ga->text }}', '{{ $ga->text }}',
          // null, new Date({{ $ga->adf }}, {{ $ga->mdf-1 }}, {{ $ga->ddf }}), daysToMilliseconds({{ $ga->duration }}), {{ ($ga->prog)*100 }}, '{{ $ga->dep }}'],
          //@endif 
              
          
          @if($ga->dep == 0)
          ['{{ $ga->id }}', '{{ $ga->text }}', null,
          new Date({{ $ga->asd }}, {{ $ga->msd-1 }}, {{ $ga->dsd }}), new Date({{ $ga->adf }}, {{ $ga->mdf-1 }}, {{ $ga->ddf }}), null, {{ ($ga->prog)*100 }}, null],
          @else
          ['{{ $ga->id }}', '{{ $ga->text }}', '{{ $ga->id }}' ,
          new Date({{ $ga->asd }}, {{ $ga->msd-1 }}, {{ $ga->dsd }}), new Date({{ $ga->adf }}, {{ $ga->mdf-1 }}, {{ $ga->ddf }}), null, {{ ($ga->prog)*100 }}, '{{ $ga->dep }}'],
          //['{{ $ga->id }}', '{{ $ga->text }}', '{{ $ga->text }}',
          // null, new Date({{ $ga->adf }}, {{ $ga->mdf-1 }}, {{ $ga->ddf }}), daysToMilliseconds({{ $ga->duration }}), {{ ($ga->prog)*100 }}, '{{ $ga->dep }}'],
          @endif 
        @empty
       @endforelse
                  ]);
                  console.log('teste');
        var w = window,
        d = document,
        e = d.documentElement,
        g = d.getElementsByTagName('body')[0],
        xWidth = w.innerWidth || e.clientWidth || g.clientWidth,
        yHeight = w.innerHeight|| e.clientHeight|| g.clientHeight;

     
        var options = {
        height: yHeight - 165,
        width: "100%",
        hAxis: {
            textStyle: {
                fontName: ["RobotoCondensedRegular"]
            }
        },
        gantt: {
          criticalPathEnabled: true,
             criticalPathStyle: {
               stroke: '#e64a19',
               strokeWidth: 5
             },
            labelStyle: {
            fontName: ["RobotoCondensedRegular"],
            fontSize: 12,
            color: '#757575',
            }
        }
    };

      var chart = new google.visualization.Gantt(document.getElementById('chart_div'));

      chart.draw(data, options);
    }
  </script>
  
    <h1>Projetos</h1>
    <br>
<br>
@stop

@section('content')
<div id="chart_div" class="gantt"></div>

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
         
    <div id="chart_div" class="gantt"></div>
         
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
            <label class="col-xs-2">TAREFA</label>
            <label class="col-xs-1">STATUS</label>
            <label class="col-xs-2">DEPENDENCIAS</label>
            <label class="col-xs-1">ATUALIZAR</label>
            </div>
           
            @foreach ($tasks as $task)
            
            @if($prj == $task->proj_id)           
            <script>
              function myFunction{{$task->id}}() {
              var x = document.getElementById("myDIV{{$task->id}}");
              if (x.style.display === "none") {x.style.display = "block";} else {x.style.display = "none";}
            }
            </script>
            <div class="row">
              <label class="col-xs-1" maxlength="20">{{ $task->id}}</label>
              <label class="col-xs-1">{{ \Carbon\Carbon::parse($task->start_date)->format('d/m/Y') }}</label>
              <label class="col-xs-1">{{ \Carbon\Carbon::parse($task->date_fim)->format('d/m/Y') }}</label>
              <label class="col-xs-1" maxlength="20">{{ $task->name}}</label>
              <label class="col-xs-2" maxlength="20"><a href="{{ route('proj.showtk', ['trf' => $task->id]) }}"
            > {{ $task->text }}</a></label>
              <label class="col-xs-1" maxlength="15">{{ $task->status }} {{ $task->parent }}</label>
              <!-- <label class="col-xs-1" maxlength="15">{{ $task->dep }}</label> -->
              <!-- <label class="col-xs-1" maxlength="15">{{ json_encode($task->jdep) }}</label> -->
              
              <ul class="col-xs-2">
              @foreach($task['jdep'] as $jd )
              <li>{{ $jd }}</li>
              @endforeach
              </ul>
              <div class="form-check">
                <input class="form-check-input col-xs-1" type="radio" name="genero[]" value="outro" onclick="myFunction{{$task->id}}()">
              </div>
              
                  <form method="POST" action="{{ route('proj.upd_d', ['trf' => $task->id]) }}">
                  {!! csrf_field() !!}
                  <div id="myDIV{{$task->id}}" class="col" style="display: none;">                    
                   
                  <div class="col-md-12">
                    @foreach ($tasks as $task)
                    @if($prj == $task->proj_id)      
                    <input type="checkbox" name="jdep[id]" value="{{ $task->id }}">{{ $task->id }}-{{$task->text }}</input>
                    <!-- <input type="hidden" class="form-group" name="jdep[text]" value="{{ $task->text }}"></input> -->
                    @endif
                    @endforeach
                  </div>
                    <button type="submit" class="btn-sm btn-outline-dark">Atualizar</button> 
                  </div>
                  </form>
            </div>
            @endif
            @endforeach
                
            </form>
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