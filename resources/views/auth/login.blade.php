@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row ">
        <div class="col-md-4 col-md-offset-4 mtop-5 ">
              <div class="panel panel-default">
                    <div class="panel-body">
                        <form method="POST" action="{{ route('login') }}">
                                {{csrf_field()}}
                            <h2><center>Login</center></h2>

                            <div class="form-group {{ $errors->has('email')?'has-error':'' }} mtop-5">
                                <label >Email address</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control" required maxlength="100">
                                @if($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group mtop-5{{ $errors->has('password')?'has-error':'' }} ">
                                <label >Password</label>
                                <input type="password" name="password" class="form-control" required minlength="8">
                                @if($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group ">
                                <input type="checkbox" name="remember" {{old('remember')?'checked':''}} > Remember
                            </div>

                            <div class="form-group mtop-5">
                                <input type="submit" name="login" class="btn btn-primary btn-block">
                        </div>
                           
                    </form>    
                </div>
            </div>
            <center><a class="text-muted" href="{{ route('password.request') }}">forgot password</a></center>
        </div>
    </div>
</div>
@endsection
