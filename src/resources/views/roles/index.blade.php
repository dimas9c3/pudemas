@extends('backend.partial.app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12 margin-tb">
			<div class="pull-left">
				<h2>Manajemen Roles User</h2>
			</div>
			<div class="pull-right">
				<a class="btn btn-success mb-2 mt-1" href="{{ route('roles.create') }}"> Tambah Role Baru</a>
			</div>
		</div>
	</div>

	@if ($message = Session::get('success'))
	<div class="alert alert-success">
		<p>{{ $message }}</p>
	</div>
	@endif

	<table class="table table-bordered">
		<tr>
			<th>No</th>
			<th>ID Roles</th>
			<th>Nama</th>
			<th width="280px">Aksi</th>
		</tr>
		@foreach ($roles as $key => $role)
		<tr>
			<td>{{ ++$i }}</td>
			<td>{{ $role->id }}</td>
			<td>{{ $role->name }}</td>
			<td>
				<a class="btn btn-info btn-sm mt-1 mb-1" href="{{ route('roles.show',$role->id) }}">Lihat</a>
				<a class="btn btn-primary btn-sm mt-1 mb-1" href="{{ route('roles.edit',$role->id) }}">Edit</a>
				{!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
				{!! Form::submit('Hapus', ['class' => 'btn btn-danger btn-sm mt-1 mb-1']) !!}
				{!! Form::close() !!}
			</td>
		</tr>
		@endforeach
	</table>
</div>

{!! $roles->render() !!}

@endsection