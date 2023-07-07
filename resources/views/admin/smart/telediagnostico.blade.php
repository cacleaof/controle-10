@extends('adminlte::page')

@section('content')

    <div class="container">
        <div class="box col-md-12">
            <div class="box-header">

                <form method="get" action="{{route('admin.smart.envio.telediagnostico')}}">

                    <input type="text" class="form-control col-md-6" name="data" placeholder="Ex: 052018" required>
                    <button type="submit">Enviar Produção</button>

                </form>

            </div>

        </div>
    </div>
    <hr>
    <h3>Telediagnostico</h3>
    <table id="example" class="display" style="width:100%">
        <thead>
        <tr>
            <th>Data Solic.</th>
            <th>tipo</th>
            <th>Solic CPF</th>
            <th>Solic Tipo</th>
            <th>Data Resp</th>
            <th>Evitou Encaminhamento</th>
            <th>DATA P/ ENVIO</th>
        </tr>
        </thead>
        <tbody>
        @foreach($telediagnostico as $tele)
            <tr>
                <td>{{ $tele->dh_realizado_exame }}</td>
                <td>{{ $tele->codigo_tipo_exame }}</td>
                <td>{{ $tele->cpf_solicitante }}</td>
                <td>{{ $tele->especialidade_solicitante }}</td>
                <td>{{ $tele->dh_laudo }}</td>
                <td>{{ $tele->cpf_laudista }}</td>
                <td>{{ $tele->data }}</td>            
            </tr>
        @endforeach


        </tbody>

    </table>


@endsection

