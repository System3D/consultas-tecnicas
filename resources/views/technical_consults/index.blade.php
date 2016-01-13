@extends('templates.default')

@section('content')

<section class="panel">
	<header class="panel-heading">
		<div class="pull-right"></div>
		Consultas Técnicas
	</header>

	@include('technical_consults.timeline.timeline')

</section>

@stop