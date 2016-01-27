{!! Form::open(array('url' => 'obras/'.$project->id, 'class'=>"form-horizontal", 'method'=>'PATCH' )) !!}

	<div class="form-group">
		<label for="inputName" class="col-lg-2 col-sm-2 control-label">Título</label>
		<div class="col-lg-10">
			<input type="text" name="title" class="form-control" id="inputName" placeholder="Título" value="{!! $project->title or old('title') !!}" required="required">
		</div>
	</div>

	<div class="form-group">
		<label for="inputDescription" class="col-lg-2 col-sm-2 control-label">Descrição</label>
		<div class="col-lg-10">
			<textarea name="description" class="form-control" id="inputDescription">{!!  $project->description or old('description') !!}</textarea>
		</div>
	</div>

	<div class="form-group">
		<label for="inputCompany" class="col-lg-2 col-sm-2 control-label">Cliente</label>
		<div class="col-lg-10">
			<select name="client_id" id="inputStatus" class="form-control">
				<option value="">-- Selecione --</option>
				@foreach ($clients as $client)
					<option value="{{ $client->id }}" {{ ( $client->id == $project->client_id )? 'selected' : '' }} >{{ $client->name }}</option>
				@endforeach
			</select>
		</div>
	</div>

	<div class="form-group">
		<div class="col-lg-offset-2 col-lg-10">
			<button type="submit" class="btn btn-success">Salvar</button>
		</div>
	</div>

{!! Form::close() !!}