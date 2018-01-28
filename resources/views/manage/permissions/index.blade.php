



@extends('layouts.manage')

@section('content')
	<div class="main-container">
		<div class="row">
			<div class="col-md-4">
				<h1>Permissions</h1>
			</div>
			<div class="col-md-4 col-md-offset-4 ">
				<a href="{{ route('permissions.create') }}" class="btn  btn-primary pull-right"> create new permissions</a>
			</div>

		</div>
		<div class="row">
			<div class="col-md-12">
				<table class="table">
					<thead>
						<th>id</th>
						<th>Name</th>
						<th>Display name</th>
						<th>Description</th>
						<th> </th>
					</thead>
					<tbody>
						@foreach($permissions as $permission)
						<tr>
							<td>{{ $permission->id }}</td>
							<td>{{ $permission->name }}</td>
							<td>{{ $permission->display_name }}</td>
							<td>{{ $permission->description }}</td>
							<td>
								<a href="{{ route('permissions.show', 
								[$permission->id]) }}" class="btn btn-default"> view </a>
								<a href="{{ route('permissions.edit', [$permission->id]) }}" class="btn btn-default"> edit </a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				
				</div>
			</div>
		</div>
	</div>
@endsection


