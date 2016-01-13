@extends('templates.default')

@section('content')

{!! Breadcrumbs::render( 'project', $project )  !!}

<section class="panel">
	<header class="panel-heading">
		<div class="pull-right">
			{!! Form::open(array('url' => 'obras/'.$project->id , 'method'  => 'delete' )) !!}                   
				<a href="{!! url( '/obras/'.$project->id.'/edit') !!}" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modal">
					<i class="fa fa-pencil"></i> EDITAR
				</a>
                <button class="btn btn-danger btn-xs" type="submit" onclick="return confirm('Excluir permanentemente esta obra?');"><i class="fa fa-trash-o"></i> EXCLUIR</button>
            {!! Form::close() !!}
		</div>
		Obra <strong>{!! $project->title !!}</strong>
	</header>
	<div class="panel-body">		
		

		<div role="tabpanel">
		    <!-- Nav tabs -->
		    <ul class="nav nav-tabs" role="tablist">
		    	<li role="presentation" class="active">
		            <a href="#overview" aria-controls="overview" role="tab" data-toggle="tab">Resumo</a>
		        </li>
		        <li role="presentation" class="">
		            <a href="#etapas" aria-controls="etapas" role="tab" data-toggle="tab">Etapas</a>
		        </li>
		        <li role="presentation">
		            <a href="#disciplinas" aria-controls="disciplinas" role="tab" data-toggle="tab">Disciplinas</a>
		        </li>
		        <li role="presentation">
		            <a href="#contatos" aria-controls="contatos" role="tab" data-toggle="tab">Contatos</a>
		        </li>
		        <li role="presentation">
		            <a href="#consultas-tecnicas" aria-controls="consultas-tecnicas" role="tab" data-toggle="tab">Consultas Técnicas</a>
		        </li>
		    </ul>
		
		    <!-- Tab panes -->
		    <div class="tab-content">

		    	<!-- RESUMO -->
		    	<div role="tabpanel" class="tab-pane active" id="overview">

		    		<div class="well-sm"></div>

					<div class="row">
						<div class="col-sm-4">
							<table class="table table-condensed">
								<thead>
									<tr>
										<th class="text-center" colspan="2">RESUMO</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="text-right"><strong>Título:</strong></td>
										<td>{{ $project->title }}</td>
									</tr>
									<tr>
										<td class="text-right"><strong>Data:</strong></td>
										<td>{!! date('d/m/Y', strtotime($project->created_at)) !!}</td>
									</tr>
									<tr>
										<td class="text-right"><strong>Alterado:</strong></td>
										<td>{!! date('d/m/Y', strtotime($project->updated_at)) !!}</td>
									</tr>										
								</tbody>
							</table>							
						</div>
						<div class="col-sm-4">
							<table class="table table-condensed">
								<thead>
									<tr>
										<th class="text-center" colspan="2">CLIENTE</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="text-right"><strong>Nome:</strong></td>
										<td>{{ $project->client->name }}</td>
									</tr>
									<tr>
										<td class="text-right"><strong>Empresa:</strong></td>
										<td>{!! $project->client->company !!}</td>
									</tr>
									<tr>
										<td class="text-right"><strong>Criado em:</strong></td>
										<td>{!! date('d/m/Y', strtotime($project->client->created_at)) !!}</td>
									</tr>										
								</tbody>
							</table>	
						</div>
						<div class="col-sm-4"></div>
					</div>
					
		        </div>
		        

		        <!-- ETAPAS -->
		        <div role="tabpanel" class="tab-pane" id="etapas">
					<div class="navbar">
			        	<div class="pull-right">
			        		
                			<a href="{!! url('obras/'.$project->id.'/etapas/create') !!}" class="btn btn-success btn-xs navbar-btn" data-target="#modal" data-toggle="modal"><i class="fa fa-plus"></i> ADICIONAR</a>		        		        			
	        			</div>        			
			        	<p class="navbar-text navbar-left">
		        			
			        	</p>	
		        	</div>					
					<table class="table table-hover">
						<thead>
							<tr>								
								<th>Título</th>
								<th>Consultas Técnicas</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							
							@foreach ($project->stages as $stage)								
								<tr>
									<td>{{ $stage->title }}</td>
									<td></td>
									<td>
										<div class="pull-right">
					                        {!! Form::open(array('url' => 'obras/etapas/'.$stage->id )) !!}

												<input type="hidden" name="_method" value="DELETE">

					                        	<a href="{{ url('obras/'.$project->id.'/etapas/'.$stage->id.'/edit') }}" class="btn btn-default btn-xs" data-target="#modal" data-toggle="modal"><i class="fa fa-pencil"></i></a>
												<a href="#" class="btn btn-default btn-xs" title="Criar consulta técnica">
													<i class="fa fa-envelope"></i>
												</a>
						                        <button class="btn btn-default btn-xs" type="submit" onclick="return confirm('Excluir permanentemente esta etapa?');"><i class="fa fa-times"></i></button>

					                        {!! Form::close() !!}
					                 	</div>
									</td>
								</tr>
							@endforeach

						</tbody>
					</table>
		        </div>

				<!-- DISCIPLINAS -->
		        <div role="tabpanel" class="tab-pane" id="disciplinas">
		        	<div class="navbar">
			        	<div class="pull-right">	        		        			
		                	<a href="{!! url('obras/'.$project->id.'/disciplinas/create') !!}" class="btn btn-success btn-xs navbar-btn" data-toggle="modal" data-target="#modal"><i class="fa fa-plus"></i> ADICIONAR</a>
	        			</div>        			
			        	<p class="navbar-text navbar-left">
		        			
			        	</p>	
		        	</div>
		        	<div class="">
		        		<table class="table table-hover">
							<thead>
								<tr>								
									<th>Título</th>
									<th>Consultas Técnicas</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								
								@foreach ($project->disciplines as $discipline)								
									<tr>
										<td>{{ $discipline->title }}</td>
										<td></td>
										<td>
											<div class="pull-right">
						                        {!! Form::open(array('url' => 'obras/disciplinas/'.$discipline->id )) !!}

													<input type="hidden" name="_method" value="DELETE">

						                        	<a href="{{ url('obras/'.$project->id.'/disciplinas/'.$discipline->id.'/edit') }}" class="btn btn-default btn-xs" data-target="#modal" data-toggle="modal"><i class="fa fa-pencil"></i></a>
													<a href="#" class="btn btn-default btn-xs" title="Criar consulta técnica">
														<i class="fa fa-envelope"></i>
													</a>
							                        <button class="btn btn-default btn-xs" type="submit" onclick="return confirm('Excluir permanentemente esta disciplina?');"><i class="fa fa-times"></i></button>

						                        {!! Form::close() !!}
						                 	</div>
										</td>
									</tr>
								@endforeach

							</tbody>
						</table>
		        	</div>
		        </div>


		        <!-- CONTATOS -->
		        <div role="tabpanel" class="tab-pane" id="contatos">
		        	<div class="navbar">
			        	<div class="navbar-form navbar-right">
							{!! Form::open(array('url' => 'obras/'.$project->id.'/contatos/attach', 'class' => 'form-inline')) !!}
							
								<div class="form-group form-group-xs">									
									
									<select name="contact_id" id="input" class="form-control input-sm" required="required">
										<option selected="selected" value="">-- Selecione --</option>
										@foreach ($project->client->contacts as $contact)
											<option value="{{ $contact->id }}">{{ $contact->name }} / {{ $contact->company }}</option>
										@endforeach
									</select>
							
									<button type="submit" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> ADICIONAR</button>
							
								</div>

							{!! Form::close() !!}
			     		</div>        			
			        	<div class="navbar-text navbar-left">
					
			        	</div>
		        	</div>
		        	<div class="collapse" id="collapseExample">

		        		@include('contacts.create-form')
			        
		        	</div>
		        	<div class="" >

						<table class="table table-hover" id="contacts-list">
							<thead>
								<tr>
									<th width="40">#</th>
									<th>Nome</th>
									<th>Empresa</th>					
									<th>Obras</th>
									<!-- <th>Price</th> -->					
									<th></th>
								</tr>
							</thead>
							<tbody>
									
								@foreach ($project->contacts as $projectcontact)
									
									<tr title="" >
										<td><a href="{{ url( '/contatos/'.$projectcontact->id) }}">{{ $projectcontact->id }}</a></td>
										<td><strong><a href="{{ url( '/contatos/'.$projectcontact->id) }}">{{ $projectcontact->name }}</a></strong></td>
										<td><a href="{{ url( '/contatos/'.$projectcontact->id) }}">{{ $projectcontact->company }}</a></td>
										<td></td>					
										<td>
											<div class="pull-right hidden-phone">

												{!! Form::open(array('url' => url('obras/'.$project->id.'/contatos/'.$projectcontact->id.'/detach'), 'role' => 'form' )) !!}

													<a href="{{ url( '/contatos/'.$projectcontact->id.'/edit') }}" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modal"><i class="fa fa-pencil"></i></a>
							                        <button class="btn btn-default btn-xs" type="submit" onclick="return confirm('Desvincular este contato desta obra?');" title="Desvincular contato"><i class="fa fa-scissors"></i></button>

												{!! Form::close() !!}
							             	</div>
										</td>
									</tr>								
									
								@endforeach
							</tbody>
						</table>
						
		        	</div>
		        </div>
		        <div role="tabpanel" class="tab-pane" id="consultas-tecnicas">
		       		<div class="navbar">
			        	<div class="navbar-right">	    
		                	<a href="{!! url('obras/'.$project->id.'/consultas_tecnicas/create') !!}" class="btn btn-success btn-xs navbar-btn"><i class="fa fa-plus"></i> ADICIONAR</a>
		     			</div>        			
			        	<p class="navbar-text navbar-left">
		        			
			        	</p>	
		        	</div>
		        	<div class="">
		        		{{-- @include('technical_consults.index_timeline') --}}
		        	</div>
		        </div>
				

		    </div>
		</div>

	</div>
</section>
@stop
