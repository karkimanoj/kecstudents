@extends('layouts.manage')

@section('content')
<div class="main-container">
    <div class="row ">
        <div class="col-md-10  ">
            <h2><center>Edit permission</center></h2>
            <hr>
             <form method="POST"  action="{{route('permissions.update', $permission->id)}} ">
                        {{csrf_field()}}
                        {{method_field('PUT')}};
                   
                <div class="panel panel-default  m-t-30" id="basic_panel">
                    <div class="panel-body">
                        <div class="form-group {{ $errors->has('display_name')?'has-error':'' }}">
                            <label> Name (Display name) </label>
                            <input type="text" name="display_name" class="form-control" value="{{$permission->display_name}}" required minlength="5" maxlength="100">
                        </div>
                        <div class="form-group {{ $errors->has('description')?'has-error':'' }}">
                            <label> Description </label>
                            <input type="text" name="description" class="form-control" value="{{$permission->description}}" required minlength="8" maxlength="150">
                        </div>
                        
                    </div>
                </div>  
 
                <center>
                          <input type="submit" class="btn btn-primary btn-lg" name="update permission" > 
                       </center>
             </form>    
                
        </div>
    </div>
</div>

@endsection

@section('scripts')
    
@endsection