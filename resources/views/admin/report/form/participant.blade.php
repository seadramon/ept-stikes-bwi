@extends('layouts.app-admin', [
		'class' => '',
		'parentActive' => 'reports',
		'elementActive' => 'report-peserta'
])

@section('title', 'Report Participant')

@section('extra-css')
<link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endsection

@section('content')
<div class="card" id="vue-app" v-cloak>
	<div class="card-header">
		<h3 class="card-title">
			Export Participant by Instansi
		</h3>
	</div>

	<div class="card-body">
  		<div class="form-group">
			<label for="part_id">Instansi</label>
			<select name="instansi" class="form-control select2bs4" id="instansi" v-model="filter.instansis">
				<!-- <option value="">Pilih Instansi : </option> -->
				<option  v-for="(row,idx) in instansi" :value="idx">@{{ row }}</option>
			</select>
		</div>
  	</div>
  	<!-- /.card-body -->

  	<div class="card-footer">
  		<div class="row">
  			<div class="col-md-6">
    			<button type="button" @click="exportPdf()" class="btn btn-danger btn-block btn-flat"><i class="fas fa-file-pdf"></i>&nbsp;PDF</button>
  			</div>
  			<div class="col-md-6">
    			<button type="button" @click="exportXls()" class="btn btn-success btn-block btn-flat"><i class="fas fa-file-excel"></i>&nbsp;Excel</button>
  			</div>
  		</div>
  	</div>
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

<script src="{{asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>
<script type="text/javascript">
	function initialState (){
		return {
			instansi: {!! json_encode($instansi) !!},
			filter: {
				instansis:''
			}
		}
	}

	let app = new Vue({
		el: "#vue-app",
		data: function (){
			return initialState();
		},
		computed: {
			queryParams: function () {
                return JSON.parse(JSON.stringify(this.filter));
            }
		},
		mounted: function() {
			const vm = this;

			$('.select2bs4').select2({
				theme: 'bootstrap4'
			})
			this.$nextTick(this.initSelect2);
		},
		methods: {
			initSelect2: function (e) {
	            var vm = this;
	            $("#instansi").select2({
	            	theme: 'bootstrap4',
	            	placeholder: "Select Instansi"
	            }).on('change', function () {
	                vm.filter.instansis = this.value;
	            });
	        },
	        exportPdf: function() {
	        	var vm = this
	        	let query = new URLSearchParams(vm.queryParams).toString();
	        	// console.log(query)
	        	window.open("{{ route('admin.report.participant-pdf') }}?" + query)
	        	// $.get("{{ route('admin.report.participant-pdf')}}", vm.queryParams)
	        },
	        exportXls: function(e) {
	        	var vm = this;
	        	let query = new URLSearchParams(vm.queryParams).toString();
	        	window.location = "{{ route('admin.report.participant-xls') }}?" + query
	        },
		}
	})
</script>
@endsection