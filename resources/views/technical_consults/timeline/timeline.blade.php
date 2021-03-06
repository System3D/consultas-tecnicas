<nav class="navbar navbar-static-top form-inline" id="timeline-filters">
    <div class="navbar-form">
        <div class="form-group">
            <div class="btn-group btn-group-sm">
                <a class="filter btn btn-default" data-filter="all">Ver tudo</a>
                <!-- <a class="filter btn btn-default" data-filter=".email_message_send">Envio</a>
                <a class="filter btn btn-default" data-filter=".email_message_reply">Retorno</a> -->
                <a class="filter btn btn-default" data-filter=".email_message_event">Acontecimento</a>
                <a class="filter btn btn-default" data-filter=".email_message_noreply">Não respondido</a>
            </div>
        </div>

        <div class="form-group">
            &nbsp;
        </div>

        <div class="form-group">
            <div class="btn-group btn-group-sm">
                <!-- <div class="sort btn btn-default" data-sort="default">Default</div> -->
                <a class="sort btn btn-default" data-sort="ctid:desc"><i class="fa fa-asc"></i> Agrupado</a>
                <a class="sort btn btn-default" data-sort="date:desc"><i class="fa fa-desc"></i> Cronológico</a>
            </div>
        </div>

        <div class="form-group">
            <div class="btn-group btn-group-sm">
                <a class="btn btn-primary" onclick="window.print();"><i class="fa fa-print"></i> Imprimir</a>
            </div>
        </div>
        <div class="form-group">
            &nbsp;
    </div>
        <div class="form-group">
            <div class="btn-group btn-group-sm">
                <a href="{{ url('/consultas_tecnicas/create?'.http_build_query(['cliente_id'=>@$project->client->id, 'obra_id'=>@$project->id])) }}" class="btn btn-success"><i class="fa fa-plus"></i> NOVA CONSULTA TÉCNICA</a>
            </div>
        </div>
    </div>
</nav>

<style>
    .timeline .mix{
        display: none;
    }
</style>

    <ul class="timeline" id="timeline">

        @foreach ($technical_consults as $technical_consult)

            <?php $reversed = $technical_consult->emails->reverse();
$reversed->all();?>

            @foreach ($reversed->all() as $email)

                @if ( $email->type == 2 )
                    @include( 'technical_consults.timeline.timeline_reply' )
                @elseif ( $email->type == 1 )
                    @include( 'technical_consults.timeline.timeline_send' )
                @else
                    @include( 'technical_consults.timeline.timeline_event' )
                @endif

            @endforeach

        @endforeach

    </ul>