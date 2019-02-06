<!DOCTYPE html>
<html>
<!-- Stylesheet -->
<link rel="stylesheet" href="{{ asset('template/backend/vendors/css/base/bootstrap.min.css') }}">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Invoice Pembelian - PUDEMAS</title>
</head>
<body>
	<div class="row">
		<div class="col-md-12 mb-3">
			<h3>Invoice Pembelian</h3>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered table-striped mb-0" style="font-size:12px">
				<thead>
					<tr>
						<th>ID Delivery</th>
						<th>Tanggal</th>
						<th>Customer</th>
						<th>Kurir</th>
						<th>Ongkir</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							{{ $delivery[0]->id_delivery }}
						</td>
						<td>
							{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $delivery[0]->date)->format('d-m-Y') }}
						</td>
						<td>
							{{ $delivery[0]->customer_name }}
						</td>
						<td>
							{{ $delivery[0]->courier_name }}
						</td>
						<td>
							Rp. {{ number_format($delivery[0]->send_cost) }}
						</td>
					</tr>
				</tbody>
			</table>
			<h3 class="mt-3">Detail Pembelian</h3>
			<table class="table table-bordered table-striped mb-0 mt-3" style="font-size:12px">
				<thead>
					<tr>
						<th>Item</th>
						<th>QTY</th>
						<th>Harga</th>
						<th>Subtotal</th>
					</tr>
				</thead>
				<tbody>
					@php $gt = 0 @endphp
					@foreach($delivery as $i)
					@php $gt = ($i->selling_price * $i->qty) + $gt; @endphp
					<tr>
						<td>
							{{ $i->item_name }}
						</td>
						<td>
							{{ $i->qty }}
						</td>
						<td>
							Rp. {{ number_format($i->selling_price) }}
						</td>
						<td>
							Rp. {{ number_format($i->selling_price * $i->qty) }}
						</td>
					</tr>
					@endforeach
				</tbody>
				<tfoot>
					<tr>
						<td colspan="3">Total Transaksi</td>
						<td>Rp. {{ number_format($gt) }}</td>
					</tr>
				</tfoot>
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