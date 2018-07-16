@extends('layouts.tenantAdmin')

@section('content')
	<div class="main-container">

		<div class="row">
			
			<div class="col-md-4 offset-md-4 ">
					<!-- Modal -->
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
				        			<form method="POST" action="{{ route('tenantAdmin.destroy', $tenant_admin->id) }}" >
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
				  
				<a href="{{ route('tenantAdmin.edit', $tenant_admin->id) }}" class="btn  btn-primary float-right"> Edit Tenant Admin</a>
				<input type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" value="delete">
				
				  
			</div>
		</div> <!--end of role-->

		<div class="row">
			<div class="col-md-8  m-t-20">
				<div class="card panel-default">
					<div class="card-header">
						<h3>Tenant Admin Details</h3>
					</div>
				  <div class="card-body">
						<p>
							<label>Name</label>
							<span>{{$tenant_admin->name}}</span>
						</p>
						
						<p>
							<label>Email</label>
							<span>{{$tenant_admin->email}}</span>
						</p>

						
				  </div>
				</div>
				
			</div>
		</div> <!--end of ro-->

	</div>	
@endsection

