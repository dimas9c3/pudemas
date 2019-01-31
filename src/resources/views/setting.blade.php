@extends('backend.partial.app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-xl-12">
			<div class="widget has-shadow">
				<div class="widget-header bordered no-actions d-flex align-items-center">
					<h4>{{ $page }}</h4>
				</div>
				<div class="widget-body">
					<div class="col-10 ml-auto">
						<div class="section-title mt-3 mb-3">
							<h4>General Setting</h4>
						</div>
						<!-- Begin Alert -->
						@if (session()->has('success'))
						<div class="alert alert-success alert-dismissible fade show">
							<span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
							<span class="alert-inner--text"><strong>{{ session()->get('success') }}</strong></span>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
						</div>
						@endif
						@if (session()->has('error'))
						<div class="alert alert-danger alert-dismissible fade show">
							<span class="alert-inner--icon"><i class="ni ni-fat-remove"></i></span>
							<span class="alert-inner--text"><strong>{{ session()->get('error') }}</strong></span>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
						</div>
						@endif
						@if ($errors->any())
						<div class="alert alert-danger alert-dismissible fade show">
							<span class="alert-inner--icon"><i class="ni ni-fat-remove"></i></span>
							<span class="alert-inner--text">
								<strong>Whoops!</strong> Inputan anda tidak sesuai dengan format yang ditentukan. Pastikan nomer HP diawali dengan "08".<br><br>
								<ul>
									@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
									@endforeach
								</ul>
							</span>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
						</div>
						@endif
						<!-- End Alert -->
					</div>
					<form class="form-horizontal" method="POST" enctype="multipart/form-data" action="{{ url('setting/updateSetting') }}">
						@csrf
						<div class="form-group row d-flex align-items-center mb-5">
							<label class="col-lg-2 form-control-label d-flex justify-content-lg-end">ID Kurir</label>
							<div class="col-lg-6">
								<input type="text" class="form-control" name="id_courier" value="{{ $setting[0]->id_courier }}" required>
							</div>
						</div>
						<div class="form-group row d-flex align-items-center mb-5">
							<label class="col-lg-2 form-control-label d-flex justify-content-lg-end">Latitude Default Toko</label>
							<div class="col-lg-6">
								<input type="text" class="form-control" name="lat_start" value="{{ $setting[0]->lat_start }}" required>
							</div>
						</div>
						<div class="form-group row d-flex align-items-center mb-5">
							<label class="col-lg-2 form-control-label d-flex justify-content-lg-end">Longtitude Default Toko</label>
							<div class="col-lg-6">
								<input type="text" class="form-control" name="lng_start" value="{{ $setting[0]->lng_start }}" required>
							</div>
						</div>
						<div class="form-group row d-flex align-items-center mb-5">
							<label class="col-lg-2 form-control-label d-flex justify-content-lg-end">Tarif Kirim Per KM</label>
							<div class="col-lg-6">
								<input type="number" class="form-control" name="default_send_cost" value="{{ $setting[0]->default_send_cost }}" required>
							</div>
						</div>

						<div class="em-separator separator-dashed"></div>
						<div class="text-right">
							<button class="btn btn-gradient-01" type="submit">Save Changes</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('js')
<script>
	document.getElementById("setting-link").classList.add('active');
</script>
@endsection