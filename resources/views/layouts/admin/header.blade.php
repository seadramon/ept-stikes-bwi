<nav class="main-header navbar navbar-expand navbar-white navbar-light">
	<!-- Left navbar links -->
	<ul class="navbar-nav">
		<li class="nav-item">
			<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
		</li>
	</ul>

	<!-- Right navbar links -->
	<ul class="navbar-nav ml-auto">
		<!-- Messages Dropdown Menu -->
      	<li class="nav-item dropdown">
        	<a class="nav-link" data-toggle="dropdown" href="#">
          		<i class="far fa-user"></i>
        	</a>
        	<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          		<a href="#" class="dropdown-item">
            		<!-- Message Start -->
            		<div class="media">
              			<img src="{{ Avatar::create(\Auth::user()->name)->toBase64() }}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
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
</nav>