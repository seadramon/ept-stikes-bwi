@extends('layouts.app-admin', [
		'class' => '',
		'parentActive' => '',
		'elementActive' => 'room'
])

@section('title', 'Data User')

@section('content')
<div class="card">
	<div class="card-header">
		<h3 class="card-title">
			Form Ruangan
		</h3>
	</div>

	@if (isset($data))
	    {!! Form::model($data, ['route' => ['admin.ruang.store'], 'class' => 'form-horizontal']) !!}
	    {!! Form::hidden('id', null) !!}
	@else
	    {!! Form::open(['url' => route('admin.ruang.store'), 'class' => 'form-horizontal']) !!}
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
	      		<label for="exampleInputEmail1">Nama <span class="redf">*</span></label>
	      		{!! Form::text('nama', null, ['class'=>'form-control', 'id'=>'nama', 'placeholder' => 'Masukkan Nama', 'required']) !!}
	    	</div>
	  	</div>
	  	<!-- /.card-body -->

	  	<div class="card-footer">
	    	<button type="submit" class="btn btn-primary">Submit</button>
	    	<a href="{{ route('admin.ruang.index') }}" class="btn btn-secondary">Cancel</a>
	  	</div>
	</form>
</div>
<!-- /.card -->
@endsection