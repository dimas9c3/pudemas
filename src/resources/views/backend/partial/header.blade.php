<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>{{ $title }}</title>
	<meta name="description" content="Pickup And Delivery Management System (PUDEMAS)">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Google Fonts -->
	<!--<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js"></script>
	<script>
		WebFont.load({
			google: {"families":["Montserrat:400,500,600,700","Noto+Sans:400,700"]},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>-->
	<!-- Favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('template/backend/img/apple-touch-icon.png') }}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('template/backend/img/favicon-32x32.png') }}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('template/backend/img/favicon-16x16.png') }}">
	<!-- Stylesheet -->
	<link rel="stylesheet" href="{{ asset('template/backend/vendors/css/base/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('template/backend/vendors/css/base/elisyam-1.5.css') }}">
	<link rel="stylesheet" href="{{ asset('template/backend/vendors/css/base/custom.css') }}">
	<!-- Datatables -->
	<link type="text/css" href="{{ asset('plugins/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
	<!-- Select2 -->
	<link type="text/css" href="{{ asset('plugins/select2/css/select2.min.css') }}" rel="stylesheet">
	<!-- Leaflet -->
	<link rel="stylesheet" href="{{ asset('plugins/leaflet/leaflet.css') }}">
	<!-- Datepicker -->
	<link rel="stylesheet" href="{{ asset('plugins/datepicker/css/bootstrap-datepicker.min.css') }}">
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
		<div class="page">
			<!-- Begin Header -->
			<header class="header">
				<nav class="navbar fixed-top">         
					<!-- Begin Search Box-->
					<div class="search-box">
						<button class="dismiss"><i class="ion-close-round"></i></button>
						<form id="searchForm" action="#" role="search">
							<input type="search" placeholder="Search something ..." class="form-control">
						</form>
					</div>
					<!-- End Search Box-->
					<!-- Begin Topbar -->
					<div class="navbar-holder d-flex align-items-center align-middle justify-content-between">
						<!-- Begin Logo -->
						<div class="navbar-header">
							<a href="{{ route('home') }}" class="navbar-brand">
								<div class="brand-image brand-big">
									<img src="{{ asset('template/backend/img/logo-big.png') }}" alt="logo" class="logo-big">
								</div>
								<div class="brand-image brand-small">
									<img src="{{ asset('template/backend/img/logo.png') }}" alt="logo" class="logo-small">
								</div>
							</a>
							<!-- Toggle Button -->
							<a id="toggle-btn" href="#" class="menu-btn active">
								<span></span>
								<span></span>
								<span></span>
							</a>
							<!-- End Toggle -->
						</div>
						<!-- End Logo -->
						<!-- Begin Navbar Menu -->
						<ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center pull-right">
							<!-- Begin Notifications -->
							<!--
							<li class="nav-item dropdown"><a id="notifications" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link"><i class="la la-bell animated infinite swing"></i><span class="badge-pulse"></span></a>
								<ul aria-labelledby="notifications" class="dropdown-menu notification">
									<li>
										<div class="notifications-header">
											<div class="title">Notifications (4)</div>
											<div class="notifications-overlay"></div>
											<img src="{{ asset('template/backend/img/notifications/01.jpg') }}" alt="..." class="img-fluid">
										</div>
									</li>
									<li>
										<a href="#">
											<div class="message-icon">
												<i class="la la-user"></i>
											</div>
											<div class="message-body">
												<div class="message-body-heading">
													New user registered
												</div>
												<span class="date">2 hours ago</span>
											</div>
										</a>
									</li>
									<li>
										<a href="#">
											<div class="message-icon">
												<i class="la la-calendar-check-o"></i>
											</div>
											<div class="message-body">
												<div class="message-body-heading">
													New event added
												</div>
												<span class="date">7 hours ago</span>
											</div>
										</a>
									</li>
									<li>
										<a href="#">
											<div class="message-icon">
												<i class="la la-history"></i>
											</div>
											<div class="message-body">
												<div class="message-body-heading">
													Server rebooted
												</div>
												<span class="date">7 hours ago</span>
											</div>
										</a>
									</li>
									<li>
										<a href="#">
											<div class="message-icon">
												<i class="la la-twitter"></i>
											</div>
											<div class="message-body">
												<div class="message-body-heading">
													You have 3 new followers
												</div>
												<span class="date">10 hours ago</span>
											</div>
										</a>
									</li>
									<li>
										<a rel="nofollow" href="#" class="dropdown-item all-notifications text-center">View All Notifications</a>
									</li>
								</ul>
							</li>
							-->
							<!-- End Notifications -->
							<!-- User -->
							<li class="nav-item dropdown"><a id="user" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link"><img src="{{ asset('template/backend/img/avatar/avatar-01.jpg') }}" alt="..." class="avatar rounded-circle"></a>
								<ul aria-labelledby="user" class="user-size dropdown-menu">
									<li class="welcome">
										<a href="#" class="edit-profil"><i class="la la-gear"></i></a>
										<img src="{{ asset('template/backend/img/avatar/avatar-01.jpg') }}" alt="..." class="rounded-circle">
									</li>
									<li>
										<a href="{{ url('/') }}" class="dropdown-item" target="_blank"> 
											Homepage
										</a>
									</li>
									<li class="separator"></li>
									<li>
										<a rel="nofollow" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="dropdown-item logout text-center"><i class="ti-power-off"></i></a>
										<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
											@csrf
										</form>
									</li>
								</ul>
							</li>
							<!-- End User -->
							<!-- Search
							<li class="nav-item d-flex align-items-center"><a id="search" href="#"><i class="la la-search"></i></a>s</li>-->
							<!-- End Search -->
						</ul>
						<!-- End Navbar Menu -->
					</div>
					<!-- End Topbar -->
				</nav>
			</header>
			<!-- End Header -->