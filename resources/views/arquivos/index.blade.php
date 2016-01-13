@extends('templates.default')

@section('content')	

	{!! Form::open(['url' => route('addentry'), 'method' => 'POST', 'class' => "form-horizontal", 'role' => "form", 'id'=>'uploadFile', "enctype"=>"multipart/form-data" ]) !!}
		<div class="row">
			<label class="col-lg-2 control-label" for="fileInput">Arquivos: </label>
			<div class="col-lg-6">
				<div class="form-group">			
					<input type="file" class="form-control" id="fileInput" name="file[]" placeholder="Input field" multiple>
				</div>
			</div>
			<div class="col-lg-4">
				<button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Upload</button>
			</div>
		</div>
	{!! Form::close() !!}	

		
	@foreach( array_chunk( $files->all(), 4 ) as $filesRow)
		<div class="row">
			@foreach( $filesRow as $file)
	            <div class="col-md-3">
	                <div class="thumbnail text-center">
	                	@if ($file->mime != "image/jpeg" && $file->mime != "image/png")
	                		<div class="well well-lg">
	                			
	                			<h3><i class="fa fa-4x fa-{{ $file->icon() }} text-muted"></i></h3>
	                			
	                		</div>
	                	@else
	                    	<img src="{{ route('filesrc', $file->filename) }}" alt="ALT NAME" class="img-responsive"
	                    	 />
	                   	@endif
	                    <div class="caption">
	                        <a href="{{ route('downloadfile', $file->original_filename) }}" target="_new"><small>{{$file->original_filename}}</small></a>
	                    </div>
	                </div>
	            </div>
			@endforeach
		</div>
	@endforeach




<section class="panel">
	<header class="panel-heading">Arquivos</header>
	<div class="panel-body table-responsive">
		<table class="table table-hover">
			<thead>
				<tr>
					<th width="30"></th>
					<th>Arquivo</th>
					<th>Tipo</th>
					<th>Anexado à</th>					
					<th>Enviado em</th>					
					<th></th>
				</tr>
			</thead>
			<tbody>				
				@foreach ($files as $file)	

				<tr title="{{ $file->notes }}">
					<td><i class="fa fa-{{ $file->icon() }} text-muted"></i></td>
					<td>{{ $file->original_filename }}</td>
					<td><strong>{{ $file->mime }}</strong></td>					
					<td></td>					
					<td>{{ date('d/m/y \à\\s H:i', strtotime($file->created_at)) }}</td>
					<td>
						<div class="pull-right hidden-phone">
	                        {!! Form::open(array('url' => 'arquivos/'.$file->id , 'method'  => 'delete' )) !!}		
	                        	<a href="{{ route('downloadfile', $file->original_filename) }}" class="btn btn-default btn-xs"><i class="fa fa-download"></i></a>
		                        <button class="btn btn-default btn-xs" type="submit" onclick="return confirm('Excluir permanentemente este arquivo?');"><i class="fa fa-times"></i></button>
	                        {!! Form::close() !!}
	                 	</div>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</section>


@endsection