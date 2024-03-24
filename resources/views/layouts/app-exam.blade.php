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

	@yield('extra-css')
	<style>
	[v-cloak] {
			display: none;
	}
	</style>
	<meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
<body>
	@yield('content')
	<!-- /.content-wrapper -->

	<!-- Main Footer -->
	@include('layouts.admin.footer')
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{asset('assets/js/adminlte.min.js') }}"></script>

<script src="{{ asset('assets/js/blockUi.js') }}"></script>

@yield('extra-js')
</body>
</html>
