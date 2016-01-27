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
		@include('arquivos.table')
	</div>
</section>


@endsection