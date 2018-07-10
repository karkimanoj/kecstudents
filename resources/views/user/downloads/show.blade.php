
@extends('layouts.app')

@section('content')
	<div class="main-container bg_grey">
	    <div class="container-fluid" id="top_header" >
          	<h2 class="text-center">View Download</h2>
        </div>

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
			        			<form method="POST" action="{{ route('downloads.destroy', $download->id) }}" >
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

		<div class="container">
			<div class="row mb-4">
				<div class="col-md-9 p-4" style="background-color: white">
					<div class="row mt-4">
						<div class="col">
							<h4 >{{$download->title}}</h4> 
							<div class="row" style="font-size: 0.9rem">
								<div class="col-md-6">
									<i class="fas fa-user" ></i> <span class="text-primary">{{$download->user->name}} <i>[{{$download->user->roll_no}}]</i></span>
								</div>
								<div class="col-md-6">
									<i class="fab fa-cuttlefish" ></i> <span class="text-muted">{{$download->download_category->name}}</span>

								</div>
							</div>
							<div class="row mt-2" style="font-size: 0.9rem">
								<div class="col-md-6">
									<i class="far fa-clock" ></i> <span class="text-muted">{{$download->published_at}}</span>
								</div>
								<div class="col-md-6">
									<i class="far fa-clock" ></i> <span class="text-muted">{{$download->created_at->toFormattedDateString()}}</span>

								</div>
							</div>
							<hr>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">

							<div class="row mt-4" >
								<div class="col">
									<i class="fas fa-comments fa-3x"></i> <span style="font-size: 2rem;"> 3</span>
								</div>
							</div>
							<div class="row mt-4" >
								<div class="col">
									<i class="fas fa-eye fa-2x"></i> <span style="font-size: 2rem;"> 120</span>
								</div>
							</div>			
							
						</div>

						<div class="col-md-8 mt-3">

							<div class="row">
								<div class="col">

									<!--<i class="fab fa-cuttlefish" ></i>-->
									{!! ($download->download_category->category_type == 'subject') ? '<label> Subject : </label> '.$download->subject->name : '<label> Faculty / Semester : </label>'.$download->faculty->name.' - '.$download->semester!!}
									 
								</div>
									
									
							</div>

							<div class="row">
								<div class="col mt-3 " style="color: rgba(0,0,0,.84); ">	
									<label>Description :</label><br>
									<p class="text-center">
										{!!$download->description!!}
									</p>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6 mt-3">
									<label> {{$download->download_files->count()}} file/s <label>
									<table class="table  visible">
									  <thead>
									    <tr>
									      
									      <th scope="col">Files</th>
									      <th scope="col">Download</th>
									   
									    </tr>
									  </thead>
									  <tbody>
									  	@foreach($download->download_files as $file)
									  	<tr>
									  		<th scope="row"><a href="{{asset($file->filepath)}}"> {{$file->display_name}} </a></th>
										     
										     <td><a class="btn btn-info" href="{{asset($file->filepath)}}"> download </a></td>
									  	</tr>
									  	@endforeach
									  </tbody>
									</table>  
										
											
										
										
								</div>
								
							</div>
							
						</div>
					</div>

				</div>
				<div class="col-md-3">
					@if( $download->uploader_id == Auth::user()->id && Auth::user()->hasRole('teacher'))
						<div class="card  card_shadow w-100 borderless mt-4" id="user_widget">
		                    <div class="card-header  " style="background-color: #F39C12">
			                     <div id="card_img">
			                   
			                        <img class="card-img img-circle bg-primary" src="/images/test-image.jpg" alt="Card image cap">

			                    </div>
			                    <div class="card_user_detail">
			                        <span style="font-size: 1.2em">{{Auth::user()->name}}</span><br>
		                            <span >{{Auth::user()->roles->first()->name}}</span><br>
		                            <span >{{Auth::user()->roll_no}}</span><br>
			                    </div>
		                   
		               		</div>             
			                <div class="card-body ">
			                 
			                    <ul class="nav flex-column text-center text-muted">
			                    <li class="nav-item">
			                      <span class="badge ">{{Auth::user()->downloads->count()}}</span><br>
			                      <a class="nav-link active" href="{{route('user.downloads.index')}}"><h7>downloads<h7> </a>
			                    </li>
			                    <li class="nav-item">
			                       <span class=" badge badge-light">31</span><br>
			                      <a class="nav-link" href="#">Events</a>
			                    </li>
			                    <li class="nav-item">
			                      <span class=" badge badge-light">{{Auth::user()->downloads->count()}}</span><br>
			                      <a class="nav-link" href="#">Downloads </a>
			                    </li>
			                    <li class="nav-item">
			                      <span class="badge badge-light">31</span><br>
			                      <a class="nav-link" href="#">posts </a>
			                    </li>
			                  </ul>		                    
			                      
			                </div>
		                
			                <div class="card-footer bg-white borderless">
			                  <div class="row">
			                    <div class="col-md-6">
			                      <a href="{{route('user.downloads.edit', $download->id)}}" class="btn btn-primary btn-sm btn-block">edit </a>
			                    </div>
			                    <div class="col-md-6">
			                    	<a class="btn btn-outline-danger btn-sm btn-block" data-toggle="modal" data-target="#myModal" href="#">delete </a>
			                      
			                    </div>

			                  </div>
			                </div>

		              	</div>
	              	@endif

	              	<div class="row">
	              		<div class="col-md-11 offset-md-1 mt-4 pl-3 pt-3  bg-white" id="pop_download_div" style="font-size: 0.8rem">
	              			<h5>popular downloads:</h5>
	              			<ul  class="nav nav-tabs list-group mt-3">
							  <li class="nav-item list-group-item">
							    <a class="nav-link " href="#">
							    kecstudents portal<br>
							    <i class="fab fa-cuttlefish" ></i>c programming
								</a>
							  </li>
							  <li class="nav-item list-group-item">
							    <a class="nav-link" href="#">hamroshoe store
							    <br>
							    <i class="fab fa-cuttlefish" ></i>c programming</a>
							  </li>
							  <li class="nav-item list-group-item">
							    <a class="nav-link" href="#">virtual kec
							    <br>
							    <i class="fab fa-cuttlefish" ></i>minor download(bct)</a>
							  </li>
							  <li class="nav-item list-group-item">
							    <a class="nav-link" href="#">kathmandu valley soil analysis
							    <br>
							    <i class="fab fa-cuttlefish" ></i>c programming</a>
							  </li>
							   <li class="nav-item list-group-item">
							    <a class="nav-link" href="#">kecstudents portal
							    <br>
							    <i class="fab fa-cuttlefish" ></i>minor download(bct)</a>
							  </li>
							   <li class="nav-item list-group-item">
							    <a class="nav-link " href="#">kathmandu valley soil analysisl
							    <br>
							    <i class="fab fa-cuttlefish" ></i>soil mechanics</a>
							  </li>

							</ul>
	              		</div>
	              	</div>

				</div>
			</div>
		</div>  


			
	</div>
@endsection


