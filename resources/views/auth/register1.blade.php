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


    <div class="container m-b-40">
        <div class="row m-t-40 ">
            <div class="col-md-5 offset-md-3 mtop-5 ">

              <div class="panel panel-default">
                <div class="panel-body">

                <form method="POST" action="{{ route('register') }}">
                    {{csrf_field()}}
                    <h2><center>Register here</center></h2>

                    <div class="form-group {{ $errors->has('email')?'has-error':'' }} mtop-5">
                        <label >You are :</label>
                       <select class="form-control" name="role">
                           <option value="student">student</option>
                           <option value="teacher">teacher</option>
                           <option value="staff">staff</option>
                       </select>
                    </div>

                    <div class="form-group {{ $errors->has('roll_no')?'has-error':'' }} mtop-5">
                        <label >Roll no</label>
                        <input type="text" name="roll_no" value="{{ old('roll_no') }}" class="form-control" placeholder="eg: KEC044BCT2071" required maxlength="13" >
                        @if($errors->has('roll_no'))
                            <span class="help-block">
                                <strong>{{ $errors->first('roll_no') }}</strong>
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
                    
                                                
                     <div class="form-group mtop-5">
                        <input type="submit" name="register" value="submit" class="btn btn-primary btn-block">
                    </div>

                    
                </form> 
                   
               </div>
               
            </div>   
                <center><a class="text-muted" href="{{ route('login') }}">Already have an account?</a></center>
            
            </div>
        </div>
    </div>
</div>
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
</body>

