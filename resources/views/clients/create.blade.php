@extends('templates.default')

@section('content')

<section class="panel">
	<header class="panel-heading">
		<div class="pull-right">
			<a href="{!! url('clientes') !!}" class="btn btn-default btn-sm btn-xs">
				<i class="fa fa-arrow-left"></i> Voltar
			</a>
		</div>
		Adicionar cliente
	</header>
	<div class="panel-body">
		@include('clients.create-form')
	</div>
</section>
@stop
