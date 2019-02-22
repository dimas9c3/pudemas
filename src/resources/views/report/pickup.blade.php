<!DOCTYPE html>
<html>
<!-- Stylesheet -->
<link rel="stylesheet" href="{{ asset('template/backend/vendors/css/base/bootstrap.min.css') }}">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Report Pengambilan - PUDEMAS</title>
</head>
<body>
	<div class="row">
		<div class="col-md-12 mb-3">
			<h3>Report Pengambilan</h3>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered table-striped mb-0" style="font-size:12px">
				<thead>
					<tr>
						<th>ID Pickup</th>
						<th>Tanggal</th>
						<th>Status</th>
						<th>Kurir</th>
						<th>Jenis</th>
						<th>Dikirim Ke Customer</th>
						<th>Item</th>
						<th>Supplier</th>
						<th>Qty</th>
						<th>Harga</th>
					</tr>
				</thead>
				<tbody>
				@foreach($pickup as $i)
					@if($i->is_first_row == 1)
					<tr>
						<td>
							{{ $i->id_pickup }}
						</td>
						<td>
							{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $i->date)->format('d-m-Y') }}
						</td>
						@if($i->status == 0)
							<td>
								Job Selesai
							</td>
							@else
							<td>
								On Progress
							</td>
						@endif
						<td>
							{{ $i->courier_name }}
						</td>
						<td>
							{{ $i->type }}
						</td>
						@if($i->is_send_to_customer == 1)
							<td>
								Ya
							</td>
							@else
							<td>
								Tidak
							</td>
						@endif
						<td>
							{{ $i->item_name }}
						</td>
						<td>
							{{ $i->supplier_name }}
						</td>
						<td>
							{{ $i->qty }}
						</td>
						<td>
							Rp. {{ number_format($i->purchase_price) }}
						</td>
					</tr>
					@else
					<tr>
						<td>
							
						</td>
						<td>
							
						</td>
			
						<td>

						</td>
						
						<td>
							
						</td>
						<td>
							
						</td>
						
						<td>
							
						</td>
						<td>
							{{ $i->item_name }}
						</td>
						<td>
							{{ $i->supplier_name }}
						</td>
						<td>
							{{ $i->qty }}
						</td>
						<td>
							{{ $i->purchase_price }}
						</td>
					</tr>
					@endif
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