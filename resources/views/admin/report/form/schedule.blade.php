@extends('layouts.app-admin', [
		'class' => '',
		'parentActive' => 'reports',
		'elementActive' => 'report-schedule'
])

@section('title', 'Report Active Schedule')

@section('extra-css')
<link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endsection

@section('content')
<div class="card" id="vue-app" v-cloak>
	<div class="card-header">
		<h3 class="card-title">
			Export Active Schedule
		</h3>
	</div>

	<div class="card-body">
  		<div class="form-group">
			<label for="part_id">Ruang</label>
			<select name="ruang_id" class="form-control select2bs4" id="ruang_id" v-model="filter.ruang_id" required>
				<option value="">Pilih Ruangan : </option>
				<option  v-for="(row,idx) in ruangs" :value="idx">@{{ row }}</option>
			</select>
		</div>

		<div class="form-group">
			<label for="part_id">Pengawas</label>
			<select name="pengawas_id" class="form-control select2bs4" id="pengawas_id" v-model="filter.pengawas_id" required>
				<option value="">Pilih Pengawas : </option>
				<option  v-for="(row,idx) in pengawass" :value="idx">@{{ row }}</option>
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
			ruangs:{!! json_encode($ruang) !!},
			pengawass:{!! json_encode($pengawas) !!},
			filter: {
				ruang_id:'',
				pengawas_id:''
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
			this.$nextTick(this.initSelect2);
		},
		methods: {
			initSelect2: function (e) {
	            var vm = this;

	            $("#ruang_id").select2({
	            	theme: 'bootstrap4',
	            }).on('change', function () {
	                vm.filter.ruang_id = this.value;
	            });

	            $("#pengawas_id").select2({
	            	theme: 'bootstrap4',
	            }).on('change', function () {
	                vm.filter.pengawas_id = this.value;
	            });
	        },
			exportPdf: function() {
	        	var vm = this
	        	let query = new URLSearchParams(vm.queryParams).toString();
	        	window.open("{{ route('admin.report.schedule-pdf') }}?" + query)
	        },
	        exportXls: function(e) {
	        	var vm = this;
	        	let query = new URLSearchParams(vm.queryParams).toString();
	        	window.location = "{{ route('admin.report.schedule-xls') }}?" + query
	        },
		}
	})
</script>
@endsection