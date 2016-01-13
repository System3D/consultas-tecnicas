{!! Form::open(array('url' => url('consultas_tecnicas'), 'method' => 'POST', 'class' => "form-horizontal", 'role' => "form", 'id'=>'technical_consults_create')) !!}

<legend>Consulta Técnica</legend>

<div class="form-group">
	<label class="col-lg-2 control-label" for="uname">Tipo: </label>
	<div class="col-lg-6">
		<div class="radio">
			<label>
				<input type="radio" name="email_message[type]" value="1" checked="checked">
				Envio 
			</label>
			&nbsp;
			<label>
				<input type="radio" name="email_message[type]" value="2">
				Retorno 
			</label>
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
	<div class="col-sm-10">
		<div class="input-group">
			<select name="technical_consult[client_id]" id="technical_consult_client" class="form-control remoteload" required="required" data-target="#technical_consult_project">			
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
	<div class="col-sm-10">
		<div class="input-group">
			<select name="technical_consult[contact_id]" id="technical_consult_contact" class="form-control" required="required">
				<option value=""></option>
			</select>
			<span class="input-group-btn">
				<a href="{{ url('contatos/create') }}" class="btn btn-default" data-target="#modal" data-toggle="modal"><i class="fa fa-plus"></i></a>
			</span>
		</div>
	</div>
</div>

<legend>Obra</legend>

<div class="form-group technical_consult_project" style="display:none;">
	<label for="technical_consult_project" class="col-sm-2 control-label">Obra:</label>
	<div class="col-sm-10">
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
	<div class="col-sm-10">
		<select name="technical_consult[project_stage_id]" id="technical_consult_project_stage" class="form-control" required="required">
			<option value="">--</option>
		</select>

	</div>
</div>

<div class="form-group technical_consult_project_discipline" style="display:none;">
	<label for="technical_consult_project_discipline" class="col-sm-2 control-label">Disciplina:</label>
	<div class="col-sm-10">
		<select name="technical_consult[project_discipline_id]" id="technical_consult_project_discipline" class="form-control" required="required">
			<option value="">--</option>
		</select>

	</div>
</div>

<hr>

<div class="form-group">
	<label for="input" class="col-sm-2 control-label">Assunto:</label>
	<div class="col-sm-10">
		<input type="text" name="technical_consult[title]" id="input" class="form-control" value="" required="required" title="">
	</div>
</div>

<div class="form-group">
	<label for="input" class="col-sm-2 control-label">Descrição:</label>
	<div class="col-sm-10">
		<textarea name="technical_consult[description]" id="input" class="form-control wysihtml5" rows="5"></textarea>
	</div>
</div>

<div class="form-group">
	<label for="input" class="col-sm-2 control-label">Classificação</label>
	<div class="col-sm-10">
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

<div class="form-group">
	<div class="col-sm-10 col-sm-offset-2">
		<button type="submit" class="btn btn-primary">Salvar</button>
	</div>
</div>
{!! Form::close() !!}

{!! Form::open(['url' => url('upload'), 'method' => 'POST', 'class' => "form-horizontal", 'role' => "form", 'id'=>'uploadFile']) !!}
	<div class="row">
		<label class="col-lg-2 control-label" for="fileInput">Arquivos: </label>
		<div class="col-lg-6">
			<div class="form-group">			
				<input type="file" class="form-control" id="fileInput" name="file[]" placeholder="Input field" multiple>
			</div>
		</div>
		<div class="col-lg-4">
			<button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Upload</button>
		</div>
	</div>
{!! Form::close() !!}

<script>
	var form 	= document.getElementById('uploadFile');
	var request = new XMLHttpRequest();

	form.addEventListener('submit',function (e) {
		e.preventDefault();
		var formdata = new FormData( form );
		request.open('post', '/upload');
		request.addEventListener('load', transferComplete);
		request.send( formdata );
	})

	var transferComplete = function ( data ){
		response = JSON.parse( data.currentTarget.response );
		if( response.success ){
			alert( 'Uploaded \o/' );
		}
		console.log( data.currentTarget.response );
	}
</script>