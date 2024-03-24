<!doctype html>
<html lang="en">
<head>
	<title>English Proficiency Test - Stikes Banyuwangi</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="shortcut icon" href="{{ asset('assets/img/ept.ico') }}">
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="{{asset('assets/css/login.css')}}">
</head>

<body>
<section class="ftco-section">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12 col-lg-10">
				<div class="wrap d-md-flex">
					<div class="img" style="background-image: url({{asset('assets/img/bg-stikes.jpeg')}});">
		      		</div>
					<div class="login-wrap p-4 p-md-5">
		      			<div class="d-flex">
		      				<div class="w-100">
		      					<h3>Reset Password</h3>
		      				</div>
		      			</div>

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

						<form action="{{ route('resetpwd') }}" method="post" class="signin-form mb-3">
							@csrf
		      				<div class="form-group mb-3">
		      					<label class="label" for="name">Email</label>
		      					<input type="email" name="email" class="form-control" placeholder="Email" required>
		      				</div>
	            			<div class="form-group">
	            				<button type="submit" class="form-control btn btn-primary rounded submit px-3">Reset</button>
	            			</div>

	            			<div class="form-group d-md-flex">
	            				<div class="w-50 text-left">
		            				<label class="checkbox-wrap checkbox-primary mb-0">
									</label>
								</div>
								<div class="w-50 text-md-right">
									<a href="{{ route('login') }}">Sign In</a>
								</div>
	            			</div>
	          			</form>
	          			<br>
	          			<br>
	          			<br>
	          			<hr>
	          			<div class="row mt-3">
	          				<div class="col-md-3" style="color: #e3b04b;font-size: 13px;">
	          					Call Center :
	          				</div>
	          				<div class="col-md-9 text-left" style="font-size: 13px;">
	          					<i class="fa fa-whatsapp" aria-hidden="true" style="color:#008000;"></i> &nbsp;0857-4970-0840 | M. Nashir<br>
	          					<i class="fa fa-whatsapp" aria-hidden="true" style="color:#008000;"></i> &nbsp;0857-4801-5150 | Roudlotun N.L
	          				</div>
	          			</div>

	        		</div>
	      		</div>
			</div>
		</div>
	</div>
</section>

<!-- jQuery -->
<script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{asset('assets/js/adminlte.min.js') }}"></script>
</body>
</html>
