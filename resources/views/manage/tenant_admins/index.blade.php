



@extends('layouts.tenantAdmin')

@section('content')
	<div class="main-container">
		<div class="row">
			<div class="col-md-4">
				<h1>Tenant Admins</h1>
			</div>
			<div class="col-md-4 offset-md-4 ">
				<a href="{{ route('tenantAdmin.create') }}" class="btn  btn-primary float-right"> Create New Admin</a>
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
						@foreach($tenant_admins as $tenant_admin)
						<tr>
							<td>{{ $tenant_admin->id }}</td>
							<td>{{ $tenant_admin->name }}</td>
							<td>{{ $tenant_admin->email }}</td>
							<td>{{ $tenant_admin->created_at->toFormattedDateString() }}</td>
							<td class="text-center">
								<a href="{{ route('tenantAdmin.show', [$tenant_admin->id]) }}" class="btn btn-default"> view </a>
								<a href="{{ route('tenantAdmin.edit', [$tenant_admin->id]) }}" class="btn btn-default "> edit </a>
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


