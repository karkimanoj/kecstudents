<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
  

    <title>Students Portal for Engineering Colleges</title>

    <!-- Styles -->

        <!--      not needed because we installed bootstrap via npm from bash -->
     
      <link href="{{ asset('css/app.css') }}" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto+Condensed" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Cabin" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
        <script src="{{ asset('js/app.js') }}"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
      @yield('styles')
  

</head>
<body>
    <div id="app">

      @include('_includes.nav.main')

      @include('_includes.messages')
      
        @yield('content')

        @include('_includes.footer')
    </div>

  

    
    @yield('scripts')
    <script type="text/javascript">
      $(document).ready(function (){

        var userId = {{Auth::user()->id}};
        //alert(userId);

        Echo.private('App.User.' + userId)
        .notification((notification) => {
        console.log(notification.message); 
    });
      });
    </script>
</body>
</html>
