@extends('adminlte::page')

@section('title', 'Teleconsultoria')

@section('content_header')
    <h1>Teleconsultoria</h1>

    <!--<ol class='breadcrumb'>
    	<li><a ref="">Dashboard</a></li>
    	<li><a ref="">Consult</a></li>
    	<li><a ref="">Entrada</a></li>
    </ol> -->
@stop

@section('content')
    <table class="table table-striped">
            <tr>
            <hr>
            <th>ID </th>
            <th>STATUS </th>
            <th>SERVIÇO </th>
            <th>DESCRIÇÃO </th>
            
            <th>NOME SOLICITANTE </th>
            <th>TELECONSULTOR </th>
           
            <th>TEMPO </th>
            <th>PACIENTE </th>
            </tr> 
            <tr>
          <h4>Dados da TeleConsultoria Selecionada</h4>    
            <td>{{ $consult->id}}</a></td>
            <td>{{ showstat($consult->status) }} </td>
            <td>{{ $consult->servico}} </td>
            <td>{{ $consult->consulta}} </td>
           
            <td>{{$consult->user->name}} </td>
            <td>{{$consult->cons_name}} </td>
           
            <td>{{ tempo($consult->created_at) }} </td>
            <td>{{$consult->nome_paciente}} </td>
            </tr>    
    </table>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Resposta da Teleconsultoria</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        @if ($consult->servico == 'Tele-ECG')
            <form  method="POST" action="{{ route('consult.storecons', ['sid' => $consult->id])}}" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <div class="box-body">
                    @include('admin.includes.alerts')
                <div class="row">
                    <div class="col-md-4">
                        <fieldset>
                            <legend>Ritmo</legend>
                        
                            <input type="checkbox" id="ritmo[]" value="Sinusal regular" name="ritmo[]">
                            <label for="">Sinusal regular</label><br/>
                        
                            <input type="checkbox" id="ritmo[]" value="Irregular" name="ritmo[]">
                            <label for="">Irregular</label><br/>
                        
                            <input type="checkbox" id="ritmo[]" value="Bradiarritmias" name="ritmo[]">
                            <label for="">Bradiarritmias</label><br/>

                            <input type="checkbox" id="ritmo[]" value="Taquiarritmias" name="ritmo[]">
                            <label for="">Taquiarritmias</label>
                        </fieldset>
                    </div>

                    <div class="col-md-4">
                        <fieldset>
                            <legend>Frequência</legend>
                        
                            <input type="checkbox" id="frequencia[]" value="Dentro da normalidade (50-100 bmp)" name="frequencia[]">
                            <label for="">Dentro da normalidade (50-100 bmp)</label><br/>
                        
                            <input type="checkbox" id="frequencia[]" value="Taquicardia (>100 bmp)" name="frequencia[]">
                            <label for="">Taquicardia (>100 bmp)</label><br/>
                        
                            <input type="checkbox" id="frequencia[]" value="Taquicardia sinusal" name="frequencia[]">
                            <label for="">Taquicardia sinusal</label><br/>

                            <input type="checkbox" id="frequencia[]" value="Bradicardia (< 60 bmp)" name="frequencia[]">
                            <label for="">Bradicardia (< 50 bmp)</label><br/>

                            <input type="checkbox" id="frequencia[]" value="Bradicardia sinusal" name="frequencia[]">
                            <label for="">Bradicardia sinusal</label>
                        </fieldset>
                    </div>

                    <div class="col-md-4">
                        <fieldset>
                            <legend>Eixo QRS</legend>
                        
                            <input type="checkbox" id="eixo[]" value="Sem desvio" name="eixo[]">
                            <label for="">Sem desvio</label><br/>
                        
                            <input type="checkbox" id="eixo[]" value="Desvio de eixo à direita" name="eixo[]">
                            <label for="">Desvio de eixo à direita</label><br/>
                        
                            <input type="checkbox" id="eixo[]" value="Desvio de Eixo à esquerda" name="eixo[]">
                            <label for="">Desvio de Eixo à esquerda</label><br/>

                            
                        </fieldset>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <fieldset>
                            <legend>Onda P</legend>
                        
                            <input type="checkbox" id="onda_p[]" value="Amplitude Normal" name="onda_p[]">
                            <label for="">Amplitude Normal</label><br/>
                        
                            <input type="checkbox" id="onda_p[]" value="Amplitude Alterada" name="onda_p[]">
                            <label for="">Amplitude Alterada</label><br/>
                        
                            <input type="checkbox" id="onda_p[]" value="Deixar campo em aberto para escrever detalhamento" name="onda_p[]">
                            <label for="">Deixar campo em aberto para escrever detalhamento</label><br/>
                        </fieldset>
                    </div>

                    <div class="col-md-4">
                        <fieldset>
                            <legend>PR</legend>
                        
                            <input type="checkbox" id="pr[]" value="Intervalo PR normal" name="pr[]">
                            <label for="">Intervalo PR normal</label><br/>
                        
                            <input type="checkbox" id="pr[]" value="Intervalo PR curto" name="pr[]">
                            <label for="">Intervalo PR curto</label><br/>
                        
                            <input type="checkbox" id="pr[]" value="Intervalo PR longo" name="pr[]">
                            <label for="">Intervalo PR longo</label>
                        </fieldset>
                    </div>

                    <div class="col-md-4">
                        <fieldset>
                            <legend>QRS</legend>
                        
                            <input type="checkbox" id="qrs[]" value="Amplitude Normal" name="qrs[]">
                            <label for="">Amplitude Normal</label><br/>
                        
                            <input type="checkbox" id="qrs[]" value="Amplitude Alterada" name="qrs[]">
                            <label for="">Amplitude Alterada</label><br/>
                        
                            <input type="checkbox" id="qrs[]" value="Duração Normal" name="qrs[]">
                            <label for="">Duração Normal</label><br/>

                            <input type="checkbox" id="qrs[]" value="Duração Alterada" name="qrs[]">
                            <label for="">Duração Alterada</label><br/>

                            <input type="checkbox" id="qrs[]" value="Morfologia Normal" name="qrs[]">
                            <label for="">Morfologia Normal</label><br/>

                            <input type="checkbox" id="qrs[]" value="Morfologia Alterada" name="qrs[]">
                            <label for="">Morfologia Alterada</label>
                        </fieldset>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <fieldset>
                            <legend>ST</legend>
                        
                            <input type="checkbox" id="st[]" value="Isoelétrico e sem alterações relevantes" name="st[]">
                            <label for="">Isoelétrico e sem alterações relevantes</label><br/>
                        
                            <input type="checkbox"  id="st[]" value="Com supradesnivelamento" name="st[]">
                            <label for="">Com supradesnivelamento</label><br/>
                        
                            <input type="checkbox" id="st[]" value="Com infradesnivelamento" name="st[]">
                            <label for="">Com infradesnivelamento</label>
                        </fieldset>
                    </div>

                    <div class="col-md-4">
                        <fieldset>
                            <legend>Onda T</legend>
                        
                            <input type="checkbox" id="onda_t[]" value="Simétrica" name="onda_t[]">
                            <label for="">Simétrica</label><br/>
                        
                            <input type="checkbox" id="onda_t[]" value="Assimétrica" name="onda_t[]">
                            <label for="">Assimétrica</label><br/>
                        
                        
                        </fieldset>
                    </div>

                    <div class="col-md-4">
                        <fieldset>
                            <legend>QT</legend>
                        
                            <input type="checkbox" id="qt[]" value="Normal" name="qt[]">
                            <label for="">Normal</label><br/>
                        
                            <input type="checkbox" id="qt[]" value="Alterada" name="qt[]">
                            <label for="">Alterada</label><br/>
                        
                        
                        </fieldset>
                    </div>
                </div>    
                    <div class="box-header with-border">
                        <h3 class="box-title">Conclusão</h3>
                    </div>
                    <div class="form-group col-md-12">
                        <textarea type="text" name="resposta" maxlength="256" rows="5" cols="80" placeholder="Responda a Teleconsultoria com até 256 caracteres. Caso seja necessário insira um arquivo." class="form-control"></textarea>
                    </div>
                    
                    
                    <div class="form-group col-md-12">
                        <label for="file">Arquivos Anexos:</label>
                        <input type="file" name="arquivo[]" id="file" multiple>
                        <input type="hidden" value="{{ csrf_token() }}" name="_token">
                    </div>
                    <div class="form-group col-md-12">
                        <label>Leitura Recomendada & DECs – descritores em ciências da saúde</label>
                    </div>
                    <div class="form-group col-md-12" >
                        <input type="text" maxlength="256" class="form-control" name="l_recom" placeholder="Leitura Recomendada">
                    </div>
                    <div class="form-group col-md-4">
                        <input type="text" name="dec1" maxlength="50" placeholder="DECs – descritores em ciências da saúde" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                        <input type="text" name="dec2" maxlength="50" placeholder="DECs – descritores em ciências da saúde" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                        <input type="text" name="dec3" maxlength="50" placeholder="DECs – descritores em ciências da saúde" class="form-control">
                    </div>

                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
            
        @else
            <form method="POST" action="{{ route('consult.storecons', ['sid' => $consult->id, 'cid' => $consult->user_id])}}" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                <div class="form-row">
                    @include('admin.includes.alerts')
                    @if ($consult->status == '2')
                    <div class="form-group">
                        <textarea type="text" name="replica" maxlength="3000" rows="8" cols="80" placeholder="Replica da Teleconsultoria com até 3000 caracteres. Caso seja necessário insira um arquivo." class="form-control"></textarea>
                    @else
                        <div class="form-group">
                        <textarea type="text" name="resposta" maxlength="3000" rows="8" cols="80" placeholder="Responda da Teleconsultoria com até 3000 caracteres. Caso seja necessário insira um arquivo." class="form-control"></textarea>
                    @endif
                        <div class="form-row">
                            <label for="file">Arquivos Anexos:</label>
                            <input type="file" name="arquivo[]" id="file" multiple>
                            <input type="hidden" value="{{ csrf_token() }}" name="_token">
                        </div>
                        <div class="form-row" >
                        <div class="form-group">
                        <button type="submit" class="btn btn-success">Enviar</button> 
                        </div>
                        </div>
                    </div>
                </div>
            </form>
        @endif
        
    </div>
    
@stop