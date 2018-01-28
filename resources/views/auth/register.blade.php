@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-5 col-md-offset-3 mtop-5 ">

          <div class="panel panel-default">
            <div class="panel-body">
            <form method="POST" action="{{ route('login') }}">
                {{csrf_field()}}
                <h2><center>Register here</center></h2>

                <div class="form-group {{ $errors->has('username')?'has-error':'' }} mtop-5">
                    <label >Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control" required maxlength="100">
                    @if($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('email')?'has-error':'' }} mtop-5">
                    <label >Email address</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" required maxlength="100">
                    @if($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="row mtop-5">
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('password')?'has-error':'' }} ">
                            <label >Password</label>
                            <input type="password" name="password" class="form-control" required minlength="8">
                            @if($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6 ">
                        <div class="form-group {{ $errors->has('password_confirmation')?'has-error':'' }} ">
                            <label >Confirm password</label>
                            <input type="password" name="password_confirmation" class="form-control" required minlength="8">
                            @if($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                        
                 <div class="form-group mtop-5">
                    <input type="submit" name="register" class="btn btn-primary btn-block">
                </div>

                
            </form>    
           </div>
           
        </div>   
            <center><a class="text-muted" href="{{ route('login') }}">Already have an account?</a></center>
        
        </div>
    </div>
</div>
@endsection
