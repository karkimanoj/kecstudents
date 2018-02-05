



@extends('layouts.manage')

@section('content')
	<div class="main-container">
		<div class="row">
			<div class="col-md-4">
				<h1>Users</h1>
			</div>
			

		</div>
		<div class="row">
			<div class="col-md-8">
				<table class="table">
					<thead>
						<th>id</th>
						<th>Name</th>
						<th>category type</th>
						<th>Actions</th>
					</thead>
					<tbody>
						@foreach($categories as $category)
						<tr>
							<td>{{ $category->id }}</td>
							<td>{{ $category->name }}</td>
							<td>{{ $category->category_type }}</td>
							
							{{--<td>{{ $user->created_at->toFormattedDateString() }}</td>
							<td class="text-center">
								<a href="{{ route('users.show', [$user->id]) }}" class="btn btn-default"> view </a>
								<a href="{{ route('users.edit', [$user->id]) }}" class="btn btn-default "> edit </a>
							</td>
							--}}
							<td></td>
						</tr>
						@endforeach
					</tbody>
				</table>
				
				
			</div>
			<div class="col-md-3 col-md-offset-1">
				<h4> Create new category</h4>
				<form method="POST" action="{{ route('download_categories.store') }}">

					 {{ csrf_field() }}
					 <div class="form-group">
						<label>Category type:</label>
						<select name="type" class="form-control" required>
							<option value="subject">subject based</option>
							<option value="facsem">faculty/semester based</option>
						 </select> 
					</div>
					<div class="form-group">
						<label>Name:</label>
						<input type="text" name="name" class="form-control" required maxlength="200">
					</div>
					
					<input type="submit" name="submit" value="create new category" class="btn btn-primary btn-block ">

				</form>
			</div>
		</div>
	</div>
@endsection


