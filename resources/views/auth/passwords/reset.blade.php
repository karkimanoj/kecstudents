@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-5 offset-md-3 mtop-5 ">

          <div class="panel panel-default">
            <div class="panel-body">
              
            <!--
                @if(session status).....
             -->

              <h2><center>Reset Password</center></h2>
              <form method="POST" action="{{ route('password.request') }}">

                    {{csrf_field()}}
                    <input type="hidden" name="token" value="{{ $token }}">


                    <div class="form-group {{ $errors->has('email')?'has-error':'' }} mtop-5">
                        <label >Email address</label>
                        <input type="email" name="email" value="{{$email or old('email') }}" class="form-control" required maxlength="100">
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
                        <button  class="btn btn-primary btn-block"> Reset password </button>
                    </div>

                    
              </form>    
           </div>
           
        </div>   
        
        </div>
    </div>
</div>
@endsection

<!--
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('password.request') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Reset Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
-->