<!DOCTYPE html>
<html>
<!-- Stylesheet -->
<link rel="stylesheet" href="{{ asset('template/backend/vendors/css/base/bootstrap.min.css') }}">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Report Customer - PUDEMAS</title>
</head>
<body>
	<div class="row">
		<div class="col-md-12 mb-3">
			<h3>Report Customer</h3>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered table-striped mb-0" style="font-size:12px">
				<thead>
					<tr>
						<th>No</th>
						<th>ID</th>
						<th>Nama</th>
						<th>Jenis</th>
						<th>Email</th>
						<th>Hp</th>
						<th>Alamat</th>
					</tr>
				</thead>
				<tbody>
				@foreach($customer as $i)
				<tr>
					<td>
						{{ $i->rownum }}
					</td>
					<td>
						{{ $i->id }}
					</td>
					<td>
						{{ $i->name }}
					</td>
					<td>
						{{ $i->type }}
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
		<div class="col-md-12">
			<table>
				<thead>
					<tr>
						<th></th>
						<th style="text-align: right;"></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Sukoharjo, Tanggal : {{ date('d-m-Y') }}</td>
					</tr>
					<tr>
						<td>
							<img src="{{ asset('template/backend/img/signature.png') }}" alt="signature" style="width: 100px; height: 100px;">
						</td>
					</tr>
					<tr>
						<td>PUDEMAS</td>
					</tr>
				</tbody>
			</table>
			
		</div>
	</div>

</body>
</html>