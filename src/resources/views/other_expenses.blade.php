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
						<button type="button" class="btn btn-gradient-01 mb-1" data-toggle="modal" data-target="#add-data">Tambah Data</button>
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
			<!-- Begin Other Expenses -->
			<div class="widget has-shadow">
				<div class="widget-header bordered no-actions d-flex align-items-center">
					<a href="{{ url('other_expenses/report') }}" class="btn btn-gradient-01 mb-1">Cetak Laporan</a>

				</div>
				<div class="widget-body">
					<div class="table-responsive">
						<table id="table-expenses" class="table mb-0">
							<thead>
								<tr>
									<th>No</th>
									<th>Tanggal</th>
									<th>Pencatat</th>
									<th>Perihal</th>
									<th>Jumlah</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>

							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- End Other Expenses -->
		</div>
	</div>
	<!-- End Row -->
</div>
<!-- End Container -->
<!-- Begin Add Other Expenses -->
<div id="add-data" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="POST" enctype="multipart/form-data" action="{{ url('other_expenses/storeOtherExpenses') }}">
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
						<label class="col-lg-3 form-control-label d-flex justify-content-lg-end">Perihal *</label>
						<div class="col-lg-9">
							<textarea name="subject" class="form-control" rows="5" placeholder="Input Perihal"></textarea>
						</div>
					</div>
					<div class="form-group row d-flex align-items-center mb-2">
						<label class="col-lg-3 form-control-label d-flex justify-content-lg-end">Jumlah *</label>
						<div class="col-lg-9">
							<input type="number" class="form-control" name="amount" placeholder="Input Jumlah" required>
						</div>
					</div>
					<div class="form-group row d-flex align-items-center mb-2">
						<label class="col-lg-3 form-control-label d-flex justify-content-lg-end">Tanggal</label>
						<div class="col-lg-9">
							<input type="text" class="form-control datepicker" name="date" value="{{ date('d-m-Y') }}" required>
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
<!-- End Add Other Expenses -->
<!-- Begin Update Other Expenses -->
<div id="update-data" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="POST" enctype="multipart/form-data" action="{{ url('other_expenses/updateOtherExpenses') }}">
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
						<label class="col-lg-3 form-control-label d-flex justify-content-lg-end">Perihal *</label>
						<div class="col-lg-9">
							<input type="hidden" name="id" class="id-expenses" value="">
							<textarea name="subject" class="form-control" rows="5" id="edit-subject"></textarea>
						</div>
					</div>
					<div class="form-group row d-flex align-items-center mb-2">
						<label class="col-lg-3 form-control-label d-flex justify-content-lg-end">Jumlah *</label>
						<div class="col-lg-9">
							<input type="number" class="form-control" name="amount" id="edit-amount" value="" required>
						</div>
					</div>
					<div class="form-group row d-flex align-items-center mb-2">
						<label class="col-lg-3 form-control-label d-flex justify-content-lg-end">Tanggal</label>
						<div class="col-lg-9">
							<input type="text" class="form-control datepicker" name="date" id="edit-date" value="" required>
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
<!-- End Update Other Expenses -->
<!-- Begin Destroy Other Expenses -->
<div id="delete-data" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="POST" enctype="multipart/form-data" action="{{ url('other_expenses/destroyOtherExpenses') }}">
				@csrf
				<div class="modal-header">
					<h4 class="modal-title">Hapus Data</h4>
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">×</span>
						<span class="sr-only">close</span>
					</button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="id" class="id-expenses" value="">
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
<!-- End Destroy Other Expenses -->
@endsection
@section('js-route')
<script>
	var token 					= '{{ csrf_token() }}';
	var getOtherExpenses 		= '{{ url('other_expenses/getOtherExpenses') }}'
</script>
@endsection
@section('js')
<script>
	$(document).ready(function() {
		document.getElementById("expenses-link").classList.add('active');
		datepicker.datepicker();
		datatables.table_other_expenses();
		showModal.destroyOtherExpenses();
		showModal.updateOtherExpenses();
	});
</script>
@endsection