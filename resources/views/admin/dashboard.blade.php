@extends('layouts.app-admin', [
		'class' => '',
		'parentActive' => '',
		'elementActive' => 'home'
])

@section('title', 'Dashboard')

@section('content')
<!-- Small boxes (Stat box) -->
<div class="row">
	<div class="col-lg-3 col-6">
		<!-- small box -->
		<div class="small-box bg-info">
				<div class="inner">
					<h3>{{ $participantsCount }}</h3>

					<p>Total Participants</p>
				</div>
				<div class="icon">
					<i class="ion ion-bag"></i>
				</div>
				<a href="{{ route('admin.user.index', ['role' => 'peserta']) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
		</div>
	</div>
	<!-- ./col -->
	<div class="col-lg-3 col-6">
		<!-- small box -->
		<div class="small-box bg-warning">
				<div class="inner">
					<h3>{{ $instansiCount }}</h3>

					<p>Total Instansi</p>
				</div>
				<div class="icon">
					<i class="ion ion-stats-bars"></i>
				</div>
				<a href="{{ route('admin.user.index', ['role' => 'peserta']) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
		</div>
	</div>
	<!-- ./col -->
	<div class="col-lg-3 col-6">
		<!-- small box -->
		<div class="small-box bg-primary">
			<div class="inner">
				<h3>{{ $jadwalCountActive }}</h3>

				<p>Total Active Schedule</p>
			</div>
			<div class="icon">
				<i class="ion ion-person-add"></i>
			</div>
			<a href="{{ route('admin.jadwal.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
		</div>
	</div>
	<!-- ./col -->
	<div class="col-lg-3 col-6">
		<!-- small box -->
		<div class="small-box bg-secondary">
			<div class="inner">
				<h3>{{ $jadwalCountPast }}</h3>

				<p>Total Past Schedule</p>
			</div>
			<div class="icon">
				<i class="ion ion-person-add"></i>
			</div>
			<a href="{{ route('admin.jadwal.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
		</div>
	</div>
</div>
<!-- /.row -->

<div class="card card-primary">
	 <div class="card-header">
		<h3 class="card-title">Question Overview</h3>
	</div>
	<div class="card-body">
		<div class="d-flex justify-content-between align-items-center border-bottom mb-3">
			<p class="text-info text-md">
				PACKET A
			</p>
			<p class="d-flex flex-column text-right">
				<span class="font-weight-bold">
					<i class="ion ion-android-arrow-up text-success"></i> {{ $countPartA }}
				</span>
				<span class="text-muted">Questions</span>
			</p>
		</div>

		<div class="d-flex justify-content-between align-items-center border-bottom mb-3">
			<p class="text-info text-md">
				PACKET B
			</p>
			<p class="d-flex flex-column text-right">
				<span class="font-weight-bold">
					<i class="ion ion-android-arrow-up text-success"></i> {{ $countPartB }}
				</span>
				<span class="text-muted">Questions</span>
			</p>
		</div>
	</div>
	<!-- /.card-body -->
	<div class="card-footer">
		
	</div>
	<!-- /.card-footer-->
</div>
<!-- /.card -->
@endsection