@extends('templates.default')

@section('content')

<section class="panel">
	<header class="panel-heading">
		<div class="pull-right">
			<a href="{!! route('contatos.create') !!}" class="btn btn-default btn-sm btn-xs">
				<i class="fa fa-plus"></i> Adicionar
			</a>
		</div>
		Contatos
	</header>
	<div class="panel-body table-responsive">
		<table class="table table-hover">
			<thead>
				<tr>
					<th>#</th>
					<th>Nome</th>
					<th>E-mail</th>					
					<th>Telefones</th>					
					<th>Cliente</th>
					<th></th>
				</tr>
			</thead>
			<tbody>				
				@foreach ($contacts as $contact)				
				<tr title="{{ $contact->notes }}">
					<td>{{	$contact->id }}</td>
					<td><strong>{{	$contact->name }}</strong></td>
					<td>{{	$contact->email }}</td>
					<td><?php echo str_replace(',', '<br/>', $contact->phones) ?></td>					
					<td>{{ $contact->client->name }}</td>
					<td>
						<div class="pull-right hidden-phone">
	                        {!! Form::open(array('url' => 'contatos/'.$contact->id , 'method'  => 'delete' )) !!}	                        	
		                        <a href="#" class="btn btn-default btn-xs"><i class="fa fa-check"></i></a>
	                        	<a href="{{ url('contatos/'.$contact->id.'/edit') }}" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></a>
								<a href="mailto:{!!	$contact->email !!}" class="btn btn-default btn-xs" title="Enviar e-mail para {!! $contact->name !!}">
									<i class="fa fa-envelope"></i>
								</a>
		                        <button class="btn btn-default btn-xs" type="submit" onclick="return confirm('Excluir permanentemente este contato?');"><i class="fa fa-times"></i></button>
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
