@extends('templates.default')

@section('content')

<div class="row">
	<div class="col-sm-6">
		<section class="panel">
		    <header class="panel-heading">
		        Adicionar Consulta Técnica
		    </header>
		    <div class="panel-body">
		    	<a href="{{ url('/consultas_tecnicas/create') }}" class="btn btn-success btn-block"><i class="fa fa-plus"></i> NOVA CONSULTA TÉCNICA</a>
		    </div>
		</section>
	</div>
	<div class="col-sm-6">
		<section class="panel">
		    <header class="panel-heading">
		        Obras
		    </header>


		    	<table class="table table-hover">
					<thead>
						<tr>
							<th>Obra</th>
							<th>Cliente</th>
							<th class="text-center">Etapas</th>
							<th class="text-center">Consultas Técnicas</th>
						</tr>
					</thead>
					<tbody>

						@foreach ($projects as $project)
						<tr>
							<td><a href="{{ url('obras/'.$project->id) }}"><strong>{{	$project->title }}</strong></a></td>
							<td><a href="{{ url('clientes/'.$project->client->id) }}">{{ $project->client->name }}</a></td>
							<td class="text-center">
								<span class="badge">{{ $project->stages->count() }}</span>
							</td>
							<td class="text-center">
								<span class="badge">{{ $project->technical_consults->count() }}</span>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>

		</section>
	</div>
	<div class="col-sm-6">
		<section class="panel">
		    <header class="panel-heading">
		        Adicionar Obra
		    </header>
		    <div class="panel-body">
		    	<a href="{{ url('/obras/create') }}" class="btn btn-success btn-block"><i class="fa fa-plus"></i> NOVA OBRA</a>
		    </div>
		</section>
	</div>
</div>
@stop
