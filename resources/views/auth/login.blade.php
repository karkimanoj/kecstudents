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
            <img src="{{count(App\Tenant::where('identifier', session('tenant'))->get() ) ? 
   asset(App\Tenant::where('identifier', session('tenant'))->first()->logo) : 'STUDENT PORTAL'}}" height="70" width="160" class="img-fluid" alt="logo">
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
            <div class="row ">
                <div class="col-md-4 offset-md-4 m-t-40 ">
                      <div class="panel panel-default">
                            <div class="panel-body">
                                <form method="POST" action="{{ route('login') }}">
                                        {{csrf_field()}}
                                    <h2><center>Login</center></h2>

                                    <div class="form-group {{ $errors->has('roll_no')?'has-error':'' }} mtop-5">
                                        <label >Username </label>
                                        <input type="text" name="roll_no" placeholder="Eg: KEC044BCT2071" value="{{ old('roll_no') }}" class="form-control" required maxlength="13">
                                        @if($errors->has('roll_no'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('roll_no') }}</strong>
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

    </div>
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
</body>