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
    //width:1600px;
    margin:0 auto;
    border:2px solid #ccc;}
    .form-control{
    color:black;}
    /* margin:0 auto;
    border:2px solid #ccc;} */
    /* .proj {
        margin:0 auto;
        font-family: arial;
        border:2px solid #ccc;
        max-width:200px;} */
    .h5 {
        color:blue;
        font-family: arial;}
  </style>
   
 </head>
 <body>
    </br>
    <div class="form-row col-md-3">
    </div>
    <div class="box col-md-6" align="center">
        <h3 align="center"><strong>MATRIZ DE EISENHOWER - TAREFAS</strong></h3>
            <a href="{{ route('admin.proj.n_proj') }}" class="btn btn-primary"><i class="fas fa-shopping-cart"></i>Novo Projeto</a>
            <a href="{{ route('admin.proj.n_task')}}" class="btn btn-primary"><i class="fas fa-shopping-cart"></i>Nova Tarefa</a>
            <a href="{{ route('admin.proj.diario')}}" class="btn btn-primary"><i class="fas fa-shopping-cart"></i>Diário</a>
            <button onclick="window.location='{{ route("admin.proj.index") }}'" id="myButton" class="btn btn-success"> Sair</button>
                <form action="" method="GET" class="form form-inline" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="form-row col-md-4">
                    <select name="projeto" class="form-control">
                    <option value="">--Selecione o Projeto--  OU</option>
                    @foreach ($projects as $project)
                    <option value="{{ $project->id }}">{{ $project->projeto }}</option>
                    @endforeach
                    </select>
                    </div>
                    <div class="form-row col-md-3">
                    <select name="usuario" class="form-control">
                    <option value="">--Selecione o Usuario--</option>
                    @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                    </select>
                    </div>
                    <div class="form-row col-md-2">
                        <select name="status" class="form-control">
                        <option value="">Status</option>
                        <option value="Planejando">Planejando</option>
                        <option value="Executando">Executando</option>
                        <option value="Pendente">Pendente</option>
                        <option value="Terminado">Terminado</option>
                        <option value="Cancelado">Cancelado</option>
                        </select>
                    </div>
                    <div class="form-row col-md-1">
                    <button type="submit" class="btn btn-primary">Enviar</button> 
                    </div>
                </form>
    </div> 
    <div class="form-row col-md-12"> 
    </br>
    <!-- <h5>Projeto{{ $pj }} Usuario {{ $usu }}</h5> -->
    </div>
<!-- @if($projeto =! null)
<div class="form-row col-md-12">
<h1>{{$projeto}}</h1>
</div>
@endif -->
    <div class="form-row col-md-6">
    <label  class="form-control col-md-6" style="background-color:#DCDCDC;">Importante mas não Urgente</label>
    </div>
    <div class="form-row col-md-6">
    <label  class="form-control" style="background-color:#DCDCDC;">Urgente e Importante</label>
    </div>
    <div class="form-row col-md-12">
    
    </div>
    <div class="container col-md-6 " style="background-color:#7dc283; right:5px;">
       @for($i = 5; $i != 2; $i--)
       @for($u = 0; $u != 3; $u++)
       <?php $contar = 0;?>
           <div class="container form-row col-md-4" style="background-color:#7dc283;" >
           
           <hr></hr>
           
           <!-- <div class="form-row col-md-4">
           <hr></hr>
           </div>
           <div class="form-row col-md-4">
           <hr></hr>
           </div> -->
           @forelse($tasks as $task)
           @if($task->urg == $u   & $task->imp == $i)
            <div class="proj" style="background-color:#7dc283;">
            @switch($task->status)
                @case('Executando')
                <h5><a href="{{ route('proj.showtk', ['trf' => $task->id]) }}" style="color:black ;font-weight: bold;"> {{ $task->text }} <i class="fa fa-circle" style="color:green" aria-hidden="true"></i> </a></h5>
                @break
                @case('Pendente')
                <h5><a href="{{ route('proj.showtk', ['trf' => $task->id]) }}" style="color:black ;font-weight: bold;"> {{ $task->text }} <i class="fa fa-circle" style="color:purple" aria-hidden="true"></i> </a></h5>
                @break
                @case('Terminado')
                <h5><a href="{{ route('proj.showtk', ['trf' => $task->id]) }}" style="color:black ;font-weight: bold;"> {{ $task->text }} <i class="fa fa-circle" style="color:black" aria-hidden="true"></i> </a></h5>
                @break
                @case('Cancelado')
                <h5><a href="{{ route('proj.showtk', ['trf' => $task->id]) }}" style="color:black ;font-weight: bold;"> {{ $task->text }} <i class="fa fa-circle" style="color:red" aria-hidden="true"></i> </a></h5>
                @break
                @default            
                <h5><a href="{{ route('proj.showtk', ['trf' => $task->id]) }}" style="color:black ;font-weight: bold;"> {{ $task->text }} <i class="fa fa-circle" style="color:white" aria-hidden="true"></i> </a></h5>
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
           @forelse($tasks as $task)
           @if($task->urg == $u   & $task->imp == $i)
           <div class="proj" style="background-color:#e5ae6b;">
           @switch($task->status)
                @case('Executando')
                <h5><a href="{{ route('proj.showtk', ['trf' => $task->id]) }}" style="color:black ;font-weight: bold;"> {{ $task->text }} <i class="fa fa-circle" style="color:green" aria-hidden="true"></i> </a></h5>
                @break
                @case('Pendente')
                <h5><a href="{{ route('proj.showtk', ['trf' => $task->id]) }}" style="color:black ;font-weight: bold;"> {{ $task->text }} <i class="fa fa-circle" style="color:purple" aria-hidden="true"></i> </a></h5>
                @break
                @case('Terminado')
                <h5><a href="{{ route('proj.showtk', ['trf' => $task->id]) }}" style="color:black ;font-weight: bold;"> {{ $task->text }} <i class="fa fa-circle" style="color:black" aria-hidden="true"></i> </a></h5>
                @break
                @case('Cancelado')
                <h5><a href="{{ route('proj.showtk', ['trf' => $task->id]) }}" style="color:black ;font-weight: bold;"> {{ $task->text }} <i class="fa fa-circle" style="color:red" aria-hidden="true"></i> </a></h5>
                @break
                @default            
                <h5><a href="{{ route('proj.showtk', ['trf' => $task->id]) }}" style="color:black ;font-weight: bold;"> {{ $task->text }} <i class="fa fa-circle" style="color:white" aria-hidden="true"></i> </a></h5>
            @endswitch
           </div>
           <?php  $contar = 1; ?>
           @endif
           @empty
           @endforelse      
           @if($contar != 1)
            <div class="proj" style="background-color:#e5ae6b;">
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
            @forelse($tasks as $task)
            @if($task->urg == $u   & $task->imp == $i)
            <div class="proj" style="background-color:#90599d;">
            @switch($task->status)
                @case('Executando')
                <h5><a href="{{ route('proj.showtk', ['trf' => $task->id]) }}" style="color:black ;font-weight: bold;"> {{ $task->text }} <i class="fa fa-circle" style="color:green" aria-hidden="true"></i> </a></h5>
                @break
                @case('Pendente')
                <h5><a href="{{ route('proj.showtk', ['trf' => $task->id]) }}" style="color:black ;font-weight: bold;"> {{ $task->text }} <i class="fa fa-circle" style="color:purple" aria-hidden="true"></i> </a></h5>
                @break
                @case('Terminado')
                <h5><a href="{{ route('proj.showtk', ['trf' => $task->id]) }}" style="color:black ;font-weight: bold;"> {{ $task->text }} <i class="fa fa-circle" style="color:black" aria-hidden="true"></i> </a></h5>
                @break
                @case('Cancelado')
                <h5><a href="{{ route('proj.showtk', ['trf' => $task->id]) }}" style="color:black ;font-weight: bold;"> {{ $task->text }} <i class="fa fa-circle" style="color:red" aria-hidden="true"></i> </a></h5>
                @break
                @default            
                <h5><a href="{{ route('proj.showtk', ['trf' => $task->id]) }}" style="color:black ;font-weight: bold;"> {{ $task->text }} <i class="fa fa-circle" style="color:white" aria-hidden="true"></i> </a></h5>
            @endswitch
            </div>
            <?php  $contar = 1; ?>
            @endif
            @empty
            @endforelse      
            @if($contar != 1)
            <div class="proj" style="background-color:#90599d;">
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
            <div class="container form-row col-md-4" style="background-color:#75a2c9;" >
            <hr></hr>
            @forelse($tasks as $task)
            @if($task->urg == $u   & $task->imp == $i)
            <div class="proj" style="background-color:#75a2c9;">
            @switch($task->status)
                @case('Executando')
                <h5><a href="{{ route('proj.showtk', ['trf' => $task->id]) }}" style="color:black ;font-weight: bold;"> {{ $task->text }} <i class="fa fa-circle" style="color:green" aria-hidden="true"></i> </a></h5>
                @break
                @case('Pendente')
                <h5><a href="{{ route('proj.showtk', ['trf' => $task->id]) }}" style="color:black ;font-weight: bold;"> {{ $task->text }} <i class="fa fa-circle" style="color:purple" aria-hidden="true"></i> </a></h5>
                @break
                @case('Terminado')
                <h5><a href="{{ route('proj.showtk', ['trf' => $task->id]) }}" style="color:black ;font-weight: bold;"> {{ $task->text }} <i class="fa fa-circle" style="color:black" aria-hidden="true"></i> </a></h5>
                @break
                @case('Cancelado')
                <h5><a href="{{ route('proj.showtk', ['trf' => $task->id]) }}" style="color:black ;font-weight: bold;"> {{ $task->text }} <i class="fa fa-circle" style="color:red" aria-hidden="true"></i> </a></h5>
                @break
                @default            
                <h5><a href="{{ route('proj.showtk', ['trf' => $task->id]) }}" style="color:black ;font-weight: bold;"> {{ $task->text }} <i class="fa fa-circle" style="color:white" aria-hidden="true"></i> </a></h5>
            @endswitch
            </div>
            <?php  $contar = 32; ?>
            @endif
            @empty
            @endforelse 
            @if($contar != 32)
            <div class="proj" style="background-color:#75a2c9;">
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
</div>

</body>

