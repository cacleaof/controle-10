@extends('adminlte::page')

@section('content')

    <div class="container">
        <div class="box col-md-12">
            <div class="box-header">

                <form method="get" action="{{route('admin.smart.envio')}}">

                        <input type="text" class="form-control col-md-6" name="data" placeholder="Ex: 052018" required>
                        <button type="submit">Enviar Produção</button>
                    
                </form>

            </div>

        </div>
    </div>
    <hr>
    <h3>Profissionais de Saúde</h3>
    <table id="example" class="display" style="width:100%">
        <thead>
        <tr>
            <th>NOME</th>
            <th>T.PROF</th>
            <th>CNS</th>
            <th>CNES</th>
            <th>CBO</th>
            <th>CPF</th>
            <th>DATA P/ ENVIO</th>
        </tr>
        </thead>
        <tbody>
        @foreach($profissional as $p)
            <tr>
                <td>{{ $p->nome }}</td>
                <td>{{ $p->tprof }}</td>
                <td>{{ $p->cns }}</td>
                <td>{{ $p->cnes }}</td>
                <td>{{ $p->cbo }}</td>
                <td>{{ $p->cpf }}</td>
                <td>{{ $p->data }}</td>
            </tr>
        @endforeach


        </tbody>

    </table>


@endsection