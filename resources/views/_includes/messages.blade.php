
@if(Session::has('success'))
  <div class="alert alert-success" role="alert">
   <strong>Well done!</strong> {{Session::get('success')}}
  </div>
@elseif(Session::has('error'))
  <div class="alert alert-success" role="alert">
   <strong>sorry </strong> {{Session::get('error')}}
  </div>
@endif

@if(count($errors)>0)
	<div class="alert alert-danger" role="alert">
      <strong>Oh snap!</strong> 
      <ul>
      @foreach($errors->all() as $error)
      	
      		<li>{{$error}}</li>
      @endforeach
      </ul>
   </div>
	
@endif