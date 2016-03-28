<li id="email_message_{{ $email->id }}" class="mix technical_consult_{{ $email->consulta_tecnica_id }} email_message_{{ $email->id }} email_message_reply {{ ( $email->type == 2 ) ? 'timeline-inverted' : '' }}" data-id="{{ $email->id }}" data-ctid="{{ $email->consulta_tecnica_id }}" data-date="{{ date( 'd/m/Y', strtotime( $email->date )) }}"  data-type="{{ $email->type }}" data-myorder="{!! $email->id !!}">


    <div class="timeline-date label label-default">
        {{ date('d/m/Y', strtotime($email->date)) }}
    </div>

    <hr style="display:none;">

    <div class="timeline-point"></div>

    <div class="timeline-panel" style="background-color: <?php echo $email->consulta_tecnica->color ?>">
    <div style="border-right: 4px solid <?php echo $email->consulta_tecnica->color ?>;">
        <div class="timeline-heading">
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
            <span class="pull-right label label-{{ $email->ratingclass }}">{!! $email->ratinglabel !!}</span>

            <h4 class="timeline-title"><strong>{{ $email->consulta_tecnica->formattedCod('CT #') }}<small class="text-lowercase">
                <time class="timeago" datetime="{{ $email->date }}">{{ date( 'd/m/Y', strtotime( $email->date )) }}</time>
            </small></strong>
            <br>
            <small>
                <i class="fa fa-calendar-o"></i> {{ date( 'd/m/Y', strtotime( $email->date )) }}
                <i class="fa fa-clock-o"></i> {{ date( 'H:i', strtotime( $email->date )) }}
            </small>
        </h4>

    </div>
    <div class="timeline-body">

        <strong><?php echo html_entity_decode($email->subject); ?></strong><br>
        <?php echo html_entity_decode($email->body_html); ?>
    </div>
    <div class="timeline-footer hidden-print">
        <div class="btn-group btn-group-justified" role="group" >
            <a href="{{ url('/consultas-tecnicas/'.$email->consulta_tecnica_id) }}" data-toggle="modal" data-target="#modal" class="btn btn-xs btn-link btn-outline"><i class="fa fa-eye"></i> Ver consulta técnica</a>
        </div>

    </div>
    </div>
</div>

<style>
    .technical_consult_{!! $email->consulta_tecnica_id !!}.email_message_{!! $email->id !!} .timeline-panel:after{
     border-right-color: <?php echo $email->consulta_tecnica->color ?>;
 }
</style>

</li>