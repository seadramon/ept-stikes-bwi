@extends('layouts.app')

@section('title', 'EPT - exam')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container">
		<!-- <div class="row mb-1">
			<div class="col-sm-6">
				<h1 class="m-0"> &nbsp;</h1>
			</div>
		</div> -->
	</div>
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
						<h5 class="card-title m-0">Information</h5>
					</div>
					<div class="card-body">
						
							<dl class="row">
								@foreach($sections as $section)
	                  				<dt class="col-sm-4">{{ $section->title }}</dt>
	                  				<dd class="col-sm-8">{!! $section->subtitle !!}</dd>
	                  			@endforeach
	                		</dl>
	                		
	                		@if (empty($monitoring->total))
								<center>
									<a href="{{ route('exam.main', ['idmonitoring' => $monitoring->id, 'section' => '1']) }}" class="btn btn-block btn-info">Start!</a>
								</center>
							@endif
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
        },
        mounted: function() {
        	localStorage.removeItem("section1_timer");
        	localStorage.removeItem("section2_timer");
        	localStorage.removeItem("section3_timer");
        }
    });
</script>
<script>
    
</script>
@endsection