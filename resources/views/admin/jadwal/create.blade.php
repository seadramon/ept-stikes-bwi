@extends('layouts.app-admin', [
		'class' => '',
		'parentActive' => '',
		'elementActive' => 'jadwal'
])

@if (isset($data))
	@section('title', 'Edit Schedule')
@else
	@section('title', 'Add New Schedule')
@endif

@section('extra-css')
<link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

<link rel="stylesheet" href="{{asset('assets/plugins/daterangepicker/daterangepicker.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/filepond/filepond.css')}}" media="all">
@endsection

@section('content')
<div class="row" id="vue-app" v-cloak>
	<div class="col-md-6">
		<div class="card card-primary">
			<div class="card-header">
				<h3 class="card-title">
					Form Jadwal
				</h3>
			</div>

			@if (Session::has('error'))
				<div class="alert alert-danger alert-styled-right alert-dismissible">
					<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
					{{ Session::get('error', 'Error') }}
				</div>
			@endif

			@if (isset($data))
				{!! Form::model($data, ['route' => ['admin.jadwal.store'], 'class' => 'form-horizontal', 'files' => true]) !!}
				{!! Form::hidden('id', null) !!}
			@else
				{!! Form::open(['url' => route('admin.jadwal.store'), 'class' => 'form-horizontal', 'files' => true]) !!}
			@endif
				<div class="card-body">
					@if (count($errors) > 0)
						@foreach($errors->all() as $error)
							<div class="alert alert-danger alert-styled-right alert-dismissible">
								<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
								{{ $error }}
							</div>
						@endforeach
					@endif

					<div class="form-group">
						<label for="period">Start and Finish</label>
						<input type="text" name="period" class="form-control daterange" v-model="data.startend" required>
					</div>

					<div class="form-group">
						<label for="part_id">Paket  <span class="redf">*</span></label>
						<select name="paket" class="form-control select2bs4" id="paket" v-model="data.paket" required>
							<option value="a">A </option>
							<option value="b">B </option>
						</select>
					</div>

					<div class="form-group">
						<label for="part_id">Ruang  <span class="redf">*</span></label>
						<select name="ruang_id" class="form-control select2bs4" id="ruang_id" v-model="data.ruang_id" required>
							<option value="">Pilih Ruangan : </option>
							<option  v-for="(row,idx) in ruangs" :value="idx">@{{ row }}</option>
						</select>
					</div>

					<div class="form-group">
						<label for="part_id">Pengawas  <span class="redf">*</span></label>
						<select name="pengawas_id" class="form-control select2bs4" id="pengawas_id" v-model="data.pengawas_id" required>
							<option value="">Pilih Pengawas : </option>
							<option  v-for="(row,idx) in pengawass" :value="idx">@{{ row }}</option>
						</select>
					</div>

			    	
				</div>
				<!-- /.card-body -->
			</form>
		</div>
		<!-- /.card -->
	</div>

	<div class="col-md-6">
		<div class="card card-info">
			<div class="card-header">
				<h3 class="card-title">
					Manage Participants
				</h3>
			</div>

			<div class="card-body">
				<div class="form-group">
					<label for="part_id">Instansi</label>
					<select class="form-control" id="instansi_id" v-model="sel_instansi">
						<option value="">Pilih Instansi : </option>
						<option  v-for="(row,idx) in instansi" :value="idx">@{{ row }}</option>
					</select>
				</div>

				<div class="form-group">
					<label for="part_id">Role</label>
					<select class="form-control select2bs4" id="role" v-model="sel_role">
						<option value="student" active>Student</option>
						<option value="lecturer">Lecturer</option>
					</select>
				</div>

				<!-- <div class="form-inline"> -->
					<div class="form-group">
						<label for="part_id">Peserta</label>
						<div class="input-group input-group-md">
							<select class="form-control select2bs4" id="peserta_id" v-model="sel_peserta">
								<option value="">Choose Participant</option>
								<option v-for="(row,idx) in peserta" :value="idx + '#'  + row">@{{ row }}</option>
							</select>
		                  	<span class="input-group-append">
		                    	<button type="button" @click.prevent="addParticipant" class="btn btn-info btn-flat">Add</button>
		                  	</span>
		                </div>
					</div>
				<!-- </div> -->

				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Selected Participants</th>
							<th>Role</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(row, idx) in tmp_peserta">
	                        <td>@{{ row.name }}</td>
	                        <td>@{{ row.role }}</td>
	                        <td>
	                            <a href="javascript:void(0)" style="color: red;" @click.prevent="removePeserta(idx)">Remove</a>
	                        </td>
	                    </tr>

	                    <tr class="text-muted" v-if="tmp_peserta.length < 1">
	                        <td colspan="3">&nbsp;There's no participant selected yet</td>
	                    </tr>
					</tbody>
				</table>
			</div>

			<div class="card-footer">
				<button @click.prevent="onSubmit" class="btn btn-primary">
					<span class="indicator-label" v-show="!is_loading">Submit</span>
					<span class="indicator-progress" v-show="is_loading">Please wait...
	                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
	                </span>
				</button>
				<a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary">Cancel</a>
			</div>
		</div>
	</div>
</div>
@endsection

@section('extra-js')
@if(App::environment('production'))
	<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14"></script>
@else
	<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
@endif
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/@flasher/flasher@1.2.4/dist/flasher.min.js"></script>

<script src="{{asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('assets/plugins/filepond/filepond-plugin-file-validate-type.js')}}"></script>
<script src="{{asset('assets/plugins/filepond/filepond.min.js')}}"></script>

<script src="{{asset('assets/js/blockUi.js')}}"></script>

<script src="{{asset('assets/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('assets/plugins/daterangepicker/daterangepicker.js')}}"></script>

<script type="text/javascript">
	function initialState (){
		return {
			jadwal_id: "{{ $jadwal_id }}",
			pesertas: {!! json_encode($peserta) !!},
			part_id:'',
			alertError:false,
			alertSuccess:false,
			msgError: 'Data Question gagal diimport',
			ruangs:{!! json_encode($ruang) !!},
			pengawass:{!! json_encode($pengawas) !!},
			data: {
				startend:{!! json_encode($startend) !!},
				peserta_ids:'',
				ruang_id:{!! json_encode($ruang_id) !!},
				pengawas_id:{!! json_encode($pengawas_id) !!},
				paket:{!! json_encode($paket) !!}
			},
			instansi: {!! json_encode($instansi) !!},
			sel_instansi:'',
			peserta: [],
			sel_peserta: '',
			tmp_peserta: {!! json_encode($monitoring) !!},
			is_loading: false,
			sel_role: 'student'
		}
	}

	let app = new Vue({
		el: "#vue-app",
		data: function (){
			return initialState();
		},
		mounted: function() {
			this.$nextTick(this.initSelect2);
			this.$nextTick(this.initDateRangePicker);
		},
		methods: {
			initDateRangePicker: function(e) {
				$('.daterange').daterangepicker({
					timePicker: true,
					timePicker24Hour:true,
					startDate: moment(),
					locale: {
						format: 'DD/MM/YYYY H:mm'
					}
				})
				.on('apply.daterangepicker', function (ev, picker) {
					app.data.startend = picker.startDate.format('YYYY-MM-DD HH:mm') + ' - ' + picker.endDate.format('YYYY-MM-DD HH:mm');
					console.log(app.data.startend)
				})
			},
			initSelect2: function (e) {
	            const vm = this;

				var pesertaSelect = $("#peserta_id");

				$("#instansi_id").select2({
				    theme: 'bootstrap4'
				}).on('change', function () {
					vm.sel_instansi = this.value;
					pesertaSelect.prop("disabled", true)

					axios.get(
						"{{ route('admin.jadwal.get-peserta') }}",
						{
							params: {
								"instansi": vm.sel_instansi,
							}
						}
					)
					.then(resp => {
						let data = resp.data
						pesertaSelect.empty()

						// vm.sel_peserta = $("#peserta_id").val()
						// console.log(pesertaSelect.select2('data'))

						pesertaSelect.select2({
			                data: data,
			                placeholder: "Choose Participant",
			                theme: 'bootstrap4'
			            }).on('change', function () {
			            	vm.sel_peserta = this.value
			            })

			            vm.sel_peserta = pesertaSelect.select2('data')

			            pesertaSelect.prop("disabled", false)
					})
					.catch(err => {})
				});        
			},
			addParticipant: function() {
				if (app.sel_peserta != "") {
					const arrpeserta = app.sel_peserta.split("#")
		            let idpeserta = arrpeserta[0]
		            let role = app.sel_role

		            let tmp = {id : idpeserta, name: arrpeserta[1], role: role}
		            app.tmp_peserta.push(tmp)
				}
			},
			removePeserta(idx) {
	            app.tmp_peserta.splice(idx, 1)
	        },
	        checkForm: function() {
	        	if (!app.data.ruang_id) {
	        		flasher.error("Room field is required")
	        		return false
	        	}

	        	if (!app.data.pengawas_id) {
	        		flasher.error("Pengawas field is required")
	        		return false
	        	}

	        	if (app.tmp_peserta.length < 1) {
	        		flasher.error("Participant is empty")
	        		return false
	        	}

	        	return true
	        },
	        onSubmit: function() {
	            app.is_loading = true
	            let check = app.checkForm()

	            if (check) {
	            	axios.post(
		            "{{ route('admin.jadwal.store') }}", {
		            	id: app.jadwal_id,
		                period: app.data.startend,
		                ruang_id: app.data.ruang_id,
		                pengawas_id: app.data.pengawas_id,
		                paket: app.data.paket,
		                peserta: app.tmp_peserta
		            })
		            .then(resp => {
		                let response = resp.data
	
		                app.is_loading = false

		                if (response.result == "success") {
		                    flasher.success("Data has been saved successfully!")
		                } else {
		                    flasher.error("Oops! Something went wrong!")
		                }
		            })
		            .catch(err => {
		                app.is_loading = false

		                flasher.error("Oops! Something went wrong!")
		            })
		            .finally(() => {
		                setTimeout(() => {
		                    window.location.href = "{{ route('admin.jadwal.index')}}"        
		                }, 5000)
		            })
	            }
	        },
			reset() {
				Object.assign(this.$data, initialState());
			}
		}
	})
</script>
@endsection