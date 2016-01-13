@extends('templates.default')

@section('content')

	{!! Breadcrumbs::render( 'project_stage_create', $project )  !!}

	<section class="panel">
		<header class="panel-heading">
			<div class="pull-right">
				<a href="{!! url('obras') !!}" class="btn btn-default btn-sm btn-xs">
					<i class="fa fa-arrow-left"></i> Voltar
				</a>
			</div>
			Nova Etapa
		</header>
		<div class="panel-body">

			@include('project_stages.create-form')

		</div>
	</section>

@stop
