@extends('frontend.partial.app')
@section('content')
<div class="content-inner boxed mt-4 w-100">
	<div class="container">
		<!-- Begin Page Header-->
		<div class="row">
			<div class="page-header">
				<div class="d-flex align-items-center">
					<h1 class="page-header-title">About Us</h1>
				</div>
			</div>
		</div>
		<!-- End Page Header -->
		<!-- Begin Row -->
		<div class="row">
			<div class="col-12">
				<div class="widget has-shadow">
					<div class="row">
						<div class="col-xl-12">
							<div class="widget">
								<div class="widget-body pt-2">
									<!-- Begin Accordion -->
									<div id="accordion" class="accordion">
										<!-- Begin Widget -->
										<div class="widget">
											<div class="widget-header no-actions d-flex align-items-center">
												<h2>Siapa Kami</h2>
											</div>
											<div class="card-body bg-grey">
												<p>
													Praesent nibh nulla, vehicula vitae metus nec, lobortis commodo lorem. Nulla pulvinar vestibulum semper. Curabitur tempor, orci eget laoreet lacinia, urna orci facilisis massa, nec convallis arcu lacus eu mi. Aliquam semper ante eget venenatis pellentesque. Sed suscipit sem id ligula sollicitudin pulvinar. Donec porta enim nec dignissim commodo. Mauris ac elit diam. In vel mattis massa. Donec id mi blandit diam fringilla fringilla vitae id elit.  
												</p>
											</div>
											<div class="widget-header no-actions d-flex align-items-center">
												<h2>Kontak Kami</h2>
											</div>
											<div class="card-body bg-grey">
												<p>
													Whatsapp 	: 082139414264 <br>
													Email 		: admin@iamhermawan.com
												</p>
											</div>
											<div class="widget-header no-actions d-flex align-items-center">
												<h2>Lokasi Kami</h2>
											</div>
											<div class="card-body bg-grey courier-location" id="map-lokasi">
												
											</div>
										</div>
										<!-- End Widget -->
									</div>
									<!-- End Accordion -->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Container -->
</div>
<!-- End Content -->
@endsection
@section('js')
<script>
	$(document).ready(function()
	{
		var mymap = L.map('map-lokasi').setView([-7.5308914, 110.73143], 13);

		L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
			maxZoom: 18,
			attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
			'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
			'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
			id: 'mapbox.streets'
		}).addTo(mymap);

		var newMark = new L.marker([-7.5308914, 110.73143]).addTo(mymap).bindPopup("<b>Lokasi Kami</b>").openPopup();
	})
</script>
@endsection
