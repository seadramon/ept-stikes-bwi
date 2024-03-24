@extends('layouts.app-admin', [
		'class' => '',
		'parentActive' => 'reports',
		'elementActive' => 'report-room'
])

@section('title', 'Report Room')

@section('extra-css')
<link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endsection

@section('content')
<div class="card" id="vue-app" v-cloak>
	<div class="card-header">
		<h3 class="card-title">
			Export Participant with Score by Room
		</h3>
	</div>

	<div class="card-body">
  		<div class="form-group">
			<label for="part_id">Rooms  <span class="redf">*</span></label>
			<select name="ruang_id" class="form-control select2bs4" id="ruang_id" v-model="filter.ruang_id" required>
				<option value="">Select Room : </option>
				<option  v-for="(row,idx) in rooms" :value="idx">@{{ row }}</option>
			</select>
		</div>

		<div class="form-group">
			<label for="part_id">Schedule  <span class="redf">*</span></label>
			<select name="jadwal_id" class="form-control select2bs4" id="jadwal_id" v-model="filter.jadwal_id" required>
				<option value="">Select Schedule : </option>
				<option  v-for="(row,idx) in schedules" :value="idx">@{{ row }}</option>
			</select>
		</div>
  	</div>
  	<!-- /.card-body -->

  	<div class="card-footer">
  		<div class="row">
  			<div class="col-md-6">
    			<button type="button" :disabled="toPdf" @click="exportPdf()" class="btn btn-danger btn-block btn-flat"><i class="fas fa-file-pdf"></i>&nbsp;PDF</button>
  			</div>
  			<div class="col-md-6">
    			<button type="button" :disabled="toXls" @click="exportXls()" class="btn btn-success btn-block btn-flat"><i class="fas fa-file-excel"></i>&nbsp;Excel</button>
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
			rooms:{!! json_encode($rooms) !!},
			schedules:'',
			toPdf: true,
			toXls: true,
			filter: {
				ruang_id:'',
				jadwal_id:''
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
		watch: {
			'filter.ruang_id': function (newVal, oldVal) {
				let vm = this
                if (newVal && vm.filter.jadwal_id) {
                	vm.toPdf = false
                	vm.toXls = false
                } else {
                	vm.toPdf = true
                	vm.toXls = true
                }
            },
            'filter.jadwal_id': function (newVal, oldVal) {
                let vm = this
                if (newVal && vm.filter.ruang_id) {
                	vm.toPdf = false
                	vm.toXls = false
                } else {
                	vm.toPdf = true
                	vm.toXls = true
                }
            }
		},
		methods: {
			initSelect2: function (e) {
	            var vm = this;
	            vm.schedules = ''

	            $("#jadwal_id").select2({
	            	theme: 'bootstrap4',
	            }).on('change', function () {
	            	vm.filter.jadwal_id = this.value;
	            });

	            $("#ruang_id").select2({
	            	theme: 'bootstrap4',
	            }).on('change', function () {
	                vm.filter.ruang_id = this.value;
	                vm.schedules = ''

	                let query = new URLSearchParams(vm.queryParams).toString();

	            	$.get('{{ route('admin.report.sch-room') }}', vm.queryParams)
                	.done(function (result) {
                		vm.schedules = result
                	}.bind(this))
                    	.always(function() {
                    }.bind(this));
	            });

	            $("#ruang_id").select2({
	            	theme: 'bootstrap4',
	            }).on('change', function () {
	                vm.filter.ruang_id = this.value;
	            });
	        },
			exportPdf: function() {
	        	var vm = this
	        	let query = new URLSearchParams(vm.queryParams).toString();
	        	window.location = "{{ route('admin.report.room-pdf') }}?" + query
	        },
	        exportXls: function(e) {
	        	var vm = this;
	        	let query = new URLSearchParams(vm.queryParams).toString();
	        	window.location = "{{ route('admin.report.room-xls') }}?" + query
	        },
		}
	})
</script>
@endsection