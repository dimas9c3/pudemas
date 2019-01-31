<!-- Begin Page Content -->
<div class="page-content d-flex align-items-stretch">
	<div class="default-sidebar">
		<!-- Begin Side Navbar -->
		<nav class="side-navbar box-scroll sidebar-scroll">
			<!-- Begin Main Navigation -->
			<ul class="list-unstyled">
				<li id="dashboard-link"><a href="{{ route('home') }}"><i class="la la-home"></i><span>Dashboard</span></a></li>
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
						<li><a id="pickup-index-link" href="{{ route('pickup') }}">Data Pengambilan Selesai</a></li>
						<li><a id="pickup-active-link" href="{{ route('pickupActive') }}">Data Pengambilan Aktif</a></li>
						<li><a id="pickup-cancel-link" href="{{ url('pickup/cancel') }}">Data Pengambilan Dibatalkan</a></li>
						<li><a id="add-pickup-link" href="{{ route('createPickup') }}">Input Pengambilan</a></li>
						@endrole
						@role('Kurir')
						<li><a id="pickup-active-link" href="{{ route('pickupActiveCourier') }}">Data Pengambilan Aktif</a></li>
						@endrole
					</ul>
				</li>
				<li id="delivery-link"><a id="delivery-link2" href="#dropdown-delivery" aria-expanded="false" data-toggle="collapse"><i class="la la-send"></i><span>Transaksi Pengiriman</span></a>
					<ul id="dropdown-delivery" class="collapse list-unstyled pt-0">
						@role('Admin|Pimpinan')
						<li><a id="delivery-index-link" href="{{ route('delivery') }}">Data Pengiriman Selesai</a></li>
						<li><a id="delivery-active-link" href="{{ route('activeDelivery') }}">Data Pengiriman Aktif</a></li>
						<li><a id="delivery-cancel-link" href="{{ url('delivery/deliveryCancel') }}">Data Pengiriman Dibatalkan</a></li>
						<li><a id="add-delivery-link" href="{{ route('createDelivery') }}">Input Pengiriman</a></li>
						@endrole
						@role('Kurir')
						<li><a id="delivery-active-link" href="{{ url('delivery/activeDeliveryCourier') }}">Data Pengiriman Aktif</a></li>
						@endrole
					</ul>
				</li>
				@role('Admin|Pimpinan')
				<li id="courier-link"><a href="{{ route('courier.index') }}"><i class="la la-user-secret"></i><span>Data Kurir</span></a></li>
				<li id="expenses-link"><a href="{{ route('otherExpenses') }}"><i class="la la-sign-out"></i><span>Data Pengeluaran</span></a></li>
				<li id="setting-link"><a href="{{ route('setting.index') }}"><i class="la la-gear"></i><span>Setting</span></a></li>
				@endrole
			</ul>
			
			<!-- End Main Navigation -->
		</nav>
		<!-- End Side Navbar -->
	</div>
	<!-- End Left Sidebar -->
	<div class="content-inner">