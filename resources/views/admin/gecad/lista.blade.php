@extends('adminlte::page')

@section('content')
      <table  class="display" style="width:100%">
        <thead>
            <tr>
            <th>ID </th>
            <th>PROJETO </th>
            <th>DESCRIÇÃO</th>
            <th>INICIO</th>
            <th>IMP</th>
            <th>URG</th>
            </tr>
        </thead>
	<tbody>

	 @forelse($colaboradors as $colaborador)
	<tr>
	<td>{{ $colaborador->id }} </td>                                            
        <td>{{ $colaborador->cns }} </td>
        <td>{{ $colaborador->conselho }} </td>
	</tr>
	@empty 
         @endforelse
      	</tbody>
       </table>
@endsection

