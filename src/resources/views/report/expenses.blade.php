<!DOCTYPE html>
<html>
<!-- Stylesheet -->
<link rel="stylesheet" href="{{ asset('template/backend/vendors/css/base/bootstrap.min.css') }}">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Report Pengeluaran Lain Lain - PUDEMAS</title>
</head>
<body>
	<div class="row">
		<div class="col-md-12 mb-3">
			<h3>Report Pengeluaran Lain Lain</h3>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered table-striped mb-0" style="font-size:12px">
				<thead>
					<tr>
						<th>No</th>
						<th>Tanggal</th>
						<th>Pencatat</th>
						<th>Perihal</th>
						<th>Jumlah</th>
					</tr>
				</thead>
				<tbody>
				@foreach($data as $i)
				<tr>
					<td>
						{{ $i->rownum }}
					</td>
					<td>
						{{ Carbon\Carbon::createFromFormat('Y-m-d', $i->date)->format('d-m-Y') }}
					</td>
					<td>
						{{ $i->created_by }}
					</td>
					<td>
						{{ $i->subject }}
					</td>
					<td>
						Rp. {{ number_format($i->amount) }}
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