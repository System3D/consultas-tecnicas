@extends('templates.default')

@section('content')

<section class="panel" style="max-width:720px;">
	<header class="panel-heading">
		<div class="pull-right">
			<i class="fa fa-refresh fa-spin loading hidden"></i>
		</div>
		Registrar Retorno {{ @$inputdata['title'] }}
	</header>
	<div class="panel-body">

		{!! Form::open(array('url' => url('consultas-tecnicas'), 'method' => 'POST', 'class' => "form-horizontal", 'role' => "form", 'id'=>'technical_consults_create', "enctype"=>"multipart/form-data")) !!}

				<input type="hidden" name="technical_consult[id]" value="{{ $consultatecnica->id }}">
				<input type="hidden" name="email_message[project_id]" value="{{ $obra->id }}">
				<input type="hidden" name="email_message[email_message_id]" value="{{ $inputdata['email_message_id'] }}">
				<input type="hidden" name="technical_consult[project_stage_id]" value="{{old('project_stage_id', $etapa->id) }}">
				<input type="hidden" name="technical_consult[project_discipline_id]" value="{{ old('project_discipline_id', @$disciplina->id) }}">
				<input type="hidden" name="email_message[type]" value="2">

				<div class="form-horizontal">

					<div class="form-group">
						<label for="input" class="col-sm-2">Consulta Técnica:</label>
						<div class="col-sm-10">
							<input type="text" name="technical_consult[consulta]" id="" class="form-control disabled readonly" value="{{ @$inputdata['title'] }}" required="required" title="" disabled>
						</div>
					</div>

<!-- 					<div class="form-group">
						<label for="input" class="col-sm-2">Obra:</label>
						<div class="col-sm-10">
							<input type="text" name="technical_consult[project]" id="" class="form-control disabled readonly" value="{{ $obra->title }}" required="required" title="" disabled>
						</div>
					</div>

					<div class="form-group">
						<label for="input" class="col-sm-2">Etapa:</label>
						<div class="col-sm-4">
							{!! Form::select('technical_consult[project_stage_id]', $inputdata['etapas'], old('disciplina', $etapa->id), ["class"=>"form-control disabled readonly","disabled","title"=>"Informe a etapa"]) !!}
						</div>
						<label for="input" class="col-sm-2">Disciplina:</label>
						<div class="col-sm-4">
							{!! Form::select('technical_consult[project_discipline_id]', $inputdata['disciplinas'], old('disciplina', @$disciplina->id), ["class"=>"form-control disabled readonly","disabled","title"=>"Informe a disciplina"]) !!}
						</div>
					</div>
 -->
					<div class="form-group">
						<label for="input" class="col-sm-2">Assunto:</label>
						<div class="col-sm-10">
							<input type="text" name="technical_consult[title]" id="" class="form-control disabled" value="{{ $inputdata['assunto'] }}" required="required" title="" disabled>
						</div>
					</div>
					<!-- <div class="form-group">
						<label for="" class="col-sm-2">Destinatários:</label>
						<div class="col-sm-10">
							{!! Form::select('email_message[to][]', $inputdata['contatos'], old('contatos'), ["class"=>"form-control selectpicker","required"=>"required","multiple","title"=>"Escolha os contatos"]) !!}

						</div>
					</div>
 -->
					<div class="form-group">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<textarea name="email_message[description]" id="" class="form-control tinymce" rows="4"></textarea>
						</div>
					</div>

					<div class="form-group anexos">
					    <label class="col-lg-2 control-label" for="">Anexos: </label>
					    <div class="col-lg-10">
					   		<ul class="list-group">
					   			@if (count($inputdata['anexos']))
						    		@foreach ($inputdata['anexos'] as $file)
									<li title="{{ $file->notes }}" class="list-group-item">
										<i class="fa fa-{{ $file->icon() }} text-muted"></i>
										{{ $file->original_filename }}
							                <a href="{{ route('downloadfile', $file->original_filename) }}" class="btn btn-default btn-xs pull-right"><i class="fa fa-download"></i></a>
										</td>
									</li>
									@endforeach
					   			@else
					   				<p class="form-control-static text-muted"><i class="fa fa-warning"></i> Sem anexos</p>
					   			@endif
							</ul>
					   	</div>
					</div>

					<div class="form-group">
				        <label for="email_message_date" class="col-sm-2 control-label">Data:</label>
				        <div class="col-sm-10">
				            <div class="row">
				                <div class="col-md-4">
			                		<input type="date" name="email_message[date]" id="email_message_date" value="{{ date('Y-m-d') }}" class="form-control">
				                </div>
				                <!-- <label for="email_message_time" class="col-sm-2 control-label">Hora:</label> -->
				                <div class="col-md-4">
			                		<input type="time" name="email_message[time]" id="email_message_time" value="{{ date('H:i') }}" class="form-control">
				                </div>
				            </div>
				        </div>
				    </div>

					<div class="form-group">
						<label class="col-lg-2 control-label" for="">Classificação: </label>
						<div class="col-sm-10">
							<input type="radio" name="email_message[rating]" value="3" class="" checked="checked">  Bom
							<br>
							<input type="radio" name="email_message[rating]" value="2" class="">  Regular
							<br>
							<input type="radio" name="email_message[rating]" value="1" class="">  Insatisfatório
						</div>
					</div>
					<hr>
					<div class="form-group">
						<div class="col-sm-10 col-sm-offset-2">
							<button type="submit" class="btn btn-success btn-brick"><i class="fa fa-save"></i> Salvar</button>
						</div>
					</div>

			</div>
		{!! Form::close() !!}

	</div>
</section>
@stop