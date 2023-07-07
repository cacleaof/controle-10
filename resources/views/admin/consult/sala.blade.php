@extends('adminlte::page')

@section('title', 'Regulação da Teleconsultoria')

@section('content_header')
    <h1>Regulação da Teleconsultoria ou Tele-ECG</h1>
    <!--<ol class='breadcrumb'>
    	<li><a ref="">Dashboard</a></li>
    	<li><a ref="">Consult</a></li>
    	<li><a ref="">Entrada</a></li>
    </ol>-->
@stop
@section('content')
<div class="container">
        <div class="box">
        <div class="box-header">

            <a href="{{ route('consult.sala') }}" class="btn btn-success"><i class="fa fa-fw fa-paper-plane-o"></i> Criar Sala</a>
        </div>
        @include('admin.includes.alerts')
        </div>
</div>
<div class="container">
    <div class="box">
        <div class="box-header">
		 @if(!empty($url))
                 <a href="{{ $url }}" target="_balnk">Link da sala clique aqui para entrar na sala</a> 
                <br>
                <h5>Ou copie o link</h5>
               <a href="{{ $url }}">{{ $url }}</a>
		@endif
        </div>
    </div>
</div>

    
        
@endsection

