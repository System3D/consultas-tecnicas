{!! Form::open(array('url' => 'obras/etapas/'.$projectstage->id, 'class'=>"form-horizontal", 'method' => 'PATCH' )) !!}

	<input type="hidden" name="project_id" id="" class="form-control" value="{{ $projectstage->project->id }}">

	<div class="form-group">
		<label for="inputCompany" class="col-lg-2 col-sm-2 control-label">Projeto</label>
		<div class="col-lg-10">

			@if ( $projectstage->project )
				<p class="form-control-static">{{ $projectstage->project->title }}   <small classs="text-muted">de <i>{{ $projectstage->project->client->name }} / {{ $projectstage->project->client->company }}</i></small></p>
				<input type="hidden" name="projectstage_id" id="inputProjectStage_id" class="form-control" value="{{ $projectstage->project->id }}">
			@else
				<select name="projectstage_id" id="inputProjectStage_id" class="form-control" {{  ( $projectstage->project->id >= 1 ) ? 'disabled' : '' }}>
					<option value="">-- Selecione um Projeto --</option>
					@foreach ($projectstage->projects as $p)
						<option value="{{ $p->id }}">{{ $p->name }}</option>
					@endforeach
				</select>
			@endif
		</div>
	</div>

	<div class="form-group">
		<label for="inputName" class="col-lg-2 col-sm-2 control-label">Título</label>
		<div class="col-lg-10">
			<input type="text" name="title" class="form-control" id="inputName" placeholder="Título" value="{!! $projectstage->title !!}" required="required">
		</div>
	</div>

	<div class="form-group">
		<label for="inputNotes" class="col-lg-2 col-sm-2 control-label">Descrição</label>
		<div class="col-lg-10">
			<textarea name="description" class="form-control" id="inputNotes">{!! $projectstage->description !!}</textarea>
		</div>
	</div>

	<div class="form-group">
		<div class="col-lg-offset-2 col-lg-10">
			<button type="submit" class="btn btn-success">Salvar</button>
		</div>
	</div>

{!! Form::close() !!}