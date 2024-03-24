@extends('layouts.app-admin', [
		'class' => '',
		'parentActive' => '',
		'elementActive' => 'jadwal'
])

@section('title', 'List Peserta')

@section('extra-css')
<link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endsection

@section('content')
<div class="card">
	<div class="card-header">
		<div class="card-title">
			
		</div>
		<div class="card-tools">
			<form action="{{ route('admin.monitoring.search', ['jadwal_id' => $jadwal_id]) }}" method="post">
			@csrf
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
		<table width="50%" style="margin-bottom: 15px;">
			<tr>
				<td>Period</td>
				<td>:</td>
				<td>
					<span class="bluef">{{ date('d F Y H:i', strtotime($jadwal->start)) }}</span> to <span class="bluef">{{date('d F Y H:i', strtotime($jadwal->end))}}</span>
				</td>
			</tr>
			<tr>
				<td>Room</td>
				<td>:</td>
				<td>
					{{ $jadwal->ruang->nama }}
				</td>
			</tr>
			<tr>
				<td>Pengawas</td>
				<td>:</td>
				<td>
					{{ $jadwal->pengawas->name }}
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<a href="{{ route('admin.jadwal.index') }}" class="btn btn-sm btn-info mt-2 mb-2"><< Back to Schedule</a>
				</td>
			</tr>
		</table>

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

		{!! Form::open(['url' => route('admin.monitoring.store'), 'method'=>'post','class' => 'form-inline', 'style' => 'width:100%']) !!}
			<input type="hidden" name="jadwal_id" value="{{ $jadwal_id }}">
			<div class="form-group mb-2" style="width: 100%">
	      		<label for="exampleInputEmail1">Participant&nbsp;:&nbsp;</label>
	      		{!! Form::select('user_id', $peserta, null, ['class'=>'form-control select2bs4', 'id'=>'user_id','style' => 'width:50%']) !!}
	      		&nbsp;&nbsp;&nbsp;
	      		<label for="exampleInputEmail1">As&nbsp;:&nbsp;</label>
	      		{!! Form::select('group', $group, null, ['class'=>'form-control', 'id'=>'group','style' => 'width:20%']) !!}
	      		&nbsp;&nbsp;&nbsp;
	    	<button type="submit" class="btn btn-primary mt-2 mb-2">Add Participant</button>
	    	</div>
		</form>

		<table class="table table-bordered">
		  	<thead>
				<tr class="table-primary">
			  		<th>NIM</th>
			  		<th>Nama</th>
			  		<th>Group</th>
			  		<th>Status</th>
			  		<th>Action</th>
				</tr>
		  	</thead>
		  	<tbody>
		  		@if (count($data) > 0)
			  		@foreach($data as $row)
						<tr>
					  		<td>{{ $row->user->nomor_induk }}</td>
					  		<td>{{ $row->user->name }}</td>
					  		<td>{{ $row->group }}</td>
					  		<td style="text-align: center;">
			                    <div class="custom-control custom-switch">
			                      	<input type="checkbox" data-id="{{ $row->id }}" class="custom-control-input toggl" id="{{'customSwitch'.$row->id}}" {{ ($row->status == '1'? "checked":"") }}>
			                      	<label class="custom-control-label" for="{{'customSwitch'.$row->id}}"></label>
			                    </div>
					  		</td>
					  		<td>
					  			<a href="#" data-href="{{ route('admin.monitoring.delete', ['userid' => $row->user_id, 'jadwalid' => $jadwal_id]) }}" data-toggle="modal" data-target="#confirm-delete"><i class="fas fa-trash-alt"></i></a>
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
                <p>Apakah Anda yakin akan menghapus Peserta ini?</p>
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
	$( document ).ready(function() {
		//Initialize Select2 Elements
	    $('.select2').select2()

	    //Initialize Select2 Elements
	    $('.select2bs4').select2({
	      theme: 'bootstrap4'
	    })

	    $.unblockUI();
	})

    $('#confirm-delete').on('show.bs.modal', function(e) {
    	console.log($(e.relatedTarget).data('href'));
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));        
    });

    $('#confirm-reset').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok-reset').attr('href', $(e.relatedTarget).data('href'));        
    });

    $(".toggl").change(function() {
    	var id = $(this).attr("data-id");

    	if (this.checked) {
    		var status = '1';
    	} else {
    		var status = '0';
    	}

    	blockui()
    	var url = "{{ url('admin/monitoring/change') }}" + '?id=' + id + '&status=' + status;

    	$.get(url, function(data){
            setTimeout("location.reload(true);",5000);
        });
    })

    function blockui() {
    	$.blockUI({ 
            message: "<div class='fa-4x'><i class='fas fa-cog fa-spin'></i></div>Loading Data <br> <b>Please wait!</b>",
            baseZ: 2000,
            css:{
                margin:     0,
                width:      '27%',
                top:        '20%',
                left:       '35%',
                textAlign:  'center',
                color:      '#000',
                backgroundColor:'#fff',
                cursor:     'wait',
                border: 'none',
                padding: '2em',
                '-webkit-border-radius': '10px',
                '-moz-border-radius': '10px',
                // opacity: .5,
            }
        });
    }
</script>
@endsection