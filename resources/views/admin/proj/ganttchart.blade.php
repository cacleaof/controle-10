<html>
  <head>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

   
<script type="text/javascript">
    google.charts.load('current', {'packages':['gantt']});
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
          new Date({{ $ga->asd }}, {{ $ga->msd }}, {{ $ga->dsd }}), new Date({{ $ga->adf }}, {{ $ga->mdf }}, {{ $ga->ddf }}), null, {{ ($ga->prog)*100 }},  null],
          @else
         ['{{ $ga->id }}', '{{ $ga->text }}', '{{ $ga->text }}',
          null, new Date({{ $ga->adf }}, {{ $ga->mdf }}, {{ $ga->ddf }}), daysToMilliseconds({{ $ga->duration }}), {{ ($ga->prog)*100 }}, '{{ $ga->parent }}'],
          @endif 
        @empty
       @endforelse
                  ]);
      

      var options = {
        height: 800,
        gantt: {
         criticalPathEnabled: true,
         //shadowEnabled: true,
         //shadowColor: 'red',
         innerGridHorizLine: {
            stroke: '#ffe0b2',
            strokeWidth: 2
          },
          innerGridTrack: {fill: '#fff3e0'},
          innerGridDarkTrack: {fill: '#ffcc80'},
         arrow: {
              //angle: 100,
              width: 3,
              color: 'black',
              radius: 0
            },
           criticalPathStyle: {
              stroke: '#e64a19',
              strokeWidth: 5 },
          trackHeight: 30,
          defaultStartDateMillis: new Date(2021, 1, 1)
        }
      };

      var chart = new google.visualization.Gantt(document.getElementById('chart_div'));

      chart.draw(data, options);
    }
  </script>
  <body>
    <h1>Telessaude - Projetos</h1>
    <form method="get" action="{{ route('admin.proj.ganttchart') }}" enctype="multipart/form-data">
    <div class="form-group col-xs-4">
    @if($projeto == null)
	  <label  class="form-control" style="background-color:#DCDCDC;">PROJETO</label>
    @endif
	  <select name="projeto">
	  @foreach ($projects as $project)
	  <option value="{{ $project->id }}">{{ $project->projeto }}</option>
	  @endforeach
	  </select>
    <button class="btn btn-primary" onclick="Func30()">Selecionar</button> 
	  </div>
    </form>
    <div id="chart_div" style="width: 1500px; height: 800px"></div>
  </body>
</html>