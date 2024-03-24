@extends('layouts.app-admin', [
		'class' => '',
		'elementActive' => 'home'
])

@section('title', 'Data Question')

@section('extra-css')
<link rel="stylesheet" href="{{asset('assets/plugins/filepond/filepond.css')}}" media="all">
@endsection

@section('content')
<div class="card" id="vue-app" v-cloak>
	<div class="card-header">
		<h3 class="card-title">
			Import Data Question
		</h3>
	</div>

	<form action="{{ route('admin.exam.question.import-excel-store') }}" class="form-horizontal" method="POST" enctype="multipart/form-data" id="formUpload" @submit="onSubmit">
	  	<div class="card-body">
	  		<!-- notification -->
	  		<div class="alert alert-danger alert-styled-right alert-dismissible" v-show="alertError">
		        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
		        <strong>Error!</strong> @{{ msgError }}
		    </div>

		    <div class="alert alert-success alert-styled-right alert-arrow-right alert-dismissible" v-show="alertSuccess">
		        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
		        <strong>Success!</strong> Data Question berhasil diimport
		    </div>
		    <!-- ./notification -->

            <div class="form-group">
                <label for="part_id">Part *</label>
                <select name="part_id" class="form-control select2bs4" id="part_id" v-model="part_id" required>
                    <option  v-for="(row,idx) in parts" :value="idx">@{{ row }}</option>
                </select>
            </div>

	  		<div class="form-group">
	      		<div class=""><input type="file" class="filePond" name="inputExcel" accept=".xlsx, .xls" id="inputExcel"></div>
	    	</div>
	  	</div>
	  	<!-- /.card-body -->

	  	<div class="card-footer">
	    	<button type="submit" @click="onSubmit" class="btn btn-primary">Submit</button>
	    	<a href="{{ route('admin.exam.question.index') }}" class="btn btn-secondary">Cancel</a>
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
            parts: {!! json_encode($part) !!},
            part_id:'',
        	alertError:false,
        	alertSuccess:false,
            msgError: 'Data Question gagal diimport'
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
    	            url: "{{ route('admin.exam.question.upload-excel') }}",
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
	                "{{ route('admin.exam.question.import-excel-store') }}", {
                        part_id:vm.part_id,
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
                            vm.msgError = 'Data Question gagal diimport'
	                	}
	                })
	                .catch(err => {
	                	vm.alertError = true
                        vm.msgError = 'Data Question gagal diimport'
	                })
	                .finally(() => {
	                    $.unblockUI()

	                    setTimeout(() => {
                            this.reset()
                        }, 5000)
	                }); 
        		} else {
                    vm.alertError = true
                    vm.msgError = 'Data excel belum diupload'

                    setTimeout(() => {
                        this.reset()
                    }, 5000)
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