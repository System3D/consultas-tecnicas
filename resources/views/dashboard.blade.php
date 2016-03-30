@extends('templates.default')

@section('content')

		<section class="panel">
		    <header class="panel-heading">
		    	<a href="{{ url('/obras/create') }}" class="btn btn-success btn-xs pull-right"><i class="fa fa-plus"></i> Novo Projeto</a>
		        Projetos
		    </header>

		    	<table class="table table-hover">
					<thead>
						<tr>
							<th>Projeto</th>
							<th>Cliente</th>
							<th class="text-center">Etapas</th>
							<th class="text-center">Consultas Técnicas</th>
							<th></th>
						</tr>
					</thead>
					<tbody>

						@foreach ($projects as $project)
						<tr>
							<td><a href="{{ url('obras/'.$project->id) }}"><strong>{{ $project->title }}</strong></a></td>
							<td><a href="{{ url('clientes/'.$project->client->id) }}">{{ $project->client->name }}</a></td>
							<td class="text-center">
								<span class="badge">{{ $project->stages->count() }}</span>
							</td>
							<td class="text-center">
								<span class="badge">{{ $project->technical_consults->count() }}</span>
							</td>
							<td class="text-right">
				                <a href="{{ url('/consultas-tecnicas/create?'.http_build_query(['cliente'=>@$project->client->id, 'project_id'=>@$project->id])) }}" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> CONSULTA TÉCNICA</a>

				                <a href="{{ url('/consultas-tecnicas/create?'.http_build_query(['tipo'=>'evento', 'cliente'=>@$project->client->id, 'project_id'=>@$project->id])) }}" class="btn btn-default btn-xs"><i class="fa fa-plus"></i> ACONTECIMENTO</a>

							</td>
						</tr>
						@endforeach

					</tbody>
				</table>

		</section>
@stop