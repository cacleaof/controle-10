<div class="modal fade" id="modalshow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header bg-blue">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Detalhamento da Teleconsultoria</h4>
        </div>
            <div class="table-responsive">
            <table class="table table-condensed table table-striped">
            <tr>
            <th>ID </th>
            <th>DATA </th>
            <th>STATUS </th>
            <th>SERVIÇO </th>
            <th>DESCRIÇÃO </th>
            </tr> 
            <tr> 
            <td>{{ $consult->id}}</a></td>
            <td>{{ $consult->created_at}}</a></td>
            <td>{{ showstat($consult->status) }} </td>
            <td>{{ $consult->serviço}} </td>
            <td>{{ $consult->consulta}} </td>
            </tr> 
            </table>
            </div>
            <div class="table-responsive">
            <table class="table table-condensed table table-striped">
            <tr>
            <th>MUNICIPIO </th>
            <th>UF</th>
            <th>NOME SOLICITANTE </th>
            </tr> 
            <tr> 
            <td>{{ $consult->municipio}} </td>
            <td>{{ $consult->uf}} </td>
            <td>{{$consult->sol_name}} </td>
            </tr> 
            </table>
            </div>
            <div class="table-responsive">
            <table class="table table-condensed table table-striped">
            <tr>
            <th>REGULADOR</th>
            <th>TELECONSULTOR </th>
            <th>TEMPO </th>
            <th>PACIENTE </th>
            </tr>
            <td>{{$consult->reg_name}} </td>
            <td>{{$consult->cons_name}} </td>
            <td>{{ tempo($consult->created_at) }} </td>
            <td>{{$consult->paciente}} </td>
            </table>
            </div>
            <div class="table-responsive">
            <table class="table table-condensed table table-striped">
            <tr>
            <th>QUEIXA </th>
            <th>INSTITUIÇÃO </th>
            <th>CIDADE </th>
            </tr>
            <td>{{$consult->queixa}} </td>
            <td>{{$consult->instituiçao}} </td>
            <td>{{$consult->municipio_sol}} </td>
            </table>
            </div>
            <div class="table-responsive">
            <table class="table table-condensed table table-striped">
            <tr>
            <th>AREA INFORMADA </th>
            <th>DEVOLUTIVA DO CONSULTOR </th>
            <th>DEVOLUTIVA DO REGULADOR </th>
            </tr>
            <td>{{$consult->area}} </td>
            <td>{{$consult->devolutiva_cons}} </td>
            <td>{{$consult->dev_reg}} </td>
            </table>
            </div>
            <div class="table-responsive">
            <table class="table table-condensed table table-striped">
            <tr>
            <th>RESPOSTA </th>
            <th>LEITURA RECOMENDADA </th>
            <th>CIAP </th>
            </tr>
            <tr>
            <td>{{$consult->resposta}} </td>
            <td>{{$consult->l_recom}} </td>
            <td>{{$consult->ciap}} </td>
            </tr>
            </table>
            </div>
            <div class="table-responsive">
            <table class="table table-condensed table table-striped">
            <tr>
            <th>REPLICA </th>
            <th>DUVIDA/RESPOSTA </th>
            <th>TREPLICA </th>
            <th>DUVIDA/RESPOSTA </th>
            </tr>
            <tr>
            <td>{{$consult->cons_replica}} </td>
            <td>{{$consult->replica}} </td>
            <td>{{$consult->cons_treplica}} </td>
            <td>{{$consult->treplica}} </td>
            </tr>
            </table>
            </div>
             <div class="table-responsive">
            <table class="table table-condensed table table-striped">
            <tr>
            <th>DEC 1o </th>
            <th>DEC 2o </th>
            <th>DEC 3o </th>
            <th>DÚVIDA </th>
            <th>AVALIAÇÃO </th>
            <th>COMENTÁRIO </th>
            </tr>
            <tr>
            <td>{{$consult->dec1}} </td>
            <td>{{$consult->dec2}} </td>
            <td>{{$consult->dec3}} </td>
            <td>{{$consult->av_duvida}} </td>
            <td>{{$consult->avaliaçao}} </td>
            <td>{{$consult->av_commen}} </td>
            </tr>
            </table>
            </div>
    </div>
  </div>
</div>
