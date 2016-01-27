<li class="mix technical_consult_{!! $technical_consult->id !!} email_message_{!! $email->id !!} email_message_send {{ ( $email->replies->count() > 0 ) ? '' : 'email_message_noreply' }}" data-id="{!! $email->id !!}" data-ctid="{!! $technical_consult->id !!}" data-date="{!! date('Y-m-d', strtotime($email->date)) !!}" data-type="{!! $email->type !!}" data-myorder="{!! $email->id !!}">


    <div class="timeline-date label label-default">
        {{ date('d/m/Y', strtotime($email->date)) }}
    </div>

    <hr style="display:none;">

    <!-- <div class="timeline-badge {{ ( count( $email->replies ) > 0 ) ? 'badge-success' : 'badge-danger' }}">
        <i class="fa fa-share"></i>
    </div> -->

    <div class="timeline-point"></div>


    <div class="timeline-panel" style="background-color: <?php echo $technical_consult->color ?>; border: 1px solid <?php echo $technical_consult->color ?>">

        <div class="timeline-heading">

            <small class="pull-right">
                @if( count($email->replies) > 0 )
                    <i class="fa fa-check"></i> {{ $email->replies->count() }} Respostas
                @else
                    <i class="fa fa-warning"></i> Sem resposta
                @endif
            </small>

            <h4 class="timeline-title"><strong>CT {{ str_pad( $technical_consult->id, 3, "0", STR_PAD_LEFT ) }}</strong> <small class="">Enviado <time class="timeago" datetime="{{ date( 'Y-m-d H:i:s', strtotime( $email->date )) }}">{{ date( 'd/m/Y', strtotime( $email->date )) }}</time></small>
                <br>
                <small>
                    <i class="fa fa-calendar-o"></i> {{ date( 'd/m/Y', strtotime( $email->date )) }}
                    <i class="fa fa-clock-o"></i> {{ date( 'H:i', strtotime( $email->date )) }}
                </small>
            </h4>

        </div>
        <div class="timeline-body">
            <strong><?php echo html_entity_decode($email->subject); ?></strong><br>
<?php
$doc = new DOMDocument();
$doc->loadHTML($email->body_html);
echo $doc->saveHTML();
?>
            <?php //echo html_entity_decode($email->body_html); ?>
        </div>

        <ul class="nav nav-justified hidden-print">
            <li class="active text-left">
                <a href="{{ url('/consultas_tecnicas/'.$technical_consult->id.'/'.$email->id.'/anexos') }}" data-toggle="modal" data-target="#modal" class=""><i class="fa fa-paperclip"></i> {{ $email->attachments->count() }} anexos</a>
            </li>
            <li class="text-center">
                <p class="form-control-static text-center">
                    <a href="{{ url('/consultas_tecnicas/'.$technical_consult->id) }}" data-toggle="modal" data-target="#modal" class="btn btn-xs btn-default btn-block"><i class="fa fa-eye"></i> Ver</a>
                </p>
            </li>
            <li class="text-left">
                    <p class="form-control-static text-center">
                        <a href="{{ url('/consultas_tecnicas/create?'.http_build_query(['cliente_id'=>$technical_consult->cliente_id, 'obra_id'=>$technical_consult->project_id, 'technical_consult'=>$technical_consult->id, 'email_message_id'=>$email->id])) }}" data-toggle="modal" class="btn btn-xs btn-default btn-block"><i class="fa fa-plus"></i> Resposta</a>
                    </p>

            </li>
        </ul>
    </div>

    <style>
        .technical_consult_{!! $technical_consult->id !!}.email_message_{!! $email->id !!} .timeline-panel:after {
            border-left-color: {{ $technical_consult->color }};
        }
        .technical_consult_{!! $technical_consult->id !!}.email_message_{!! $email->id !!}:after {
            border-right-color: {{ $technical_consult->color }};
        }
    </style>

</li>