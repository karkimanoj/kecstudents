
@extends('layouts.tenantAdmin')

@section('content')
	<div class="main-container">
		<div class="row m-b-20">
			 
			<!-- Modal -->
			<div class="modal fade" id="add-user-modal" tabindex="-1" role="dialog" aria-labelledby="add-user-modal-label" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="add-user-modal-label">Add superadmin to {{$tenant->name}}</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">

			      	<form method="POST" action="{{route('tenants.addSuperAdmin')}} " id="add_superadmin_form">
                                {{csrf_field()}}

                                  
                                    <div class="form-group {{ $errors->has('email')?'has-error':'' }} mtop-5">
                                        <label >Name</label>
                                        <input type="text" name="name"  class="form-control" required  maxlength="100">
                                       
                                    </div>
                                    <div class="form-group {{ $errors->has('roll_no')?'has-error':'' }} mtop-5">
                                        <label >Roll no</label>
                                        <input type="text" name="roll_no" value="{{ old('roll_no') }}" class="form-control" placeholder="eg: 002/BCT/2071" required maxlength="13" >
                                        @if($errors->has('roll_no'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('roll_no') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group {{ $errors->has('email')?'has-error':'' }} mtop-5">
                                        <label >Email address</label>
                                        <input type="email" name="email"  class="form-control" required maxlength="100">
                                         @if($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                       
                                    </div>

                                    <div class="form-group mtop-5{{ $errors->has('password')?'has-error':'' }} ">
                                        <label >Password</label>
                                        <input type="password" name="password" id="manage_password"  class="form-control" required minlength="8" >
                                       
                                    </div>
                                     <div class="form-group mt-2{{ $errors->has('password_confirmation')?'has-error':'' }} ">
                                        <label >password_confirmation</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation"  class="form-control" required minlength="8" >
                                       
									</div>	
									<input type="hidden" name="tenant_identifier" value="{{$tenant->identifier}}">
			        	</form>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			      
			        <a href="#" role="button" class="btn btn-primary" onclick="document.getElementById('add_superadmin_form').submit();"> submit </a>
			        
			      </div>
			  
			    </div>
			  </div>
			</div>
			<!-- Modal end-->
			{{--<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal">delete</button>
			--}}
					<!-- Modal 1 -->
			  <div class="modal fade " id="soft_delete_Modal" role="dialog">
			    <div class="modal-dialog">
			      <!-- Modal content-->
			      <div class="modal-content">

			        <div class="modal-header">
			          <button type="button" class="close" data-dismiss="modal">&times;</button>
			          <h5 class="modal-title">Confirm Activate/Deactivate</h5>
			        </div>

			        <div class="modal-body">
			          <p>Are you sure? This action will Activate/Deactivate the tenant temporarily? </p>
			        </div>

			        <div class="modal-footer">
			        	<div class="row">
			        		<div class="col-md-6">
									<a href="{{route('tenants.softDelete', $tenant->id)}}" class="btn btn-danger">YES</a>
			        		</div>
			        		<div class="col-md-6">
			        			<button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
			        		</div>
			        	</div>	
			        </div>
			      </div>
			      
			    </div>
			  </div> <!-- end of modal -->	
			  <!-- Modal2 -->
				<div class="modal fade" id="migration_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				  <div class="modal-dialog modal-dialog-centered" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				      </div>
				      <div class="modal-body">
				       
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				        <button type="button" class="btn btn-primary" id="tables_action">Yes</button>
				        <input type="hidden" value="">
				      </div>
				    </div>
				  </div>
				</div>	
			<div class="col-md-10">
				<div class="page-header">
				  <center><h1>VIEW TENANT</h1><center>
				</div>
			</div>			
			<div class="col-md-2">
				

				<div class="btn-group">
				  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    Actions 
				  </button>
				  <div class="dropdown-menu">
				    <a class="dropdown-item" href="{{ route('tenants.edit', [$tenant->id]) }}"> edit </a>
				    <a class="dropdown-item" id="activate_btn" data-toggle="modal" data-target="#soft_delete_Modal" href="#">
			         	@if($tenant->deleted_at)
			                  Activate 
			               @else
			              	  Deactivate
			               @endif
			           </a>
				    <!--<a class="dropdown-item" style="color: red;" data-toggle="modal" data-target="#myModal" href="#">delete </a>-->
				    
				  </div>
				</div>
				
			</div>
		</div>

		<div class="row">
			<div class="col-md-10">
				
				<div class="Card ">
					<div class="card-header">
						<h3>{{$tenant->id}}. {{$tenant->name}} ({{$tenant->identifier}})</h3>
					</div>	
				  	<div class="card-body bg-white">
				  		<div class="card-text">
					  		<p>
							<label> Created At: </label> {{$tenant->created_at}}<br>		 
						    </p>
						    <p>
						    	<label> Updated At: </label> {{$tenant->updated_at}}
						    </p>
						    <p>
							<label>Deleted At: &ensp;</label>		 
						    <span id="publised_at">
						    	{{$tenant->deleted_at}}
						    </span>	
						    </p>
						   
						    <p>
							<label>Sub-domain: </label>	 
						    	{{$tenant->subdomain}} 
						    </p>
							
						    <p>
							<label>Logo: </label>	 
						    	  <img src="{{asset($tenant->logo)}}" width="150" height="90" alt="{{$tenant->logo}}"> 
						    </p>
							
						    <p>
							<label> Description: </label>		 
						    	{!!$tenant->description!!}
						    </p>
						    
						    <p>
						    @if($tenant->trashed() == false)
							   <label> Superadministrators: </label>
								<input type="button" name="add-user" class="btn btn-info" value="add new superadmin" data-toggle="modal" data-target="#add-user-modal">
							@endif
							@if($superadmins)		 
						    	<table class="table table-bordered">
								  <thead class="thead-dark">
								    <tr>
								      <th scope="col">#</th>
								      <th scope="col">Name</th>
								      <th scope="col">Email</th>
								      <th scope="col">Roll no</th>
								      <th scope="col">Role</th>
								      <th scope="col">created_at</th>
								    </tr>
								  </thead>
								  <tbody>
								  	@foreach($superadmins as $superadmin)
								    <tr>
								      <th scope="row">{{$superadmin->id}}</th>
								      <td> {{ $superadmin->name}}</td>
								      <td>{{$superadmin->email}}</td>
								      <td>{{ $superadmin->roll_no }}</td>
								      <td>{{ $superadmin->role_name }}</td>
								      <td>{{ $superadmin->created_at}}</td>
								    </tr>
								   @endforeach
								  </tbody>
								</table>
								@endif
						    </p>
						    
				  		</div>
				  		<!--
				  		<div class="row mb-2">
				  			<div class="col-md-6">
				  				<a href="#"  class="btn btn-primary" data-toggle="modal" data-target="#migration_model">Migrate Tables</a>
				  				<input type="hidden" value="migrate">
				  			</div>
				  			<div class="col-md-6">
				  				<a href="#"  class="btn btn-danger" data-toggle="modal" data-target="#migration_model">Drop Tables</a>
				  				<input type="hidden" value="drop">
				  			</div>
				  		</div>
				  		
				  		<a href="#" id="migrate_tables" class="btn btn-primary">Migrate Tables</a>-->
				  		<div class="card-footer">
				  			<h5>Tables <h5>
				  			<ul class="list-group">
				  				
							  @foreach($table_array as $table_name)
							  	 <li class="list-group-item">{{$loop->index+1}}.&ensp; {{$table_name}}</li>
							  @endforeach
							 
							</ul>
				  		</div>
				  			
				  		</div>
				  						        
					</div>
				
				
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
<script type="text/javascript">
	$(document).ready(function ()
	{
		$('#migration_model').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget) 
		  var action = button.next().val()
		 			
		  var modal = $(this)
		  modal.find('.modal-title').text('Confirm '+action+' tables')
		  modal.find('.modal-body ').text('Are you sure to '+action+' tables? This will permanantly change the database')
		  $('#tables_action').next().val(action);
		})

		$('#tables_action').click(function()
		{
			$('#migration_model').modal('hide')
			action=$(this).next().val();
			host='{{url('/')}}';
			id={{$tenant->id}};
			
			$.ajax({
				type:'GET',
				dataType:'JSON',
				url:host+'/migrateTables1' ,
				data:{ 'token' : '{{csrf_token()}}',
						'id': id,
						'action':action
					 },
				success: function(data1){
					console.log(data1);
					$('.list-group').empty();
					for (i = 0; i < data1.length; i++) {
						$('.list-group').append('<li class="list-group-item">'+(i+1)+'. '+data1[i]+'</li>');
					}
					
				},
				error: function(e){
					alert('error migrating tables');
					console.log(e);
				}	
			});
		});
	});
</script>
@endsection
