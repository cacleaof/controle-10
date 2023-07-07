@extends('adminlte::page')

@section('content')

    <div class="container">
        <div class="box col-md-6">
            <div class="box-header">

                <form method="get" action="{{route('admin.smart.implist')}}">

                        <input type="text" class="form-control" name="data" placeholder="Digite o mes e ano Ex. 102020">
                        <button type="submit">IMPORTAR</button>
                <a href="{{ route('admin.smart.nprof') }}" class="btn btn-success"><i class="fas fa-shopping-cart"></i>NOVO</a>
        	<a href="{{ route('admin.smart.implist') }}" class="btn btn-success"><i class="fas fa-shopping-cart"></i>IMPORTAR</a>    
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
            <th>Sexo</th>
            <th>INE</th>
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
                <td>{{ $p->sexo }}</td>
                <td>{{ $p->ine }}</td>
                <td>{{ $p->data }}</td>
            </tr>
        @endforeach


        </tbody>

    </table>


@endsection