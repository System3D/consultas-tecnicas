@extends('templates.default')

@section('content')

{!! Breadcrumbs::render( 'technical_consult', $technical_consult )  !!}

<section class="panel">
	<header class="panel-heading">
		<div class="pull-right">
			{!! Form::open(array('url' => 'consultas_tecnicas/'.$technical_consult->id , 'method'  => 'delete' )) !!}
			<a href="{!! url( '/consultas_tecnicas/'.$technical_consult->id.'/edit') !!}" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modal">
				<i class="fa fa-pencil"></i> EDITAR
			</a>
			<a class="btn btn-default btn-xs" onclick="window.print();"><i class="fa fa-print"></i> Imprimir</a>
			<button class="btn btn-danger btn-xs" type="submit" onclick="return confirm('Excluir permanentemente esta consulta técnica e todas as conversas anexadas?');"><i class="fa fa-trash-o"></i> EXCLUIR</button>
			{!! Form::close() !!}
		</div>
		{{ 'CT ' . str_pad($technical_consult->id, 3, "0", STR_PAD_LEFT) }} <strong>{!! $technical_consult->title !!}</strong>
	</header>

	<div class="list-group">

		@foreach ($technical_consult->emails as $email)

			<div href="#" class="list-group-item">
				<h4 class="list-group-item-heading">
					<?php echo html_entity_decode($email->subject); ?>
				</h4>
				<div class="btn-group">
					<a href="#" class="btn-xs btn-link"><i class="fa fa-calendar-o"></i> {{ date( 'd/m/Y', strtotime( $email->date )) }}</a>
					<a href="#" class="btn-xs btn-link"><i class="fa fa-clock-o"></i> {{ date( 'H:i', strtotime( $email->date )) }}</a>
					@if ($email->replies->count() > 0)
						<a href="#email_message_{{ current($email->replies->toArray())['id'] }}" class="btn-xs btn-link"><i class="fa fa-reply"></i> {{ $email->replies->count() }} respostas</a>
					@else
						<a class="btn-xs btn-link"><i class="fa fa-warning"></i> Sem resposta</a>
					@endif
					@if ($email->attachments->count() > 0)
						<a href="#email_message_{{ current($email->attachments->toArray())['id'] }}" class="btn-xs btn-link"><i class="fa fa-reply"></i> {{ $email->attachments->count() }} Anexos</a>
					@else
						<a href="#" class="btn-xs btn-link"><i class="fa fa-warning"></i> Sem anexos</a>
					@endif
					<a href="#" class="btn-xs btn-link"><i class="fa fa-circle" style="color:<?php echo $technical_consult->color ?>;"></i> <?php echo $technical_consult->color ?></a>
				</div>

				<br><br>

				<p class="list-group-item-text"><?php echo html_entity_decode($email->body_html); ?></p>
			</div>

		@endforeach

	</div>

</section>

@stop