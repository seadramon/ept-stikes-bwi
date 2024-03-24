@extends('layouts.app-admin', [
		'class' => '',
		'parentActive' => 'user',
		'elementActive' => 'user-'.$role
])

@section('title', 'Data ' . ucwords($role))

@section('content')
<div class="card">
	<div class="card-header">
		<div class="card-title">
			@if ($role == 'peserta')
				<div class="dropdown show">
				  	<a class="btn btn-primary dropdown-toggle" href="{{ route('admin.user.create') . '?role=' . $role }}" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    	Add New
				  	</a>

				  	<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
				    	<a class="dropdown-item" href="{{ route('admin.user.create') . '?role=' . $role }}">Create</a>
				    	<a class="dropdown-item" href="{{ route('admin.user.import-excel') . '?role=' . $role }}">Import dari Excel</a>
				  	</div>
				</div>
			@else
				<a href="{{ route('admin.user.create') . '?role=' . $role }}" class="btn btn-block btn-primary">Add New</a>
			@endif
		</div>
		<div class="card-tools">
			<form action="{{ route('admin.user.index', ['role' => $role]) }}" method="get">
			<div class="input-group input-group-sm" style="width: 200px;">
	            <input type="text" name="search" class="form-control float-right" placeholder="Search">

	            <div class="input-group-append">
	            	<button type="submit" class="btn btn-default">
	                	<i class="fas fa-search"></i>
	              	</button>
	            </div>
          	</div>
          </form>
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

		<table class="table table-bordered">
		  	<thead>
				<tr class="table-primary">
			  		<th>Nomor Induk</th>
			  		<th>Name</th>
			  		<th>Email</th>
			  		<th>Phone</th>
			  		<th>Instansi</th>
			  		<th>Action</th>
				</tr>
		  	</thead>
		  	<tbody>
		  		@foreach($data as $row)
					<tr>
				  		<td>{{ $row->nomor_induk }}</td>
				  		<td>{{ $row->name }}</td>
				  		<td>{{ $row->email }}</td>
				  		<td>{{ $row->phone }}</td>
				  		<td>{{ $row->instansi }}</td>
				  		<td>
				  			<a href="{{ route('admin.user.create', ['role' => $role, 'id' => $row->id]) }}" alt="Edit User"><i class="far fa-edit"></i></a>
				  			&nbsp;
				  			<a href="#" data-href="{{ route('admin.user.delete', ['role' => $role, 'id' => $row->id]) }}" data-toggle="modal" data-target="#confirm-delete"><i class="fas fa-trash-alt"></i></a>
				  			&nbsp;
				  			<a href="#" data-href="{{ route('admin.user.reset', ['role' => $role, 'id' => $row->id]) }}" data-toggle="modal" data-target="#confirm-reset"><i class="fas fa-sync-alt"></i></a>
				  		</td>
					</tr>
				@endforeach
		  	</tbody>
		</table>

	</div>
	<!-- /.card-body -->
	<div class="card-footer clearfix">
		{{ $data->links('pagination.default') }}
		<p>Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total() }} entries</p>
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
                <p>Apakah Anda yakin akan menghapus user ini?</p>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirm-reset" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Confirm Reset Password</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
        
            <div class="modal-body">
                <p>Apakah Anda yakin akan mereset password user ini?</p>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok-reset">Reset</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra-js')
<script type="text/javascript">
    $('#confirm-delete').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));        
    });

    $('#confirm-reset').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok-reset').attr('href', $(e.relatedTarget).data('href'));        
    });
</script>
@endsection