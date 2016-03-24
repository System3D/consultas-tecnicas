<li class="mix technical_consult_{!! $email->consulta_tecnica_id !!} email_message_{!! $email->id !!} email_message_send {{ ( $email->replies->count() > 0 ) ? '' : 'email_message_noreply' }}" data-id="{!! $email->id !!}" data-ctid="{!! $email->consulta_tecnica_id !!}" data-date="{{ date( 'd/m/Y', strtotime( $email->date )) }}" data-type="{!! $email->type !!}" data-myorder="{!! $email->id !!}">


    <div class="timeline-date label label-default">
        {{ date('d/m/Y', strtotime($email->date)) }}
    </div>

    <hr style="display:none;">

    <!-- <div class="timeline-badge {{ ( count( $email->replies ) > 0 ) ? 'badge-success' : 'badge-danger' }}">
        <i class="fa fa-share"></i>
    </div> -->

    <div class="timeline-point"></div>


    <div class="timeline-panel" style="background-color: <?php echo $email->consulta_tecnica->color ?>; border: 1px solid <?php echo $email->consulta_tecnica->color ?>;">
        <div style="border-left: 4px solid <?php echo $email->consulta_tecnica->color ?>;">
        <div class="timeline-heading">

            <small class="pull-right">
                @if( count($email->replies) > 0 )
                    <i class="fa fa-check"></i> {{ $email->replies->count() }} Respostas
                @else
                    <i class="fa fa-warning"></i> Sem resposta
                @endif
            </small>            

            <h4 class="timeline-title"><strong>{{ $email->consulta_tecnica->formattedCod('CT #') }}</strong> <small class="text-lowercase"><time class="timeago" datetime="{{ $email->date }}">{{ date( 'd/m/Y', strtotime( $email->date )) }}</time></small>
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

        <div class="timeline-footer hidden-print">
            <div class="btn-group btn-group-justified" role="group" >
                <a href="{{ url('/consultas-tecnicas/'.$email->consulta_tecnica_id.'/'.$email->id.'/anexos') }}" data-toggle="modal" data-target="#modal" class="btn btn-xs btn-link btn-outline"><i class="fa fa-paperclip"></i> {{ $email->attachments->count() }} anexos</a>
                <a href="{{ url('/consultas-tecnicas/'.$email->consulta_tecnica_id.'?'.http_build_query([
                    'cliente_id'=>$email->consulta_tecnica->cliente_id,
                    'project_id'=>$email->consulta_tecnica->project_id,
                    'project_stage_id'=>$email->consulta_tecnica->project_stage_id,
                    'consulta_tecnica_id'=>$email->consulta_tecnica_id,
                    'email_message_id'=>$email->id,
                    'tipo'=>'retorno'])) }}" data-toggle="modal" data-target="#modal" class="btn btn-xs btn-link btn-outline"><i class="fa fa-eye"></i> Ver</a>
                <a href="{{ url('/consultas-tecnicas/create?'.http_build_query([
                    'cliente_id'=>$email->consulta_tecnica->cliente_id,
                    'project_id'=>$email->consulta_tecnica->project_id,
                    'project_stage_id'=>$email->consulta_tecnica->project_stage_id,
                    'consulta_tecnica_id'=>$email->consulta_tecnica_id,
                    'email_message_id'=>$email->id,
                    'tipo'=>'retorno']))  }}" data-toggle="modal" class="btn btn-xs btn-link btn-outline"><i class="fa fa-plus"></i> Resposta</a>
            </div>

        </div>
        </div>
    </div>

    <style>
        .technical_consult_{!! $email->consulta_tecnica_id !!}.email_message_{!! $email->id !!} .timeline-panel:after {
            border-left-color: {{ $email->consulta_tecnica->color }};
        }
        .technical_consult_{!! $email->consulta_tecnica_id !!}.email_message_{!! $email->id !!}:after {
            border-right-color: {{ $email->consulta_tecnica->color }};
        }
    </style>

</li>