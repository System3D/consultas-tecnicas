{!! Form::open(array('url' => 'obras/etapas', 'class'=>"form-horizontal" )) !!}

	<div class="form-group">
		<label for="inputCompany" class="col-lg-2 col-sm-2 control-label">Projeto</label>
		<div class="col-lg-10">

			@if ( $project )
				<p class="form-control-static">{{ $project->title }}   <small classs="text-muted">de <i>{{ $project->client->name }} / {{ $project->client->company }}</i></small></p>
				<input type="hidden" name="project_id" id="inputProject_id" class="form-control" value="{{ $project->id }}">
			@else
				<select name="project_id" id="inputProject_id" class="form-control" {{  ( $project->id >= 1 ) ? 'disabled' : '' }}>
					<option value="">-- Selecione um Projeto --</option>
					@foreach ($projects as $p)
						<option value="{{ $p->id }}">{{ $p->name }}</option>
					@endforeach
				</select>
			@endif
		</div>
	</div>

	<div class="form-group">
		<label for="inputName" class="col-lg-2 col-sm-2 control-label">Título</label>
		<div class="col-lg-10">
			<input type="text" name="title" class="form-control" id="inputName" placeholder="Título" value="{!! old('title') !!}" required="required">
		</div>
	</div>

	<div class="form-group">
		<label for="inputNotes" class="col-lg-2 col-sm-2 control-label">Descrição</label>
		<div class="col-lg-10">
			<textarea name="description" class="form-control" id="inputNotes">{!! old('description') !!}</textarea>
		</div>
	</div>

	<div class="form-group">
		<div class="col-lg-offset-2 col-lg-10">
			<button type="submit" class="btn btn-success">Salvar</button>
		</div>
	</div>

{!! Form::close() !!}