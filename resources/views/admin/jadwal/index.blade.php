@extends('layouts.app-admin', [
		'class' => '',
		'parentActive' => '',
		'elementActive' => 'jadwal'
])

@section('title', 'List Schedule')

@section('extra-css')
<link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endsection

@section('content')
<div class="card">
	<div class="card-header">
		<div class="card-title">
			@if (\Auth::user()->role == 'administrator')
		  	<a class="btn btn-primary" href="{{ route('admin.jadwal.create') }}">
		    	Add New
		  	</a>
		  	@endif
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
			  		<th>Start</th>
			  		<th>End</th>
			  		<th>Packet</th>
			  		<th>Ruangan</th>
			  		<th>Pengawas</th>
			  		<th>Total Participants</th>
			  		<th>Action</th>
				</tr>
		  	</thead>
		  	<tbody>
		  		@if (count($data) > 0)
			  		@foreach($data as $row)
						<tr>
					  		<td>{{ $row->start }} (WIB)</td>
					  		<td>{{ $row->end }} (WIB)</td>
					  		<td>{{ strtoupper($row->paket) }}</td>
					  		<td>{{ $row->ruang->nama }}</td>
					  		<td>{{ $row->pengawas->name }}</td>
					  		<td>{{ $row->monitoring_count }}</td>
					  		<td>
					  			@if (\Auth::user()->role == 'administrator')
					  				<a href="{{ route('admin.jadwal.create', ['id' => $row->id]) }}" alt="Edit User"><i class="	far fa-edit"></i></a>
					  				&nbsp;
					  			@endif

					  			<a href="{{ route('admin.monitoring.index', ['jadwal_id' => $row->id]) }}" alt="Peserta"><i class="fas fa-users"></i></a>

					  			@if (\Auth::user()->role == 'administrator')
					  				&nbsp;
					  				<a href="#" data-href="{{ route('admin.jadwal.delete', ['id' => $row->id]) }}" data-toggle="modal" data-target="#confirm-delete"><i class="fas fa-trash-alt"></i></a>
					  			@endif
					  		</td>
						</tr>
					@endforeach
				@else
					<tr>
						<td colspan="6">Data tidak ditemukan</td>
					</tr>
				@endif
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
                <p>Apakah Anda yakin akan menghapus Question ini?</p>
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