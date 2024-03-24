<aside class="main-sidebar sidebar-dark-primary elevation-5">
	<!-- Brand Logo -->
	@if (\Auth::user()->role == 'administrator')
		<a href="{{ route('admin.dashboard') }}" class="brand-link" style="font-size: 1.15rem;">
	@else
		<a href="/" class="brand-link" style="font-size: 1.15rem;">
	@endif
		<img src="{{asset('assets/img/ept.png')}}" alt="English Proficiency Test" class="brand-image elevation-3" style="opacity: .8">
		<span class="brand-text font-weight-light">English Proficiency Test</span>
	</a>

	<!-- Sidebar -->
	<div class="sidebar">
		<!-- Sidebar user panel (optional) -->
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image">
				<img src="{{ Avatar::create(\Auth::user()->name)->toBase64() }}" class="img-circle elevation-2" alt="User Image">
			</div>
			<div class="info">
				<a href="#" class="d-block">{{\Auth::user()->name}}</a>
			</div>
		</div>

		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<!-- Add icons to the links using the .nav-icon class
						 with font-awesome or any other icon font library -->
				
				@if (\Auth::user()->role == 'peserta')
					<li class="nav-item">
						<a href="{{ route('home') }}" class="nav-link {{ $elementActive == 'home' ? 'active' : '' }}">
							<i class="nav-icon fas fa-home"></i>
							<p>
								Home
							</p>
						</a>
					</li>
				@else
					<li class="nav-item">
						<a href="{{ route('admin.dashboard') }}" class="nav-link {{ $elementActive == 'home' ? 'active' : '' }}">
							<i class="nav-icon fas fa-home"></i>
							<p>
								Home
							</p>
						</a>
					</li>
				@endif

				@if (\Auth::user()->role == 'administrator')
					<li class="nav-item {{ $parentActive == 'user' ? 'menu-open' : '' }}">
			            <a href="#" class="nav-link {{ $parentActive == 'user' ? 'active' : '' }}">
			              	<i class="nav-icon fas fa-user-friends"></i>
			              	<p>
			                	Users
			                	<i class="right fas fa-angle-left"></i>
			              	</p>
			            </a>
			            <ul class="nav nav-treeview">
			              	<li class="nav-item">
			                	<a href="{{ route('admin.user.index', ['role' => 'administrator']) }}" class="nav-link {{ $elementActive == 'user-administrator' ? 'active' : '' }}">
			                  	<i class="far fa-circle nav-icon"></i>
			                  	<p>Administrator</p>
			                	</a>
			              	</li>
			              	<li class="nav-item">
			                	<a href="{{ route('admin.user.index', ['role' => 'pengawas']) }}" class="nav-link {{ $elementActive == 'user-pengawas' ? 'active' : '' }}">
			                  	<i class="far fa-circle nav-icon"></i>
			                  	<p>Pengawas</p>
			                	</a>
			              	</li>
			              	<li class="nav-item">
			                	<a href="{{ route('admin.user.index', ['role' => 'peserta']) }}" class="nav-link {{ $elementActive == 'user-peserta' ? 'active' : '' }}">
			                  	<i class="far fa-circle nav-icon"></i>
			                  	<p>Peserta</p>
			                	</a>
			              	</li>
			            </ul>
			        </li>
			        <li class="nav-item">
						<a href="{{ route('admin.ruang.index') }}" class="nav-link {{ $elementActive == 'room' ? 'active' : '' }}">
							<i class="nav-icon fas fa-house-user"></i>
							<p>
								Rooms
							</p>
						</a>
					</li>
				@endif

				@if (\Auth::user()->role == 'administrator')
					<li class="nav-item {{ $parentActive == 'exams' ? 'menu-open' : '' }}">
			            <a href="#" class="nav-link {{ $parentActive == 'exams' ? 'active' : '' }}">
			              	<i class="nav-icon fas fa-list-alt"></i>
			              	<p>
			                	Questions
			                	<i class="right fas fa-angle-left"></i>
			              	</p>
			            </a>
			            <ul class="nav nav-treeview">
			              	<li class="nav-item">
			                	<a href="{{ route('admin.exam.section.index') }}" class="nav-link {{ $elementActive == 'section' ? 'active' : '' }}">
			                  	<i class="far fa-circle nav-icon"></i>
			                  	<p>Section</p>
			                	</a>
			              	</li>
			              	<li class="nav-item">
			                	<a href="{{ route('admin.exam.part.index') }}" class="nav-link {{ $elementActive == 'part' ? 'active' : '' }}">
			                  	<i class="far fa-circle nav-icon"></i>
			                  	<p>Part</p>
			                	</a>
			              	</li>
			              	<li class="nav-item">
			                	<a href="{{ route('admin.exam.question.index') }}" class="nav-link {{ $elementActive == 'question' ? 'active' : '' }}">
			                  	<i class="far fa-circle nav-icon"></i>
			                  	<p>Question</p>
			                	</a>
			              	</li>
			            </ul>
			        </li>
			    @endif

				@if (\Auth::user()->role != 'peserta')
			        <li class="nav-item">
						<a href="{{ route('admin.jadwal.index') }}" class="nav-link {{ $elementActive == 'jadwal' ? 'active' : '' }}">
							<i class="nav-icon fas fa-th-list"></i>
							<p>
								Schedule
							</p>
						</a>
					</li>
				@endif

				@if (\Auth::user()->role == 'peserta')
					<li class="nav-item">
						<a href="{{ route('exam.pscore') }}" class="nav-link {{ $elementActive == 'pscore' ? 'active' : '' }}">
							<i class="nav-icon fas fa-th-list"></i>
							<p>
								Score
							</p>
						</a>
					</li>
				@endif

				@if (\Auth::user()->role != 'peserta')
					<li class="nav-item {{ $parentActive == 'reports' ? 'menu-open' : '' }}">
			            <a href="#" class="nav-link {{ $parentActive == 'reports' ? 'active' : '' }}">
			              	<i class="nav-icon fas fa-list-alt"></i>
			              	<p>
			                	Reports
			                	<i class="right fas fa-angle-left"></i>
			              	</p>
			            </a>
			            <ul class="nav nav-treeview">
			              	<li class="nav-item">
			                	<a href="{{ route('admin.report.participant') }}" class="nav-link {{ $elementActive == 'report-peserta' ? 'active' : '' }}">
			                  	<i class="far fa-circle nav-icon"></i>
			                  	<p>Participant</p>
			                	</a>
			              	</li>
			              	<li class="nav-item">
			                	<a href="{{ route('admin.report.room') }}" class="nav-link {{ $elementActive == 'report-room' ? 'active' : '' }}">
			                  	<i class="far fa-circle nav-icon"></i>
			                  	<p>Room</p>
			                	</a>
			              	</li>
			              	<li class="nav-item">
			                	<a href="{{ route('admin.report.schedule') }}" class="nav-link {{ $elementActive == 'report-schedule' ? 'active' : '' }}">
			                  	<i class="far fa-circle nav-icon"></i>
			                  	<p>Schedule</p>
			                	</a>
			              	</li>
			            </ul>
			        </li>
				@endif
			</ul>
		</nav>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>