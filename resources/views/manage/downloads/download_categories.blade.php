



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
						<th>Id</th>
						<th>Name</th>
						<th>Category Type</th>
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
			<div class="col-md-3 offset-md-1">
				<h4> Create New Category</h4>
				<form method="POST" action="{{ route('download_categories.store') }}">

					 {{ csrf_field() }}
					 <div class="form-group">
						<label>Name:</label>
						<input type="text" name="name" class="form-control" required maxlength="200">
					</div>
					 <div class="form-group">
						<label>Category Type:</label>
						<select name="type" class="form-control" required>
							<option value="subject">Subject Based</option>
							<option value="facsem">Faculty/Semester Based</option>
						 </select> 
					</div>
					<div class="form-group">
						<label> Max file uploads (between 1 - 12)</label>
						<select name="max_files" class="form-control" required>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
							<option value="9">9</option>
							<option value="10">10</option>
							<option value="11">11</option>
							<option value="12">12</option>
							
						 </select> 

					</div>

					
					
					<input type="submit" name="submit" value="create new category" class="btn btn-primary btn-block ">

				</form>
			</div>
		</div>
	</div>
@endsection


