@extends('templates.default')

@section('content')

<section class="panel">
	<header class="panel-heading">
		<div class="pull-right">
			<a href="{!! url('/clientes/create') !!}" class="btn btn-success btn-xs" data-target="#modal" data-toggle="modal">
				<i class="fa fa-plus"></i> Adicionar
			</a>
		</div>
		Clientes
	</header>
	<div class="table-responsive">
		<table class="table table-hover" id="clients-list">
			<thead>
				<tr>
					<th width="40">#</th>
					<th>Nome</th>
					<th>Responsável</th>
					<th>Emails</th>
					<th>Obras</th>
					<!-- <th>Price</th> -->
					<th></th>
				</tr>
			</thead>
			<tbody>

				@foreach ($clients as $client)

				<tr title="{{ $client->notes }}">
					<td><a href="{{ url('clientes/'.$client->id) }}">{{	$client->id }}</a></td>
					<td><strong><a href="{{ url('clientes/'.$client->id) }}">{{	$client->name }}</a></strong><br>
						<small>{{	$client->address }}. {{	$client->city }}. CEP {{	$client->cep }}</small>
					</td>
					<td><a href="{{ url('clientes/'.$client->id) }}">{{	$client->responsavel }}</a></td>
					<td><a href="mailto:{{	$client->email }}">{{	$client->email }}</a>
								@if($client->email2)
									<br/><a href="mailto:{!! $client->email2 !!}">{!! $client->email2 !!}</a>
								@endif
								</td>
					<td>{{  count( $client->projects ) }}</td>
					<td>
						<div class="pull-right hidden-phone">
	                        {!! Form::open(array('url' => 'clientes/'.$client->id , 'method'  => 'delete' )) !!}
	                        	<a href="{{ url('clientes/'.$client->id.'/edit') }}" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></a>
								<a href="mailto:{!!	$client->email !!}" class="btn btn-default btn-xs" title="Enviar e-mail para {!! $client->name !!}">
									<i class="fa fa-envelope"></i>
								</a>
		                        <button class="btn btn-default btn-xs" type="submit" onclick="return confirm('Excluir permanentemente este cliente e todas as suas obras?');"><i class="fa fa-times"></i></button>
	                        {!! Form::close() !!}
	                 	</div>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</section>
@stop
