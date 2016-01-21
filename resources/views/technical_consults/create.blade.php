@extends('templates.default')

@section('content')

	{!! Breadcrumbs::render( 'technical_consults_create' )  !!}

	<section class="panel">
		<header class="panel-heading">
			<div class="pull-right">
				<i class="fa fa-refresh fa-spin loading hidden"></i>
			</div>
			Novo registro
		</header>
		<div class="panel-body">

			@include('technical_consults.create-form')

		</div>
	</section>

@stop