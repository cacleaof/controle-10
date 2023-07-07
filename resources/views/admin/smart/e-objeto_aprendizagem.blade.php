@extends('adminlte::page')

@section('content')

    <div class="container">
        <div class="box col-md-12">
            <div class="box-header">

                <form method="get" action="{{route('admin.smart.envio.objeto')}}">

                    <input type="text" class="form-control col-md-6" name="data" placeholder="Ex: 052018" required>
                    <button type="submit">Enviar Produção</button>

                </form>

            </div>

        </div>
    </div>
    <hr>
    <h3>Objeto Aprendizagem</h3>
    <table id="example" class="display" style="width:100%">
        <thead>
        <tr>
            <th>Id Curso</th>
            <th>Data Disp</th>
            <th>Disp... Plataforma</th>
            <th>Disp... ARES</th>
            <th>Disp... AVASUS</th>
            <th>Disp... Rede Soci</th>
            <th>DATA P/ ENVIO</th>
        </tr>
        </thead>
        <tbody>
        @foreach($objeto as $obj)
            <tr>
                <td>{{ $obj->id_curso  }}</td>
                <td>{{ $obj->dtdispo }}</td>
                <td>{{ $obj->dpltaf }}</td>
                <td>{{ $obj->dares }}</td>
                <td>{{ $obj->davasus }}</td>
                <td>{{ $obj->drsociais }}</td>
                <td>{{ $obj->data }}</td>
            </tr>
        @endforeach


        </tbody>

    </table>

@endsection
