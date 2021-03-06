@extends('backend.partial.app')
@section('content')
<div class="container-fluid">
	<!-- Begin Page Header-->
	<div class="row">
		<div class="page-header">
			<div class="d-flex align-items-center">
				<h2 class="page-header-title">{{ $page }}</h2>
				<div>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="ti ti-home"></i></a></li>
						<li class="breadcrumb-item active">{{ $page }}</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<!-- End Page Header -->
	<div class="row">
		<div class="page-header">
			<div class="d-flex align-items-center">
				<div>
					<div class="page-header-tools">
						<a href="{{ route('createPickup') }}" class="btn btn-gradient-01 mb-1">Tambah Data</a>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-12">
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
			<!-- Begin Supplier -->
			<div class="widget has-shadow">
				<div class="widget-header bordered no-actions d-flex align-items-center">
					<h4>Tabel Data Pengambilan</h4>

				</div>
				<div class="widget-body">
					<div class="table-responsive">
						<table id="table-pickup-cancel" class="table mb-0 table-striped">
							<thead>
								<tr>
									<th>ID PICKUP</th>
									<th>Tanggal</th>
									<th>Status</th>
									<th>Kurir</th>
									<th>Jenis</th>
									<th>Langsung Dikirim Ke Customer</th>
									<th>Item</th>
									<th>Supplier</th>
									<th>Qty</th>
									<th>Harga</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>

							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- End Supplier -->
		</div>
	</div>
	<!-- End Row -->
</div>
<!-- End Container -->
<!-- Begin Destroy Supplier -->
<div id="delete-supplier" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="POST" enctype="multipart/form-data" action="{{ url('supplier/destroySupplier') }}">
				@csrf
				<div class="modal-header">
					<h4 class="modal-title">Hapus Data</h4>
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">×</span>
						<span class="sr-only">close</span>
					</button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="id" class="id-supplier" value="">
					<strong><p>Apakah Anda Yakin Akan Menghapus Data Ini ?</p></strong>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Submit</button>
					<button type="button" class="btn btn-shadow" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- End Destroy Item -->
<!-- Begin Update Supplier -->
<div id="update-supplier" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="POST" enctype="multipart/form-data" action="{{ url('supplier/updateSupplier') }}">
				@csrf
				<div class="modal-header">
					<h4 class="modal-title">Edit Data</h4>
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">×</span>
						<span class="sr-only">close</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group row d-flex align-items-center mb-2">
						<label class="col-lg-3 form-control-label d-flex justify-content-lg-end">Nama *</label>
						<div class="col-lg-9">
							<input type="hidden" name="id" class="id-supplier" value="">
							<input type="text" name="name" id="update-name" class="form-control" value="">
						</div>
					</div>
					<div class="form-group row d-flex align-items-center mb-2">
						<label class="col-lg-3 form-control-label d-flex justify-content-lg-end">Email *</label>
						<div class="col-lg-9">
							<input type="text" name="email" id="update-email" class="form-control" value="">
						</div>
					</div>
					<div class="form-group row d-flex align-items-center mb-2">
						<label class="col-lg-3 form-control-label d-flex justify-content-lg-end">Hp *</label>
						<div class="col-lg-9">
							<input type="text" name="phone" id="update-phone" class="form-control" value="">
						</div>
					</div>
					<div class="form-group row d-flex align-items-center mb-2">
						<label class="col-lg-3 form-control-label d-flex justify-content-lg-end">Alamat *</label>
						<div class="col-lg-9">
							<textarea name="address" id="update-address" class="form-control" rows="5"></textarea>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Submit</button>
					<button type="button" class="btn btn-shadow" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- End Update Supplier -->
@endsection
@section('js-route')
<script>
	var getPickupCancel  	= '{{ url('pickup/getPickupCancel') }}';
	var getPickupActiveById = '{{ url('pickup/getPickupActiveById') }}';
	var token 				= '{{ csrf_token() }}';
</script>
@endsection
@section('js')
<script>
	$(document).ready(function() {
		document.getElementById("pickup-link").classList.add('active');
		document.getElementById("pickup-link2").setAttribute('aria-expanded','TRUE');
		document.getElementById("dropdown-pickup").classList.add('show');
		document.getElementById("pickup-cancel-link").classList.add('active');
		datatables.table_pickup_cancel();
	});
</script>
@endsection