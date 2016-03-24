<header class="panel-heading text-center visible-print-block">
    Consultas Técnicas <br>
    <small class="text-center visible-print-block">
        {!! Breadcrumbs::render( 'project', $project )  !!}             
        <span id="activefilters">Listando Todas Consultas</span>
    </small>
</header>

<nav class="navbar navbar-static-top form-inline" id="timeline-filters">
    <div class="navbar-form">
        <div class="form-group">
            <div class="btn-group btn-group-sm">
                <a class="filter btn btn-default" data-filter="all" data-printlabel="Listando Todas Consultas">Ver tudo</a>
                <!-- <a class="filter btn btn-default" data-filter=".email_message_send">Envio</a>
                <a class="filter btn btn-default" data-filter=".email_message_reply">Retorno</a> -->
                <a class="filter btn btn-default" data-filter=".email_message_event" data-printlabel="Listando Somente Acontecimentos">Acontecimento</a>
                <a class="filter btn btn-default" data-filter=".email_message_noreply" data-printlabel="Listando Consultas Não Respondidas">Não respondido</a>
            </div>
        </div>

        <div class="form-group">
            &nbsp;
        </div>

        <!-- <div class="form-group">
            <div class="btn-group btn-group-sm">
                <div class="sort btn btn-default" data-sort="default">Default</div>
                <a class="sort btn btn-default" data-sort="ctid:desc"><i class="fa fa-asc"></i> Agrupado</a>
                <a class="sort btn btn-default" data-sort="date:desc"><i class="fa fa-desc"></i> Cronológico</a>
            </div>
        </div> -->

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
                <a href="{{ url('/consultas-tecnicas/create?'.http_build_query(['cliente'=>@$project->client->id, 'project_id'=>@$project->id])) }}" class="btn btn-success"><i class="fa fa-plus"></i> NOVA CONSULTA TÉCNICA</a>
            </div>
        </div>
        <div class="form-group">
            <div class="btn-group btn-group-sm">
                <a href="{{ url('/consultas-tecnicas/create?'.http_build_query(['tipo'=>'evento', 'cliente'=>@$project->client->id, 'project_id'=>@$project->id])) }}" class="btn btn-default"><i class="fa fa-plus"></i> REGISTRAR ACONTECIMENTO</a>
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

        @foreach ($email_messages as $email)

            @if ( $email->type == 2 )
                @include( 'consultas_tecnicas.timeline.timeline_retorno' )
            @elseif ( $email->type == 1 )
                @include( 'consultas_tecnicas.timeline.timeline_envio' )
            @else
                @include( 'consultas_tecnicas.timeline.timeline_evento' )
            @endif

        @endforeach

    </ul>