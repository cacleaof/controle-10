@extends('adminlte::page')

@section('content_header')
@include('admin.includes.alerts')
    @if ( perfil()['solS'] )
    <div class="container">
        <div class="box">
        <div class="box-header">
            <a href="{{ route('consult.nova')}}" class="btn btn-primary"><i class="fa fa-fw fa-wechat"></i> TeleConsultoria</a>
           
        
        </div>
        </div>
        
    </div>
    @endif
@stop

@section('content')
    @if ( perfil()['solR'] )
    <table id="example" class="display responsive nowrap" width="100%">
        <thead>
        <tr>
            <th>VISUALIZAR </th>
            <th>STATUS </th>
            <th>TELECONSULTOR </th>
            <th>SERVIÇO </th>
            <th>DESCRIÇÃO </th>
            <th>TEMPO </th>
            <th>PACIENTE </th>

        </tr>
        </thead>
        <tbody>
        <tr>
            @if ($consults!=null)
                @forelse($consults as $consult)
                    <td><a href="{{ route('consult.regular', ['sid' => $consult->id] ) }}"><i class="fa fa-fw fa-search"></i></a> </td>
                    <td>{{ showstat($consult->status) }} </td>
                    <td>{{$consult->cons_name}} </td>
                    <td>{{ $consult->servico}} </td>
                    <td>{{ substr($consult->consulta, 0, 100) }} </td> 
		    <td>{{ tempo($consult->created_at) }} </td>
		    <td>{{$consult->paciente}} </td>
                           </tr>
        @empty
            <p>Você não tem consultas na sua caixa de entrada</p>
            @endforelse
            
            @endif
            </tr>
        </tbody>
    </table>
    @else
    <table id="example" class="display responsive nowrap" width="100%">
        <thead>
        <tr>
            
            <th>STATUS </th>
            <th>SERVIÇO </th>
            <th>DESCRIÇÃO </th>
            <th>TELECONSULTOR </th>
            <th>TEMPO </th>
            <th>PACIENTE </th>

        </tr>
        </thead>
        <tbody>
        <tr>
            @if ($consults!=null)
                @forelse($consults as $consult)
                    <td>{{ showstat($consult->status) }} </td>
                    <td>{{ $consult->servico}} </td>
                    <td>{{ substr($consult->consulta, 0, 100) }} </td> 
                    <td>{{$consult->cons_name}} </td>
            <td>{{ tempo($consult->created_at) }} </td>
            <td>{{$consult->paciente}} </td>
                           </tr>
        @empty
            <p>Você não tem consultas na sua caixa de entrada</p>
            @endforelse
            
            @endif
            </tr>
        </tbody>
    </table>
    @endif

@endsection