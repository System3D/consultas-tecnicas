{!! Form::open(array('url' => 'obras/disciplinas/'.$projectdiscipline->id, 'class'=>"form-horizontal", 'method' => 'PATCH' )) !!}

	<input type="hidden" name="project_id" id="" class="form-control" value="{{ $projectdiscipline->project_id }}">
	
	<div class="form-group">
		<label for="inputCompany" class="col-lg-2 col-sm-2 control-label">Obra</label>
		<div class="col-lg-10">
			
			@if ( $projectdiscipline->project )
				<p class="form-control-static">{{ $projectdiscipline->project->title }}   <small classs="text-muted">de <i>{{ $projectdiscipline->project->client->name }} / {{ $projectdiscipline->project->client->company }}</i></small></p>
				<input type="hidden" name="projectdiscipline_id" id="inputProjectDiscipline_id" class="form-control" value="{{ $projectdiscipline->project->id }}">
			@else
				<select name="projectdiscipline_id" id="inputProjectDiscipline_id" class="form-control" {{  ( $projectdiscipline->project->id >= 1 ) ? 'disabled' : '' }}>
					<option value="">-- Selecione uma Obra --</option>
					@foreach ($projectdiscipline->projects as $p)
						<option value="{{ $p->id }}">{{ $p->name }}</option>
					@endforeach						
				</select>					
			@endif
		</div>
	</div>			

	<div class="form-group">
		<label for="inputName" class="col-lg-2 col-sm-2 control-label">Título</label>
		<div class="col-lg-10">
			<input type="text" name="title" class="form-control" id="inputName" placeholder="Título" value="{!! $projectdiscipline->title !!}" required="required">
		</div>
	</div>
	
	<div class="form-group">
		<label for="inputNotes" class="col-lg-2 col-sm-2 control-label">Descrição</label>
		<div class="col-lg-10">
			<textarea name="description" class="form-control" id="inputNotes">{!! $projectdiscipline->description !!}</textarea>
		</div>
	</div>

	<div class="form-group">
		<div class="col-lg-offset-2 col-lg-10">
			<button type="submit" class="btn btn-success">Salvar</button>
		</div>
	</div>

{!! Form::close() !!}  