



@extends('layouts.manage')

@section('content')
	<div class="main-container">
		<div class="row">
			<div class="col-md-4">
				<h1>Subjects</h1>
			</div>
			<div class="col-md-4 offset-md-4 ">
				<a href="{{ route('subjects.create') }}" class="btn  btn-primary float-right"> Add new subject</a>
			</div>

		</div>
		<div class="row">
			<div class="col-md-12">
				<table class="table">
					<thead>
						<th>id</th>
						<th>Name</th>
						<th>project?</th>
						<th>created_at</th>
						<th>actions</th>
					</thead>
					<tbody>
						@foreach($subjects as $subject)
						<tr>
							<td>{{ $subject->id }}</td>
							<td>{{ $subject->name }}</td>
							<td>@if($subject->project==1)
								yes
								@else
								no
							@endif</td>
							<td>{{$subject->created_at}}</td>
							<td>
								<a href="{{ route('subjects.show', 
								[$subject->id]) }}" class="btn btn-default"> view </a>
								<!-- delete with modal-->
								<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal">delete</button>
								
									<!-- Modal -->
							  <div class="modal fade " id="myModal" role="dialog">
							    <div class="modal-dialog modal-sm">
							      <!-- Modal content-->
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
							        			<form method="POST" action="{{ route('subjects.destroy', $subject->id) }}" >
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
							  </div> <!-- end of modal -->	
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


