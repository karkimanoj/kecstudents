<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Devmarketer-Management</title>

    
        <!-- Our Custom CSS -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto+Condensed" rel="stylesheet">
     

</head>
<body>
    <div id="app">
         @include('_includes.nav.main')  
        <div class="wrapper">
                       
              @include('_includes.nav.manageSidebar')

              <div id="content">

                @include('_includes.nav.managenavbar')
                @yield('content')

              </div>
        </div>
    </div>

       <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"
      integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
      crossorigin="anonymous"></script>
        <!-- Bootstrap Js CDN -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    @yield('scripts')

    <script type="text/javascript">
        $(document).ready(function () {

            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });

            $.each($('.col_ul').children('li'), function() {
           // $.each($('#pageSubmenu').next().children('li'), function(){
             if($(this).hasClass('active'))
                //$('.col_ul').removeClass('collapse');
               $('.col_ul').collapse('show');
            });


        });
    </script>
    </body>
</html>
