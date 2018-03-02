@extends('layouts.manage')

@section('content')
<div class="main-container">
    <div class="row ">
        <div class="col-md-8 offset-md-2 ">
        	<h2><center>Edit Faculty</center></h2>
              <div class="panel panel-default m-t-25">
                    <div class="panel-body">
                        <form method="POST" action="{{route('faculties.update', $faculty->id)}} ">

                                {{csrf_field()}}   
                                {{method_field('PUT')}} 
                                        
                                <div class="form-group {{ $errors->has('name')?'has-error':'' }} mtop-5">
                                    <label >Name</label>
                                    <input type="text" name="name" value="{{ $faculty->name }}" class="form-control" required maxlength="100">
                                    @if($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group mtop-5{{ $errors->has('display_name')?'has-error':'' }} ">
                                    <label >Display Name</label>
                                    <input type="text" name="display_name" class="form-control" required maxlength="255" value="{{$faculty->display_name}}">
                                    @if($errors->has('display_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('display_name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group ">
                                        <input type="submit" name="update" class="btn btn-primary btn-block">
                                </div>
                        </form>    
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
	
@endsection