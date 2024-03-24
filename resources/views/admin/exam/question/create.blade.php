@extends('layouts.app-admin', [
		'class' => '',
		'parentActive' => 'exams',
		'elementActive' => 'question'
])

@section('title', 'Data Question')

@section('extra-css')
<link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote-bs4.min.css')}}">
@endsection

@section('content')
<div class="card">
	<div class="card-header">
		<h3 class="card-title">
			Form Question
		</h3>
	</div>

	@if (Session::has('error'))
	    <div class="alert alert-danger alert-styled-right alert-dismissible">
	        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
	        {{ Session::get('error', 'Error') }}
	    </div>
	@endif

	@if (isset($data))
	    {!! Form::model($data, ['route' => ['admin.exam.question.store'], 'class' => 'form-horizontal', 'files' => true]) !!}
	    {!! Form::hidden('id', null) !!}
	@else
	    {!! Form::open(['url' => route('admin.exam.question.store'), 'class' => 'form-horizontal', 'files' => true]) !!}
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
	      		{!! Form::select('section_id', $section, null, ['class'=>'form-control select2', 'id'=>'section_id', 'required']) !!}
	    	</div>

	    	<div class="form-group">
	      		<label for="exampleInputEmail1">Part <span class="redf">*</span></label>
	      		{!! Form::select('part_id', $part, null, ['class'=>'form-control select2', 'id'=>'part_id', 'required']) !!}
	    	</div>

	    	<div class="form-group" id="reading">
	      		<label for="exampleInputEmail1">Story</label>
	      		{!! Form::textarea('story', null, ['class'=>'form-control summernote', 'id'=>'story', 'placeholder' => 'Masukkan Story']) !!}
	    	</div>

	    	<div class="form-group"  id="no-listening">
	      		<label for="exampleInputEmail1">Question</label>
	      		{!! Form::textarea('question', null, ['class'=>'form-control summernote', 'id'=>'question', 'placeholder' => 'Masukkan question']) !!}
	    	</div>

	    	<div class="form-group" id="listening">
	    		@if (isset($data->filename))
		    		<audio id="audio" controls>
						<source src="{{ url('admin/audio-api/audio/'.str_replace('/', '&', $data->filename)) }}" id="src" />
					</audio><br>
				@endif
	      		<label for="exampleInputEmail1">Audio</label>
	      		<input type="file" name="audio" class="form-control">
	    	</div>

	    	<div class="form-group">
	      		<label for="exampleInputEmail1">Pilihan A <span class="redf">*</span></label>
	      		{!! Form::text('choice_a', null, ['class'=>'form-control', 'id'=>'choice_a', 'required']) !!}
	    	</div>

	    	<div class="form-group">
	      		<label for="exampleInputEmail1">Pilihan B <span class="redf">*</span></label>
	      		{!! Form::text('choice_b', null, ['class'=>'form-control', 'id'=>'choice_b', 'required']) !!}
	    	</div>

	    	<div class="form-group">
	      		<label for="exampleInputEmail1">Pilihan C <span class="redf">*</span></label>
	      		{!! Form::text('choice_c', null, ['class'=>'form-control', 'id'=>'choice_c', 'required']) !!}
	    	</div>

	    	<div class="form-group">
	      		<label for="exampleInputEmail1">Pilihan D <span class="redf">*</span></label>
	      		{!! Form::text('choice_d', null, ['class'=>'form-control', 'id'=>'choice_d', 'required']) !!}
	    	</div>

	    	<div class="form-group">
	      		<label for="exampleInputEmail1">Answer <span class="redf">*</span></label>
	      		{!! Form::select('answer', $alpha, null, ['class'=>'form-control select2bs4', 'id'=>'answer', 'required']) !!}
	    	</div>

	    	@if (isset($data))
	    		<div class="form-group">
		      		<label for="urutan">Urutan</label>
		      		{!! Form::number('urutan', null, ['class'=>'form-control', 'id'=>'urutan', 'required']) !!}
		    	</div>
	    	@endif
	  	</div>
	  	<!-- /.card-body -->

	  	<div class="card-footer">
	    	<button type="submit" class="btn btn-primary">Submit</button>
	    	<a href="{{ route('admin.exam.question.index') }}" class="btn btn-secondary">Cancel</a>
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
	        ['fontsize', ['fontsize']],
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
	
	var sectionSelect = $("#section_id");
	sectionSelect.select2({
		placeholder: "Choose Section",
	});

	var partSelect = $("#part_id");
	partSelect.select2({
		placeholder: "Choose Part",
	});

	sectionSelect.on("change", function (e) { 
		let id = $(this).val()

		$.get("{{ route('admin.exam.question.part') }}", { id:id }, function(data) {
			partSelect.empty()

			partSelect.select2({
				data: data
			})
		});

		if (id == 1) {
			$("#listening").show();
			$("#reading").hide();
			$("#no-listening").hide();
		}

		if (id == 2) {
			$("#listening").hide();
			$("#reading").hide();
			$("#no-listening").show();
		}

		if (id == 3) {
			$("#listening").hide();
			$("#reading").show();
			$("#no-listening").show();
		}
	});

});
</script>


@endsection