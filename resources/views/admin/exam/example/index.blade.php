@extends('layouts.app-admin', [
		'class' => '',
		'elementActive' => 'home'
])

@section('title', 'List Example')

@section('extra-css')
<link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endsection

@section('content')
<div class="card">
	<div class="card-header">
		<div class="card-title">
			<a href="{{ route('admin.exam.example.create') }}" class="btn btn-block btn-primary">Add New</a>
		</div>
	</div>
	<div class="card-body">
		<!-- Notifikasi -->
		@if (Session::has('error'))
		    <div class="alert alert-danger alert-styled-right alert-dismissible">
		        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
		        {{ Session::get('error', 'Error') }}
		    </div>
		@endif
		@if (Session::has('success'))
		    <div class="alert alert-success alert-styled-right alert-arrow-right alert-dismissible">
		        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
		        {{ Session::get('success', 'Success') }}
		    </div>
		@endif
		<!-- ./notifikasi -->

		{!! Form::open(['url' => route('admin.exam.example.search-part'), 'method'=>'post','class' => 'form-inline']) !!}
			<div class="form-group mx-sm-3 mb-2">
	      		<label for="exampleInputEmail1">Part&nbsp;</label>
	      		{!! Form::select('search_part', $part, null, ['class'=>'form-control select2bs4', 'id'=>'search_part']) !!}
	    	</div>
	    	<button type="submit" class="btn btn-primary mb-2">Search</button>
		</form>

		<table class="table table-bordered">
		  	<thead>
				<tr>
			  		<th>ID</th>
			  		<th>Section</th>
			  		<th>Part</th>
			  		<th>Action</th>
				</tr>
		  	</thead>
		  	<tbody>
		  		@if (count($data) > 0)
			  		@foreach($data as $row)
						<tr>
					  		<td>{{ $row->id }}</td>
					  		<td>{{ $row->part->section->title }}</td>
					  		<td>{{ $row->part->title }}</td>
					  		<td>
					  			<a href="{{ route('admin.exam.example.create', ['id' => $row->id]) }}" alt="Edit User"><i class="far fa-edit"></i></a>
					  			&nbsp;
					  			<a href="#" data-href="{{ route('admin.exam.example.delete', ['id' => $row->id]) }}" data-toggle="modal" data-target="#confirm-delete"><i class="fas fa-trash-alt"></i></a>
					  		</td>
						</tr>
					@endforeach
				@else
					<tr>
						<td colspan="3">Data tidak ditemukan</td>
					</tr>
				@endif
		  	</tbody>
		</table>

	</div>
	<!-- /.card-body -->
	<div class="card-footer clearfix">
		
	</div>
	<!-- /.card-footer-->
</div>
<!-- /.card -->

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
        
            <div class="modal-body">
                <p>Apakah Anda yakin akan menghapus Example ini?</p>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra-js')
<script src="{{asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>

<script type="text/javascript">
	//Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    $('#confirm-delete').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));        
    });

    $('#confirm-reset').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok-reset').attr('href', $(e.relatedTarget).data('href'));        
    });
</script>
@endsection