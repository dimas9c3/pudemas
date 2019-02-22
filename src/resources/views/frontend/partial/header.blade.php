<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>PUDEMAS SYSTEM</title>
	<meta name="description" content="Pickup And Delivery Management System (PUDEMAS)">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Google Fonts -->
	<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js"></script>
	<script>
		WebFont.load({
			google: {"families":["Montserrat:400,500,600,700","Noto+Sans:400,700"]},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>
	<!-- Favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('template/backend/img/apple-touch-icon.png') }}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('template/backend/img/favicon-32x32.png') }}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('template/backend/img/favicon-16x16.png') }}">
	<!-- Stylesheet -->
	<link rel="stylesheet" href="{{ asset('template/backend/vendors/css/base/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('template/backend/vendors/css/base/elisyam-1.5.css') }}">
	<link rel="stylesheet" href="{{ asset('template/backend/vendors/css/base/custom.css') }}">
	<!-- Leaflet -->
	<link rel="stylesheet" href="{{ asset('plugins/leaflet/leaflet.css') }}">
		<!-- Tweaks for older IEs--><!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
	</head>
	<body id="page-top">
		<!-- Begin Preloader -->
		<div id="preloader">
			<div class="canvas">
				<img src="{{ asset('template/backend/img/logo.png') }}" alt="logo" class="loader-logo">
				<div class="spinner"></div>   
			</div>
		</div>
		<!-- End Preloader -->
		<div class="page db-modern">
			<!-- Begin Header -->
			<header class="header">
				<div class="container">
					<nav class="navbar">         
						<!-- Begin Topbar -->
						<div class="navbar-holder d-flex align-items-center align-middle justify-content-between">
							<!-- Begin Logo -->
							<div class="navbar-header">
								<a href="{{ url('/') }}" class="navbar-brand">
									<div class="brand-image brand-big">
										<img src="{{ asset('template/backend/img/logo.png') }}" alt="logo" style="width: 70px;" class="logo-big">
										<h3 class="text-primary">PUDEMAS</h3>
									</div>
									<div class="brand-image brand-small">
										<img src="{{ asset('template/backend/img/logo.png') }}" alt="logo" class="logo-small">
									</div>
								</a>
							</div>
							<!-- End Logo -->
						</div>
						<!-- End Topbar -->
					</nav>
				</div>
			</header>
			<!-- End Header -->
			<!-- Begin Page Content -->
			<div class="page-content">
				<!-- Begin Navigation -->
				<div class="horizontal-menu">
					<div class="container">
						<div class="row">
							<nav class="navbar navbar-light navbar-expand-lg main-menu">
								<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
									<span></span>
									<span></span>
									<span></span>
								</button>
								<div class="collapse navbar-collapse" id="navbarSupportedContent">
									<ul class="navbar-nav mr-auto">
										<li><a href="{{ url('/') }}">Home</a></li>
										<li><a href="{{ route('front.about') }}">About Us</a></li>
									</ul>
								</div>
							</nav>
						</div>
					</div>
				</div>
				<!-- End Navigation -->