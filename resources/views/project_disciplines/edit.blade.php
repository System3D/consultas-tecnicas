@extends('templates.default')

@section('content')

<section class="panel">
	<header class="panel-heading">
		Editar Disciplina <strong>#{!! $projectdiscipline->id !!}</strong> | Obra <strong>{{ $projectdiscipline->project->title }}</strong>
	</header>
	<div class="panel-body">
		@include('project_disciplines.edit-form')
	</div>
</section>

@stop