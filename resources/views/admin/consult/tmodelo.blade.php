
{{-- calling layouts \ modelo.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="modal fade" id="modalshow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-red">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-footer">
        <div class="form-group">
          <br>
          <table class="table table-bordered" id="table">
        <tr>
            <hr>
            <th width="150px">Id </th>
            <th>DATA </th>
            <th>STATUS </th>
            <th>SERVIÇO </th>
            <th>DESCRIÇÃO </th>
            <th>MUNICIPIO </th>
            <th>UF</th>
            <th>NOME SOLICITANTE </th>
            <th>REGULADOR</th>
        </tr>
        <tr>
            <td>{{ $consult->id}}</a></td>
            <td>{{ $consult->created_at}}</a></td>
            <td>{{ showstat($consult->status) }} </td>
            <td>{{ $consult->servico}} </td>
            <td>{{ $consult->consulta}} </td>
            <td>{{ $consult->municipio}} </td>
            <td>{{ $consult->uf}} </td>
            <td>{{$consult->sol_name}} </td>
            <td>{{$consult->reg_name}} </td>
        </tr>
        <tr>
            <hr>
            <th>TELECONSULTOR </th>
            <th>TEMPO </th>
            <th>PACIENTE </th>
            <th>QUEIXA </th>
            <th>INSTITUIÇÃO </th>
            <th>CIDADE </th>
            <th>AREA INFORMADA </th>
            <th>devolutiva </th>
            <th>dev_reg </th>
        </tr>
        <tr>
            <td>{{$consult->cons_name}} </td>
            <td>{{ tempo($consult->created_at) }} </td>
            <td>{{$consult->paciente}} </td>
            <td>{{$consult->queixa}} </td>
            <td>{{$consult->instituiçao}} </td>
            <td>{{$consult->municipio_sol}} </td>
            <td>{{$consult->area}} </td>
            <td>{{$consult->devolutiva}} </td>
            <td>{{$consult->dev_reg}} </td>
        </tr>
            <th>resposta </th>
            <th>l_recom </th>
            <th>ciap </th>
            <th>dec1 </th>
            <th>dec2 </th>
            <th>dec3 </th>
            <th>av_duvida </th>
            <th>avaliaçao </th>
            <th>av_commen </th>
        <tr>
            <td>{{$consult->resposta}} </td>
            <td>{{$consult->l_recom}} </td>
            <td>{{$consult->ciap}} </td>
            <td>{{$consult->dec1}} </td>
            <td>{{$consult->dec2}} </td>
            <td>{{$consult->dec3}} </td>
            <td>{{$consult->av_duvida}} </td>
            <td>{{$consult->avaliaçao}} </td>
            <td>{{$consult->av_commen}} </td>
        </tr>
    </table>
                    <button type="submit" class="btn btn-block">Confirmar</button>
                </div>
          </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script type="text/javascript">
  function modalQuantidadeParticipantes($evento){
      $("#modalshow").modal();
    }
    </script>
    @endpush
