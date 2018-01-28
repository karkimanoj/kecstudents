



@extends('layouts.manage')

@section('content')
	<div class="main-container">
		<div class="row">
			<div class="col-md-4">
				<h1>Users</h1>
			</div>
			<div class="col-md-4 col-md-offset-4 ">
				<a href="{{ route('users.create') }}" class="btn  btn-primary pull-right"> create new user</a>
			</div>

		</div>
		<div class="row">
			<div class="col-md-12">
				<table class="table">
					<thead>
						<th>id</th>
						<th>Name</th>
						<th>Email</th>
						<th>Date Created</th>
						<th>Actions</th>
					</thead>
					<tbody>
						@foreach($users as $user)
						<tr>
							<td>{{ $user->id }}</td>
							<td>{{ $user->name }}</td>
							<td>{{ $user->email }}</td>
							<td>{{ $user->created_at->toFormattedDateString() }}</td>
							<td class="text-center">
								<a href="{{ route('users.show', [$user->id]) }}" class="btn btn-default"> view </a>
								<a href="{{ route('users.edit', [$user->id]) }}" class="btn btn-default "> edit </a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				<center>
				{{ $users->links()}}
				</center>
				</div>
			</div>
		</div>
	</div>
@endsection


