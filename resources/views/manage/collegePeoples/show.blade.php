'@extends('layouts.manage')

@section('content')
	<div class="main-container">

		<div class="row">
			<div class="col-md-4">
				<h1>view {{$role}}</h1>
			</div>
			<div class="col-md-4 offset-md-4 ">
				<!--modal-->
				 <div class="modal fade " id="deleteModal" role="dialog">
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
				        			<form method="POST" action="{{ route('collegePeoples.destroy', [$people->id, $role]) }}" >
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

				<input type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" value="delete">
				<a href="{{ route('collegePeoples.edit', [$people->id, $role]) }}" class="btn  btn-primary float-right"> Edit people</a>
			</div>
		</div> <!--end of role-->

		<div class="row">
			<div class="col-md-8  m-t-20">
				<div class="panel panel-default">
				  <div class="panel-body">
						<p>
							<label>Name</label>
							<span>{{$people->name}}</span>
						</p>
						<p>
							<label>Roll no</label>
							<span>{{$people->roll_no}}</span>
						</p>
						<p>
							<label>Email</label>
							<span>{{$people->email}}</span>
						</p>
						<p>
							<label>dob</label>
							<span>{{$people->dob}}</span>
						</p>
						<p>
							<label>Gender</label>
							<span>{{$people->gender}}</span>
						</p>
						
				  </div>
				</div>
				
			</div>
		</div> <!--end of ro-->

	</div>	
@endsection

