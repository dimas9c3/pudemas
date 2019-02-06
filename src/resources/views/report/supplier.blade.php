<!DOCTYPE html>
<html>
<!-- Stylesheet -->
<link rel="stylesheet" href="{{ asset('template/backend/vendors/css/base/bootstrap.min.css') }}">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Report Supplier - PUDEMAS</title>
</head>
<body>
	<div class="row">
		<div class="col-md-12 mb-3">
			<h3>Report Supplier</h3>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered table-striped mb-0" style="font-size:12px">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama</th>
						<th>Email</th>
						<th>Hp</th>
						<th>Alamat</th>
					</tr>
				</thead>
				<tbody>
				@foreach($supplier as $i)
				<tr>
					<td>
						{{ $i->rownum }}
					</td>
					<td>
						{{ $i->name }}
					</td>
					<td>
						{{ $i->email }}
					</td>
					<td>
						{{ $i->phone }}
					</td>
					<td>
						{{ $i->address }}
					</td>
				</tr>
			@endforeach

		</tbody>
	</table>
</div>
</div>
<br>
<br>
<div class="row mt-3">
	<div class="col-md-12 d-flex justify-content-end align-items-sm-end">
		<h6>Sukoharjo, Tanggal : {{ date('d-m-Y') }}</h6>
	</div>
</div>

</body>
</html>