
@extends('layouts.manage')

@section('content')
	<div class="main-container">
		<div class="row m-b-20">
			<div class="col-md-10">
				<div class="page-header">
				  <h1>{{$faculty->display_name}} <small > <i>({{$faculty->name}})</i></small></h1>
				</div>
			</div>			
			<div class="col-md-2">
				<a href="{{ route('faculties.index') }}" class="btn  btn-primary btn-block pull-right"> view all</a>
			</div>
		</div>

		<div class="row">
			<div class="col-md-10">
				
				<div class="card">
				  <div class="card-block">
				    <h2 class="card-title"> Subjects</h2>
				    <p >
						<ol class="list-group">
							
							  <li class="list-group-item borderless">
							  	<i class="fa fa-circle" aria-hidden="true"></i>
							  	
							  	<i class="text-muted"></i>
							  </li>
							 
						</ol>
				    	
				    </p>
				    
				  </div>
				</div>
				
				</div>
			</div>
		</div>
	</div>
@endsection


