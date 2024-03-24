@extends('layouts.app-admin', [
		'class' => '',
		'parentActive' => '',
		'elementActive' => 'pscore'
])

@section('title', 'Exam Results')

@section('content')

<!-- START ALERTS AND CALLOUTS -->
<div class="row">

  	<div class="col-md-12">
		<div class="card card-default">
	  		<div class="card-header">
				<h3 class="card-title">
		  			Hello, {{ \Auth::user()->name }}
				</h3>
	  		</div>
	  		<!-- /.card-header -->
	  		<div class="card-body">

	  			@if (count($data) > 0)
	  				<?php
	  				$a = 1;
	  				?>

	  				<div class="accordion" id="accordionExample">
		  				@foreach($data as $row)

		  					<div class="card">
						    	<div class="card-header" id="heading-{{ $a }}">
						      		<h2 class="mb-0">
						        		<button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse-{{$a}}" aria-expanded="true" aria-controls="collapse-{{$a}}">
						          		Period {{ date('d F Y H:i', strtotime($row->jadwal->start)) }} to {{ date('d F Y H:i', strtotime($row->jadwal->end)) }}
						        		</button>
						      		</h2>
						    	</div>

						    	<div id="collapse-{{$a}}" class="collapse{{ ($a==1)?' show':'' }}" aria-labelledby="heading-{{ $a }}" data-parent="#accordionExample">
						      		<div class="card-body">
						        		<table class="table table-bordered">
										  	<thead>
												<tr class="table-primary">
											  		<th>Section</th>
											  		<th>Jumlah Soal</th>
											  		<th>Jumlah Benar</th>
											  		<th>Score</th>
												</tr>
										  	</thead>
										  	<tbody>
										  		@if ($row->group == 'lecturer')
										  			<?php 
										  			$sections = $sectionsLecturers
										  			?>
										  		@endif

										  		@foreach($sections as $section)
										  			<?php 
										  			$i = $section->id;
										  			?>
										  			<?php
										  			switch ($i) {
										  				case 1:
										  					$jmlSoal = $row->section_1_qty;
										  					$rights = $row->section_1_right;
										  					$score = $row->section_1;
										  					break;
										  				case 2:
										  					$jmlSoal = $row->section_2_qty;
										  					$rights = $row->section_2_right;
										  					$score = $row->section_2;
										  					break;
										  				case 3:
										  					$jmlSoal = $row->section_3_qty;
										  					$rights = $row->section_3_right;
										  					$score = $row->section_3;
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
										  			<td>{{ $row->total }}</td>
										  		</tr>
										  	</tbody>
										</table>
						      		</div>
						    	</div>
						  	</div>

						<?php $a++; ?>
		  				@endforeach
	  				</div>
	  			@endif
	  		</div>
	  		<!-- /.card-body -->
		</div>
		<!-- /.card -->
  	</div>
  	<!-- /.col -->
</div>
<!-- /.row -->
<!-- /.card -->
@endsection