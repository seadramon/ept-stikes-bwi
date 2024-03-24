@extends('layouts.app-admin', [
		'class' => '',
		'elementActive' => 'home'
])

@section('title', 'Data Example')

@section('extra-css')
<link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote-bs4.min.css')}}">
@endsection

@section('content')
<div class="card">
	<div class="card-header">
		<h3 class="card-title">
			Form Example
		</h3>
	</div>

	@if (isset($data))
	    {!! Form::model($data, ['route' => ['admin.exam.example.store'], 'class' => 'form-horizontal', 'files' => true]) !!}
	    {!! Form::hidden('id', null) !!}
	@else
	    {!! Form::open(['url' => route('admin.exam.example.store'), 'class' => 'form-horizontal', 'files' => true]) !!}
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
	      		<label for="exampleInputEmail1">Part</label>
	      		{!! Form::select('part_id', $part, null, ['class'=>'form-control select2bs4', 'id'=>'part_id', 'required']) !!}
	    	</div>

	    	<div class="form-group">
	      		<label for="exampleInputEmail1">Story</label>
	      		{!! Form::textarea('story', null, ['class'=>'form-control summernote', 'id'=>'story', 'placeholder' => 'Masukkan Story']) !!}
	    	</div>

	    	<div class="form-group">
	      		<label for="exampleInputEmail1">Question</label>
	      		{!! Form::textarea('question', null, ['class'=>'form-control summernote', 'id'=>'question', 'placeholder' => 'Masukkan question']) !!}
	    	</div>

	    	<div class="form-group">
	      		<label for="exampleInputEmail1">Pilihan A</label>
	      		{!! Form::text('choice_a', null, ['class'=>'form-control', 'id'=>'choice_a', 'placeholder' => 'Masukkan Nama', 'required']) !!}
	    	</div>

	    	<div class="form-group">
	      		<label for="exampleInputEmail1">Pilihan B</label>
	      		{!! Form::text('choice_b', null, ['class'=>'form-control', 'id'=>'choice_b', 'placeholder' => 'Masukkan Nama', 'required']) !!}
	    	</div>

	    	<div class="form-group">
	      		<label for="exampleInputEmail1">Pilihan C</label>
	      		{!! Form::text('choice_c', null, ['class'=>'form-control', 'id'=>'choice_c', 'placeholder' => 'Masukkan Nama', 'required']) !!}
	    	</div>

	    	<div class="form-group">
	      		<label for="exampleInputEmail1">Pilihan D</label>
	      		{!! Form::text('choice_d', null, ['class'=>'form-control', 'id'=>'choice_d', 'placeholder' => 'Masukkan Nama', 'required']) !!}
	    	</div>

	    	<div class="form-group">
	      		<label for="exampleInputEmail1">Answer</label>
	      		{!! Form::text('answer', null, ['class'=>'form-control', 'id'=>'answer', 'placeholder' => 'Masukkan Nama', 'required']) !!}
	    	</div>

	    	<div class="form-group">
	      		<label for="exampleInputEmail1">ALasan</label>
	      		{!! Form::textarea('reason', null, ['class'=>'form-control summernote', 'id'=>'reason', 'placeholder' => 'Masukkan reason']) !!}
	    	</div>

	    	<div class="form-group">
	    		@if (isset($data->filename))
		    		<audio id="audio" controls>
						<source src="{{ url('admin/audio-api/audio/'.str_replace('/', '&', $data->filename)) }}" id="src" />
					</audio><br>
				@endif
	      		<label for="exampleInputEmail1">File</label>
	      		<input type="file" name="audio" class="form-control">
	    	</div>
	  	</div>
	  	<!-- /.card-body -->

	  	<div class="card-footer">
	    	<button type="submit" class="btn btn-primary">Submit</button>
	    	<a href="{{ route('admin.exam.example.index') }}" class="btn btn-secondary">Cancel</a>
	  	</div>
	</form>
</div>
<!-- /.card -->
@endsection

@section('extra-js')
<script src="{{asset('assets/plugins/summernote/summernote-bs4.min.js')}}"></script>
<script src="{{asset('assets/js/summernote-cleaner.js')}}"></script>

<script type="text/javascript">
$(document).ready(function () {
	$('.summernote').summernote({
		toolbar:[
	        ['cleaner',['cleaner']], // The Button
	        ['style',['style']],
	        ['font',['bold','italic','underline','clear']],
	        ['fontname',['fontname']],
	        ['color',['color']],
	        ['para',['ul','ol','paragraph']],
	        ['height',['height']],
	        ['table',['table']],
	        ['insert',['media','link','hr']],
	        ['view',['fullscreen','codeview']],
	        ['help',['help']]
	    ]
	})
});
</script>


@endsection