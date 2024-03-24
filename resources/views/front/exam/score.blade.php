@extends('layouts.app')

@section('title', 'EPT - exam')

@section('extra-css')
<style type="text/css">
	.right{
		text-align: right;
	}

	.left {
		text-align: left;
	}
</style>
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0"> EPT TEST RESULT</h1>
			</div><!-- /.col -->
			<!-- <div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item"><a href="#">Layout</a></li>
					<li class="breadcrumb-item active">Top Navigation</li>
				</ol>
			</div> --><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
	<div class="container">
		<div class="row">
			
			<!-- /.col-md-12 -->
			<div class="col-lg-12">

				<div class="card card-info card-outline">
					<div class="card-header">
						<h5 class="card-title m-0">Score</h5>
					</div>
					<div class="card-body">
						<table class="table table-bordered">
						  	<thead>
								<tr>
							  		<th>Section</th>
							  		<th>Jumlah Soal</th>
							  		<th>Jumlah Benar</th>
							  		<th>Score</th>
								</tr>
						  	</thead>
						  	<tbody>
						  		@foreach($sections as $section)
						  			<?php 
						  			$i = $section->id;
						  			switch ($i) {
						  				case 1:
						  					$jmlSoal = $data->section_1_qty;
						  					$rights = $data->section_1_right;
						  					$score = $data->section_1;
						  					break;
						  				case 2:
						  					$jmlSoal = $data->section_2_qty;
						  					$rights = $data->section_2_right;
						  					$score = $data->section_2;
						  					break;
						  				case 3:
						  					$jmlSoal = $data->section_3_qty;
						  					$rights = $data->section_3_right;
						  					$score = $data->section_3;
						  					break;
						  			}
						  			?>
							  			<tr>
								  			<td>Section {{$section->id}} - {{ $section->title }}</td>
								  			<td>{{ $jmlSoal }}</td>
								  			<td>{{ $rights }}</td>
								  			<td>{{ $score }}</td>
								  		</tr>
						  		@endforeach
						  		<tr>
						  			<td colspan="3">Total</td>
						  			<td>{{ $data->total }}</td>
						  		</tr>
						  	</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- /.col-md-6 -->
		</div>
		<!-- /.row -->
	</div><!-- /.container-fluid -->
</div>
@endsection
@section('extra-js')
<script type="text/javascript">
    function initialState (){
        return {
            data: {},
            imgloading: "{{asset('/assets/img/hex-loader.gif')}}",
            errors: []
        }
    }

    let app = new Vue({
        el: "#vue-app",
        data: function (){
            return initialState();
        }
    });
</script>
<script>
    
</script>
@endsection