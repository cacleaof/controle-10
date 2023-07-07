
@extends('adminlte::page')

@section('content')

    
    <style type="text/css">
        html, body{
            height:100%;
            padding:0px;
            margin:0px;
            overflow: hidden;
        }
    </style>
    
    

    <h4></h4>

    <div id="gantt_here" style='width:100%; height:700px;'></div>
    <script type="text/javascript">
    gantt.config.xml_date = "%Y-%m-%d %H:%i:%s";
        gantt.config.order_branch = true;/*!*/
        gantt.config.order_branch_free = true;/*!*/
    
        //gantt.config.columns =  [
        //{name:"task",       label:"Nome da Tarefa",  tree:true, width:"*" },
        //{name:"start_date", label:"Start time", align:"center" },
        //{name:"end_date",   label:"End date",   align:"center" },
       // {name:"progress",   label:"Progress",   align:"center" },
    //];
        gantt.init("gantt_here");
    
        gantt.load("/data");
    
        var dp = new gantt.dataProcessor("/api");
        dp.init(gantt);/*!*/
        dp.setTransactionMode("REST");/*!*/  
    </script>
@endsection
