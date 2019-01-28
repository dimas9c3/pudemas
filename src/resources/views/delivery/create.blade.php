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
						<li class="breadcrumb-item"><a href="{{ route('delivery') }}">Delivery</a></li>
						<li class="breadcrumb-item active">{{ $page }}</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<!-- End Page Header -->
	<div class="row">
		<div class="page-header">
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
					<strong>Whoops!</strong> Inputan anda tidak sesuai dengan format yang ditentukan.<br><br>
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
			<div class="row">
				<div class="col-md-6 col-xs-12">
					<!-- Form -->
					<div class="widget has-shadow">
						<div class="widget-header bordered no-actions d-flex align-items-center">
							<h4>Input Barang Yang Akan Dikirim</h4>
						</div>
						<div class="widget-body">
							<form class="needs-validation" novalidate>
								<div class="form-group row d-flex align-items-center mb-3">
									<label class="col-lg-4 form-control-label d-flex justify-content-lg-start">Nama Barang</label>
									<div class="col-lg-8">
										<select name="item" id="select-item" class="form-control select2 select-item">
										</select>
									</div>
								</div>

								<div class="form-group row d-flex align-items-center mb-3">
									<label class="col-lg-4 form-control-label d-flex justify-content-lg-start">Jumlah Dikirim</label>
									<div class="col-lg-8">
										<input type="number" name="qty" id="qty" class="form-control input-qty">
									</div>
								</div>

								<div class="form-group row d-flex align-items-center mb-3">
									<label class="col-lg-4 form-control-label d-flex justify-content-lg-start">Harga Jual Barang</label>
									<div class="col-lg-8">
										<input type="number" name="selling_price" id="selling-price" class="form-control input-purchase-price">
									</div>
								</div>

								<div id="item-visible"></div>

								<div class="em-separator separator-dashed"></div>
								<div class="text-right">
									<button class="btn btn-gradient-01" id="add-item" type="button">Submit Form</button>
								</div>
							</form>
						</div>
					</div>
					<!-- End Form -->
				</div>
				<div class="col-md-6 col-xs-12">
					<!-- Tabel Item Delivery -->
					<div class="widget has-shadow">
						<div class="widget-header bordered no-actions d-flex align-items-center">
							<h4>Tabel Barang Dikirim</h4>
							<hr>
							<button type="button" id="destroy-item-delivery" class="btn btn-primary align-right">Clear All</button>
						</div>
						<div class="widget-body">
							<div class="table-responsive">
								<table id="table-item-delivery" class="table mb-0">
									<thead>
										<tr>
											<th>Nama</th>
											<th>QTY</th>
											<th>Harga Jual</th>
											<th>Subtotal</th>
										</tr>
									</thead>
									<tbody>

									</tbody>
								</table>
							</div>
						</div>
					</div>
					<!-- End Item Delivery -->
				</div>
			</div>
			<!-- End Row -->
			<div class="row">
				<div class="col-md-12 col-xs-12">
					<!-- Form -->
					<div class="widget has-shadow">
						<div class="widget-header bordered no-actions d-flex align-items-center">
							<h4>Form Finalisasi Data Akhir</h4>
						</div>
						<div class="widget-body">
							<form class="needs-validation" method="POST" action="{{ url('delivery/storeDelivery') }}">
								@CSRF
								<div class="form-group row d-flex align-items-center mb-3">
									<label class="col-lg-2 form-control-label d-flex justify-content-lg-end">Nama Kurir</label>
									<div class="col-lg-4">
										<select name="courier" id="select-courier" class="form-control select2 select-courier" required>
										</select>
									</div>
									<label class="col-lg-2 form-control-label d-flex justify-content-lg-end">Customer</label>
									<div class="col-lg-4">
										<select name="customer" class="form-control select-customer" required></select>
									</div>
								</div>
								<div class="form-group row d-flex align-items-center mb-5">	
									<label class="col-lg-2 form-control-label d-flex justify-content-lg-end">Ongkos Pengiriman</label>
									<div class="col-lg-4">
										<input type="number" name="send_cost" id="send_cost" class="form-control">
									</div>
								</div>
								<div class="em-separator separator-dashed"></div>
								<div class="text-right">
									<button class="btn btn-gradient-01" type="submit">Submit & Finish</button>
								</div>
							</form>
						</div>
					</div>
					<!-- End Form -->
				</div>
			</div>
			<!-- End Row -->
		</div>
		<!-- End page header -->
	</div>
	<!-- End Row -->
</div>
<!-- End Container -->
@endsection
@section('js-route')
<script>
	var token 				= '{{ csrf_token() }}';	
	var getItemDelivery		= '{{ url('item/getItemDelivery') }}';
	var getItemById 		= '{{ route('getItemById') }}';
	var getCustomerById 	= '{{ route('getCustomerById') }}';
	var destroyItemDelivery = '{{ url('item/destroyItemDelivery') }}';
	var selectItem 			= '{{ route('selectItem') }}';
	var selectCourier 		= '{{ url('user/selectCourier') }}';
	var selectCustomer 		= '{{ url('customer/selectCustomer') }}';
	var storeItemDelivery 	= '{{ url('item/storeItemDelivery') }}';
</script>
@endsection
@section('js')
<script>
	$(document).ready(function() {
		document.getElementById("delivery-link").classList.add('active');
		document.getElementById("delivery-link2").setAttribute('aria-expanded','TRUE');
		document.getElementById("dropdown-delivery").classList.add('show');
		document.getElementById("add-delivery-link").classList.add('active');

			// Tabel temp item delivery
			var tabel_delivery_temp =  $('#table-item-delivery').DataTable
			({
				ajax            : 
				{
					url         : getItemDelivery,
					type        : 'POST',
					data        : {_token:token},
					dataSrc     : 'data',
				},
				paging          : false,
				pageLength      : 25,
				lengthChange    : false,
				searching       : false,
				search          : 
				{
					smart       : false,
					regex       : true,
					caseInsen       : true,
				},
				aaSorting       : [],
				ordering        : true,
				info            : true,
			});

			// Event add pickup item
			$('#add-item').on('click', function() {
				sell 				= $('#selling-price').val();
				id_item 			= $('#select-item') .val();
				jml 				= $('#qty').val();

				if (sell == '' || id_item == null || jml == '') {
					alert('Ada data yang kosong silahkan lengkapi dulu');
				}else {
					$.ajax({
						url 				: storeItemDelivery,
						type 				: 'POST',
						dataType 			: 'JSON',
						data 				: {id: $('#select-item').val(),
						qty 			: $('#qty').val(),
						selling_price 	: sell,
						_token			: token},
						success 			: function(data) {
							console.log(data);
							$('#selling-price').val('');
							$('#select-item') .val('').trigger('change');
							$('#qty').val('');
							tabel_delivery_temp.ajax.reload();
						},
						error				: function(data) {
							console.log(data);
						}
					});
				}
				

			});

			// Event destroy delivery item
			$('#destroy-item-delivery').on('click', function() {
				$.ajax({
					url 		: destroyItemDelivery,
					type 		: 'POST',
					dataType 	: 'JSON',
					data 		: {_token:token},
					success 	: function(data) {
						console.log('Sukses Hapus Data');
						console.log(data);
					},
					error 		: function(data) {
						console.log('Gagal Hapus Data');
						console.log(data);
					}
				}).then(function() {
					tabel_delivery_temp.ajax.reload();
				});
			});

			select2.selectItem();
			select2.selectCourier();
			select2.selectCustomer();
			event.selectItemChange();
		/*[].forEach.call(document.querySelectorAll('.is-visible'), function (el) {
			el.style.visibility = 'hidden';
		});*/
	});
</script>
@endsection