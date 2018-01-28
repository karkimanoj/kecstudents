@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-4 col-md-offset-4 mtop-5 ">
              <div class="panel panel-default">
                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                         @endif

                        <form method="POST" action="{{ route('password.email') }}">
                                {{csrf_field()}}
                            <h2><center>Forgot password?</center></h2>

                            <div class="form-group {{ $errors->has('email')?'has-error':'' }} mtop-5">
                                <label >Email address</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control" required maxlength="100">
                                @if($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                           

                            <div class="form-group mtop-5">
                                <button class="btn btn-primary btn-block">get reset link</button>
                        </div>
                           
                    </form>    
                </div>
            </div>
            <center><a class="text-muted" href="{{ route('login') }}">back to login</a></center>
        </div>


        <!--<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Send Password Reset Link
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    -->

    </div>
</div>
@endsection
