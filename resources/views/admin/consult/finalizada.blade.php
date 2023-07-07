@extends('adminlte::page')

@section('content_header')
@include('admin.includes.alerts')
    @if ( perfil()['solS'] )
    <div class="container">
        <div class="box">
        <div class="box-header">
            <a href="{{ route('consult.nova')}}" class="btn btn-primary"><i class="fa fa-fw fa-wechat"></i> TeleConsultoria</a>
           <!--<a href="{{ route('consult.novaecg')}}" class="btn btn-danger"><i class="fa fa-fw fa-heartbeat"></i> Tele-ECG</a>-->
        
        </div>
        </div>
    </div>
    @endif
@stop

@section('content')
    <table id="example" class="display responsive nowrap" width="100%">
        <thead>
        <tr>
            <th>ID </th>
            <th>STATUS </th>
            <th>SERVIÇO </th>
            <th>DESCRIÇÃO </th>
            <th>NOME SOLICITANTE </th>
            <th>TELECONSULTOR </th>
            <th>TEMPO </th>
            <th>PACIENTE </th>
        </tr>
        </thead>
        <tbody>
        <tr>
            @forelse($consults as $consult)
            @if ( $consult->status=='F')
                <td>{{ $consult->id }}</td>
                <td>{{ showstat($consult->status) }} </td>
                <td>{{ $consult->servico}} </td>
                <td>{{ substr($consult->consulta, 0, 100) }} </td>
                <td>{{$consult->user->name}} </td>
                <td>{{$consult->cons_name}} </td>
                <td>{{ tempo($consult->created_at) }} </td>
                <td>{{$consult->nome_paciente}} </td>
            @endif
        </tr>
        @empty
            <p>Nenhum solicitação realizada</p>
        @endforelse

        </tbody>

    </table>


@endsection