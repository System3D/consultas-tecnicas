@extends('templates.default')

@section('content')

<section class="panel">
	<header class="panel-heading">
		<div class="pull-right">
			<i class="fa fa-refresh fa-spin loading hidden"></i>
		</div>
		Registrar Evento
	</header>
	<div class="panel-body">
		<div class="row">
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				@include('consultas_tecnicas.info')
			</div>
			<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">

			</div>
		</div>
	</div>
</section>

@stop