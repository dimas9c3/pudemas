<!DOCTYPE html>
<html>
<!-- Stylesheet -->
<link rel="stylesheet" href="{{ asset('template/backend/vendors/css/base/bootstrap.min.css') }}">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Report Item - PUDEMAS</title>
</head>
<body>
	<div class="row">
		<div class="col-md-12 mb-3">
			<h3>Report Item</h3>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered table-striped mb-0" style="font-size:12px">
				<thead>
					<tr>
						<th>No</th>
						<th>Foto</th>
						<th>Kategori</th>
						<th>Merk</th>
						<th>Nama Model</th>
						<th>Harga Beli</th>
						<th>Harga Jual</th>
					</tr>
				</thead>
				<tbody>
					@foreach($item as $i)
					<tr>
						@if (!empty($i->image))
						
						<td>
							<img class="rounded-circle" src="{{ asset('storage/images/item/thumbnail/'.$i->image) }}" style="width:100px;height:100px;" />
						</td>
						@else
						<td>
							<img class="rounded-circle" src="{{ asset('storage/images/item/item-template.png') }}" style="width:100px;height:100px;" />
						</td>
						@endif
				<td>
					{{ $i->rownum }}
				</td>
				<td>
					{{ $i->kategori }}
				</td>
				<td>
					{{ $i->merk }}
				</td>
				<td>
					{{ $i->name }}
				</td>
				<td>
					Rp. {{ number_format($i->purchase_price) }}
				</td>
				<td>
					Rp. {{ number_format($i->selling_price) }}
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