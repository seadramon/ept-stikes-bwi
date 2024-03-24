@extends('layouts.app-admin', [
		'class' => '',
		'elementActive' => 'home'
])

@section('title', 'Hello, ' . \Auth::user()->name)

@section('content')

<!-- START ALERTS AND CALLOUTS -->
<div class="row">
	<div class="col-md-12">
		<div class="card card-info">
	  		<div class="card-header">
				<h3 class="card-title">
		  			Welcome to the Stikes Banyuwangi English Proficiency Test
				</h3>
	  		</div>

	  		<div class="card-body">
	  			<p>Stikes Banyuwangi English Proficiency Test (SBEPT) is a program specifically designed to measure your ability in using and understanding English as a foreign language, which consists of listening comprehension, structure and written expression, and reading comprehension. The test is carried out using a computer-based test that can be taken online (online proctoring) or offline (offline proctoring). This exam is intended for the Banyuwangi Stikes academic community and the public. </p>
	  		</div>
	  	</div>
	</div>

	<!-- Schedule -->
	<div class="col-md-12">
  		<div class="card card-info">
	  		<div class="card-header">
				<h3 class="card-title">
		  			Schedule
				</h3>
	  		</div>

	  		<div class="card-body">
	  			<table class="table table-bordered">
	  			  	<thead>
	  					<tr class="table-primary">
	  				  		<th>Start</th>
	  				  		<th>End</th>
	  				  		<th>Ruangan</th>
	  				  		<th>Action</th>
	  					</tr>
	  			  	</thead>
	  			  	<tbody>
	  			  		@if (count($jadwal) > 0)
	  				  		@foreach($jadwal as $row)
	  							<tr>
	  						  		<td>{{ $row->start }} (WIB)</td>
	  						  		<td>{{ $row->end }} (WIB)</td>
	  						  		<td>{{ $row->ruang->nama }}</td>
	  						  		<td style="text-align: center;">
	  						  			<!-- cek periode jadwal -->
	  						  			@if ($row->start <= now() && $row->end >= now())
	  						  				<!-- section 1 case -->
	  						  				@if (!empty($row->monitoring[0]->section1_answer) && empty($row->monitoring[0]->section2_answer))
	  						  					@if ($row->monitoring[0]->section1_finished == 0)
	  						  						<a href="{{ route('exam.main', ['idmonitoring' => $row->monitoring[0]->id, 'section' => '1', 'continue' => $row->monitoring[0]->last_question]) }}" 	class="btn btn-warning btn-sm">
														<i class="fas fa-pencil-alt"></i> CONTINUE IN SECTION 1
													</a>
	  						  					@else
		  						  					<a href="{{ route('exam.main', ['idmonitoring' => $row->monitoring[0]->id, 'section' => '2']) }}" 	class="btn btn-warning btn-sm">
														<i class="fas fa-pencil-alt"></i> CONTINUE TO SECTION 2
													</a>
	  						  					@endif


											@elseif (!empty($row->monitoring[0]->section1_answer) && !empty($row->monitoring[0]->section2_answer) && empty($row->monitoring[0]->section3_answer)) 
												<a href="{{ route('exam.main', ['idmonitoring' => $row->monitoring[0]->id, 'section' => '3']) }}" 	class="btn btn-warning btn-sm">
													<i class="fas fa-pencil-alt"></i> CONTINUE TO SECTION 3
												</a>
											@elseif (!empty($row->monitoring[0]->section1_answer) && !empty($row->monitoring[0]->section2_answer) && !empty($row->monitoring[0]->section3_answer)) 
												<a href="{{ route('exam.pscore') }}" class="btn btn-success btn-sm">
													<i class="fas fa-medal"></i> CHECK SCORE
												</a>
											@else
												<a href="{{ route('exam.index', ['jadwal_id' => $row->id]) }}" 	class="btn btn-primary btn-sm">
													<i class="fas fa-pencil-alt"></i> START EXAM
												</a>
											@endif
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
	  	</div>
  	</div>

</div>
<!-- /.row -->
<!-- /.card -->
@endsection