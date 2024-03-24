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
	<!-- Theme style -->
	<link rel="stylesheet" href="{{asset('assets/css/adminlte.min.css')}}">

	@yield('extra-css')
	<style>
	[v-cloak] {
		display: none;
	}
	ul.no-bullets {
	  	list-style-type: none; /* Remove bullets */
	  	padding: 0; /* Remove padding */
	  	margin: 0; /* Remove margins */
	}
	</style>
	<meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

	<!-- Navbar -->
	<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
		<div class="container">
			<a href="{{ route('home') }}" class="navbar-brand">
				<img src="{{asset('assets/img/ept-transparan.png')}}" alt="EPT" class="brand-image elevation-3" style="opacity: .8">
				<span class="brand-text font-weight-light">English Proficiency Test</span>
			</a>

			<button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse order-3" id="navbarCollapse">
				<!-- Left navbar links -->
				<ul class="navbar-nav">
					<!-- <li class="nav-item">
						<a href="index3.html" class="nav-link">Home</a>
					</li> -->
				</ul>
			</div>

			<!-- Right navbar links -->
			<ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
				<li class="nav-item dropdown">
		        	<a class="nav-link" data-toggle="dropdown" href="#">
		          		<i class="far fa-user"></i>
		        	</a>
		        	<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
		          		<a href="#" class="dropdown-item">
		            		<!-- Message Start -->
		            		<div class="media">
		              			<img src="{{asset('assets/img/user1-128x128.jpg')}}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
		              			<div class="media-body">
		                			<h3 class="dropdown-item-title">
		                  				{{\Auth::user()->name}}
		                			</h3>
		                			<p class="text-sm">{{ ucwords(\Auth::user()->role) }}</p>
		              			</div>
		            		</div>
		            		<!-- Message End -->
		          		</a>
		          		<div class="dropdown-divider"></div>
		          
		          		<a href="{{ route('signout') }}" class="dropdown-item">
		            		<i class="fas fa-sign-out-alt ml-2"></i>&nbsp;&nbsp; Log Out
		          		</a>
		        	</div>
		      	</li>
			</ul>
		</div>
	</nav>
	<!-- /.navbar -->

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper" id="vue-app" v-cloak>
		@yield('content')
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->

	<!-- Control Sidebar -->
	<aside class="control-sidebar control-sidebar-dark">
		<!-- Control sidebar content goes here -->
	</aside>
	<!-- /.control-sidebar -->

	<!-- Main Footer -->
	@include('layouts.admin.footer')
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
@if(App::environment('production'))
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14"></script>
@else
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
@endif
<!-- Bootstrap 4 -->
<script src="{{asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{asset('assets/js/adminlte.min.js') }}"></script>

<script src="{{ asset('assets/js/blockUi.js') }}"></script>

@yield('extra-js')
</body>
</html>
