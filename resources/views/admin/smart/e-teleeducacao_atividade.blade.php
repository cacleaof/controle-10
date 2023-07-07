@extends('adminlte::page')

@section('content')

    <div class="container">
        <div class="box col-md-12">
            <div class="box-header">

                <form method="get" action="{{route('admin.smart.envio.atividade')}}">

                    <input type="text" class="form-control col-md-6" name="data" placeholder="Ex: 052018" required>
                    <button type="submit">Enviar Produção</button>

                </form>

            </div>

        </div>
    </div>
    <hr>
    <h3>Atividade de Saúde</h3>
    <table id="example" class="display" style="width:100%">
        <thead>
        <tr>
            <th>Data Participação</th>
            <th>CNES</th>
            <th>CBO</th>
            <th>CPF</th>
            <th>Id Curso</th>
            <th>Satisfação</th>
            <th>DATA P/ ENVIO</th>
        </tr>
        </thead>
        <tbody>
        @foreach($atividade as $at)
            <tr>
                <td>{{ $at->dtparti  }}</td>
                <td>{{ $at->cnes }}</td>
                <td>{{ $at->cbo }}</td>
                <td>{{ $at->cpf }}</td>
                <td>{{ $at->id_curso }}</td>
                <td>{{ $at->satisf }}</td>
                <td>{{ $at->data }}</td>

            </tr>
        @endforeach


        </tbody>

    </table>


@endsection
