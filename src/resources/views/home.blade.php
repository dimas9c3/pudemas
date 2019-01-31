@extends('backend.partial.app')
@section('content')

<div class="container-fluid">
	<!-- Begin Page Header-->
	<div class="row">
		<div class="page-header">
			@role('Kurir')
			@if (!empty($job_pickup))
			@foreach ($job_pickup as $i)
			<div class="alert alert-success alert-dismissible fade show">
				<span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
				<span class="alert-inner--text"><strong>Anda Mendapatkan Job Pengambilan Barang ID :  {{ $i->id_pickup }} <hr> <a href="{{ url('/pickup/getPickupActiveById/'.$i->id_pickup) }}" class="btn btn-primary">Detail Job</a></strong></span>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
			</div>
			@endforeach
			@endif
			@endrole
			<div class="d-flex align-items-center">
				<h2 class="page-header-title">{{ $page }}</h2>
			</div>
		</div>
	</div>
	<!-- End Page Header -->
	<!-- Begin Row -->
	<div class="row flex-row">
		<!-- Begin Card 1 -->
		<div class="col-xl-4 col-md-6 col-sm-6">
			<div class="widget widget-12 has-shadow">
				<div class="widget-body">
					<div class="media">
						<div class="align-self-center ml-5 mr-5">
							<i class="ion-person-stalker text-facebook"></i>
						</div>
						<div class="media-body align-self-center">
							<div class="title text-facebook">Aktivitas Kurir</div>
							<div class="number"><strong>{{ $free_courier }}</strong> Dari <strong>{{ $all_courier }}</strong> Kurir Sedang Tidak Bertugas</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End Card 1 -->
		<!-- Begin Card 2 -->
		<div class="col-xl-4 col-md-6 col-sm-6">
			<div class="widget widget-12 has-shadow">
				<div class="widget-body">
					<div class="media">
						<div class="align-self-center ml-5 mr-5">
							<i class="ion-arrow-down-a text-facebook"></i>
						</div>
						<div class="media-body align-self-center">
							<div class="title text-facebook">Aktivitas Pengambilan</div>
							<div class="number">
								@if($active_pickup)
								<strong>{{ $active_pickup }}</strong> Job Masih Dalam Proses
								@else
								<strong>Tidak Ada Aktivitas Pengambilan</strong>
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End Card 2 -->
		<!-- Begin Card 3 -->
		<div class="col-xl-4 col-md-6 col-sm-6">
			<div class="widget widget-12 has-shadow">
				<div class="widget-body">
					<div class="media">
						<div class="align-self-center ml-5 mr-5">
							<i class="ion-paper-airplane text-facebook"></i>
						</div>
						<div class="media-body align-self-center">
							<div class="title text-facebook">Aktivitas Pengiriman</div>
							<div class="number">
								@if($active_delivery)
								<strong>{{ $active_delivery }}</strong> Job Masih Dalam Proses
								@else
								<strong>Tidak Ada Aktivitas Pengiriman</strong>
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End Card 3 -->
	</div>
	<!-- End Row -->
	<div class="row">
		<div class="col-xl-6">
			<!-- Delivery Total -->
			<div class="widget has-shadow">
				<div class="widget-header bordered no-actions d-flex align-items-center">
					<h4>Total Pengambilan</h4>
				</div>
				<div class="widget-body">
					<div class="chart">
						<canvas id="pickup-pie-chart"></canvas>
					</div>
				</div>
			</div>
			<!-- End Pie Chart -->
		</div>
		<div class="col-xl-6">
			<!-- Delivery Total -->
			<div class="widget has-shadow">
				<div class="widget-header bordered no-actions d-flex align-items-center">
					<h4>Total Pengiriman</h4>
				</div>
				<div class="widget-body">
					<div class="chart">
						<canvas id="delivery-pie-chart"></canvas>
					</div>
				</div>
			</div>
			<!-- End Pie Chart -->
		</div>
	</div>
	<!-- End Row -->
</div>
<!-- End Container -->
@endsection
@section('js-route')
<script>
	console.log('Pudemas Route');
</script>
@endsection
@section('js')
<script>
	document.getElementById("dashboard-link").classList.add('active');
	console.log('Pudemas JS');

	// ------------------------------------------------------- //
    // Pickup Pie Chart
    // ------------------------------------------------------ //	
    var ctx = document.getElementById("pickup-pie-chart").getContext('2d');
    var ctx2 = document.getElementById("delivery-pie-chart").getContext('2d');

    var myChart = new Chart(ctx, {
    	type: 'pie',
    	data: {
    		labels: [
    		@foreach($pickup_count as $i)
    		"{{ $i->courier_name }}",
    		@endforeach
    		],
    		datasets: [{
    			label: "Label",
    			backgroundColor: ["#08a6c3", "#5cb85c", "#d9534f"],
    			borderColor: ["#fff", "#fff", "#fff"],
    			hoverBorderColor: ["#fff", "#fff", "#fff"],
    			borderWidth: 10,
    			data: [
    			@foreach($pickup_count as $i)
    				@php echo $i->total @endphp,
    			@endforeach
    			]
    		}]
    	},
    	options: {
    		legend: {
    			display: true,
    			position: 'top',
    			labels: {
    				fontColor: "#2e3451",
    				usePointStyle: true,
    				fontSize: 13
    			}
    		},
    		tooltips: {
    			backgroundColor: 'rgba(47, 49, 66, 0.8)',
    			titleFontSize: 13,
    			titleFontColor: '#fff',
    			caretSize: 0,
    			cornerRadius: 4,
    			xPadding: 10,
    			displayColors: true,
    			yPadding: 10
    		}
    	}
    });

    var myChart2 = new Chart(ctx2, {
    	type: 'pie',
    	data: {
    		labels: [
    		@foreach($delivery_count as $i)
    		"{{ $i->courier_name }}",
    		@endforeach
    		],
    		datasets: [{
    			label: "Label",
    			backgroundColor: ["#08a6c3", "#5cb85c", "#d9534f"],
    			borderColor: ["#fff", "#fff", "#fff"],
    			hoverBorderColor: ["#fff", "#fff", "#fff"],
    			borderWidth: 10,
    			data: [
    			@foreach($delivery_count as $i)
    				@php echo $i->total @endphp,
    			@endforeach
    			]
    		}]
    	},
    	options: {
    		legend: {
    			display: true,
    			position: 'top',
    			labels: {
    				fontColor: "#2e3451",
    				usePointStyle: true,
    				fontSize: 13
    			}
    		},
    		tooltips: {
    			backgroundColor: 'rgba(47, 49, 66, 0.8)',
    			titleFontSize: 13,
    			titleFontColor: '#fff',
    			caretSize: 0,
    			cornerRadius: 4,
    			xPadding: 10,
    			displayColors: true,
    			yPadding: 10
    		}
    	}
    });

</script>
@endsection
