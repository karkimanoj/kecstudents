<nav class="navbar navbar-default mbottom-0 ">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="{{ route('home') }}">Devmarketer</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Learn <span class="sr-only">(current)</span></a></li>
        <li><a href="#">Discuss</a></li>
         <li><a href="#">Share</a></li>
        
      </ul>
      <form class="navbar-form navbar-left">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>

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
              <a href='#' onclick="document.getElementById('logoutForm').submit();" name="logout" >logout</a>
              </form>
            </li>
          </ul>
        </li>
        @endif
      </ul>

    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>