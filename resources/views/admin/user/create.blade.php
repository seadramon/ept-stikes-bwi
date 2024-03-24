@extends('layouts.app-admin', [
		'class' => '',
		'parentActive' => 'user',
		'elementActive' => 'user-'.$role
])

@if (isset($data))
	@section('title', 'Edit ' . ucwords($role))
@else
	@section('title', 'Add New ' . ucwords($role))
@endif

@section('extra-css')
<link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endsection

@section('content')
<div class="card">
	<div class="card-header">
		<h3 class="card-title">
			Form {{ $role }}
		</h3>
	</div>

	@if (isset($data))
	    {!! Form::model($data, ['route' => ['admin.user.store'], 'class' => 'form-horizontal']) !!}
	    {!! Form::hidden('id', null) !!}
	@else
	    {!! Form::open(['url' => route('admin.user.store'), 'class' => 'form-horizontal']) !!}
	@endif
		{!! Form::hidden('role', $role) !!}
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
	      		<label for="exampleInputEmail1">Nomor Induk <span class="redf">*</span></label>
	      		{!! Form::text('nomor_induk', null, ['class'=>'form-control', 'id'=>'nomor_induk', 'placeholder' => 'Enter Nomor Induk', 'required', isset($data)?'readonly':'']) !!}
	    	</div>

	    	<div class="form-group">
	      		<label for="exampleInputEmail1">Name <span class="redf">*</span></label>
	      		{!! Form::text('name', null, ['class'=>'form-control', 'id'=>'name', 'placeholder' => 'Enter Name', 'required']) !!}
	    	</div>

	    	<div class="form-group">
	      		<label for="exampleInputEmail1">Email <span class="redf">*</span></label>
	      		{!! Form::email('email', null, ['class'=>'form-control', 'id'=>'email', 'placeholder' => 'Enter Email Address', 'required']) !!}
	    	</div>

	    	<div class="form-group">
	      		<label for="exampleInputEmail1">No Telp <span class="redf">*</span></label>
	      		{!! Form::text('phone', null, ['class'=>'form-control', 'id'=>'phone', 'placeholder' => 'Enter No Telp', 'required']) !!}
	    	</div>

	    	@if (count($instansi) > 0)
		    	<div class="form-group">
		      		<label for="exampleInputEmail1">Instansi</label>
		      		{!! Form::select('instansi', $instansi, null, ['class'=>'form-control select2bs4', 'id'=>'instansi', 'required', 'placeholder' => 'Choose Instansi :']) !!}
		    	</div>
	    	@else
	    		{!! Form::text('instansi', null, ['class'=>'form-control', 'id'=>'instansi', 'placeholder' => 'Enter Instansi', 'required']) !!}
	    	@endif

	    	<div class="form-group">
	      		<label for="exampleInputEmail1">Password</label>
	      		{!! Form::password('password', ['class'=>'form-control', 'id'=>'password', 'placeholder' => 'Enter Password']) !!}
	    	</div>
	  	</div>
	  	<!-- /.card-body -->

	  	<div class="card-footer">
	    	<button type="submit" class="btn btn-primary">Submit</button>
	    	<a href="{{ route('admin.user.index', ['role' => $role]) }}" class="btn btn-secondary">Cancel</a>
	  	</div>
	</form>
</div>
<!-- /.card -->
@endsection

@section('extra-js')
<script src="{{asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>

<script type="text/javascript">
	$(".select2bs4").select2({
	    theme: 'bootstrap4',
	    placeholder: 'Choose Instansi :'
	})
</script>
@endsection