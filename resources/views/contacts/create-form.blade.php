{!! Form::open(array('url' => 'contatos', 'class'=>"form-horizontal")) !!}

	<input type="hidden" name="client_id" id="input" class="form-control" value="{!! old('client_id', ( isset($client_id) ) ? $client_id : null ) !!}"> 

	<div class="form-group">
		<label for="inputName" class="col-lg-2 col-sm-2 control-label">Nome</label>
		<div class="col-lg-10">
			<input type="text" name="name" class="form-control" id="inputName" placeholder="Nome" value="{!! old('name') !!}" required="required">
		</div>
	</div>
	<div class="form-group">
		<label for="inputEmail" class="col-lg-2 col-sm-2 control-label">E-mail</label>
		<div class="col-lg-10">
			<input type="email" name="email" class="form-control" id="inputEmail" placeholder="E-mail" value="{!! old('email') !!}" required="required">
		</div>
	</div>
	<div class="form-group">
		<label for="inputPhones" class="col-lg-2 col-sm-2 control-label">Telefones</label>
		<div class="col-lg-10">
			<input type="tel" name="phones" class="form-control" id="inputPhones" placeholder="Telefone" value="{!! old('phones') !!}">
		</div>
	</div>
	<div class="form-group">
		<label for="inputPhones2" class="col-lg-2 col-sm-2 control-label"></label>
		<div class="col-lg-10">
			<input type="tel" name="phones2" class="form-control" id="inputPhones2" placeholder="Telefone adicional" value="{!! old('phones2') !!}">
		</div>
	</div>
	<div class="form-group">
		<label for="inputPhones3" class="col-lg-2 col-sm-2 control-label"></label>
		<div class="col-lg-10">
			<input type="tel" name="phones3" class="form-control" id="inputPhones3" placeholder="Telefone adicional" value="{!! old('phones3') !!}">
		</div>
	</div>
	<div class="form-group">
		<label for="inputSkype" class="col-lg-2 col-sm-2 control-label">Skype</label>
		<div class="col-lg-10">
			<input type="tel" name="skype" class="form-control" id="inputSkype" placeholder="Skype" value="{!! old('skype') !!}">
		</div>
	</div>
	<div class="form-group">
		<label for="inputCompany" class="col-lg-2 col-sm-2 control-label">Empresa</label>
		<div class="col-lg-10">
			<input type="text" name="company" class="form-control" id="inputCompany" placeholder="Empresa" value="{!! old('company') !!}">
		</div>
	</div>	
	<div class="form-group">
		<label for="inputAddress" class="col-lg-2 col-sm-2 control-label">Endereço</label>
		<div class="col-lg-10">
			<input type="text" name="address" class="form-control" id="inputAddress" placeholder="Endereço" value="{!! old('address') !!}">
		</div>
	</div>	
	<div class="form-group">
		<label for="inputNotes" class="col-lg-2 col-sm-2 control-label">Obeservações</label>
		<div class="col-lg-10">
			<textarea name="notes" class="form-control" id="inputNotes">{!! old('notes') !!}</textarea>
		</div>
	</div>	

	<hr>
	
	<div class="form-group <?php echo (@$client_id > 0)?'hidden':'' ?>">
		<label for="client" class="col-sm-2 control-label">Cliente:</label>
		<div class="col-sm-10">
			<div class="input-group">
				<select name="client_id" id="client" class="form-control remoteload" required="required" data-target="#project">			
					@foreach($request->user()->clients as $client)
						<option value="{{ $client->id }}" <?php	echo (@$client_id == $client->id)?'selected':'' ?> >{{ $client->name }} / {{ $client->company }}</option>
					@endforeach								
				</select>
				<span class="input-group-btn">
					<a href="{{ url('clientes/create') }}" class="btn btn-default" data-target="#modal" data-toggle="modal"><i class="fa fa-plus"></i></a>
				</span>
			</div><!-- /input-group -->
		</div>
	</div>	

	<div class="form-group">
		<div class="col-lg-offset-2 col-lg-10">
			<button type="submit" class="btn btn-success">Salvar</button>
		</div>
	</div>

	

{!! Form::close() !!}  