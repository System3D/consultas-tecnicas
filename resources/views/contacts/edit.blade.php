@extends('templates.default')

@section('content')

<section class="panel">
	<header class="panel-heading">
		<div class="pull-right">
			<a href="{!! url('contatos') !!}" class="btn btn-default btn-sm btn-xs">
				<i class="fa fa-arrow-left"></i> Voltar
			</a>
		</div>
		Editar contato
	</header>
	<div class="panel-body">
		
		@include('contacts.edit-form')

	</div>
</section>
@stop
