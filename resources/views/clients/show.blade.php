@extends('templates.default')

@section('content')

<section class="panel">
	<header class="panel-heading">
		<div class="pull-right">
			{!! Form::open(array('url' => 'clientes/'.$client->id , 'method'  => 'delete' )) !!}
				{{-- <a href="{!! url('/clientes') !!}" class="btn btn-default btn-xs">
					<i class="fa fa-bars"></i> Ver todos
				</a> --}}
				<a href="{!! url( '/clientes/'.$client->id.'/edit') !!}" class="btn btn-default btn-xs">
					<i class="fa fa-pencil"></i> Editar
				</a>
				<a href="mailto:{!!	$client->email !!}" class="btn btn-default btn-xs" title="Enviar e-mail para {!! $client->title !!}">
					<i class="fa fa-envelope"></i> E-mail
				</a>
				<button class="btn btn-danger btn-xs" type="submit" onclick="return confirm('Excluir permanentemente esta obra?');"><i class="fa fa-trash-o"></i> EXCLUIR</button>
				{!! Form::close() !!}
			</div>
			Cliente <strong>#{!! $client->id !!}</strong>
		</header>
		<div class="panel-body">

			<div class="">
				<h4><strong>{!! $client->name !!}</strong><br><small>{!! $client->company !!}</small></h4>
				&nbsp;
			</div>

			<div role="tabpanel">
				<!-- Nav tabs -->
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active">
						<a href="#resumo" aria-controls="resumo" role="tab" data-toggle="tab">Resumo</a>
					</li>
					<li role="presentation" class="">
						<a href="#obras" aria-controls="obras" role="tab" data-toggle="tab">Obras</a>
					</li>
					<li role="presentation" class="">
						<a href="#contatos" aria-controls="contatos" role="tab" data-toggle="tab">Contatos</a>
					</li>
				</ul>

				<!-- Tab panes -->
				<div class="tab-content">

					<!-- RESUMO -->
					<div role="tabpanel" class="tab-pane active" id="resumo">

						&nbsp;

						{!! Form::open(array('url' => 'clientes/'.$client->id, 'class'=>"form-horizontal", 'method'=>'PATCH' )) !!}
						<div class="form-group">
							<label for="inputName" class="col-lg-2 col-sm-2 control-label">Nome</label>
							<div class="col-lg-10">
								<p class="form-control-static h4">{!! $client->name !!}</p>
							</div>
						</div>
						<div class="form-group">
							<label for="inputresponsavel" class="col-lg-2 col-sm-2 control-label">Responsável</label>
							<div class="col-lg-10">
								<p class="form-control-static">{!! $client->responsavel !!}</p>
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail" class="col-lg-2 col-sm-2 control-label">E-mails</label>
							<div class="col-lg-10">
								<p class="form-control-static"><a href="mailto:{!! $client->email !!}">{!! $client->email !!}</a>
								@if($client->email2)
									<br/><a href="mailto:{!! $client->email2 !!}">{!! $client->email2 !!}</a>
								@endif
								</p>
							</div>
						</div>
						<div class="form-group">
							<label for="inputPhones" class="col-lg-2 col-sm-2 control-label">Telefones</label>
							<div class="col-lg-10">
								<p class="form-control-static">{!! $client->phones !!}</p>
							</div>
						</div>
						<div class="form-group">
							<label for="inputCompany" class="col-lg-2 col-sm-2 control-label">Empresa</label>
							<div class="col-lg-10">
								<p class="form-control-static">{!! $client->company !!}</p>
							</div>
						</div>
						<div class="form-group">
							<label for="inputAddress" class="col-lg-2 col-sm-2 control-label">Endereço</label>
							<div class="col-lg-10">
								<p class="form-control-static">{!! $client->address !!}</p>
							</div>
						</div>
						<div class="form-group">
							<label for="inputcep" class="col-lg-2 col-sm-2 control-label">CEP</label>
							<div class="col-lg-10">
								<p class="form-control-static">{!! $client->cep !!}</p>
							</div>
						</div>
						<div class="form-group">
							<label for="inputobs" class="col-lg-2 col-sm-2 control-label">Obeservações</label>
							<div class="col-lg-10">
								<p class="form-control-static">{!!  $client->obs !!}</p>
							</div>
						</div>
						{!! Form::close() !!}

					</div>

					<!-- OBRAS -->
					<div role="tabpanel" class="tab-pane" id="obras">

						<div class="row">
							<div class="col-md-6">

							</div>
							<div class="col-sm-6 text-right">
								<a href="{!! url('clientes/'.$client->id.'/obras/create') !!}" class="btn btn-success btn-xs navbar-btn"><i class="fa fa-plus"></i> ADICIONAR</a>
							</div>
						</div>

						@include('projects.index-table', ['projects'=>$client->projects, 'client_id'=>$client->id] )

					</div>

					<!-- CONTATOS -->
					<div role="tabpanel" class="tab-pane" id="contatos">

						<div class="navbar">
				        	<div class="navbar-form navbar-right">
								<a href="{{ url('clientes/'.$client->id.'/contatos/create') }}" class="btn btn-xs btn-success" data-toggle="modal" data-target="#modal"><i class="fa fa-plus"></i> ADICIONAR</a>
				     		</div>
				        	<div class="navbar-text navbar-left">

				        	</div>
			        	</div>
			        	<div class="" >

							<table class="table table-hover" id="contacts-list">
								<thead>
									<tr>
										<th width="40">#</th>
										<th>Nome</th>
										<th>Empresa</th>
										<th>E-mail</th>
										<th>Telefones</th>
										<th></th>
									</tr>
								</thead>
								<tbody>

									@foreach ($client->contacts as $clientcontact)

										<tr title="" >
											<td><a href="{{ url( '/contatos/'.$clientcontact->id) }}">{{ $clientcontact->id }}</a></td>
											<td><a href="{{ url( '/contatos/'.$clientcontact->id) }}">{{ $clientcontact->name }}</a></td>
											<td>{{ $clientcontact->company }}</td>
											<td><a href="mailto:{{ $clientcontact->email }}">{{ $clientcontact->email }}</a></td>
											<td>{{ $clientcontact->phones }}</td>
											<td>
												<div class="pull-right hidden-phone">

													{!! Form::open(array('url' => url('contatos/'.$clientcontact->id ), 'role' => 'form', 'method' => 'delete' )) !!}

														<input type="hidden" name="_method" value="delete">

														<input type="hidden" name="back_to" value="{{ url('clientes/'.$client->id.'#contatos' ) }}">

														<a href="{{ url( 'contatos/'.$clientcontact->id.'/edit') }}" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modal"><i class="fa fa-pencil"></i></a>
								                        <button class="btn btn-default btn-xs" type="submit" onclick="return confirm('Exluir este contato permanentemente?');"><i class="fa fa-times"></i></button>

													{!! Form::close() !!}

								             	</div>
											</td>
										</tr>

									@endforeach
								</tbody>
							</table>

			        	</div>

					</div>

				</div>
			</div>

		</div>
	</section>
	@stop
