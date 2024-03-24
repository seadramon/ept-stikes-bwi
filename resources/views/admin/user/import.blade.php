@extends('layouts.app-admin', [
        'class' => '',
        'parentActive' => 'user',
        'elementActive' => 'user-'.$role
])

@section('title', 'Data User')

@section('extra-css')
<link rel="stylesheet" href="{{asset('assets/plugins/filepond/filepond.css')}}" media="all">
@endsection

@section('content')
<div class="card" id="vue-app" v-cloak>
	<div class="card-header">
		<h3 class="card-title">
			Import Data {{ $role }}
		</h3>
	</div>

	<form action="{{ route('admin.user.import-excel-store') }}" class="form-horizontal" method="POST" enctype="multipart/form-data" id="formUpload" @submit="onSubmit">
		{!! Form::hidden('role', $role) !!}

	  	<div class="card-body">
	  		<!-- notification -->
	  		<div class="alert alert-danger alert-styled-right alert-dismissible" v-show="alertError">
		        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
		        <strong>Error!</strong> Data Peserta gagal diimport
		    </div>

		    <div class="alert alert-success alert-styled-right alert-arrow-right alert-dismissible" v-show="alertSuccess">
		        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
		        <strong>Success!</strong> Data Peserta berhasil diimport
		    </div>
		    <!-- ./notification -->

	  		<div class="form-group">
	      		<div class=""><input type="file" class="filePond" name="inputExcel" accept=".xlsx, .xls" id="inputExcel"></div>
                <!-- <div class="">
                    <input type="submit" id="uploadBtn" class="btn btn-primary btn-block" value="Upload file">
                </div> -->
                <div style="text-align: right;">
                    <a href="{{ route('admin.user.template') }}">Download Template</a>
                </div>
	    	</div>
	  	</div>
	  	<!-- /.card-body -->

	  	<div class="card-footer">
	    	<button type="submit" @click="onSubmit" class="btn btn-primary">Submit</button>
	    	<a href="{{ route('admin.user.index', ['role' => $role]) }}" class="btn btn-secondary">Cancel</a>
	  	</div>
	</form>
</div>
<!-- /.card -->
@endsection

@section('extra-js')

@if(App::environment('production'))
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14"></script>
@else
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
@endif
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<script src="{{asset('assets/plugins/filepond/filepond-plugin-file-validate-type.js')}}"></script>
<script src="{{asset('assets/plugins/filepond/filepond.min.js')}}"></script>

<script src="{{asset('assets/js/blockUi.js')}}"></script>
<script type="text/javascript">
	function initialState (){
        return {
        	alertError:false,
        	alertSuccess:false,
        	role: "{{ $role }}"
        }
    }

    let app = new Vue({
        el: "#vue-app",
        data: function (){
            return initialState();
        },
        mounted: function() {
        	const vm = this;

    		const inputElement = document.querySelector('input[name="inputExcel"]');
    	    const pond = FilePond.create( inputElement, {
    	        acceptedFileTypes: [
    	           'application/vnd.ms-excel',
    	           'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    	       ]
    	    });

    	    FilePond.setOptions({
    	        server: {
    	            url: "{{ route('admin.user.upload-excel') }}",
    	            headers : {
    	                'X-CSRF-TOKEN': '{{ csrf_token() }}'
    	            }
    	        },
    	        onprocessfiles: function(){
    	            vm.alertError = false
    	        }
    	    });
        },
        methods: {
        	onSubmit: function(e) {
        		e.preventDefault();

        		const vm = this;

        		let inputExcel = $("input[name=inputExcel]").val();

        		if (inputExcel) {
	        		vm.onLoading();

					axios.post(
	                "{{ route('admin.user.import-excel-store') }}", {
	                    role:vm.role,
	                    inputExcel:inputExcel
	                })
	                .then(resp => {
	                	if (resp.data.result == "success") {
	                		console.log('masuk sukses')
	                		vm.alertSuccess = true
	                	} else {
	                		console.log('masuk error')
	                		vm.alertError = true
	                	}
	                })
	                .catch(err => {
	                	vm.alertError = true
	                })
	                .finally(() => {
	                    $.unblockUI()

	                    setTimeout(() => {
                            this.reset()
                        }, 5000)
	                }); 
        		}
        	},
        	onLoading: function() {
                $.blockUI({ 
                    message: "<div class='fa-4x'><i class='fas fa-cog fa-spin'></i></div>Loading Data <br> <b>Please wait!</b>",
                    baseZ: 2000,
                    css:{
                        margin:     0,
                        width:      '27%',
                        top:        '20%',
                        left:       '35%',
                        textAlign:  'center',
                        color:      '#000',
                        backgroundColor:'#fff',
                        cursor:     'wait',
                        border: 'none',
                        padding: '2em',
                        '-webkit-border-radius': '10px',
                        '-moz-border-radius': '10px',
                        // opacity: .5,
                    }
                });
            },
            reset() {
                Object.assign(this.$data, initialState());
            }

        }
    })
</script>
@endsection