<!-- Begin Page Content -->
<div class="page-content d-flex align-items-stretch">
	<div class="default-sidebar">
		<!-- Begin Side Navbar -->
		<nav class="side-navbar box-scroll sidebar-scroll">
			<!-- Begin Main Navigation -->
			<ul class="list-unstyled">
				<li><a href="{{ route('home') }}"><i class="la la-home"></i><span>Dashboard</span></a></li>
				@can('master-items')
				<li id="master-link"><a id="master-link2" href="#dropdown-master" aria-expanded="false" data-toggle="collapse"><i class="la la-spinner"></i><span>Data Master</span></a>
					<ul id="dropdown-master" class="collapse list-unstyled pt-0">
						<li><a id="item-link" href="{{ route('item') }}">Data Barang</a></li>
						@can('master-customers')
						<li><a id="customer-link" href="{{ route('customer') }}">Data Customer</a></li>
						@endcan
						@can('master-suppliers')
						<li><a id="supplier-link" href="{{ route('supplier') }}">Data Supplier</a></li>
						@endcan
					</ul>
				</li>
				@endcan
				@can('master-users')
				<li><a href="#dropdown-icons" aria-expanded="false" data-toggle="collapse"><i class="la la-users"></i><span>Manajemen Users</span></a>
					<ul id="dropdown-icons" class="collapse list-unstyled pt-0">
						<li><a href="{{ route('users.index') }}">Data User</a></li>
						@can('master-roles')
						<li><a href="{{ route('roles.index') }}">Manajemen Roles User</a></li>
						@endcan
					</ul>
				</li>
				@endcan
				<li id="pickup-link"><a id="pickup-link2" href="#dropdown-pickup" aria-expanded="false" data-toggle="collapse"><i class="la la-cart-arrow-down"></i><span>Transaksi Pengambilan</span></a>
					<ul id="dropdown-pickup" class="collapse list-unstyled pt-0">
						@role('Admin|Pimpinan')
						<li><a id="pickup-active-link" href="{{ route('pickupActive') }}">Data Pengambilan Aktif</a></li>
						<li><a id="add-pickup-link" href="{{ route('createPickup') }}">Input Pengambilan</a></li>
						@endrole
						@role('Kurir')
						<li><a id="pickup-active-link" href="{{ route('pickupActiveCourier') }}">Data Pengambilan Aktif</a></li>
						@endrole
					</ul>
				</li>
			</ul>
			
			<!-- End Main Navigation -->
		</nav>
		<!-- End Side Navbar -->
	</div>
	<!-- End Left Sidebar -->
	<div class="content-inner">