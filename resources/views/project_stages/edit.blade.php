@extends('templates.default')

@section('content')

<section class="panel">
	<header class="panel-heading">
		Editar etapa <strong>#{!! $projectstage->id !!}</strong> do Projeto <strong>{{ $projectstage->project->title }}</strong>
	</header>
	<div class="panel-body">
		@include('project_stages.edit-form')
	</div>
</section>

@stop