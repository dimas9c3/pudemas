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
						<button type="button" class="btn btn-gradient-01 mb-1" data-toggle="modal" data-target="#add-customer">Tambah Customer</button>
						<button type="button" class="btn btn-gradient-01 mb-1" data-toggle="modal" data-target="#customer-type" >Data Jenis Customer</button>
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
					<strong>Whoops!</strong> Inputan anda tidak sesuai dengan format yang ditentukan. Pastikan Nomor Hp diawali "08" lalu diikuti digit nomor yang benar.<br><br>
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
			<!-- Begin Customer -->
			<div class="widget has-shadow">
				<div class="widget-header bordered no-actions d-flex align-items-center">
					<h4>Tabel Customer</h4>

				</div>
				<div class="widget-body">
					<div class="table-responsive">
						<table id="table-customer" class="table mb-0">
							<thead>
								<tr>
									<th>No</th>
									<th>ID</th>
									<th>Nama</th>
									<th>Jenis</th>
									<th>Email</th>
									<th>Hp</th>
									<th>Alamat</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>

							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- End Customer -->
		</div>
	</div>
	<!-- End Row -->
</div>
<!-- End Container -->
<!-- Begin Add Customer -->
<div id="add-customer" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="POST" enctype="multipart/form-data" action="{{ route('storeCustomer') }}">
				@csrf
				<div class="modal-header">
					<h4 class="modal-title">Tambah Data</h4>
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">×</span>
						<span class="sr-only">close</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group row d-flex align-items-center mb-2">
						<label class="col-lg-3 form-control-label d-flex justify-content-lg-end">Nama *</label>
						<div class="col-lg-9">
							<input type="text" name="name" class="form-control" placeholder="Input Nama" required autofocus>
						</div>
					</div>
					<div class="form-group row d-flex align-items-center mb-2">
						<label class="col-lg-3 form-control-label d-flex justify-content-lg-end">Jenis *</label>
						<div class="col-lg-9">
							<select name="type" class="form-control select2 select-customer-type" required>
							</select>
						</div>
					</div>
					<div class="form-group row d-flex align-items-center mb-2">
						<label class="col-lg-3 form-control-label d-flex justify-content-lg-end">Email *</label>
						<div class="col-lg-9">
							<input type="text" name="email" class="form-control" placeholder="Input Email">
						</div>
					</div>
					<div class="form-group row d-flex align-items-center mb-2">
						<label class="col-lg-3 form-control-label d-flex justify-content-lg-end">Hp *</label>
						<div class="col-lg-9">
							<input type="text" name="phone" class="form-control" placeholder="Input Nomor Hp">
						</div>
					</div>
					<div class="form-group row d-flex align-items-center mb-2">
						<label class="col-lg-3 form-control-label d-flex justify-content-lg-end">Alamat *</label>
						<div class="col-lg-9">
							<textarea name="address" class="form-control" rows="5" placeholder="Input Alamat"></textarea>
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
<!-- End Add Customer -->
<!-- Begin Destroy Customer -->
<div id="delete-customer" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="POST" enctype="multipart/form-data" action="{{ route('destroyCustomer') }}">
				@csrf
				<div class="modal-header">
					<h4 class="modal-title">Hapus Data</h4>
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">×</span>
						<span class="sr-only">close</span>
					</button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="id" class="id-customer" value="">
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
<!-- End Destroy Customer Type -->
<!-- Begin Update Customer -->
<div id="update-customer" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="POST" enctype="multipart/form-data" action="{{ route('updateCustomer') }}">
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
							<input type="hidden" name="id" id="edit-customer-id" value="">
							<input type="text" name="name" id="edit-customer-name" class="form-control" value="">
						</div>
					</div>
					<div class="form-group row d-flex align-items-center mb-2">
						<label class="col-lg-3 form-control-label d-flex justify-content-lg-end">Jenis *</label>
						<div class="col-lg-9">
							<select name="type" class="form-control select2 select-customer-type" id="edit-customer-type" required>
							</select>
						</div>
					</div>
					<div class="form-group row d-flex align-items-center mb-2">
						<label class="col-lg-3 form-control-label d-flex justify-content-lg-end">Email</label>
						<div class="col-lg-9">
							<input type="text" name="email" class="form-control" id="edit-customer-email">
						</div>
					</div>
					<div class="form-group row d-flex align-items-center mb-2">
						<label class="col-lg-3 form-control-label d-flex justify-content-lg-end">Hp</label>
						<div class="col-lg-9">
							<input type="text" name="phone" class="form-control" id="edit-customer-phone">
						</div>
					</div>
					<div class="form-group row d-flex align-items-center mb-2">
						<label class="col-lg-3 form-control-label d-flex justify-content-lg-end">Alamat</label>
						<div class="col-lg-9">
							<textarea name="address" class="form-control" rows="5" id="edit-customer-address"></textarea>
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
<!-- End Update Customer -->
<!-- Begin Customer Type -->
<div id="customer-type" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form class="needs-validation" novalidate>
				<div class="modal-header">
					<h4 class="modal-title">Data Jenis Customer</h4>
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">×</span>
						<span class="sr-only">close</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="table-responsive">
						<table id="table-customer-type" class="table mb-0" style="width: 100%;">
							<thead>
								<tr>
									<th>No</th>
									<th>Customer Type</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								
							</tbody>
						</table>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" data-toggle="modal" data-target="#add-customer-type" data-dismiss="modal" class="btn btn-success">Tambah Data</button>
					<button type="button" class="btn btn-shadow" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- End Customer Type -->
<!-- Begin Add Customer Type -->
<div id="add-customer-type" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="POST" enctype="multipart/form-data" action="{{ route('storeCustomerType') }}">
				@csrf
				<div class="modal-header">
					<h4 class="modal-title">Tambah Data</h4>
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">×</span>
						<span class="sr-only">close</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group row d-flex align-items-center mb-2">
						<label class="col-lg-3 form-control-label d-flex justify-content-lg-end">Nama *</label>
						<div class="col-lg-9">
							<input type="text" name="name" class="form-control" placeholder="Input Nama" required autofocus>
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
<!-- End Add Customer Type -->
<!-- Begin Destroy Customer Type -->
<div id="delete-customer-type" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="POST" enctype="multipart/form-data" action="{{ route('destroyCustomerType') }}">
				@csrf
				<div class="modal-header">
					<h4 class="modal-title">Hapus Data</h4>
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">×</span>
						<span class="sr-only">close</span>
					</button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="id" class="id-customer-type" value="">
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
<!-- End Destroy Customer Type -->
<!-- Begin Update Customer Type -->
<div id="update-customer-type" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="POST" enctype="multipart/form-data" action="{{ route('updateCustomerType') }}">
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
							<input type="hidden" name="id" class="id-customer-type" value="">
							<input type="text" id="update-nama-customer-type" name="name" class="form-control" value="">
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
<!-- End Update Customer Type -->
@endsection
@section('js-route')
<script>
	var getCustomer         = '{{ route('getCustomer') }}';
	var getCustomerType 	= '{{ route('getCustomerType') }}';
	var getCustomerById 	= '{{ route('getCustomerById') }}';
	var selectCustomerType 	= '{{ route('selectCustomerType') }}';
	var token 				= '{{ csrf_token() }}';
</script>
@endsection
@section('js')
<script>
	$(document).ready(function() {
		document.getElementById("master-link").classList.add('active');
		document.getElementById("master-link2").setAttribute('aria-expanded','TRUE');
		document.getElementById("dropdown-master").classList.add('show');
		document.getElementById("customer-link").classList.add('active');
		datatables.table_customer();
		datatables.table_customer_type();
		select2.selectCustomerType();
		showModal.destroyCustomer();
		showModal.destroyCustomerType();
		showModal.updateCustomer();
		showModal.updateCustomerType();
	});
</script>
@endsection