@extends('layouts.app-admin', [
		'class' => '',
		'parentActive' => 'exams',
		'elementActive' => 'part'
])

@section('title', 'Data Part')

@section('extra-css')
<link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote-bs4.min.css')}}">
@endsection

@section('content')
<div class="card">
	<div class="card-header">
		<h3 class="card-title">
			Form Part
		</h3>
	</div>

	@if (isset($data))
	    {!! Form::model($data, ['route' => ['admin.exam.part.store'], 'class' => 'form-horizontal', 'files' => true]) !!}
	    {!! Form::hidden('id', null) !!}
	@else
	    {!! Form::open(['url' => route('admin.exam.part.store'), 'class' => 'form-horizontal', 'files' => true]) !!}
	@endif
	  	<div class="card-body">
	  		@if (count($errors) > 0)
				@foreach($errors->all() as $error)
					<div class="alert alert-danger alert-styled-right alert-dismissible">
			            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
			            {{ $error }}
			        </div>
				@endforeach
			@endif

	  		<div class="form-group">
	      		<label for="exampleInputEmail1">Section <span class="redf">*</span></label>
	      		{!! Form::select('section_id', $section, null, ['class'=>'form-control select2bs4', 'id'=>'section_id', 'required']) !!}
	    	</div>

	    	<div class="form-group">
	      		<label for="exampleInputEmail1">Packet <span class="redf">*</span></label>
	      		{!! Form::select('paket', $paket, null, ['class'=>'form-control select2bs4', 'id'=>'paket', 'required']) !!}
	    	</div>

	    	<div class="form-group">
	      		<label for="exampleInputEmail1">Title <span class="redf">*</span></label>
	      		{!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title', 'placeholder' => 'Masukkan Nama', 'required']) !!}
	    	</div>

	    	<div class="form-group">
	      		<label for="exampleInputEmail1">Direction <span class="redf">*</span></label>
	      		{!! Form::textarea('direction', null, ['class'=>'form-control summernote', 'id'=>'direction', 'placeholder' => 'Masukkan Nama', 'required']) !!}
	    	</div>

	    	<div class="form-group">
	    		@if (isset($data->audio))
		    		<audio id="audio" controls>
						<source src="{{ url('admin/audio-api/audio/'.str_replace('/', '&', $data->audio)) }}" id="src" />
					</audio><br>
				@endif
	      		<label for="exampleInputEmail1">Audio</label>
	      		<input type="file" name="audio" class="form-control">
	    	</div>
	  	</div>
	  	<!-- /.card-body -->

	  	<div class="card-footer">
	    	<button type="submit" class="btn btn-primary">Submit</button>
	    	<a href="{{ route('admin.exam.part.index') }}" class="btn btn-secondary">Cancel</a>
	  	</div>
	</form>
</div>
<!-- /.card -->
@endsection

@section('extra-js')
<script src="{{asset('assets/plugins/summernote/summernote-bs4.min.js')}}"></script>
<script src="{{asset('assets/js/summernote-cleaner.js')}}"></script>
<script type="text/javascript">
	$('.summernote').summernote({
		toolbar: [
		    // [groupName, [list of button]]
		    ['cleaner',['cleaner']], // The Button
		    ['style', ['bold', 'italic', 'underline', 'clear']],
		    ['font', ['strikethrough', 'superscript', 'subscript']],
		    ['fontsize', ['fontsize']],
		    ['color', ['color']],
		    ['para', ['ul', 'ol', 'paragraph']],
		    ['height', ['height']]
	  	],
	  	styleTags: [
		    { title: 'P Indent', tag: 'p', className: 'indent', value: 'p' },
		    { title: 'P Blue', tag: 'p', className: 'blue', value: 'p' },
		    { title: 'Blockquote', tag: 'blockquote', className: 'blockquote', value: 'blockquote' },
		    'pre', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
		],
	})
</script>
@endsection