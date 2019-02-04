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
						<a href="{{ route('createDelivery') }}" class="btn btn-gradient-01 mb-1">Tambah Data</a>
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
					<h4>Tabel Data Pengiriman</h4>

				</div>
				<div class="widget-body">
					<div class="table-responsive">
						<table id="table-delivery-active" class="table mb-0 table-striped">
							<thead>
								<tr>
									<th>ID Pengiriman</th>
									<th>Status</th>
									<th>Customer</th>
									<th>Kurir</th>
									<th>Dilakukan Pengambilan Ke Supplier</th>
									<th>Ongkir</th>
									<th>Item</th>
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
@endsection
@section('js-route')
<script>
	var getDeliveryActive 	= '{{ url('delivery/getDeliveryActive') }}';
	var token 				= '{{ csrf_token() }}';
</script>
@endsection
@section('js')
<script>
	$(document).ready(function() {
		document.getElementById("delivery-link").classList.add('active');
		document.getElementById("delivery-link2").setAttribute('aria-expanded','TRUE');
		document.getElementById("dropdown-delivery").classList.add('show');
		document.getElementById("delivery-active-link").classList.add('active');
		datatables.table_delivery_active();
	});
</script>
@endsection