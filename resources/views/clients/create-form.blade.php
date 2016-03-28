{!! Form::open(array('url' => 'clientes', 'class'=>"form-horizontal" )) !!}
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
		<label for="inputEmail2" class="col-lg-2 col-sm-2 control-label"></label>
		<div class="col-lg-10">
			<input type="email" name="email2" class="form-control" id="inputEmail2" placeholder="E-mail adicional" value="{!! old('email2') !!}">
		</div>
	</div>
	<div class="form-group">
		<label for="inputresponsavel" class="col-lg-2 col-sm-2 control-label">Responsável</label>
		<div class="col-lg-10">
			<input type="text" name="responsavel" class="form-control" id="inputresponsavel" placeholder="Responsável" value="{!! old('responsavel') !!}">
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
		<label for="inputcep" class="col-lg-2 col-sm-2 control-label">CEP</label>
		<div class="col-lg-10">
			<input type="text" name="cep" class="form-control" id="inputcep" placeholder="CEP" value="{!! old('cep') !!}">
		</div>
	</div>
	<div class="form-group">
		<label for="inputobs" class="col-lg-2 col-sm-2 control-label">Obeservações</label>
		<div class="col-lg-10">
			<textarea name="obs" class="form-control" id="inputobs">{!! old('obs') !!}</textarea>
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-offset-2 col-lg-10">
			<button type="submit" class="btn btn-success">Salvar</button>
		</div>
	</div>

{!! Form::close() !!}