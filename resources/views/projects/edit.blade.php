@extends('templates.default')

@section('content')

<section class="panel">
	<header class="panel-heading">
		<div class="pull-right">
			<a href="{!! url('/obras/'.$project->id) !!}" class="btn btn-default btn-sm btn-xs">
				<i class="fa fa-arrow-left"></i> Voltar
			</a>
		</div>
		Editar obra <strong>#{!! $project->id !!}</strong>
	</header>
	<div class="panel-body">
		@include('projects.edit-form')
	</div>
</section>
@stop
