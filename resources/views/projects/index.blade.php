@extends('templates.default')

@section('content')

<section class="panel">
	<header class="panel-heading">
		<div class="pull-right">
			<a href="{{ url('obras/create') }}" class="btn btn-default btn-xs" data-target="#modal" data-toggle="modal"><i class="fa fa-plus"></i> Adicionar</a>
		</div>
		Obras
	</header>
	<div class="table-responsive">
		@include('projects.index-table')
	</div>
</section>
@stop