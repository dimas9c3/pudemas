@extends('backend.partial.app')
@section('content')
<div class="container-fluid">
	<!-- Begin Page Header-->
	<div class="row">
		<div class="page-header">
			<div class="d-flex align-items-center">
				<h2 class="page-header-title">{{ $page }}</h2>
				<div>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="ti ti-home"></i></a></li>
						<li class="breadcrumb-item active">{{ $page }}</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<!-- End Page Header -->
	<div class="row">
		<div class="page-header">
			<div class="d-flex align-items-center">
				<div>
					<div class="page-header-tools">
						<button type="button" class="btn btn-gradient-01 mb-1" data-toggle="modal" data-target="#add-item">Tambah Barang</button>
						<button type="button" class="btn btn-gradient-01 mb-1" data-toggle="modal" data-target="#item-category1" >Data Kategori Barang</button>
						<button type="button" class="btn btn-gradient-01 mb-1" data-toggle="modal" data-target="#item-category2" >Data Merk Barang</button>
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
			<!-- Begin Item -->
			<div class="widget has-shadow">
				<div class="widget-header bordered no-actions d-flex align-items-center">
					<h4>Tabel Barang</h4>

				</div>
				<div class="widget-body">
					<div class="table-responsive">
						<table id="table-item" class="table mb-0">
							<thead>
								<tr>
									<th>No</th>
									<th>Foto</th>
									<th>Kategori</th>
									<th>Merk</th>
									<th>Nama Model</th>
									<th>Harga Beli</th>
									<th>Harga Jual</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>

							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- End Item -->
		</div>
	</div>
	<!-- End Row -->
</div>
<!-- End Container -->
<!-- Begin Add Item -->
<div id="add-item" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="POST" enctype="multipart/form-data" action="{{ url('item/storeItem') }}">
				@csrf
				<div class="modal-header">
					<h4 class="modal-title">Tambah Data</h4>
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">×</span>
						<span class="sr-only">close</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group row d-flex align-items-center mb-2">
						<label class="col-lg-3 form-control-label d-flex justify-content-lg-end">Kategori *</label>
						<div class="col-lg-9">
							<select name="item_category1" class="form-control select2 select-item-category1" required>
							</select>
						</div>
					</div>
					<div class="form-group row d-flex align-items-center mb-2">
						<label class="col-lg-3 form-control-label d-flex justify-content-lg-end">Merk *</label>
						<div class="col-lg-9">
							<select name="item_category2" class="form-control select2 select-item-category2" required>
							</select>
						</div>
					</div>
					<div class="form-group row d-flex align-items-center mb-2">
						<label class="col-lg-3 form-control-label d-flex justify-content-lg-end">Nama *</label>
						<div class="col-lg-9">
							<input type="text" name="name" class="form-control" placeholder="Input Nama" required>
						</div>
					</div>
					<div class="form-group row d-flex align-items-center mb-2">
						<label class="col-lg-3 form-control-label d-flex justify-content-lg-end">Harga Beli *</label>
						<div class="col-lg-9">
							<input type="text" name="purchase_price" class="form-control" placeholder="Input Harga Beli" required>
						</div>
					</div>
					<div class="form-group row d-flex align-items-center mb-2">
						<label class="col-lg-3 form-control-label d-flex justify-content-lg-end">Harga Jual *</label>
						<div class="col-lg-9">
							<input type="text" name="selling_price" class="form-control" placeholder="Input Harga Jual" required>
						</div>
					</div>
					<div class="form-group row d-flex align-items-center mb-2">
						<label class="col-lg-3 form-control-label d-flex justify-content-lg-end">Foto</label>
						<div class="col-lg-9">
							<input type="file" name="image" class="form-control">
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
<!-- End Add Item -->
<!-- Begin Destroy Item -->
<div id="delete-item" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="POST" enctype="multipart/form-data" action="{{ url('item/destroyItem') }}">
				@csrf
				<div class="modal-header">
					<h4 class="modal-title">Hapus Data</h4>
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">×</span>
						<span class="sr-only">close</span>
					</button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="id" class="id-item" value="">
					<input type="hidden" name="image" class="image-item" value="">
					<strong><p>Apakah Anda Yakin Akan Menghapus Data Ini ?</p></strong>
					<hr>
					<img class="mx-auto d-block image-preview" src="" style="width: 100px;height: 100px;">
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Submit</button>
					<button type="button" class="btn btn-shadow" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- End Destroy Item -->
<!-- Begin Update Item -->
<div id="update-item" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="POST" enctype="multipart/form-data" action="{{ url('item/updateItem') }}">
				@csrf
				<div class="modal-header">
					<h4 class="modal-title">Edit Data</h4>
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">×</span>
						<span class="sr-only">close</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group row d-flex align-items-center mb-2">
						<label class="col-lg-3 form-control-label d-flex justify-content-lg-end">Kategori *</label>
						<div class="col-lg-9">
							<input type="hidden" name="id" class="id-item" value="">
							<input type="hidden" name="image_old" class="image-item" value="">
							<select name="item_category1" class="form-control select2 select-item-category1" id="update-kategori-item" required>
							</select>
						</div>
					</div>
					<div class="form-group row d-flex align-items-center mb-2">
						<label class="col-lg-3 form-control-label d-flex justify-content-lg-end">Merk *</label>
						<div class="col-lg-9">
							<select name="item_category2" class="form-control select2 select-item-category2" id="update-merk-item" required>
							</select>
						</div>
					</div>
					<div class="form-group row d-flex align-items-center mb-2">
						<label class="col-lg-3 form-control-label d-flex justify-content-lg-end">Nama *</label>
						<div class="col-lg-9">
							<input type="text" name="name" class="form-control" id="update-nama-item" value="" required>
						</div>
					</div>
					<div class="form-group row d-flex align-items-center mb-2">
						<label class="col-lg-3 form-control-label d-flex justify-content-lg-end">Harga Beli *</label>
						<div class="col-lg-9">
							<input type="text" name="purchase_price" class="form-control" id="update-beli-item" value="" required>
						</div>
					</div>
					<div class="form-group row d-flex align-items-center mb-2">
						<label class="col-lg-3 form-control-label d-flex justify-content-lg-end">Harga Jual *</label>
						<div class="col-lg-9">
							<input type="text" name="selling_price" class="form-control" id="update-jual-item" value="" required>
						</div>
					</div>
					<div class="form-group row d-flex align-items-center mb-2">
						<label class="col-lg-3 form-control-label d-flex justify-content-lg-end">Foto</label>
						<div class="col-lg-9">
							<input type="file" name="image" class="form-control">
						</div>
					</div>
					<hr>
					<img class="mx-auto d-block image-preview" src="" style="width: 100px;height: 100px;">
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Submit</button>
					<button type="button" class="btn btn-shadow" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- End Update Item -->
<!-- Begin  Item Category 1 -->
<div id="item-category1" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form class="needs-validation" novalidate>
				<div class="modal-header">
					<h4 class="modal-title">Data Kategori Barang</h4>
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">×</span>
						<span class="sr-only">close</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="table-responsive">
						<table id="table-item-category1" class="table mb-0" style="width: 100%;">
							<thead>
								<tr>
									<th>No</th>
									<th>Kategori</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								
							</tbody>
						</table>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" data-toggle="modal" data-target="#add-item-catgeory1" data-dismiss="modal" class="btn btn-success">Tambah Data</button>
					<button type="button" class="btn btn-shadow" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- End Item Category 1 -->
<!-- Begin Add Item Category 1 -->
<div id="add-item-catgeory1" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="POST" enctype="multipart/form-data" action="{{ url('item/storeItemCategory1') }}">
				@csrf
				<div class="modal-header">
					<h4 class="modal-title">Tambah Data</h4>
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">×</span>
						<span class="sr-only">close</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group row d-flex align-items-center mb-2">
						<label class="col-lg-3 form-control-label d-flex justify-content-lg-end">Nama *</label>
						<div class="col-lg-9">
							<input type="text" name="name" class="form-control" placeholder="Input Nama" required autofocus>
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
<!-- End Add Item Category 1 -->
<!-- Begin Destroy Item Category 1 -->
<div id="delete-item-category1" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="POST" enctype="multipart/form-data" action="{{ url('item/destroyItemCategory1') }}">
				@csrf
				<div class="modal-header">
					<h4 class="modal-title">Hapus Data</h4>
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">×</span>
						<span class="sr-only">close</span>
					</button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="id" class="id-item-category1" value="">
					<strong><p>Apakah Anda Yakin Akan Menghapus Data Ini ?</p></strong>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Submit</button>
					<button type="button" class="btn btn-shadow" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- End Destroy Item Category 1 -->
<!-- Begin Update Item Category 1 -->
<div id="update-item-category1" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="POST" enctype="multipart/form-data" action="{{ url('item/updateItemCategory1') }}">
				@csrf
				<div class="modal-header">
					<h4 class="modal-title">Edit Data</h4>
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">×</span>
						<span class="sr-only">close</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group row d-flex align-items-center mb-2">
						<label class="col-lg-3 form-control-label d-flex justify-content-lg-end">Nama *</label>
						<div class="col-lg-9">
							<input type="hidden" name="id" class="id-item-category1" value="">
							<input type="text" id="update-nama-item-category1" name="name" class="form-control" value="">
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
<!-- End Update Item Category 1 -->
<!-- Begin  Item Category 2 -->
<div id="item-category2" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form class="needs-validation" novalidate>
				<div class="modal-header">
					<h4 class="modal-title">Data Merk Barang</h4>
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">×</span>
						<span class="sr-only">close</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="table-responsive">
						<table id="table-item-category2" class="table mb-0" style="width: 100%;">
							<thead>
								<tr>
									<th>No</th>
									<th>Merk</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								
							</tbody>
						</table>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" data-toggle="modal" data-target="#add-item-category1" data-dismiss="modal" class="btn btn-success">Tambah Data</button>
					<button type="button" class="btn btn-shadow" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- End Item Category 1 -->
<!-- Begin Add Item Category 1 -->
<div id="add-item-category1" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="POST" enctype="multipart/form-data" action="{{ url('item/storeItemCategory2') }}">
				@csrf
				<div class="modal-header">
					<h4 class="modal-title">Tambah Data</h4>
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">×</span>
						<span class="sr-only">close</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group row d-flex align-items-center mb-2">
						<label class="col-lg-3 form-control-label d-flex justify-content-lg-end">Nama *</label>
						<div class="col-lg-9">
							<input type="text" name="name" class="form-control" placeholder="Input Nama" required autofocus>
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
<!-- End Add Item Category 2 -->
<!-- Begin Destroy Item Category 2 -->
<div id="delete-item-category2" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="POST" enctype="multipart/form-data" action="{{ url('item/destroyItemCategory2') }}">
				@csrf
				<div class="modal-header">
					<h4 class="modal-title">Hapus Data</h4>
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">×</span>
						<span class="sr-only">close</span>
					</button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="id" class="id-item-category2" value="">
					<strong><p>Apakah Anda Yakin Akan Menghapus Data Ini ?</p></strong>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Submit</button>
					<button type="button" class="btn btn-shadow" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- End Destroy Item Category 1 -->
<!-- Begin Update Item Category 1 -->
<div id="update-item-category2" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="POST" enctype="multipart/form-data" action="{{ url('item/updateItemCategory2') }}">
				@csrf
				<div class="modal-header">
					<h4 class="modal-title">Edit Data</h4>
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">×</span>
						<span class="sr-only">close</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group row d-flex align-items-center mb-2">
						<label class="col-lg-3 form-control-label d-flex justify-content-lg-end">Nama *</label>
						<div class="col-lg-9">
							<input type="hidden" name="id" class="id-item-category2" value="">
							<input type="text" id="update-nama-item-category2" name="name" class="form-control" value="">
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
<!-- End Update Item Category 2 -->
@endsection
@section('js-route')
<script>
	var getItem 			= '{{ route('getItem') }}';
	var getItemCategory1 	= '{{ route('getItemCategory1') }}';
	var getItemCategory2 	= '{{ url('item/getItemCategory2') }}';
	var getItemById 		= '{{ route('getItemById') }}';
	var selectItemCategory1 = '{{ url('item/selectItemCategory1') }}';
	var selectItemCategory2 = '{{ url('item/selectItemCategory2') }}';
	var path_item 			= '{{ asset('storage/images/item') }}'
	var token 				= '{{ csrf_token() }}';
</script>
@endsection
@section('js')
<script>
	$(document).ready(function() {
		document.getElementById("master-link").classList.add('active');
		document.getElementById("master-link2").setAttribute('aria-expanded','TRUE');
		document.getElementById("dropdown-master").classList.add('show');
		document.getElementById("item-link").classList.add('active');
		datatables.table_item();
		datatables.table_item_category1();
		datatables.table_item_category2();
		select2.selectItemCategory1();
		select2.selectItemCategory2();
		showModal.destroyItem();
		showModal.updateItem();
		showModal.destroyItemCategory1();
		showModal.updateItemCategory1();
		showModal.destroyItemCategory2();
		showModal.updateItemCategory2();
	});
</script>
@endsection