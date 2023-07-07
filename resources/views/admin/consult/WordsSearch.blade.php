@extends('adminlte::page')

@section('content_header')
<div class="box">
    <p><strong>Usuário Logado: </strong>{{auth()->user()->name }}</p>
</div>
@stop

@section('content')

<p> Saida: {{$data->query}} </p>   
 <form method="POST" action="{{ route('consult.store')}}" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                <div class="form-row">
                    @include('admin.includes.alerts')
                        <div class="form-group">
                        <textarea type="text" name="consulta" rows="5" cols="80" placeholder="Descreva sua dúvida ou questionamento" class="form-control"></textarea>
                        <div class="form-row">
                            <label for="file">Arquivos Anexos:</label>
                            <input type="file" name="arquivo[]" id="file" multiple>
                            <input type="hidden" value="{{ csrf_token() }}" name="_token">
                        </div>
                        <div class="form-row" >
                            <label>Caso seja relavante informe dados do paciente como nome, idade indicando unidade(Anos, Meses, dias), Queixa, Instituiçao e Município</label>
                        </div>
                        <div class="form-group col-xs-9" >
                            <input type="text" class="form-control" name="paciente" placeholder="Nome do Paciente">
                        </div>           
@endsection