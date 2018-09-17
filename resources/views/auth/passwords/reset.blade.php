

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Devmarketer</title>
     
      <link href="{{ asset('css/app.css') }}" rel="stylesheet">
      @yield('styles')
  

</head>
<body>
    <div id="app">

        <nav class="navbar navbar-expand-lg navbar-light ">
          <a class="navbar-brand "  href="{{ route('home') }}">
            {{--<i class="fas fa-graduation-cap fa-lg"  style="color:#228AE6"></i> --}}
            <img src="{{asset('images/Kecstudentslogo2.jpg')}}" height="50" width="140">
            {{--<span style="font-size: 1.5rem; margin-left: 4px; font-weight:100;" id="brand_name"> Kecstudents</span>--}}
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarNavDropdown">
            

            <ul class="navbar-nav ml-auto">
                @if(Auth::guest())
                    <li class="nav-item"><a  class="nav-link " href="{{ route('login') }}">Login as User</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register as User</a></li>
                    
                @else

                  <li class="nav-item dropdown pull-right">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"  >
                      <span>hy {{Auth::user()->name}} <span> 
                    </a>

                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                      <a class="dropdown-item" href="#">profile</a>
                      <a class="dropdown-item" href="#">Notification </a>
                      <a class="dropdown-item" href="{{ route('manage.dashboard') }}">Manage</a>

                      <form method="POST" action="{{ route('logout') }}" id="logoutForm" style="display: none">
                        {{csrf_field()}} </form>
                        <a class="dropdown-item" href='#' onclick="document.getElementById('logoutForm').submit();" name="logout" >logout</a>               
                    </div>

                  </li>
                @endif
            </ul> 
            
          </div>
        </nav>
            <div class="container">
                <div class="row">
                    <div class="col-md-5 offset-md-3 mtop-5 ">

                      <div class="panel panel-default">
                        <div class="panel-body">
                          
                        <!--
                            {{--@if(session status)--}}.....
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
           

            {{--
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
            --}}
<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
</body>            