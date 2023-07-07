@extends('adminlte::page')

@section('content')

    <div class="container">
        <div class="box col-md-12">
            <div class="box-header">

                <form method="get" action="{{route('admin.smart.envio.cursos')}}">

                    <input type="text" class="form-control col-md-6" name="data" placeholder="Ex: 052018" required>
                    <button type="submit">Novo</button>

                </form>

            </div>

        </div>
    </div>
    <hr>
    <h3>Cursos</h3>

    <table id="example" class="display" style="width:100%">
        <thead>
        <tr>
            <th>Data Inicio</th>
            <th>Data Fim</th>
            <th>Carga Horaria</th>
            <th>Vagas</th>
            <th>Id Curso</th>
            <th>Data p/ Envio</th>
        </tr>
        </thead>
        <tbody>
        @foreach($curso as $c)
            <tr>
                <td>{{ $c->dtini }}</td>
                <td>{{ $c->dtfim }}</td>
                <td>{{ $c->cargah }}</td>
                <td>{{ $c->vagas }}</td>
                <td>{{ $c->id_curso }}</td>
                <td>{{ $c->data }}</td>

            </tr>
        @endforeach


        </tbody>

    </table>

@endsection