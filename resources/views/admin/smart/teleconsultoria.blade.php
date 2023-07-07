@extends('adminlte::page')

@section('content')

    <div class="container">
        <div class="box col-md-12">
            <div class="box-header">

                <form method="get" action="{{route('admin.smart.envio.teleconsultoria')}}">

                    <input type="text" class="form-control col-md-6" name="data" placeholder="Ex: 052018" required>
                    <button type="submit">Enviar Produção</button>

                </form>

            </div>

        </div>
    </div>
    <hr>
    <h3>Teleconsultorias</h3>
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
        @foreach($teleconsultoria as $tele)
            <tr>
                <td>{{ $tele->dtsol }}</td>
                <td>{{ $tele->tipo }}</td>
                <td>{{ $tele->solicitante_cpf }}</td>
                <td>{{ $tele->solicitante_tipo }}</td>
                <td>{{ $tele->dtresposta }}</td>
                <td>{{ $tele->evitou_encaminha }}</td>
                <td>{{ $tele->data }}</td>
            </tr>
        @endforeach


        </tbody>

    </table>


@endsection
