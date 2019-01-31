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
						<a href="#" class="btn btn-gradient-01 mb-1">Cetak Surat Jalan</a>
						<a href="#" class="btn btn-gradient-01 mb-1">Cetak Invoice</a>
						@role('Kurir')
						@php
						$pickup_data = array(
						'id_pickup'				=> $pickup[0]->id_pickup,
						'is_send_to_customer'	=> $pickup[0]->is_send_to_customer,
						);
						@endphp
						@if($pickup[0]->status == 3)
						<a href="{{ route('changePickupJob',['id_pickup' => $pickup[0]->id_pickup,'is_send_to_customer' => $pickup[0]->is_send_to_customer, 'changeTo' => '2']) }}" class="btn btn-gradient-01 mb-1">Ambil Job</a>
						@elseif($pickup[0]->status == 2)
						<a href="{{ route('changePickupJob',['id_pickup' => $pickup[0]->id_pickup,'is_send_to_customer' => $pickup[0]->is_send_to_customer, 'changeTo' => '1']) }}" class="btn btn-gradient-01 mb-1">Barang Terambil</a>
						@elseif($pickup[0]->status == 1)
						<a href="{{ route('changePickupJob',['id_pickup' => $pickup[0]->id_pickup,'is_send_to_customer' => $pickup[0]->is_send_to_customer, 'changeTo' => '0']) }}" class="btn btn-gradient-01 mb-1">Pickup Selesai</a>
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
							<input type="text" class="form-control" value="{{ $pickup[0]->courier_name }}" disabled>
						</div>
					</div>
					<div class="form-group row mb-4">
						<label class="col-lg-1 form-control-label d-flex justify-content-lg-start">Jenis</label>
						<div class="col-lg-5">
							<input type="text" class="form-control" value="{{ $pickup[0]->type }}" disabled>
						</div>
						<label class="col-lg-1 form-control-label d-flex justify-content-lg-start">Dikirim Ke Customer</label>
						<div class="col-lg-5">
							<input type="text" class="form-control" value="{{ $send }}" disabled>
						</div>
					</div>
					<div class="form-group row mb-5">
						<label class="col-lg-1 form-control-label d-flex justify-content-lg-start">Total Transaksi</label>
						<div class="col-lg-4">
							<input type="text" class="form-control" value="Rp. {{ number_format($gt) }}" disabled>
						</div>
					</div>
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
								@foreach ($pickup as $i)
								@php 
								$no++;
								@endphp
								<tr>
									<td>{{ $no }}</td>
									<td>{{ $i->item_name }}</td>
									<td>{{ $i->supplier_name }}</td>
									<td>{{ $i->qty }}</td>
									<td>Rp. {{ number_format($i->purchase_price) }}</td>
									<td>Rp. {{ number_format($i->qty * $i->purchase_price) }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					@if($pickup[0]->status != 3 AND $pickup[0]->status != 0)
					<hr>
					<h4>Lokasi Realtime Kurir</h4>
					<div class="courier-location" id="map-courier-detail"></div>
					@elseif($pickup[0]->status == 0)
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
@endsection
@section('js-route')
<script>
	var id_pickup 			= '{{ $pickup[0]->id_pickup }}';
	var is_send_to_customer = '{{ $pickup[0]->is_send_to_customer }}';
	var lat_start           = '-7.5308914';
	var lng_start           = '110.73143';
	var token 				= '{{ csrf_token() }}';
</script>
@endsection
@section('js')
<script>
	$(document).ready(function() {
		document.getElementById("pickup-link").classList.add('active');
		document.getElementById("pickup-link2").setAttribute('aria-expanded','TRUE');
		document.getElementById("dropdown-pickup").classList.add('show');

		@if($pickup[0]->status != '3' AND $pickup[0]->status != '0')
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
	  		url 			: '{{ url('pickup/storeLocation') }}',
	  		type 			: 'POST',
	  		dataType 		: 'JSON',
	  		data 			: {_token: token, id: id_pickup, latitude: e.latlng.lat, longtitude:e.latlng.lng, is_send_to_customer: is_send_to_customer},
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

	  current_position = L.marker(e.latlng).addTo(map)
	  .bindPopup("Kurir anda berada " + radius + " dari point ini").openPopup();

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
			url         : '{{ url('pickup/getPickupLocation') }}',
			type        : 'POST',
			dataType    : 'JSON',
			data        : {_token:token, id: '{{ $pickup[0]->id_pickup }}' },
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
	@elseif($pickup[0]->status == 0)
	console.log('Job Telah Selesai')
	@endif
});
</script>
@endsection