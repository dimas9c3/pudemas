<!-- Begin Page Content -->
<div class="page-content d-flex align-items-stretch">
	<div class="default-sidebar">
		<!-- Begin Side Navbar -->
		<nav class="side-navbar box-scroll sidebar-scroll">
			<!-- Begin Main Navigation -->
			<ul class="list-unstyled">
				<li><a href="{{ route('home') }}"><i class="la la-home"></i><span>Dashboard</span></a></li>
				<li><a href="#dropdown-ui" aria-expanded="false" data-toggle="collapse"><i class="la la-spinner"></i><span>Data Master</span></a>
					<ul id="dropdown-ui" class="collapse list-unstyled pt-0">
						<li id="customer-link"><a href="{{ route('customer') }}">Data Customer</a></li>
					</ul>
				</li>
				<li><a href="#dropdown-icons" aria-expanded="false" data-toggle="collapse"><i class="la la-users"></i><span>Manajemen Users</span></a>
					<ul id="dropdown-icons" class="collapse list-unstyled pt-0">
						<li><a href="{{ route('users.index') }}">Data User</a></li>
						<li><a href="{{ route('roles.index') }}">Manajemen Roles User</a></li>
					</ul>
				</li>
				<li><a href="#dropdown-forms" aria-expanded="false" data-toggle="collapse"><i class="la la-list-alt"></i><span>Forms</span></a>
					<ul id="dropdown-forms" class="collapse list-unstyled pt-0">
						<li><a href="forms-basic.html">Form Basic</a></li>
					</ul>
				</li>
				<li><a href="#dropdown-tables" aria-expanded="false" data-toggle="collapse"><i class="la la-th-large"></i><span>Tables</span></a>
					<ul id="dropdown-tables" class="collapse list-unstyled pt-0">
						<li><a href="tables-basic.html">Basic</a></li>
					</ul>
				</li>
			</ul>
			
			<!-- End Main Navigation -->
		</nav>
		<!-- End Side Navbar -->
	</div>
	<!-- End Left Sidebar -->
	<div class="content-inner">