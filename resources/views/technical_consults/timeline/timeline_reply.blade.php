<li id="email_message_{{ $email->id }}" class="mix technical_consult_{{ $technical_consult->id }} email_message_{{ $email->id }} email_message_reply {{ ( $email->type == 2 ) ? 'timeline-inverted' : '' }} {{ ( $email->replies->count() > 0 ) ? '' : 'email_message_noreply' }}" data-id="{{ $email->id }}" data-ctid="{{ $technical_consult->id }}" data-date="{!! date('Y-m-d', strtotime($email->date)) !!}"  data-type="{{ $email->type }}" data-myorder="{!! $email->id !!}">


    <div class="timeline-date label label-default">
        {{ date('d/m/Y', strtotime($email->date)) }}
    </div>

    <hr style="display:none;">

    <div class="timeline-point"></div>

    <div class="timeline-panel" style="background-color: <?php echo $technical_consult->color ?>">
        <div class="timeline-heading">


            <h4 class="timeline-title"><strong>CT {{ str_pad( $technical_consult->id, 3, "0", STR_PAD_LEFT ) }}  <small class="text-muted">
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
            <a href="#" class=""><i class="fa fa-paperclip"></i> {{ $email->replies->count() }} anexos</a>
        </li>
        <li class="text-left">
            @if ($email->replies->count() > 0)
            <a href="#email_message_{{ current($email->replies->toArray())['id'] }}" class="scrollto"><i class="fa fa-reply"></i> {{ $email->replies->count() }} respostas</a>
            @endif
        </li>
        <li class="text-left">
            @if ($email->replies->count() > 0)
            <a href="#email_message_{{ current($email->replies->toArray())['id'] }}" class="scrollto"><i class="fa fa-reply"></i> {{ $email->replies->count() }} respostas</a>
            @endif
        </li>
    </ul>
</div>

<style>
    .technical_consult_{!! $technical_consult->id !!}.email_message_{!! $email->id !!} .timeline-panel:after{
     border-right-color: <?php echo $technical_consult->color ?>;
 }
</style>

</li>