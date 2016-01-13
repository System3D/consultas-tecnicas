@extends('templates.default')

@section('content')

	{!! Breadcrumbs::render( 'project_disciplines_create', $project )  !!}

	<section class="panel">
		<header class="panel-heading">
			<div class="pull-right">
				<a href="{!! url('obras') !!}" class="btn btn-default btn-sm btn-xs">
					<i class="fa fa-arrow-left"></i> Voltar
				</a>
			</div>
			Nova Disciplina
		</header>
		<div class="panel-body">

			@include('project_disciplines.create-form')

		</div>
	</section>

@stop
