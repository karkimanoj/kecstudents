



@extends('layouts.manage')

@section('content')
	<div class="main-container">
		<div class="row">
			<div class="col-md-4">
				<h1>{{$role}}</h1>
			</div>
			<div class="col-md-4 offset-md-4 ">
				<a href="{{ route('collegePeoples.create') }}" class="btn btn-primary float-right"> add new student/teacher/staff</a>
			</div>

		</div>
		<div class="row">
			<div class="col-md-12">
				<table class="table">
					<thead>
						<th>id</th>
						<th>Name</th>
						<th>Email</th>
						<th>rollno</th>
						<th>gender</th>
						<th>dob</th>
						<th>Date Created</th>
						<th>Actions</th>
					</thead>
					<tbody>
						@foreach($peoples as $people)
						<tr>
							<td>{{ $people->id }}</td>
							<td>{{ $people->name }}</td>
							<td>{{ $people->email }}</td>
							<td>{{ $people->roll_no }}</td>
							<td>{{ $people->gender }}</td>
							<td>{{ $people->dob }}</td>

							<td>{{ $people->created_at}}</td>
							<td class="text-center">
								<a href="{{ route('collegePeoples.show', [$people->id, $role]) }}" class="btn btn-default"> view </a>
								<a href="{{ route('collegePeoples.edit', [$people->id, $role]) }}" class="btn btn-default "> edit </a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				
				
	                
	                <div class="row">
			          <div class="col-auto offset-md-4">
			            {{$peoples->links( "pagination::bootstrap-4") }}
			          </div>
			        </div>
	            
					
				</div>
			</div>
		</div>
	</div>
@endsection


