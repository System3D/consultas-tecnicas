<div class="modal-header">
	Anexos
</div>
@if( count( $files ) > 0 )
<table class="table table-hover">
	<thead>
		<tr>
			<th width="30"></th>
			<th>Arquivo</th>
			<th>Tipo</th>
			<th>Enviado em</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		@foreach ($files as $file)

		<tr title="{{ $file->notes }}">
			<td><i class="fa fa-{{ $file->icon() }} text-muted"></i></td>
			<td>{{ $file->original_filename }}</td>
			<td><strong>{{ $file->mime }}</strong></td>
			<td>{{ date('d/m/y \à\\s H:i', strtotime($file->created_at)) }}</td>
			<td>
				<div class="pull-right hidden-phone">
                    {!! Form::open(array('url' => 'arquivos/'.$file->id , 'method'  => 'delete' )) !!}
                    	<a href="{{ route('downloadfile', $file->original_filename) }}" class="btn btn-default btn-xs"><i class="fa fa-download"></i></a>
                        <button class="btn btn-default btn-xs" type="submit" onclick="return confirm('Excluir permanentemente este arquivo?');"><i class="fa fa-times"></i></button>
                    {!! Form::close() !!}
             	</div>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
@else
	<div class="text-center">
		<h3>Nenhum anexo encontrado!</h3>
	</div>
@endif
