<table class="table table-hover">
	<thead>
		<tr>
			<th>#</th>
			<th>Título</th>
			@if ( !@$client_id )
				<th>Cliente</th>
			@endif
			<th class="text-center" colspan="3"></th>
			<th></th>
		</tr>
	</thead>
	<tbody>

		@foreach ($projects as $project)
		<tr>
			<td width="40"><a href="{{ url('obras/'.$project->id) }}">{{	$project->id }}</a></td>
			<td><a href="{{ url('obras/'.$project->id) }}"><strong>{{	$project->title }}</strong></a></td>

			@if ( !@$client_id )
				<td><a href="{{ url('clientes/'.$project->client->id) }}">{{ $project->client->name }}</a></td>
			@endif

			<td class="text-center">
				<span class="badge">{{ $project->stages->count() }}</span> Etapas
			</td>
			<td class="text-center">
				<span class="badge">{{ $project->disciplines->count() }}</span> Disciplinas
			</td>
			<td class="text-center">
				<span class="badge">{{ $project->consultas_tecnicas->count() }}</span> Consultas Técnicas
			</td>
			<td>
				<div class="pull-right hidden-phone">
                    {!! Form::open(array('url' => 'obras/'.$project->id , 'method'  => 'delete' )) !!}
                    	<a href="{{ url('obras/'.$project->id.'/edit') }}" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></a>
                        <button class="btn btn-default btn-xs" type="submit" onclick="return confirm('Excluir permanentemente esta obra?');"><i class="fa fa-times"></i></button>

                    {!! Form::close() !!}
             	</div>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>