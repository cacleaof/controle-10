@extends('adminlte::page')

@section('content_header')
@include('admin.includes.alerts')
    @if ( perfil()['solS'] )
    <h5>Solicite aqui a sua:</h5>
    <div class="container col-md-6 col-xs-8">
        <div class="box">
        <div class="box-header">
            <a class="glyphicon glyphicon-arrow-right"></a>
            <a href="{{ route('consult.nova')}}" class="btn btn-primary"><i class="fa fa-fw fa-wechat"></i> TeleConsultoria</a>
           <!--<a href="{{ route('consult.novaecg')}}" class="btn btn-danger"><i class="fa fa-fw fa-heartbeat"></i> Tele-ECG</a>-->
        </div>
        </div>
    </div>
    @endif
@stop
@section('content')
    @if($consults!=null)
        <table id="example" class="display responsive nowrap" width="100%">
            <thead>
            <tr>
                <th width="8%">VISUALIZAR </th>
                <th>STATUS </th>
                <th>DESCRIÇÃO </th>
                <th>SERVIÇO </th>
                <th>TELECONSULTOR </th>
                <th>TEMPO </th>                
            </tr>
            </thead>
            <tbody>
            <tr>
                @if ($consults!=null)
                    
                    @forelse($consults as $consult)

                    @if ( perfil()['solA'] )   
                        <td><a href="{{ route('consult.showSA', ['sid' => $consult->id]) }}"><i class="fa fa-fw fa-search"></i></a></td>
                    @else
                        <td><a href="{{ route('consult.showS', ['sid' => $consult->id]) }}"><i class="fa fa-fw fa-search"></i></a></td>
                    @endif
                        <td>{{ showstat($consult->status) }} </td>
    			<td>{{ $consult->consulta}} </td>
                        <td>{{ $consult->servico}} </td>                                            
                        <td>{{$consult->cons_name}} </td>
                        <td>{{ tempo($consult->created_at) }} </td>
                        
            </tr>
            @empty
                <p>Você não tem consultas na sua caixa de entrada</p>
                @endforelse
                @endif
                </tr>
            </tbody>
        </table>
        @endif


    <!-- table regulador-->
    @if($conreg!=null)
        <table id="example" class="display responsive nowrap" width="100%">
            <thead>
            <tr>
                <th>VISUALIZAR </th>
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

                @forelse($conreg as $reg)
                    <tr>
                        <td><a href="{{ route('consult.regular', ['sid' => $reg->id] ) }}"><i class="fa fa-fw fa-search"></i></a> </td>
                        <td>{{ showstat($reg->status) }} </td>
                        <td>{{ $reg->servico}} </td>
                        <td>{{ substr($reg->consulta, 0, 200) }} </td>
                       
                        <td>{{$reg->user->name}} </td>
                        <td>{{$reg->cons_name}} </td>
                        <td>{{ tempo($reg->created_at) }} </td>
                        <td>{{$reg->nome_paciente}} </td>
                    </tr>

                @empty
                    <p>Você não tem regulações na sua caixa de entrada</p>
                @endforelse
               

            </tbody>
        </table>
        @endif

    <!---->
    @if ($conscons!=null)
        <table id="example" class="display responsive nowrap" width="100%">
            <thead>
            <tr>
                <th>VISUALIZAR </th>
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

            @forelse($conscons as $con)
                <tr>
                    <td><a href="{{ route('consult.selecresp', ['sid' => $con->id, 'cid' => $con->user_id]) }}"><i class="fa fa-fw fa-search"></i></a> </td>
                    <td>{{ showstat($con->status) }} </td>
                    <td>{{ $con->servico}} </td>
                    <td>{{ $con->consulta}} </td>
                    
                    <td>{{$con->user->name}} </td>
                    <td>{{$con->cons_name}} </td>
                    <td>{{ tempo($con->created_at) }} </td>
                    <td>{{$con->nome_paciente}} </td>
                </tr>

            @empty
                <p>Você não tem regulações na sua caixa de entrada</p>
            @endforelse

            </tbody>
        </table>
    @endif


@endsection