@extends('layouts.manage')

@section('content')
<div class="main-container">
    <div class="row ">
        <div class="col-md-8  offset-md-2 ml-3 ">
            <h2><center>Edit student/teacher/staf</center></h2>
              <div class="panel panel-default">
                    <div class="panel-body">
                        <form method="POST" action="{{route('collegePeoples.update', $people->id)}} ">
                                {{csrf_field()}}
                                {{method_field('PUT')}}

                                    <div class="form-group  mt-3">
                                        <label >Role</label>
                                        <select  required class="form-control" disabled>
                                                <option value="{{$role}}">{{$role}}</option>                                          
                                        </select>
                                        <input type="hidden" name="role" value="{{$role}}">
                                    </div>


                                    <div class="form-group {{ $errors->has('name')?'has-error':'' }} mtop-5">
                                        <label >Name</label>
                                        <input type="text" name="name"  class="form-control" required  maxlength="100" value="{{$people->name or old('name')}}">
                                       
                                    </div>
                                     <div class="form-group {{ $errors->has('dob')?'has-error':'' }} mtop-5">
                                        <label >Date Of Birth</label>
                                        <input type="date" name="dob" value="{{$people->dob or old('dob') }}" class="form-control" required  >
                                        @if($errors->has('dob'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('dob') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group {{ $errors->has('roll_no')?'has-error':'' }} mtop-5">
                                        <label >Roll no</label>
                                        <input type="text" name="roll_no" value="{{$people->roll_no or old('roll_no') }}" class="form-control" placeholder="eg: 002/BCT/2071" required maxlength="13" >
                                        @if($errors->has('roll_no'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('roll_no') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group {{ $errors->has('email')?'has-error':'' }} mtop-5">
                                        <label >Email address</label>
                                        <input type="email" name="email"  class="form-control" required maxlength="100" value="{{$people->email or old('email') }}">
                                         @if($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                       
                                    </div>

                                    <div class="form-group {{ $errors->has('gender')?'has-error':'' }} mt-3">
                                        <label >Gender</label>
                                        <select name="gender" required class="form-control">
                                           
                                            <option value="male" {{ ($people->gender == 'male') ? 'selected':'' }}>male</option>
                                            <option value="female" {{ ($people->gender == 'female') ? 'selected':'' }}>female</option>
                                           
                                        </select>
                                        
                                    </div>
                                   

                        
                                <div class="form-group col-auto">
                                        <input type="submit" name="update" class="btn btn-primary btn-block">
                                </div>
                                                    
                        </form>    
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

