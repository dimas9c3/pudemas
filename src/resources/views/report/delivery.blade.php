<!DOCTYPE html>
<html>
<!-- Stylesheet -->
<link rel="stylesheet" href="{{ asset('template/backend/vendors/css/base/bootstrap.min.css') }}">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Report Pengiriman - PUDEMAS</title>
</head>
<body>
	<div class="row">
		<div class="col-md-12 mb-3">
			<h3>Report Pengiriman</h3>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered table-striped mb-0" style="font-size:12px">
				<thead>
					<tr>
						<th>ID Delivery</th>
						<th>Tanggal</th>
						<th>Status</th>
						<th>Customer</th>
						<th>Kurir</th>
						<th>Pickup Ke Distributor</th>
						<th>Ongkir</th>
						<th>Item</th>
						<th>Qty</th>
						<th>Harga</th>
					</tr>
				</thead>
				<tbody>
				@foreach($delivery as $i)
					@if($i->is_first_row == 1)
					<tr>
						<td>
							{{ $i->id_delivery }}
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
							{{ $i->customer_name }}
						</td>
						<td>
							{{ $i->courier_name }}
						</td>
						@if($i->is_pickup_first == 1)
							<td>
								Ya
							</td>
						@else
							<td>
								Tidak
							</td>
						@endif
						<td>
							Rp. {{ number_format($i->send_cost) }}
						</td>
						<td>
							{{ $i->item_name }}
						</td>
						<td>
							{{ $i->qty }}
						</td>
						<td>
							Rp.{{ number_format($i->selling_price) }}
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

						</td>
						<td>
							{{ $i->item_name }}
						</td>
						<td>
							{{ $i->qty }}
						</td>
						<td>
							Rp.{{ number_format($i->selling_price) }}
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