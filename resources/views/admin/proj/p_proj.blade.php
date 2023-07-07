<!DOCTYPE html>
<html>
 <head>
  <title>Tarefas</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
  <style type="text/css">
   .box{
    width:600px;
    margin:0 auto;
    border:2px solid #ccc;}
    .form-control{
    color:black;}
    .seta-direita:before {
  content: "";
  display: inline-block;
  vertical-align: middle;
  margin-right: 10px;
  width: 0; 
  height: 0; 

  border-top: 5px solid transparent;
  border-bottom: 5px solid transparent;
  border-left: 5px solid black;
}
    /* margin:0 auto;
    border:2px solid #ccc;} */
    /* .proj {
        margin:0 auto;
        font-family: arial;
        border:2px solid #ccc;
        max-width:200px;} */
    #linha-vertical {
    height: 600px;
    border-right: 2px solid red;
    }
    #linha-horizontal {
    width: 1600px;
    border: 2px solid #000;
    }
    .h5 {
        color:blue;
        font-family: arial;}
  </style>
   
 </head>
 <body>
    </br>
    <div class="form-row col-md-4">
    </div>
    <div class="box col-md-6" align="center">
    <h3 align="center"><strong>MATRIZ DE EISENHOWER</strong><i class="fa fa-lightbulb-o fa-3x" style="color:red" aria-hidden="true"></i></h3> 
    <h3 align="center"><strong>PROJETOS</strong></h3> 
            <a href="{{ route('admin.proj.n_proj') }}" class="btn btn-primary"><i class="fas fa-shopping-cart"></i>Novo Projeto</a>
            <a href="{{ route('admin.proj.n_task')}}" class="btn btn-primary"><i class="fas fa-shopping-cart"></i>Nova Tarefa</a>
            <a href="{{ route('admin.proj.diario')}}" class="btn btn-primary"><i class="fas fa-shopping-cart"></i>Diário</a>
            <button onclick="window.location='{{ route("admin.proj.index") }}'" id="myButton" class="btn btn-success"> Sair</button>
            <!-- <button onclick="location.href = '/admin';" id="myButton" class="float-left submit-button" >Voltar</button> -->
            
        <div class='form-row'>
            </br>
        </div>
    </div>  
    </br>
<div class="form-row col-md-12">
    </br>
    <!-- <h3>&#8594;&#10132;</h3>
    <div id="linha-horizontal"></div>
    <div class="seta-direita">Seta para direita</div>
    <div id="linha-vertical"></div> -->
    
    <div class="form-row col-md-6">
    <label align="center" class="form-control" style="background-color:#DCDCDC;">IMPORTANTE MAS NÃO URGENTE</label>
    <label align="center" class="form-row col-md-1">Urgência</label>
    <label align="center" class="form-row col-md-1"><i class="fa fa-arrow-right" aria-hidden="true"></i></label>
    <label align="left" class="form-row col-md-1">0 </label>
    <label align="center" class="form-row col-md-1"><i class="fa fa-arrow-right" aria-hidden="true"></i></label>
    <label align="center" class="form-row col-md-1"><i class="fa fa-arrow-right" aria-hidden="true"></i></label>
    <label align="center" class="form-row col-md-2">1</label>
    <label align="center" class="form-row col-md-1"><i class="fa fa-arrow-right" aria-hidden="true"></i></label>
    <label align="center" class="form-row col-md-1"><i class="fa fa-arrow-right" aria-hidden="true"></i></label>
    <label align="center" class="form-row col-md-2">2</label>
    <label align="center" class="form-row col-md-1"><i class="fa fa-arrow-right" aria-hidden="true"></i></label>
    </div>
    <div class="form-row col-md-6">
    <label align="center" class="form-control" style="background-color:#DCDCDC;">URGENTE E IMPORTANTE</label>
    <label align="center" class="form-row col-md-1">Urgência</label>
    <label align="center" class="form-row col-md-1"><i class="fa fa-arrow-right" aria-hidden="true"></i></label>
    <label align="left" class="form-row col-md-1">3</label>
    <label align="center" class="form-row col-md-1"><i class="fa fa-arrow-right" aria-hidden="true"></i></label>
    <label align="center" class="form-row col-md-1"><i class="fa fa-arrow-right" aria-hidden="true"></i></label>
    <label align="center" class="form-row col-md-2">4</label>
    <label align="center" class="form-row col-md-1"><i class="fa fa-arrow-right" aria-hidden="true"></i></label>
    <label align="center" class="form-row col-md-1"><i class="fa fa-arrow-right" aria-hidden="true"></i></label>
    <label align="center" class="form-row col-md-2">5</label>
    <label align="center" class="form-row col-md-1"><i class="fa fa-arrow-right" aria-hidden="true"></i></label>
    </div>
    


    <div class="form-row col-md-12">
    </div>
    <div class="container col-md-6 " style="background-color:#7dc283; right:5px;">
       @for($i = 5; $i != 2; $i--)
       @for($u = 0; $u != 3; $u++)
       <?php $contar = 0;?>
           <div class="container form-row col-md-4" style="background-color:#7dc283;" >
           <hr></hr>
           @forelse($projects as $project)
           @if($project->urg == $u   & $project->imp == $i)
            <div class="proj" style="background-color:#7dc283;">
            @switch($project->status)
                @case('Executando')
                <h5><a href="{{ route('proj.showpj', ['prj' => $project->id]) }}" style="color:black ;font-weight: bold;"> {{ $project->projeto }} <i class="fa fa-circle" style="color:green" aria-hidden="true"></i></a></h5>
                @break
                @case('Pendente')
                <h5><a href="{{ route('proj.showpj', ['prj' => $project->id]) }}" style="color:black ;font-weight: bold;"> {{ $project->projeto }} <i class="fa fa-circle" style="color:purple" aria-hidden="true"></i></a></h5>
                @break
                @case('Terminado')
                <h5><a href="{{ route('proj.showpj', ['prj' => $project->id]) }}" style="color:black ;font-weight: bold;"> {{ $project->projeto }} <i class="fa fa-circle" style="color:black" aria-hidden="true"></i></a></h5>
                @break
                @case('Cancelado')
                <h5><a href="{{ route('proj.showpj', ['prj' => $project->id]) }}" style="color:black ;font-weight: bold;"> {{ $project->projeto }} <i class="fa fa-circle" style="color:red" aria-hidden="true"></i></a></h5>
                @break
                @default            
                <h5><a href="{{ route('proj.showpj', ['prj' => $project->id]) }}" style="color:black ;font-weight: bold;"> {{ $project->projeto }} <i class="fa fa-circle " style="color:white" aria-hidden="true"></i></a></h5>
            @endswitch
            </div>
           <?php  $contar = 1; ?>
           @endif
           @empty
           @endforelse      
           @if($contar != 1)
            <div class="proj" style="background-color:#7dc283;">
            <h5>&nbsp;</h5>
            </div>
           @endif
           </div> 
       @endfor
            <div class="row">
            <h5>&nbsp;</h5>
            </div>    
       @endfor   
       
    </div>   

    <div class="container col-md-6" style="background-color:#e5ae6b; left:5px;">
       @for($i = 5; $i != 2; $i--)
       @for($u = 3; $u != 6; $u++)
       <?php $contar = 0;?>
           <div class="container form-row col-md-4" style="background-color:#e5ae6b;"  >
           <hr></hr>
           @forelse($projects as $project)
           @if($project->urg == $u   & $project->imp == $i)
           <div class="proj" style="background-color:#e5ae6b;">
           @switch($project->status)
                @case('Executando')
                <h5><a href="{{ route('proj.showpj', ['prj' => $project->id]) }}" style="color:black ;font-weight: bold;"> {{ $project->projeto }} <i class="fa fa-circle" style="color:green" aria-hidden="true"></i></a></h5>
                @break
                @case('Pendente')
                <h5><a href="{{ route('proj.showpj', ['prj' => $project->id]) }}" style="color:black ;font-weight: bold;"> {{ $project->projeto }} <i class="fa fa-circle" style="color:purple" aria-hidden="true"></i></a></h5>
                @break
                @case('Terminado')
                <h5><a href="{{ route('proj.showpj', ['prj' => $project->id]) }}" style="color:black ;font-weight: bold;"> {{ $project->projeto }} <i class="fa fa-circle" style="color:black" aria-hidden="true"></i></a></h5>
                @break
                @case('Cancelado')
                <h5><a href="{{ route('proj.showpj', ['prj' => $project->id]) }}" style="color:black ;font-weight: bold;"> {{ $project->projeto }} <i class="fa fa-circle" style="color:red" aria-hidden="true"></i></a></h5>
                @break
                @default            
                <h5><a href="{{ route('proj.showpj', ['prj' => $project->id]) }}" style="color:black ;font-weight: bold;"> {{ $project->projeto }} <i class="fa fa-circle " style="color:white" aria-hidden="true"></i></a></h5>
            @endswitch
           </div>
           <?php  $contar = 1; ?>
           @endif
           @empty
           @endforelse      
           @if($contar != 1)
            <div class="proj" style="background-color:#e5ae6b;">
            <h5>&nbsp;</h5>
            </div>
           @endif
           </div> 
       @endfor
            <div class="row">
            <h5>&nbsp;</h5>
            </div>    
       @endfor    
          
    </div>   

    <div class="form-row col-md-12">
    </br>
    </div>
        
        <div class="form-row col-md-6"> 
        <label  class="form-control" style="background-color:#DCDCDC;">Nem Urgente e Nem Importante</label>
        </div>
        <div class="form-row col-md-6"> 
	    <label  class="form-control" style="background-color:#DCDCDC;">Urgente mas Não Importante</label>
        </div>    


    <div class="container col-md-6" style="background-color:#90599d; right:5px;">   
        @for($i = 2; $i != -1; $i--)
        @for($u = 0; $u != 3; $u++)
        <?php $contar = 0;?>
            <div class="container form-row col-md-4" style="background-color:#90599d;" >
            <hr></hr>
            @forelse($projects as $project)
            @if($project->urg == $u   & $project->imp == $i)
            <div class="proj" style="background-color:#90599d;">
            @switch($project->status)
                @case('Executando')
                <h5><a href="{{ route('proj.showpj', ['prj' => $project->id]) }}" style="color:black ;font-weight: bold;"> {{ $project->projeto }} <i class="fa fa-circle" style="color:green" aria-hidden="true"></i></a></h5>
                @break
                @case('Pendente')
                <h5><a href="{{ route('proj.showpj', ['prj' => $project->id]) }}" style="color:black ;font-weight: bold;"> {{ $project->projeto }} <i class="fa fa-circle" style="color:purple" aria-hidden="true"></i></a></h5>
                @break
                @case('Terminado')
                <h5><a href="{{ route('proj.showpj', ['prj' => $project->id]) }}" style="color:black ;font-weight: bold;"> {{ $project->projeto }} <i class="fa fa-circle" style="color:black" aria-hidden="true"></i></a></h5>
                @break
                @case('Cancelado')
                <h5><a href="{{ route('proj.showpj', ['prj' => $project->id]) }}" style="color:black ;font-weight: bold;"> {{ $project->projeto }} <i class="fa fa-circle" style="color:red" aria-hidden="true"></i></a></h5>
                @break
                @default            
                <h5><a href="{{ route('proj.showpj', ['prj' => $project->id]) }}" style="color:black ;font-weight: bold;"> {{ $project->projeto }} <i class="fa fa-circle " style="color:white" aria-hidden="true"></i></a></h5>
            @endswitch
            </div>
            <?php  $contar = 1; ?>
            @endif
            @empty
            @endforelse      
            @if($contar != 1)
            <div class="proj form-row" style="background-color:#90599d;">
            <h5>&nbsp; </h5>
            </div>
            @endif
            </div> 
        @endfor  
        <div class="row">
        <h5>&nbsp;</h5>
        </div>    
        @endfor

    </div>

    <div class="container col-md-6" style="background-color:#75a2c9; left:5px;">   
    
        @for($i = 2; $i != -1; $i--)
        @for($u = 3; $u != 6; $u++)
        <?php $contar = 0;?>
            <div class="container col-md-4" style="background-color:#75a2c9;" >
            <hr></hr>
            @forelse($projects as $project)
            @if($project->urg == $u   & $project->imp == $i)
            <div class="proj" style="background-color:#75a2c9;">
            @switch($project->status)
                @case('Executando')
                <h5><a href="{{ route('proj.showpj', ['prj' => $project->id]) }}" style="color:black ;font-weight: bold;"> {{ $project->projeto }} <i class="fa fa-circle" style="color:green" aria-hidden="true"></i></a></h5>
                @break
                @case('Pendente')
                <h5><a href="{{ route('proj.showpj', ['prj' => $project->id]) }}" style="color:black ;font-weight: bold;"> {{ $project->projeto }} <i class="fa fa-circle" style="color:purple" aria-hidden="true"></i></a></h5>
                @break
                @case('Terminado')
                <h5><a href="{{ route('proj.showpj', ['prj' => $project->id]) }}" style="color:black ;font-weight: bold;"> {{ $project->projeto }} <i class="fa fa-circle" style="color:black" aria-hidden="true"></i></a></h5>
                @break
                @case('Cancelado')
                <h5><a href="{{ route('proj.showpj', ['prj' => $project->id]) }}" style="color:black ;font-weight: bold;"> {{ $project->projeto }} <i class="fa fa-circle" style="color:red" aria-hidden="true"></i></a></h5>
                @break
                @default            
                <h5><a href="{{ route('proj.showpj', ['prj' => $project->id]) }}" style="color:black ;font-weight: bold;"> {{ $project->projeto }} <i class="fa fa-circle " style="color:white" aria-hidden="true"></i></a></h5>
            @endswitch
            </div>
            <?php  $contar = 32; ?>
            @endif
            @empty
            @endforelse 
            @if($contar != 32)
            <div class="proj" style="background-color:#75a2c9;">
            <h5>&nbsp; </h5>
            </div>
            @endif
            </div> 
        @endfor
        <div class="row">
        <h5>&nbsp;</h5>
        </div>
        @endfor
    </div>
</div>

</body>

