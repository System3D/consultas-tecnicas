<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title">CONSULTA TÉCNICA {{ $technical_consult->formattedCod('CT #') }} <strong>{!! $technical_consult->title !!}</strong></h4>
</div>

@foreach ($technical_consult->emails as $email)
	<div class="modal-body" style="background-color:{{$technical_consult->color}};border-bottom: 1px dashed #3e3e3e; {{ ($email->type != 0)?'color:#fff;':'color:#222;'}}">

		<span class="pull-right">		

			{!! Form::open(['url' => '/emailmessage/'.$email->id.'/' , 'method' => 'delete', 'onsubmit' => "javascript: return confirm('Excluir o registro?')"]) !!}
				<button type="submit" class="btn btn-danger btn-xs pull-right"><i class="fa fa-trash-o"></i></button>
			{!! Form::close() !!}

		</span>
		

		<small class="modal-title text-muted pull-right">
<?php
switch ($email->rating) {
case 1:
	# code...
	$email->ratingclass = 'danger';
	$email->ratinglabel = 'Insatisfatório';
	break;
case 2:
	# code...
	$email->ratingclass = 'info';
	$email->ratinglabel = 'Regular';
	break;

default:
	$email->ratingclass = 'success';
	$email->ratinglabel = '<i class="fa fa-check"></i> Satisfatório';
	break;
}
?>
        @if ($email->type == 2)
            <span class="label label-{{ $email->ratingclass }}">{!! $email->ratinglabel !!}</span>
        @endif

		</small>

		<small class="modal-title text-muted" style="{{ ($email->type != 0)?'color:#fff;':'color:#222;'}}">

			<span class="pull-right">

				@if ($email->type == 1 && $email->attachments->count())
					<a href="{{ url('/consultas_tecnicas/'.$email->consulta_tecnica_id.'/'.$email->id.'/anexos') }}" data-toggle="modal" data-target="#modal" class="btn btn-default btn-xs"><i class="fa fa-paperclip"></i> {{ $email->attachments->count() }} anexos</a>
		        @endif
		        @if ($email->type == 1 && $email->attachments->count() == 0)
					<a class="btn btn-default btn-xs disabled"><i class="fa fa-paperclip"></i> Sem anexos</a>
		        @endif				

			</span>

			@if ($email->type == 2)
			<span class="fa-stack fa-lg">
				<!-- <i class="fa fa-reply fa-stack-2x"></i> -->
				<i class="fa fa-reply fa-stack-1x"></i>
			</span>
			@endif

			@if ($email->type == 1)
			<span class="fa-stack fa-lg">
				<!-- <i class="fa fa-reply fa-stack-2x"></i> -->
				<i class="fa fa-share fa-stack-1x"></i>
			</span>
			@endif

			@if ($email->type == 0)
			<span class="fa-stack fa-lg">
				<!-- <i class="fa fa-reply fa-stack-2x"></i> -->
				<i class="fa fa-warning fa-stack-1x"></i>
			</span>
			@endif

			<i class="fa fa-calendar-o"></i> {{ date( 'd/m/Y', strtotime( $email->date )) }}
			<i class="fa fa-clock-o"></i> {{ date( 'H:i', strtotime( $email->date )) }}
		
		</small>

		<p class="" style="{{ ($email->type != 0)?'color:#fff;':'color:#eee;'}}"><?php echo html_entity_decode($email->body_html); ?></p>

	</div>

@endforeach