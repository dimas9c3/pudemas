<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>PUDEMAS - Login</title>
	<meta name="description" content="Elisyam is a Web App and Admin Dashboard Template built with Bootstrap 4">
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
	  <!-- Tweaks for older IEs--><!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
	</head>
	<body class="bg-white">
		<!-- Begin Preloader -->
		<div id="preloader">
			<div class="canvas">
				<img src="{{ asset('template/backend/img/logo.png') }}" alt="logo" class="loader-logo">
				<div class="spinner"></div>   
			</div>
		</div>
		<!-- End Preloader -->
		<!-- Begin Container -->
		<div class="container-fluid no-padding h-100">
			<div class="row flex-row h-100 bg-white">
				<!-- Begin Left Content -->
				<div class="col-xl-8 col-lg-6 col-md-5 no-padding">
					<div class="elisyam-bg background-01">
						<div class="elisyam-overlay overlay-01"></div>
						<div class="authentication-col-content mx-auto">
							<h1 class="gradient-text-01">
								Welcome To PUDEMAS!
							</h1>
							<span class="description">
								Pick Up And Delivery Management System
							</span>
						</div>
					</div>
				</div>
				<!-- End Left Content -->
				<!-- Begin Right Content -->
				<div class="col-xl-4 col-lg-6 col-md-7 my-auto no-padding">
					<!-- Begin Form -->
					<div class="authentication-form mx-auto">
						<form method="POST" action="{{ route('login') }}">
							@csrf
							<div class="logo-centered">
								<a href="#">
									<img src="{{ asset('template/backend/img/logo.png') }}" alt="logo">
								</a>
							</div>
							<h3>Sign In To PUDEMAS</h3>

							<div class="group material-input">
								<input d="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
								<span class="highlight"></span>
								<span class="bar"></span>
								<label>Email</label>
								@if ($errors->has('email'))
								<span class="invalid-feedback" role="alert">
									<strong>{{ $errors->first('email') }}</strong>
								</span>
								@endif
							</div>
							<div class="group material-input">
								<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
								<span class="highlight"></span>
								<span class="bar"></span>
								<label>Password</label>
								@if ($errors->has('password'))
								<span class="invalid-feedback" role="alert">
									<strong>{{ $errors->first('password') }}</strong>
								</span>
								@endif
							</div>

							<div class="row">
								<div class="col text-left">
									<div class="styled-checkbox">
										<input type="checkbox" name="remember" id="remeber" {{ old('remember') ? 'checked' : '' }}>
										<label for="remeber">Remember me</label>
									</div>
								</div>
								<div class="col text-right">
									<a href="{{ route('password.request') }}">Forgot Password ?</a>
								</div>
							</div>
							<div class="sign-btn text-center">
								<button type="submit" class="btn btn-lg btn-gradient-01">
									Sign in
								</button>
							</div>
						</form>
					</div>
					<!-- End Form -->                        
				</div>
				<!-- End Right Content -->
			</div>
			<!-- End Row -->
		</div>
		<!-- End Container -->    
		<!-- Begin Vendor Js -->
		<script src="{{ asset('template/backend/vendors/js/base/jquery.min.js') }}"></script>
		<script src="{{ asset('template/backend/vendors/js/base/core.min.js') }}"></script>
		<!-- End Vendor Js -->
		<!-- Begin Page Vendor Js -->
		<script src="{{ asset('template/backend/vendors/js/app/app.js') }}"></script>
		<script src="{{ asset('template/backend/vendors/js/nicescroll/nicescroll.min.js') }}"></script>
		<!-- End Page Vendor Js -->
	</body>
	</html>