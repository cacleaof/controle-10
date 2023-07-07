<html>
  <head>
<script type="text/javascript">
  var x = 10;
    
    draw = function() {
        
        // all lines of code inside here will be run repeatedly
        background(151, 244, 247);
        
        // draw the car body
        fill(255, 0, 115);
        rect(x, 200, 100, 20);
        rect(x + 15, 178, 70, 40);
        
        // draw the wheels
        fill(77, 66, 66);
        ellipse(x + 25, 221, 24, 24);
        ellipse(x + 75, 221, 24, 24);
        
        x = x + 1;
    };
  </script>
  <body style="background-color:blue; border:5px solid #0000000;">
    <h1>Telessaude - Projetos do Núcleo CRUD JS</h1>
    
      <!-- <canvas id="mycanvas" width="400" height="20" style="background-color:blue;  border:1px solid #000000;"></canvas>  -->
    <table id="example1" class="display" style="background-color:red; border:5px solid #0000000; width:100%;">
    <div id="message"></div>
    <thead>
            <tr>
            <th style="background-color:purple; border:5px solid #0000000; width:10px;">ID </th>
            <th style="background-color:green; border:5px solid #0000000; width:10px;">TAREFA</th>
            <th>INICIO</th>
            <!-- <th>STATUS</th>
            <th>IMP + URG</th> -->
            </tr>
        </thead>
        <tbody>
            <tr>
            @forelse($gantt as $ga)
                <td><button id="{{ $ga->id }}">{{ $ga->id}}</button></td>
                <td><input type="move" maxlength="20" readonly value="{{ $ga->text}}"></td>
                <td style="cursor: col-resize;">
                <canvas width="20" height="20" style="background-color:yellow;  border:1px solid #000000;"></canvas>
                <canvas width="20" height="20" style="background-color:yellow;  border:1px solid #000000;"></canvas>
                <canvas id="m{{ $ga->id }}" width="{{ $ga->duration }}" height="20" style="background-color:blue;  border:1px solid #000000;"></canvas> 
              </td>
                <!-- <td>{{ $ga->duration }}</td>
                <td>{{ $ga->parent }}</td> -->
                </tr> 
                @empty
            <p>Você não tem projetos na sua caixa de entrada</p>  
                @endforelse
        </tbody>        
  </table>
  <script> 
    var clickerButton = document.getElementById("15");
    var move = document.getElementById("m16");
    var onButtonClick = function() {
        clickerButton.textContent = "Oh wow, you clicked me!";
    };
    var onMouseMove = function() {
      document.getElementById("message").textContent+= "moove";
    };
    move.addEventListener("mousemove", onMouseMove);
    clickerButton.addEventListener("click", onButtonClick);
  </script>
  </body>
</html>