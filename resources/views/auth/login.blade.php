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

    <nav class="navbar navbar-default mbottom-0 ">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#colapsable_navbar" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand " style="display: flex;" href="{{ route('home') }}"><i class="fas fa-graduation-cap fa-5x "  data-fa-transform="shrink-8 up-6" style="color:#228AE6"></i> <span style="font-size: 2.3rem; margin-left: 4px" id="brand_name"> Kecstudents</span></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="colapsable_navbar">
          
          
          <ul class="nav navbar-nav navbar-right">
            @if(Auth::guest())
              <li><a href="{{ route('login') }}">login</a></li>
              <li><a href="{{ route('register') }}">Join the community</a></li>
            @else
            <li class="dropdown ">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <span>hy {{Auth::user()->name}} <span> 
              </a>
              <ul class="dropdown-menu">
                <li><a href="#">profile</a></li>
                <li><a href="#">Notification</a></li>
                <li><a href="{{ route('manage.dashboard') }}">Manage</a></li>
                <li role="separator" class="divider"></li>
                <li><form method="POST" action="{{ route('logout') }}" id="logoutForm">
                    {{csrf_field()}}
                    <a href='#' class="m-l-20" onclick="document.getElementById('logoutForm').submit();" name="logout" >logout</a>
                    </form>
                </li>
              </ul>
            </li>
            @endif
          </ul>

        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>


        <div class="container">
            <div class="row ">
                <div class="col-md-4 offset-md-4 m-t-40 ">
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

    </div>
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
</body>