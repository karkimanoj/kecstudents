



@extends('layouts.manage')

@section('content')

	<div class="main-container">

		<div class="row">
			<div class="col-md-6">
				<h1>Faculties</h1>
			</div>
			<div class="col-md-4 offset-md-2 ">
				<a href="{{ route('faculties.create') }}" class="btn  btn-primary float-right"> create new Faculty</a>
			</div>

		</div>
		<div class="row">
			<div class="col-md-12">
				<table class="table">
					<thead>
						<th>id</th>
						<th>Name</th>
						<th>Display Name</th>
						<th>Date Created</th>
						<th>Actions</th>
					</thead>
					<tbody>
						@foreach($faculties as $faculty)
						<tr>
							<td>{{ $faculty->id }}</td>
							<td>{{ $faculty->name }}</td>
							<td>{{ $faculty->display_name }}</td>
							<td>{{ $faculty->created_at->toFormattedDateString() }}</td>
							<td class="text-center">
								<a href="{{ route('faculties.show', [$faculty->id]) }}" class="btn btn-default"> view </a>
								<a href="{{ route('faculties.edit', [$faculty->id]) }}" class="btn btn-default"> edit </a>
								<!-- delete with modal-->
								{{--
								<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal">delete</button>
								
									
							  <div class="modal fade " id="myModal" role="dialog">
							    <div class="modal-dialog modal-sm">
							     
							      <div class="modal-content">

							        <div class="modal-header">
							          <button type="button" class="close" data-dismiss="modal">&times;</button>
							          <h4 class="modal-title">Confirm deletion</h4>
							        </div>

							        <div class="modal-body">
							          <p>Are you sure?</p>
							        </div>

							        <div class="modal-footer">
							        	<div class="row">
							        		<div class="col-md-6">
							        			<form method="POST" action="{{ route('faculties.destroy', $faculty->id) }}" >
									        		{{method_field("DELETE")}}
									        		{{csrf_field()}}
									        		<input type="submit" class="btn btn-danger float-right" name="delete" value="yes">
												</form>		
							        		</div>
							        		<div class="col-md-6">
							        			<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
							        		</div>
							        	</div>	
							        </div>
							      </div>
							      
							    </div>
							  </div> 	
--}}
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				<center>
				{{ $faculties->links( "pagination::bootstrap-4")}}
				</center>
				</div>
			</div>
		</div>
	</div>
@endsection


