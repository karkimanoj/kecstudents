



@extends('layouts.manage')

@section('content')

	<div class="main-container">

		<div class="row">
			<div class="col-md-6">
				<h1>All Tenants</h1>
	
			</div>
			<div class="col-md-4 offset-md-2 ">
				<a href="{{ route('tenants.create') }}" class="btn  btn-primary float-right"> Create New Tenants</a>
			</div>

		</div>
		<div class="row">
			<div class="col-md-12">
			
				
				{{--{{ substr(strip_tags($tenant->filepath),0,38) }} <span style="color: blue"> {{ strlen(strip_tags($tenant->filepath))>38?'....':'' }} </span>--}}
				<table class="table mt-2">
					<thead>
						<th>id</th>
						<th>identifier</th>
						<th>subdomain</th>
						<th>Name</th>
						
						
						
						<th>Deleted At</th>
						<th>Created At</th>
						<th>Actions</th>
					</thead>
					<tbody>
						@foreach($tenants as $tenant)
						<tr>
							<td>{{ $tenant->id }}</td>
							<td>{{$tenant->identifier}}</td>
							<td>{{ $tenant->subdomain }}</td>
							<td>
							{{ substr(strip_tags($tenant->name ),0,60) }} <span style="color: blue"> {{ strlen(strip_tags($tenant->name ))>60?'....':'' }}
							</td>
							
							<td>{{$tenant->deleted_at}}</td>
							<td>{{ $tenant->created_at }}</td>
							<td >
								<div class="input-group-btn">
							        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></button>
							        <ul class="dropdown-menu dropdown-menu-right">
							          <li><a href="{{ route('tenants.show', [$tenant->id]) }}" > view </a>
							          </li>
							          <li><a href="{{ route('tenants.edit', [$tenant->id]) }}"> edit </a>
							          </li>
							         
							          <li role="separator" class="divider"></li>
							          
							        </ul>
							    </div><!-- /btn-group -->

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
				{{ $tenants->links("pagination::bootstrap-4")}}
				</center>
				</div>
			</div>
		</div>

	</div>
@endsection


