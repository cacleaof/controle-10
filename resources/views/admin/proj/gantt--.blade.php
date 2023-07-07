
@extends('adminlte::page')

@section('content')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

   
<script type="text/javascript">
    google.charts.load('current', {'packages':['gantt']});
    google.charts.setOnLoadCallback(drawChart);

    function daysToMilliseconds(days) {
      return days * 24 * 60 * 60 * 1000;
    }

    function drawChart() {

      var otherData = new google.visualization.DataTable();
      otherData.addColumn('string', 'Task ID');
      otherData.addColumn('string', 'Task Name');
      otherData.addColumn('string', 'Resource');
      otherData.addColumn('date', 'Start Date');
      otherData.addColumn('date', 'End Date');
      otherData.addColumn('number', 'Duration');
      otherData.addColumn('number', 'Percent Complete');
      otherData.addColumn('string', 'Dependencies');

      otherData.addRows([

        //['Research', 'Find sources', null,
        // new Date(2015, 0, 1), new Date(2015, 0, 5), null,  100,  null],

        //['Write', 'Write paper', 'write',
        // null, new Date(2015, 0, 20), daysToMilliseconds(2), 25, 'Research'],
        
        @forelse($gantt as $ga)
          @if($ga->parent == 0)
          ['{{ $ga->id }}', '{{ $ga->text }}', null,
          new Date({{ $ga->asd }}, {{ $ga->msd }}, {{ $ga->dsd }}), new Date({{ $ga->adf }}, {{ $ga->mdf }}, {{ $ga->ddf }}), null,  100,  null],
          @else
         ['{{ $ga->id }}', '{{ $ga->text }}', '{{ $ga->text }}',
          null, new Date({{ $ga->adf }}, {{ $ga->mdf }}, {{ $ga->ddf }}), daysToMilliseconds({{ $ga->duration }}), 25, '{{ $ga->parent }}'],
          @endif
                    
        @empty
       @endforelse

      ]);

      var options = {
        height:2000,
        
      };

      var chart = new google.visualization.Gantt(document.getElementById('chart_div'));

      chart.draw(otherData, options);
    }
  </script>

    <div id="chart_div" style="width: 100%"; ></div>
@endsection
