@extends('templates.default')

@section('content')

<section class="panel" style="max-width:720px;">
	<header class="panel-heading">
		<div class="pull-right">
			<i class="fa fa-refresh fa-spin loading hidden"></i>
		</div>
		Registrar Acontecimento - OBRA {{ $obra->id }}
	</header>
	<div class="panel-body">
		{!! Form::open(array('url' => url('consultas-tecnicas'), 'method' => 'POST', 'class' => "form-horizontal", 'role' => "form", 'id'=>'technical_consults_create', "enctype"=>"multipart/form-data")) !!}

				<input type="hidden" name="email_message[project_id]" id="inputEmail_message[Project_id]" class="form-control" value="{{ $obra->id }}">
				<input type="hidden" name="technical_consult[project_id]" value="{{ $obra->id }}">
				<input type="hidden" name="email_message[type]" value="0">

				<div class="form-horizontal">

					<div class="form-group">
						<label for="input" class="col-sm-2">Obra:</label>
						<div class="col-sm-10">
							<input type="text" name="technical_consult[project]" id="" class="form-control disabled readonly" value="{{ $obra->title }}" required="required" title="" readonly="readonly" >
						</div>
					</div>

					<div class="form-group">
						<label for="input" class="col-sm-2">Etapa:</label>
						<div class="col-sm-4">
							{!! Form::select('technical_consult[project_stage_id]', $inputdata['etapas'], old('disciplina', @$etapa->id), ["class"=>"form-control selectpicker","required"=>"required","title"=>"Informe a etapa"]) !!}
						</div>
						<label for="input" class="col-sm-2">Disciplina:</label>
						<div class="col-sm-4">
							{!! Form::select('technical_consult[project_discipline_id]', $inputdata['disciplinas'], old('disciplina', @$disciplina->id), ["class"=>"form-control selectpicker","title"=>"Informe a disciplina"]) !!}
						</div>
					</div>

					<div class="form-group">
						<label for="input" class="col-sm-2">Assunto:</label>
						<div class="col-sm-10">
							<input type="text" name="technical_consult[title]" id="" class="form-control" value="" required="required" title="">
						</div>
					</div>

					<div class="form-group" id="contatos">
						<label for="" class="col-sm-2">Destinatários:</label>
						<div class="col-sm-10">
							{!! Form::select('email_message[to][]', $inputdata['contatos'], old('contatos'), ["class"=>"form-control selectpicker","required"=>"required","multiple","title"=>"Escolha os contatos"]) !!}

						</div>
					</div>

					<div class="form-group">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<textarea name="email_message[description]" id="" class="form-control tinymce" rows="4"></textarea>
						</div>
					</div>

					<div class="form-group">
					    <label class="col-lg-2 control-label" for="">Anexos: </label>
					    <div class="col-lg-10">
					    	<input type="file" class="form-control" id="" name="file[]" placeholder="Input field" multiple>
					   	</div>
					</div>

					<div class="form-group">
				        <label for="email_message_date" class="col-sm-2 control-label">Data:</label>
				        <div class="col-sm-10">
				            <div class="row">
				                <div class="col-md-4">
			                		<input type="date" name="email_message[date]" id="email_message_date" value="{{ date('Y-m-d') }}" class="form-control">
				                </div>
				                <div class="col-md-4">
			                		<input type="time" name="email_message[time]" id="email_message_time" value="{{ date('H:i') }}" class="form-control">
				                </div>
				            </div>
				        </div>
				    </div>

					<div class="form-group">
						<div class="col-sm-10 col-sm-offset-2">
							<input type="checkbox" name="sendnow" id="sendnow">  Enviar e-mail ao salvar
						</div>
					</div>

					<div class="form-group" id="sendtome">
						<div class="col-sm-10 col-sm-offset-2">
							<input type="checkbox" name="sendtome" class="">  Receber uma cópia <small class="text-muted">&lt;{{ Auth::user()->email }}&gt; </small>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-10 col-sm-offset-2">
							<button type="submit" class="btn btn-success btn-brick">Salvar</button>
						</div>
					</div>

			</div>
		{!! Form::close() !!}
	</div>
</section>
@stop

@section('footer-scripts')
<script>
	$(document).ready(function($) {
		$('#sendtome').slideUp(150);
		$('#sendnow').change(function(event) {
			if( $(this).is(':checked') ){
				$('#sendtome').slideDown(150);
			}else{
				$('#sendtome').slideUp(150);
			}
		});
	});
</script>
@stop