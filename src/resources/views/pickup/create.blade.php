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
						<li class="breadcrumb-item"><a href="{{ route('home') }}">Pick Up</a></li>
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
							<h4>Input Barang Yang Akan Diambil</h4>
						</div>
						<div class="widget-body">
							<form class="needs-validation" novalidate>
								<div class="form-group row d-flex align-items-center mb-3">
									<label class="col-lg-4 form-control-label d-flex justify-content-lg-start">Dikirim Ke Customer</label>
									<div class="col-lg-8">
										<select name="is_send_to_customer" id="is_send" class="form-control">
											<option value="0">Tidak</option>
											<option value="1">Ya</option>
										</select>
									</div>
								</div>
								<div class="form-group row d-flex align-items-center mb-3">
									<label class="col-lg-4 form-control-label d-flex justify-content-lg-start">Nama Barang</label>
									<div class="col-lg-8">
										<select name="item" id="select-item" class="form-control select2 select-item">
										</select>
									</div>
								</div>

								<div class="form-group row d-flex align-items-center mb-3">
									<label class="col-lg-4 form-control-label d-flex justify-content-lg-start">Nama Supplier</label>
									<div class="col-lg-8">
										<select name="supplier" id="select-supplier" class="form-control select2 select-supplier">
										</select>
									</div>
								</div>

								<div class="form-group row d-flex align-items-center mb-3">
									<label class="col-lg-4 form-control-label d-flex justify-content-lg-start">Jumlah Diambil</label>
									<div class="col-lg-8">
										<input type="number" name="qty" id="qty" class="form-control input-qty">
									</div>
								</div>

								<div class="form-group row d-flex align-items-center mb-3">
									<label class="col-lg-4 form-control-label d-flex justify-content-lg-start">Harga Beli Barang</label>
									<div class="col-lg-8">
										<input type="number" name="purchase_price" id="purchase-price" class="form-control input-purchase-price">
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
					<!-- Tabel Item Pickup -->
					<div class="widget has-shadow">
						<div class="widget-header bordered no-actions d-flex align-items-center">
							<h4>Tabel Barang Diambil</h4>
							<hr>
							<button type="button" id="destroy-item-pickup" class="btn btn-primary align-right">Clear All</button>
						</div>
						<div class="widget-body">
							<div class="table-responsive">
								<table id="table-item-pickup" class="table mb-0">
									<thead>
										<tr>
											<th>Nama</th>
											<th>Supplier</th>
											<th>QTY</th>
											<th>Harga Beli</th>
											<th>Subtotal</th>
										</tr>
									</thead>
									<tbody>

									</tbody>
								</table>
							</div>
						</div>
					</div>
					<!-- End Item Pickup -->
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
							<form class="needs-validation" method="POST" action="{{ url('pickup/storePickup') }}">
								@CSRF
								<div class="form-group row d-flex align-items-center mb-3">
									<label class="col-lg-2 form-control-label d-flex justify-content-lg-end">Nama Kurir</label>
									<div class="col-lg-4">
										<input type="hidden" name="is_send_to_customer" id="is_send_to_customer" value="0">
										<select name="courier" id="select-courier" class="form-control select2 select-courier" required>
										</select>
									</div>
									<label class="col-lg-2 form-control-label d-flex justify-content-lg-end">Jenis Pembelian</label>
									<div class="col-lg-4">
										<select name="type" class="form-control" required>
											<option value="cash">Cash</option>
											<option value="tempo">Tempo</option>
										</select>
									</div>
								</div>
								<div id="item-visible2">
									
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
	var getItemPickup 		= '{{ url('item/getItemPickup') }}';
	var getItemDelivery		= '{{ url('item/getItemDelivery') }}';
	var getItemById 		= '{{ route('getItemById') }}';
	var getCustomerById 	= '{{ route('getCustomerById') }}';
	var destroyItemPickup 	= '{{ url('item/destroyItemPickup') }}';
	var destroyItemDelivery = '{{ url('item/destroyItemDelivery') }}';
	var selectItem 			= '{{ route('selectItem') }}';
	var selectSupplier 		= '{{ route('selectSupplier') }}';
	var selectCourier 		= '{{ url('user/selectCourier') }}';
	var selectCustomer 		= '{{ url('customer/selectCustomer') }}';
	var storeItemPickup 	= '{{ url('item/storeItemPickup') }}';
</script>
@endsection
@section('js')
<script>
	$(document).ready(function() {
		document.getElementById("pickup-link").classList.add('active');
		document.getElementById("pickup-link2").setAttribute('aria-expanded','TRUE');
		document.getElementById("dropdown-pickup").classList.add('show');
		document.getElementById("add-pickup-link").classList.add('active');

			// Tabel temp item pickup
			var tabel_pickup_temp =  $('#table-item-pickup').DataTable
			({
				ajax            : 
				{
					url         : getItemPickup,
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

			// Tabel temp item pickup
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
				price 				= $('#purchase-price').val();
				sell 				= $('#selling_price').val();
				id_item 			= $('#select-item') .val();
				id_supplier			= $('#select-supplier') .val();
				jml 				= $('#qty').val();
				apa_dikirim 		= $('#is_send').val();

				if (apa_dikirim == '0') {
					if (price == '' || id_item == null || id_supplier == null || jml == '') {
						alert('Ada data yang kosong silahkan lengkapi dulu');
					}else {
						$.ajax({
							url 				: storeItemPickup,
							type 				: 'POST',
							dataType 			: 'JSON',
							data 				: {id: $('#select-item').val(),
							supplier 		: $('#select-supplier') .val(),
							qty 			: $('#qty').val(),
							is_send 		: $('#is_send').val(),
							purchase_price 	: $('#purchase-price').val(),
							_token			: token},
							success 			: function(data) {
								console.log(data);
								$('#purchase-price').val('');
								$('#select-item') .val('').trigger('change');
								$('#select-supplier') .val('').trigger('change');
								$('#qty').val('');
								tabel_pickup_temp.ajax.reload();
							},
							error				: function(data) {
								console.log(data);
							}
						});
					}
				}else if (apa_dikirim == '1') {
					if (price == '' || id_item == null || id_supplier == null || jml == '' || sell == '') {
						alert('Ada data yang kosong silahkan lengkapi dulu');
					}else {
						$.ajax({
							url 				: storeItemPickup,
							type 				: 'POST',
							dataType 			: 'JSON',
							data 				: {id: $('#select-item').val(),
							supplier 		: $('#select-supplier') .val(),
							qty 			: $('#qty').val(),
							is_send 		: $('#is_send').val(),
							purchase_price 	: $('#purchase-price').val(),
							selling_price 	: $('#selling_price').val(),
							_token			: token},
							success 			: function(data) {
								console.log(data);
								$('#purchase-price').val('');
								$('#select-item') .val('').trigger('change');
								$('#select-supplier') .val('').trigger('change');
								$('#qty').val('');
								$('#selling_price').val('');
								tabel_pickup_temp.ajax.reload();
								tabel_delivery_temp.ajax.reload();
							},
							error				: function(data) {
								console.log(data);
							}
						});
					}
				}

			});

			// Event destroy pickup item
			$('#destroy-item-pickup').on('click', function() {
				$.ajax({
					url 		: destroyItemPickup,
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
					tabel_pickup_temp.ajax.reload();
				});
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
			select2.selectSupplier();
			select2.selectCourier();
			event.is_send();
			event.selectItemChange();
		/*[].forEach.call(document.querySelectorAll('.is-visible'), function (el) {
			el.style.visibility = 'hidden';
		});*/
	});
</script>
@endsection