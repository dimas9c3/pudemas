@extends('backend.partial.app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12 margin-tb">
			<div class="pull-left">
				<h2>Manajemen User</h2>
			</div>
			<div class="pull-right">
				<a class="btn btn-success" href="{{ route('users.create') }}"> Tambah User Baru</a>
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
				<th width="280px">Aksi</th>
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
					<a class="btn btn-info btn-sm mr-1 mb-2" href="{{ route('users.show',$user->id) }}">Lihat</a>
					<a class="btn btn-primary btn-sm mr-1 mb-2" href="{{ route('users.edit',$user->id) }}">Edit</a>
					{!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
					{!! Form::submit('Hapus', ['class' => 'btn btn-danger btn-sm mr-1 mb-2']) !!}
					{!! Form::close() !!}
				</td>
			</tr>
			@endforeach
		</table>
	</div>
	
	{!! $data->render() !!}
</div>


@endsection