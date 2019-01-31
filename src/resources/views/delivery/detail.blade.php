@extends('backend.partial.app')
@section('content')
<div class="container-fluid">
	<!-- Begin Page Header-->
	<div class="row">
		<div class="page-header">
			<div class="d-flex align-items-center">
				<h2 class="page-header-title">{{ $page }}</h2>
			</div>
		</div>
	</div>
	<!-- End Page Header -->
	<div class="row">
		<div class="page-header">
			<div class="d-flex align-items-center">
				<div>
					<div class="page-header-tools">
						<a href="#" class="btn btn-gradient-01 mb-1">Cetak Invoice</a>
						<a href="https://api.whatsapp.com/send?phone={{ $phone }}&text=&source=&data=" class="btn btn-gradient-01 mb-1" target="_blank">Chat Customer</a>
						@role('Kurir')
						@php
						$delivery_data = array(
						'id_delivery'			=> $delivery[0]->id_delivery,
						'is_pickup_first'		=> $delivery[0]->is_pickup_first,
						);
						@endphp
						@if($delivery[0]->status == 4)
						<a href="{{ route('changeDeliveryJob',['id_delivery' => $delivery[0]->id_delivery,'is_pickup_first' => $delivery[0]->is_pickup_first, 'changeTo' => '3']) }}" class="btn btn-gradient-01 mb-1">Ambil Job</a>
						@elseif($delivery[0]->status == 3)
						<a href="{{ route('changeDeliveryJob',['id_delivery' => $delivery[0]->id_delivery,'is_pickup_first' => $delivery[0]->is_pickup_first, 'changeTo' => '2']) }}" class="btn btn-gradient-01 mb-1">Barang Terambil</a>
						@elseif($delivery[0]->status == 2)
						<a href="{{ route('changeDeliveryJob',['id_delivery' => $delivery[0]->id_delivery,'is_pickup_first' => $delivery[0]->is_pickup_first, 'changeTo' => '1']) }}" class="btn btn-gradient-01 mb-1">Kirim Ke Customer</a>
						@elseif($delivery[0]->status == 1)
						<button type="button" class="btn btn-gradient-01 mb-1" data-toggle="modal" data-target="#finish-delivery">Job Selesai</button>
						@endif
						@endrole
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
			<!-- Begin Detail -->
			<div class="widget has-shadow">
				<div class="widget-header bordered no-actions d-flex align-items-center">
					<h4>Detail Transaksi Pengambilan</h4>
				</div>
				<div class="widget-body">
					<div class="form-group row mb-4">
						<label class="col-lg-1 form-control-label d-flex justify-content-lg-start">Status</label>
						<div class="col-lg-5">
							{!! $status !!}
						</div>
						<label class="col-lg-1 form-control-label d-flex justify-content-lg-start">Kurir</label>
						<div class="col-lg-5">
							<input type="text" class="form-control" value="{{ $delivery[0]->courier_name }}" disabled>
						</div>
					</div>
					<div class="form-group row mb-4">
						<label class="col-lg-1 form-control-label d-flex justify-content-lg-start">Customer</label>
						<div class="col-lg-5">
							<input type="text" class="form-control" value="{{ $delivery[0]->customer_name }}" disabled>
						</div>
						<label class="col-lg-1 form-control-label d-flex justify-content-lg-start">Pengambilan Ke Supplier</label>
						<div class="col-lg-5">
							<input type="text" class="form-control" value="{{ $send }}" disabled>
						</div>
					</div>
					<div class="form-group row mb-4">
						<label class="col-lg-1 form-control-label d-flex justify-content-lg-start">Ongkir</label>
						<div class="col-lg-5">
							<input type="text" class="form-control" value="Rp. {{ number_format($send_cost) }}" disabled>
						</div>
						<label class="col-lg-1 form-control-label d-flex justify-content-lg-start">Total Transaksi</label>
						<div class="col-lg-5">
							<input type="text" class="form-control" value="Rp. {{ number_format($gt) }}" disabled>
						</div>
					</div>
					@if($delivery[0]->status == 0)
					<div class="form-group row mb-4">
						<label class="col-lg-1 form-control-label d-flex justify-content-lg-start">Penerima</label>
						<div class="col-lg-5">
							<input type="text" class="form-control" value="{{ $delivery[0]->receiver }}" disabled>
						</div>
						<label class="col-lg-1 form-control-label d-flex justify-content-lg-start">Bukti Penerimaan</label>
						<div class="col-lg-5">
							<a href="{{ asset('storage/images/received_proof/'.$delivery[0]->received_proof) }}"><img class="mx-auto d-block image-preview" src="{{ asset('storage/images/received_proof/thumbnail/'.$delivery[0]->received_proof) }}" style="width: 100px;height: 100px;"></a>
						</div>
					</div>
					@endif
					<hr>
					<h4>Data Barang Yang Diambil</h4>
					<div class="table-responsive">
						<table class="table mb-0">
							<thead>
								<tr>
									<th>No</th>	
									<th>Item</th>
									<th>Supplier</th>
									<th>Qty</th>
									<th>Harga</th>
									<th>Subtotal</th>
								</tr>
							</thead>
							<tbody>
								@php 
								$no = 0;
								@endphp
								@foreach ($delivery as $i)
								@php 
								$no++;
								@endphp
								<tr>
									<td>{{ $no }}</td>
									<td>{{ $i->item_name }}</td>
									<td>{{ $i->supplier_name }}</td>
									<td>{{ $i->qty }}</td>
									<td>Rp. {{ number_format($i->selling_price) }}</td>
									<td>Rp. {{ number_format($i->qty * $i->selling_price) }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					@if($delivery[0]->status != 3 AND $delivery[0]->status != 0)
					<hr>
					<h4>Lokasi Realtime Kurir</h4>
					<div class="courier-location" id="map-courier-detail"></div>
					@elseif($delivery[0]->status == 0)
					<hr>
					@endif
				</div>
			</div>
			<!-- End Supplier -->
		</div>
	</div>
	<!-- End Row -->
</div>
<!-- End Container -->
<!-- Begin Delivery Finish -->
<div id="finish-delivery" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="POST" enctype="multipart/form-data" action="{{ url('delivery/finishDelivery') }}">
				@csrf
				<div class="modal-header">
					<h4 class="modal-title">Finalisasi Job</h4>
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">×</span>
						<span class="sr-only">close</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group row d-flex align-items-center mb-2">
						<label class="col-lg-3 form-control-label d-flex justify-content-lg-end">Nama Penerima</label>
						<div class="col-lg-9">
							<input type="hidden" name="id_delivery" value="{{ $delivery[0]->id_delivery }}">
							<input type="hidden" name="is_pickup_first" value="{{ $delivery[0]->is_pickup_first }}">
							<input type="text" name="receiver" placeholder="Input Nama Penerima" class="form-control" required>
						</div>
					</div>
					<div class="form-group row d-flex align-items-center mb-2">
						<label class="col-lg-3 form-control-label d-flex justify-content-lg-end">Bukti Penerimaan</label>
						<div class="col-lg-9">
							<input type="file" name="received_proof" class="form-control" required>
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
<!-- End Delivery Finish -->
@endsection
@section('js-route')
<script>
	var id_delivery 		= '{{ $delivery[0]->id_delivery }}';
	var is_pickup_first 	= '{{ $delivery[0]->is_pickup_first }}';
	var lat_start           = '-7.5308914';
	var lng_start           = '110.73143';
	var token 				= '{{ csrf_token() }}';
</script>
@endsection
@section('js')
<script>
$(document).ready(function() {
	document.getElementById("delivery-link").classList.add('active');
	document.getElementById("delivery-link2").setAttribute('aria-expanded','TRUE');
	document.getElementById("dropdown-delivery").classList.add('show');

	@if($delivery[0]->status != '3' AND $delivery[0]->status != '0')
	
	@role('Kurir')

	var map = L.map('map-courier-detail');

	L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
		maxZoom: 18,
		attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
		'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
		'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
		id: 'mapbox.streets'
	}).addTo(map);

 	// placeholders for the L.marker and L.circle representing user's current position and accuracy    
 	var current_position, current_accuracy;

 	function onLocationFound(e) {
  		// if position defined, then remove the existing position marker and accuracy circle from the map
  		if (current_position) {
  			map.removeLayer(current_position);
  			map.removeLayer(current_accuracy);

			//Set current location into db
			$.ajax({
				url 			: '{{ url('delivery/storeLocation') }}',
				type 			: 'POST',
				dataType 		: 'JSON',
				data 			: {_token: token, id: id_delivery, latitude: e.latlng.lat, longtitude:e.latlng.lng, is_pickup_first: is_pickup_first},
				success 		: function(data) {
					console.log('Location data successfully stored');
				},
				error 			: function(data) {
					console.log('Location data failed to store');
				}
			});

		console.log(e.latlng.lat + ", " + e.latlng.lng);
	}

	var radius = e.accuracy / 2;

	current_position = L.marker(e.latlng).addTo(map).bindPopup("Kurir anda berada " + radius + " dari point ini").openPopup();

	current_accuracy = L.circle(e.latlng, radius).addTo(map);
	}

	function onLocationError(e) {
		console.log(e.message);
	}

	map.on('locationfound', onLocationFound);
	map.on('locationerror', onLocationError);

	// wrap map.locate in a function    
	function locate() {
		map.locate({setView: true, maxZoom: 18, watch: false, enableHighAccuracy: false , maximumAge:120000, timeout: 240000});
	}

	// call locate every .. seconds... forever
	setInterval(locate, 60000);
	
	map.on('click', function(e) {
		alert("Lat, Lon : " + e.latlng.lat + ", " + e.latlng.lng)
	});

	@endrole

/* ========= ROLE PIMPINAN OR ADMIN ============= */

	@role('Pimpinan|Admin')

	var mymap = L.map('map-courier-detail').setView([JSON.parse(lat_start), JSON.parse(lng_start)], 13);

	L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
		maxZoom: 18,
		attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
		'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
		'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
		id: 'mapbox.streets'
	}).addTo(mymap);

	function locate() {
		$.ajax({
			url         : '{{ url('delivery/getDeliveryLocation') }}',
			type        : 'POST',
			dataType    : 'JSON',
			data        : {_token:token, id: '{{ $delivery[0]->id_delivery }}' },
			success     : function(data) {
				console.log('Updated Successfully');

				mymap.panTo([JSON.parse(data[0].latitude), JSON.parse(data[0].longtitude)], 13);

				var newMark = new L.marker([JSON.parse(data[0].latitude), JSON.parse(data[0].longtitude)]).addTo(mymap).bindPopup("<b>Lokasi Kurir</b>").openPopup();

			}
		});
	}

	// call locate every .. seconds... forever
	setInterval(locate, 5000);

	@endrole

	@elseif($delivery[0]->status == 0)
	console.log('Job Telah Selesai')
	@endif
});
</script>
@endsection