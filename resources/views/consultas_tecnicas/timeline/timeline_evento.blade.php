<li class="mix technical_consult_{{ $email->consulta_tecnica_id }} email_message_{{ $email->id }} email_message_event" data-id="{{ $email->id }}" data-ctid="{{ $email->consulta_tecnica_id }}" data-date="{!! date('Y-m-d', strtotime($email->date)) !!}" data-type="{{ $email->type }}" data-myorder="{!! $email->id !!}">

    <div class="timeline-date label label-default">
        {{ date('d/m/Y', strtotime($email->date)) }}
    </div>

    <hr style="display:none;">

   <!--  <div class="timeline-badge badge-warning">
        <i class="fa fa-exclamation"></i>
    </div> -->

    <div class="timeline-point"></div>

    <div class="timeline-panel" style="background-color: #fff;">

        <style>
            /*.technical_consult_{!! $email->consulta_tecnica_id !!}.email_message_{!! $email->id !!} .timeline-panel:after {
                border-left-color: #d4d4d4;
            }
            .technical_consult_{!! $email->consulta_tecnica_id !!}.email_message_{!! $email->id !!}:after {
                border-right-color: #d4d4d4;
            }*/
        </style>

        <div class="timeline-heading">

            <small class="pull-right">
                <a href="#" class="text-warning"><i class="fa fa-exclamation-circle"></i> Acontecimento</a>
            </small>

            <h4 class="timeline-title"><strong>CT {{ str_pad( $email->consulta_tecnica_id, 3, "0", STR_PAD_LEFT ) }}</strong> <small class="text-muted">
                Registrado <time class="timeago" datetime="{{ date( 'Y-m-d H:i:s', strtotime( $email->date )) }}">{{ date( 'd/m/Y', strtotime( $email->date )) }}</time>
            </small>
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
            <a href="{{ url('/consultas-tecnicas/'.$email->consulta_tecnica_id) }}" data-toggle="modal" data-target="#modal" class="btn btn-xs btn-default btn-block"><i class="fa fa-eye"></i> VER ACONTECIMENTO</a>
        </div>
    </div>
</div>
</li>