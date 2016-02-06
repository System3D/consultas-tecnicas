<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title">CONSULTA TÉCNICA {{ 'CT ' . str_pad($technical_consult->id, 3, "0", STR_PAD_LEFT) }} <strong>{!! $technical_consult->title !!}</strong></h4>
</div>

@foreach ($technical_consult->emails as $email)
	<div class="modal-body" style="background-color:{{$technical_consult->color}};border-bottom: 1px dashed #3e3e3e; {{ ($email->type != 0)?'color:#fff;':'color:#222;'}}">

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
	$email->ratinglabel = '<i class="fa fa-check"></i> Bom';
	break;
}
?>
        @if ($email->type == 2)
            <span class="label label-{{ $email->ratingclass }}">{!! $email->ratinglabel !!}</span>
        @endif

		</small>

		<small class="modal-title text-muted" style="{{ ($email->type != 0)?'color:#fff;':'color:#222;'}}">

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

			@if ($email->type == 1 && $email->attachments->count())
				<a href="{{ url('/consultas-tecnicas/'.$email->consulta_tecnica_id.'/'.$email->id.'/anexos') }}" data-toggle="modal" data-target="#modal" class="pull-right btn btn-default btn-xs"><i class="fa fa-paperclip"></i> {{ $email->attachments->count() }} anexos</a>
	        @endif
	        @if ($email->type == 1 && $email->attachments->count() == 0)
				<a class="btn btn-default btn-xs pull-right disabled"><i class="fa fa-paperclip"></i> Sem anexos</a>
	        @endif
		</small>

		<p class="" style="{{ ($email->type != 0)?'color:#fff;':'color:#eee;'}}"><?php echo html_entity_decode($email->body_html); ?></p>

	</div>

@endforeach