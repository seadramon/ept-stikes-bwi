<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ 'English Proficiency Test - Stikes Banyuwangi' }}</title>

	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="{{asset('assets/plugins/fontawesome-free/css/all.min.css')}}" media="all">
	<link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}" media="all">
	<!-- Theme style -->
	<link rel="stylesheet" href="{{asset('assets/css/adminlte.min.css')}}">

	@yield('extra-css')
	<style>
    [v-cloak] {
        display: none;
    }
    .redf {
    	color: red;
    }
    .bluef {
    	color: blue;
    }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
	<!-- Navbar -->
	@include('layouts.admin.header')
	<!-- /.navbar -->

	<!-- Main Sidebar Container -->
	@include('layouts.admin.sidebar')
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		
		<section class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1>@yield('title')</h1>
					</div>
				</div>
			</div><!-- /.container-fluid -->
		</section>

		<!-- Main content -->
		<section class="content">
			<!-- Default box -->
			@yield('content')
		</section>
		<!-- /.content -->
	</div>
	@include('layouts.admin.footer')
	<!-- /.content-wrapper -->
	
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{asset('assets/js/adminlte.min.js') }}"></script>

<script src="{{ asset('assets/js/blockUi.js') }}"></script>

@yield('extra-js')
</body>
</html>