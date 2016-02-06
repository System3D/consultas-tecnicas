@extends('templates.default')

@section('content')

{!! Breadcrumbs::render( 'project', $project )  !!}

<section class="panel hidden-print">
	<header class="panel-heading">
		<div class="pull-right">
			{!! Form::open(array('url' => 'obras/'.$project->id , 'method'  => 'delete' )) !!}
			<a href="{!! url( '/obras/'.$project->id.'/edit') !!}" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modal">
				<i class="fa fa-pencil"></i> EDITAR
			</a>
			<button class="btn btn-danger btn-xs" type="submit" onclick="return confirm('Excluir permanentemente esta obra?');"><i class="fa fa-trash-o"></i> EXCLUIR</button>
			{!! Form::close() !!}
		</div>
		Obra <strong>{!! $project->title !!}</strong>
	</header>
	<div class="panel-body">

		<div class="row">
						<div class="col-sm-6">
							<table class="table table-condensed">
								<thead>
									<tr>
										<th class="text-center" colspan="2">RESUMO</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="text-right"><strong>Título:</strong></td>
										<td>{{ $project->title }}</td>
									</tr>
									<tr>
										<td class="text-right"><strong>Data:</strong></td>
										<td>{!! date('d/m/Y', strtotime($project->created_at)) !!}</td>
									</tr>
									<tr>
										<td class="text-right"><strong>Alterado:</strong></td>
										<td>{!! date('d/m/Y', strtotime($project->updated_at)) !!}</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="col-sm-6">
							<table class="table table-condensed">
								<thead>
									<tr>
										<th class="text-center" colspan="2">CLIENTE</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="text-right"><strong>Nome:</strong></td>
										<td>{{ $project->client->name }}</td>
									</tr>
									<tr>
										<td class="text-right"><strong>Empresa:</strong></td>
										<td>{!! $project->client->company !!}</td>
									</tr>
									<tr>
										<td class="text-right"><strong>Criado em:</strong></td>
										<td>{!! date('d/m/Y', strtotime($project->client->created_at)) !!}</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="col-sm-4"></div>
					</div>

		<div class="row">

			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				<!-- ETAPAS -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<a href="{!! url('obras/'.$project->id.'/etapas/create') !!}" class="btn btn-success btn-xs pull-right" data-target="#modal" data-toggle="modal"><i class="fa fa-plus"></i> ADICIONAR</a>
						<h3 class="panel-title">ETAPAS</h3>
					</div>

					<table class="table table-hover">
						<tbody>

							@foreach ($project->stages as $stage)
							<tr>
								<td>{{ $stage->title }}</td>
								<td></td>
								<td>
									<div class="pull-right">
										{!! Form::open(array('url' => 'obras/etapas/'.$stage->id )) !!}

										<input type="hidden" name="_method" value="DELETE">

										<a href="{{ url('obras/'.$project->id.'/etapas/'.$stage->id.'/edit') }}" class="btn btn-default btn-xs" data-target="#modal" data-toggle="modal"><i class="fa fa-pencil"></i></a>
										<button class="btn btn-default btn-xs" type="submit" onclick="return confirm('Excluir permanentemente esta etapa?');"><i class="fa fa-times"></i></button>

										{!! Form::close() !!}
									</div>
								</td>
							</tr>
							@endforeach

						</tbody>
					</table>
				</div>

			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				<!-- DISCIPLINAS -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<a href="{!! url('obras/'.$project->id.'/disciplinas/create') !!}" class="btn btn-success btn-xs pull-right" data-toggle="modal" data-target="#modal"><i class="fa fa-plus"></i> ADICIONAR</a>
						<h3 class="panel-title">DISCIPLINAS</h3>
					</div>

					<table class="table table-hover">
						<tbody>

							@foreach ($project->disciplines as $discipline)
							<tr>
								<td>{{ $discipline->title }}</td>
								<td></td>
								<td>
									<div class="pull-right">
										{!! Form::open(array('url' => 'obras/disciplinas/'.$discipline->id )) !!}

										<input type="hidden" name="_method" value="DELETE">

										<a href="{{ url('obras/'.$project->id.'/disciplinas/'.$discipline->id.'/edit') }}" class="btn btn-default btn-xs" data-target="#modal" data-toggle="modal"><i class="fa fa-pencil"></i></a>
										<button class="btn btn-default btn-xs" type="submit" onclick="return confirm('Excluir permanentemente esta disciplina?');"><i class="fa fa-times"></i></button>

										{!! Form::close() !!}
									</div>
								</td>
							</tr>
							@endforeach

						</tbody>
					</table>
				</div>
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				<!-- CONTATOS -->
				<div class="panel panel-default" id="contatos">

					<div class="panel-heading">
						<a href="{{ url('clientes/'.$project->client_id.'/contatos/create') }}" class="btn btn-xs btn-success pull-right" data-toggle="modal" data-target="#modal"><i class="fa fa-plus"></i> ADICIONAR</a>
						<h3 class="panel-title">CONTATOS</h3>
					</div>

					@if ($project->client->contacts->diff( $project->contacts )->count() > 0)
						{!! Form::open(array('url' => 'obras/'.$project->id.'/contatos/attach', 'class' => 'panel-body')) !!}

							<div class="input-group input-group-sm">
								<select name="contact_id" id="input" class="form-control input-sm" required="required">
									<option selected="selected" value="">-- Selecione --</option>
									@foreach ($project->client->contacts->diff( $project->contacts ) as $contact)
										<option value="{{ $contact->id }}">{{ $contact->name }} / {{ $contact->company }}</option>
									@endforeach
								</select>

						      	<div class="input-group-btn">
						        	<button type="submit" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Vincular</button>
						      	</div><!-- /btn-group -->
						    </div><!-- /input-group -->
						{!! Form::close() !!}
					@endif

					<table class="table table-hover" id="contacts-list">
						<tbody>

							@foreach ($project->contacts as $projectcontact)

							<tr title="" >
								<td><strong><a href="{{ url( '/contatos/'.$projectcontact->id) }}">{{ $projectcontact->name }}</a></strong></td>

								<td>
									<div class="pull-right hidden-phone">

										{!! Form::open(array('url' => url('obras/'.$project->id.'/contatos/'.$projectcontact->id.'/detach'), 'role' => 'form' )) !!}

										<a href="{{ url( '/contatos/'.$projectcontact->id.'/edit') }}" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modal"><i class="fa fa-pencil"></i></a>
										<button class="btn btn-default btn-xs" type="submit" onclick="return confirm('Desvincular este contato desta obra?');" title="Desvincular contato"><i class="fa fa-scissors"></i></button>

										{!! Form::close() !!}
									</div>
								</td>
							</tr>

							@endforeach
						</tbody>
					</table>


				</div>
			</div>
		</div>

	</div>
</section>

<section>
	<section class="panel">
		<header class="panel-heading">
			Consultas Técnicas da Obra
		</header>

		@include('consultas_tecnicas.timeline.timeline', array('email_messages' => $email_messages))

	</section>
</section>

@stop
