@extends('frontend.partial.app')
@section('content')
<div class="content-inner boxed mt-4 w-100">
	<div class="container">
		<!-- Begin Page Header-->
		<div class="row">
			<div class="page-header">
				<div class="d-flex align-items-center">
					<h1 class="page-header-title">Cek Resi</h1>
				</div>
			</div>
		</div>
		<!-- End Page Header -->
		<!-- Begin Row -->
		<div class="row">
			<div class="page-header">
				<div class="d-flex align-items-center">
					<h3 class="page-header-title">Tracking Package Anda</h3>
				</div>
			</div>
			<!-- End Page Header -->
		</div>
		<div class="row">
			<div class="col-md-12">
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
				<div class="widget has-shadow">
					<div class="widget-body">
						<form action="{{ url('/cekresi') }}" method="GET" enctype="multipart/form-data">
							<div class="input-group">
								@csrf
								<input type="text" name="id_resi" class="form-control" placeholder="Input Nomor Resi Anda..">
								<span class="input-group-addon">
									<button type="submit" class="btn btn-primary"><i class="la la-search la-2x"></i></button>
								</span>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		@if($delivery != NULL)
		@if($delivery[0]->status == 4 OR $delivery[0]->status == 3 OR $delivery[0]->status == 2 OR $delivery[0]->status == 1 OR $delivery[0]->status == 0 )
		<div class="row justify-content-center">
			<div class="col-xl-10 col-12">
				<!-- Begin Timeline -->
				<div class="timeline timeline-line-solid">
					<span class="timeline-label">
						<span class="label">Start</span>
					</span>
					<!-- Begin Timeline Item -->
					<div class="timeline-item">
						<div class="timeline-point timeline-point" style="background-color: #00aced; color: #00aced;"></div>
						<!-- Begin Timeline Event -->
						<div class="timeline-event">
							<!-- Begin Widget -->
							<div class="widget icon-widget has-shadow" style="background-color: #00aced;">
								<!-- Begin Widget Body -->
								<div class="widget-body" style="color: #fff;">
									<div class="media">
										<div class="media-left align-self-center">
											<i class="la la-pencil" style="font-size: 4rem;"></i>
										</div>
										<div class="media-body align-self-center pl-4">
											<h3>"Pesanan Anda Sudah Diterima Bagian Admin"</h3><br>
											Pesanan anda sudag tercatat dan akan segera diproses selanjutnya.
										</div>
									</div>
								</div>
								<!-- End Widget Body -->
							</div>
							<!-- End Widget -->
						</div>
						<!-- End Timeline Event -->
					</div>
					<!-- End Timeline Item -->
					@endif
					<!-- Begin Timeline -->
					@if($delivery[0]->status == 3 OR $delivery[0]->status == 2 OR $delivery[0]->status == 1 OR $delivery[0]->status == 0 )
					<!-- Begin Timeline Item -->
					<div class="timeline-item">
						<div class="timeline-point timeline-point" style="background-color: #00aced; color: #00aced;"></div>
						<!-- Begin Timeline Event -->
						<div class="timeline-event">
							<!-- Begin Widget -->
							<div class="widget icon-widget has-shadow" style="background-color: #00aced;">
								<!-- Begin Widget Body -->
								<div class="widget-body" style="color: #fff;">
									<div class="media">
										<div class="media-left align-self-center">
											<i class="la la-building" style="font-size: 4rem;"></i>
										</div>
										<div class="media-body align-self-center pl-4">
											<h3>"Pesanan Anda Sudah Dikonfirmasi"</h3><br>
											Pesanan anda akan segera dipacking setelah diambil dari gudang.
										</div>
									</div>
								</div>
								<!-- End Widget Body -->
							</div>
							<!-- End Widget -->
						</div>
						<!-- End Timeline Event -->
					</div>
					<!-- End Timeline Item -->
					@endif
					@if($delivery[0]->status == 2 OR $delivery[0]->status == 1 OR $delivery[0]->status == 0 )
					<!-- Begin Timeline Item -->
					<div class="timeline-item">
						<div class="timeline-point timeline-point" style="background-color: #00aced; color: #00aced;"></div>
						<!-- Begin Timeline Event -->
						<div class="timeline-event">
							<!-- Begin Widget -->
							<div class="widget icon-widget has-shadow" style="background-color: #00aced;">
								<!-- Begin Widget Body -->
								<div class="widget-body" style="color: #fff;">
									<div class="media">
										<div class="media-left align-self-center">
											<i class="la la-dropbox" style="font-size: 4rem;"></i>
										</div>
										<div class="media-body align-self-center pl-4">
											<h3>"Pesanan Anda Sedang Di Packing"</h3><br>
											Pesanan anda sedang dalam proses packing untuk selanjutnya dikirim.
										</div>
									</div>
								</div>
								<!-- End Widget Body -->
							</div>
							<!-- End Widget -->
						</div>
						<!-- End Timeline Event -->
					</div>
					<!-- End Timeline Item -->
					@endif
					@if($delivery[0]->status == 1 OR $delivery[0]->status == 0 )
					<!-- Begin Timeline Item -->
					<div class="timeline-item">
						<div class="timeline-point timeline-point" style="background-color: #00aced; color: #00aced;"></div>
						<!-- Begin Timeline Event -->
						<div class="timeline-event">
							<!-- Begin Widget -->
							<div class="widget icon-widget has-shadow" style="background-color: #00aced;">
								<!-- Begin Widget Body -->
								<div class="widget-body" style="color: #fff;">
									<div class="media">
										<div class="media-left align-self-center">
											<i class="la la-send" style="font-size: 4rem;"></i>
										</div>
										<div class="media-body align-self-center pl-4">
											<h3>"Pesanan Akan Segera Dikirmkan Ke Tempat Anda"</h3><br>
											Pesanan anda sedang dalam proses pengiriman menuju lokasi anda.
										</div>
									</div>
								</div>
								<!-- End Widget Body -->
							</div>
							<!-- End Widget -->
						</div>
						<!-- End Timeline Event -->
					</div>
					<!-- End Timeline Item -->
					@endif
					@if($delivery[0]->status == 0 )
					<!-- Begin Timeline Item -->
					<div class="timeline-item">
						<div class="timeline-point timeline-point" style="background-color: #00aced; color: #00aced;"></div>
						<!-- Begin Timeline Event -->
						<div class="timeline-event">
							<!-- Begin Widget -->
							<div class="widget icon-widget has-shadow" style="background-color: #00aced;">
								<!-- Begin Widget Body -->
								<div class="widget-body" style="color: #fff;">
									<div class="media">
										<div class="media-left align-self-center">
											<i class="la la-check-circle" style="font-size: 4rem;"></i>
										</div>
										<div class="media-body align-self-center pl-4">
											<h3>"Pesanan Anda Sudah Anda Terima"</h3><br>
											Pesanan sudah diberikan pada penerima sesuai lokasi pengiriman.
										</div>
									</div>
								</div>
								<!-- End Widget Body -->
							</div>
							<!-- End Widget -->
						</div>
						<!-- End Timeline Event -->
					</div>
					<!-- End Timeline Item -->
					@endif
				</div>
				<!-- End Timeline -->
			</div>
		</div>
		@endif
		<!-- End Row -->
		<div class="row mt-2">
			<div class="col-12">
				<div class="widget has-shadow">
					<div class="row">
						<div class="col-xl-3">
							<div class="widget">
								<div class="widget-body">
									<h3>PUDEMAS SYSTEM</h3>
									<ul class="nav flex-column">
										<li class="nav-item">
											<a class="nav-link" href="javascript:void(0)">
												<i class="la la-truck la-2x align-middle pr-2"></i>Cepat
											</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" href="javascript:void(0)">
												<i class="la la-puzzle-piece la-2x align-middle pr-2"></i>Mudah
											</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" href="javascript:void(0)">
												<i class="la la-thumbs-up la-2x align-middle pr-2"></i>Terpercaya
											</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" href="javascript:void(0)">
												<i class="la la-wrench la-2x align-middle pr-2"></i>Garansi
											</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
						<div class="col-xl-9">
							<div class="widget">
								<div class="widget-body pt-2">
									<!-- Begin Accordion -->
									<div id="accordion" class="accordion">
										<!-- Begin Widget -->
										<div class="widget">
											<div class="widget-header no-actions d-flex align-items-center">
												<h2>Frequently Asked Question (FAQ)</h2>
											</div>
											<a class="card-header collapsed d-flex align-items-center" data-toggle="collapse" href="#collapseOne">
												<div class="card-title">Cara Pemesanan Barang</div>
											</a>
											<div id="collapseOne" class="card-body bg-grey collapse" data-parent="#accordion">
												<p>
													Praesent nibh nulla, vehicula vitae metus nec, lobortis commodo lorem. Nulla pulvinar vestibulum semper. Curabitur tempor, orci eget laoreet lacinia, urna orci facilisis massa, nec convallis arcu lacus eu mi. Aliquam semper ante eget venenatis pellentesque. Sed suscipit sem id ligula sollicitudin pulvinar. Donec porta enim nec dignissim commodo. Mauris ac elit diam. In vel mattis massa. Donec id mi blandit diam fringilla fringilla vitae id elit.  
												</p>
											</div>
											<a class="card-header collapsed d-flex align-items-center" data-toggle="collapse" href="#collapseTwo">
												<div class="card-title">Cara Mengecek Resi</div>
											</a>
											<div id="collapseTwo" class="card-body bg-grey collapse" data-parent="#accordion">
												<p>
													Etiam ut eleifend eros. Morbi in lectus ut nulla dapibus ornare. Praesent et sapien ac tortor consectetur bibendum.Nam nec sem at lacus tempor porta. Donec ultricies ante sed urna cursus, eget vestibulum libero congue
												</p>
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
