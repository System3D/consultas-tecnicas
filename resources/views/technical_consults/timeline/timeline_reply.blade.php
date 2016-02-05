<li id="email_message_{{ $email->id }}" class="mix technical_consult_{{ $email->consulta_tecnica_id }} email_message_{{ $email->id }} email_message_reply {{ ( $email->type == 2 ) ? 'timeline-inverted' : '' }}" data-id="{{ $email->id }}" data-ctid="{{ $email->consulta_tecnica_id }}" data-date="{!! date('Y-m-d', strtotime($email->date)) !!}"  data-type="{{ $email->type }}" data-myorder="{!! $email->id !!}">


    <div class="timeline-date label label-default">
        {{ date('d/m/Y', strtotime($email->date)) }}
    </div>

    <hr style="display:none;">

    <div class="timeline-point"></div>

    <div class="timeline-panel" style="background-color: <?php echo $email->consulta_tecnica->color ?>">
        <div class="timeline-heading">


            <h4 class="timeline-title"><strong>CT {{ str_pad( $email->consulta_tecnica_id, 3, "0", STR_PAD_LEFT ) }}  <small class="text-muted">
                Respondido <time class="timeago" datetime="{{ date( 'Y-m-d H:i:s', strtotime( $email->date )) }}">{{ date( 'd/m/Y', strtotime( $email->date )) }}</time>
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
    <ul class="nav nav-justified hidden-print">
        <li class="active text-left">
            <a href="{{ url('/consultas_tecnicas/'.$email->consulta_tecnica_id.'/'.$email->id.'/anexos') }}" data-toggle="modal" data-target="#modal" class=""><i class="fa fa-paperclip"></i> {{ $email->attachments->count() }} anexos</a>
        </li>
        <li class="text-left">
            <p class="form-control-static text-center">
                <a href="{{ url('/consultas_tecnicas/'.$email->consulta_tecnica_id) }}" data-toggle="modal" data-target="#modal" class="btn btn-xs btn-default btn-block"><i class="fa fa-eye"></i> Ver</a>
            </p>
        </li>
        <li class="">
            <p class="form-control-static text-center">
                <a href="{{ url('/consultas_tecnicas/create?'.http_build_query(['cliente_id'=>$email->consulta_tecnica->cliente_id, 'obra_id'=>$email->consulta_tecnica->project_id, 'technical_consult'=>$email->consulta_tecnica_id, 'email_message_id'=>$email->id])) }}" data-toggle="modal" class="btn btn-xs btn-default btn-block"><i class="fa fa-plus"></i> Resposta</a>
            </p>

        </li>
    </ul>
</div>

<style>
    .technical_consult_{!! $email->consulta_tecnica_id !!}.email_message_{!! $email->id !!} .timeline-panel:after{
     border-right-color: <?php echo $email->consulta_tecnica->color ?>;
 }
</style>

</li>