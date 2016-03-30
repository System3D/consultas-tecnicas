{!! Form::open(array('url' => url('consultas_tecnicas'), 'method' => 'POST', 'class' => "form-horizontal", 'role' => "form", 'id'=>'technical_consults_create', "enctype"=>"multipart/form-data")) !!}

<input type="hidden" name="technical_consult_id" value="<?php echo @$data['technical_consult'] ?>">
<input type="hidden" name="email_message_id" value="<?php echo @$data['email_message_id'] ?>">

@if ( @$data['technical_consult'] )
    <legend>Consulta Técnica CT0{{ @$data['technical_consult'] }}</legend>
@else
    <legend>Consulta Técnica</legend>
@endif

<div class="form-group">
	<label class="col-lg-2 control-label" for="uname">Tipo: </label>
	<div class="col-lg-6">
		<div class="radio" id="email_message_type">

            @if ( !@$data['technical_consult'] )
                <label>
                    <input type="radio" name="email_message[type]" value="1" checked="checked">
                    Envio
                </label>
    			&nbsp;
            @else

    			<label>
    				<input type="radio" name="email_message[type]" value="2" checked="{{ ( isset($data['email_message']) )?'checked':'' }}">
    				Retorno
    			</label>
            @endif
			&nbsp;
			<label>
				<input type="radio" name="email_message[type]" value="0">
				Acontecimento
			</label>
		</div>
	</div>
</div>

<div class="form-group technical_consult_client">
	<label for="technical_consult_client" class="col-sm-2 control-label">Cliente:</label>
	<div class="col-sm-5">
		<div class="input-group">
			<select name="technical_consult[cliente_id]" id="technical_consult_client" class="form-control remoteload" required="required" data-target="#technical_consult_project">
				@foreach($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->name }} / {{ $client->company }}</option>
                @endforeach
            </select>
            <span class="input-group-btn">
                <a href="{{ url('clientes/create') }}" class="btn btn-default" data-target="#modal" data-toggle="modal"><i class="fa fa-plus"></i></a>
        </span>
    </div><!-- /input-group -->
</div>
</div>

<div class="form-group technical_consult_contact" style="display:none;">
	<label for="technical_consult_contact" class="col-sm-2 control-label">Contato:</label>
	<div class="col-sm-5">
        <div class="input-group">
            <select name="technical_consult[contact_id]" id="technical_consult_contact" class="form-control" required="required">
                <option value=""></option>
            </select>
            <span class="input-group-btn">
                <a href="{{ url('contatos/create') }}" class="btn btn-default" data-target="#modal" data-toggle="modal"><i class="fa fa-plus"></i></a>
            </span>
        </div>
    </div>
    <div class="col-sm-5">
		<div class="input-group">
			<p class="form-control-static" id="contact_email"></p>
		</div>
	</div>
</div>

<legend>Projeto</legend>

<div class="form-group technical_consult_project" style="display:none;">
	<label for="technical_consult_project" class="col-sm-2 control-label">Projeto:</label>
	<div class="col-sm-5">
		<div class="input-group">
			<select name="technical_consult[project_id]" id="technical_consult_project" class="form-control" required="required">
				<option value="">--</option>
			</select>
			<span class="input-group-btn">
				<a href="{{ url('obras/create') }}" class="btn btn-default" data-target="#modal" data-toggle="modal"><i class="fa fa-plus"></i></a>
			</span>
		</div>
	</div>
</div>

<div class="form-group technical_consult_project_stage" style="display:none;">
	<label for="technical_consult_project_stage" class="col-sm-2 control-label">Etapa:</label>
	<div class="col-sm-5">
		<select name="technical_consult[project_stage_id]" id="technical_consult_project_stage" class="form-control" required="required">
			<option value="">--</option>
		</select>
	</div>
</div>

<div class="form-group technical_consult_project_discipline" style="display:none;">
	<label for="technical_consult_project_discipline" class="col-sm-2 control-label">Disciplina:</label>
	<div class="col-sm-5">
		<select name="technical_consult[project_discipline_id]" id="technical_consult_project_discipline" class="form-control" required="required">
			<option value="">--</option>
		</select>

	</div>
</div>

<hr>

<div class="form-group">
	<label for="input" class="col-sm-2 control-label">Assunto:</label>
	<div class="col-sm-5">
		<input type="text" name="technical_consult[title]" id="input" class="form-control" value="" required="required" title="">
	</div>
</div>

<div class="form-group">
	<label for="input" class="col-sm-2 control-label">Descrição:</label>
	<div class="col-sm-5">
		<textarea name="technical_consult[description]" id="input" class="form-control" rows="5"></textarea>
	</div>
</div>


<div id="email_message_date">

<legend>Dados adicionais</legend>

    <div class="form-group">
    	<label for="input" class="col-sm-2 control-label">Classificação</label>
    	<div class="col-sm-5">
    		<div class="radio">
    			<label>
    				<input type="radio" name="email_message[rating]" id="input" value="1" checked="checked"> Insuficiente
    			</label>
    			&nbsp;
    			<label>
    				<input type="radio" name="email_message[rating]" id="input" value="2"> Regular
    			</label>
    			&nbsp;
    			<label>
    				<input type="radio" name="email_message[rating]" id="input" value="3"> Satisfatório
    			</label>
    		</div>
    	</div>
    </div>

    <div class="form-group technical_consult_time">
        <label for="email_message_date" class="col-sm-2 control-label">Data:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input type="date" name="email_message[date]" id="email_message_date" class="form-control">
            </div>
        </div>
    </div>

    <div class="form-group email_message_time">
        <label for="email_message_time" class="col-sm-2 control-label">Hora:</label>
        <div class="col-sm-5">
            <div class="input-group">
                <input type="time" name="email_message[time]" id="email_message_time" class="form-control">
            </div>
        </div>
    </div>
</div>


<div class="row">
    <label class="col-lg-2 control-label" for="">Anexos: </label>
    <div class="col-lg-6">
        <div class="input-group">
            <input type="file" class="form-control" id="" name="file[]" placeholder="Input field" multiple>
        </div>
    </div>
</div>

&nbsp;

<div class="row">
    <label for="email_message_time" class="col-sm-2 control-label">&nbsp;</label>
    <div class="col-sm-5">

        <button type="submit" class="btn btn-primary btn-block">Salvar</button>

    </div>
</div>


    {!! Form::close() !!}


    @section('footer-scripts')
    <script>
    var buildCreateTechnicalConsultForm = function(){

        var loadClients = function(){
			// console.log( urlbase );
            /* Act on the event */
            $.ajax({
                url: urlbase+'/api/clients',
                type: 'GET',
                dataType: 'json',
                data: '',
                beforeSend: function() {

                    $('.technical_consult_client').slideUp();
                    $('.technical_consult_contact').slideUp();
                    $('.technical_consult_project').slideUp();
                    $('.technical_consult_project_stage').slideUp();
                    $('.technical_consult_project_discipline').slideUp();

                    $('#technical_consult_client').html('');
                    $('#technical_consult_contact').html('');
                    $('#technical_consult_project').html('');
                    $('#technical_consult_project_stage').html('');
                    $('#technical_consult_project_discipline').html('');

                    $('.loading.hidden').removeClass('hidden');
                }
            })
            .done(function( data ) {
                $.each(data, function(index, val) {
                    selected = ( cliente_id == val.id ) ? 'selected' : '';
                    $('#technical_consult_client').append('<option value="'+val.id+'" '+selected+'>'+val.name+'</option>');
                });
                $('.technical_consult_client').slideDown();
                $('.loading').addClass('hidden');
                loadContacts( $('#technical_consult_client').val() );
                loadProjects( $('#technical_consult_client').val() );
            })
            .fail(function() {
                $('#technical_consult_client').html('<option value="">Erro ao carregar clientes</option>');
            });
        };



        var loadContacts = function(client_id){
            /* Act on the event */
            $.ajax({
                url: urlbase+'/api/clients/'+client_id+'/contacts',
                type: 'GET',
                dataType: 'json',
                data: '',
                beforeSend: function() {

                    $('.technical_consult_contact').slideUp();
                    $('#technical_consult_contact').html('');

                    $('.loading.hidden').removeClass('hidden');
                }
            })
            .done(function( data ) {
                $.each(data, function(index, val) {
                    $('#technical_consult_contact').append('<option value="'+val.id+'">'+val.name+'</option>');
                });
                $('.technical_consult_contact').slideDown();
                $('.loading').addClass('hidden');

                showemail();

            })
            .fail(function() {
                $('#technical_consult_contact').html('<option value="">Erro ao carregar contatos</option>');
            });
        };


        var loadProjects = function( client_id ){
            /* Act on the event */
            $.ajax({
                url: urlbase+'/api/clients/' + client_id + '/projects',
                type: 'GET',
                dataType: 'json',
                data: '',
                beforeSend: function() {
                    $('.technical_consult_project').slideUp();
                    $('.technical_consult_project_stage').slideUp();
                    $('.technical_consult_project_discipline').slideUp();

                    $('#technical_consult_project').html('');
                    $('#technical_consult_project_stage').html('');
                    $('#technical_consult_project_discipline').html('');

                    $('.loading.hidden').removeClass('hidden');
                }
            })
            .done(function( data ) {

                obra_id;
                var selected;
                console.log( obra_id );

                $.each(data, function(index, val) {
                    selected = ( obra_id == val.id ) ? 'selected' : '';
                    $('#technical_consult_project').append('<option value="'+val.id+'" '+selected+'>'+val.title+'</option>');
                });

                $('.technical_consult_project').slideDown();

                loadProjectStages( $('#technical_consult_client').val(), $('#technical_consult_project').val() );
                loadProjectDisciplines( $('#technical_consult_client').val(), $('#technical_consult_project').val() );

                $('.loading').addClass('hidden');

            })
            .fail(function() {
                $('#technical_consult_project').html('<option value="">Erro ao carregar projetos</option>');
            });
        };



        var loadProjectStages = function( client_id, project_id ){
            /* Act on the event */
            $.ajax({
                url: urlbase+'/api/clients/' + client_id + '/projects/' + project_id + '/stages',
                type: 'GET',
                dataType: 'json',
                data: '',
                beforeSend: function() {
                    $('.technical_consult_project_stage').slideUp();
                    $('#technical_consult_project_stage').html('');
                    $('.loading.hidden').removeClass('hidden');
                }
            })
            .done(function( data ) {

                $.each(data, function(index, val) {
                    $('#technical_consult_project_stage').append('<option value="'+val.id+'">'+val.title+'</option>');
                });

                $('.technical_consult_project_stage').slideDown();

                $('.loading').addClass('hidden');
            })
            .fail(function() {
                $('#technical_consult_project_stage').html('<option value="">Erro ao carregar etapas do projeto</option>');
            });

        };


        var loadProjectDisciplines = function( client_id, project_id ){
            /* Act on the event */
            $.ajax({
                url: urlbase+'/api/clients/' + client_id + '/projects/' + project_id + '/disciplines',
                type: 'GET',
                dataType: 'json',
                data: '',
                beforeSend: function() {
                    $('.technical_consult_project_discipline').slideUp();
                    $('#technical_consult_project_discipline').html('');
                    $('.loading.hidden').removeClass('hidden');
                }
            })
            .done(function( data ) {

                $.each(data, function(index, val) {
                    $('#technical_consult_project_discipline').append('<option value="'+val.id+'">'+val.title+'</option>');
                });
                $('#technical_consult_project_discipline').append('<option>-- Nenhuma --</option>');

                $('.technical_consult_project_discipline').slideDown();

                $('.loading').addClass('hidden');
            })
            .fail(function() {
                $('#technical_consult_project_discipline').html('<option value="">Erro ao carregar disciplinas do projeto</option>');
            });
        };

        $('#technical_consult_client').change(function(event) {
            loadProjects( $(this).val() );
            loadContacts( $(this).val() );
        });
        $('#technical_consult_project').change(function(event) {
            loadProjectStages( $('#technical_consult_client').val(), $(this).val() );
            loadProjectDisciplines( $('#technical_consult_client').val(), $(this).val() );
        });
        loadClients();

        // loadContacts( $('#technical_consult_client').val() );
        $('#email_message_date').hide();

    };

    buildCreateTechnicalConsultForm();


    $('#technical_consults_create').change(function(event) {
        var type = $('#email_message_type input:checked').val();

        if( type == 2 || type == 0 ){
            $('#email_message_date').show();
        }else{
            $('#email_message_date').hide();
        }

        showemail();

    });

    var showemail = function () {
        var client = $('#technical_consult_client option:selected').val();
        var contact = $('#technical_consult_contact option:selected').val();
        $.ajax({
            // url: urlbase+'//api/clients/',
            url: urlbase+'/api/clients/'+client+'/contacts/'+contact,
            type: 'GET',
            dataType: 'json',
            data: '',
        })
        .done(function( data ) {
            $('#contact_email').text(data.email);
        });
    }

</script>


@stop