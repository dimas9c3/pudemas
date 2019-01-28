@extends('backend.partial.app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12 margin-tb">
			<div class="pull-left">
				<h2>Data Kurir</h2>
			</div>
			<div class="pull-right">
				
			</div>
		</div>
	</div>

	@if ($message = Session::get('success'))
	<div class="alert alert-success">
		<p>{{ $message }}</p>
	</div>
	@endif
	<div class="table-responsive">
		<table class="table table-bordered mt-2">
			<tr>
				<th>No</th>
				<th>Nama</th>
				<th>Email</th>
				<th>Roles</th>
				<th>Status</th>
			</tr>
			@foreach ($data as $key => $user)
			<tr>
				<td>{{ ++$i }}</td>
				<td>{{ $user->name }}</td>
				<td>{{ $user->email }}</td>
				<td>
					@if(!empty($user->getRoleNames()))
					@foreach($user->getRoleNames() as $v)
					<label class="badge badge-success">{{ $v }}</label>
					@endforeach
					@endif
				</td>
				<td>
					@if($user->is_free == 1)
					<button type="button" class="btn btn-success btn-sm mr-2 mb-3" data-toggle="tooltip" data-placement="top" title="Kurir Bebas Tidak Sedang Mengerjakan Job">
						Bebas dari Job
					</button>
					@elseif($user->is_free == 0)
					<button type="button" class="btn btn-danger btn-sm mr-2 mb-3" data-toggle="tooltip" data-placement="top" title="Kurir sedang Mengerjakan Job">
						Sedang mengerjakan Job
					</button>
					@endif
				</td>
			</tr>
			@endforeach
		</table>
	</div>
	
	{!! $data->render() !!}
</div>
@endsection

@section('js')
<script>
	document.getElementById("courier-link").classList.add('active');
	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	})
</script>
@endsection