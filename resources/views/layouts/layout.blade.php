<!DOCTYPE html>
<html lang="en">
  <head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">   
    <meta name="csrf-token" content="{{ csrf_token() }}"> 

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/img/favicon.png')}}">

    <!-- <title>Printerous Indonesia - @yield('title')</title> -->
    <title>Printerous Indonesia - {{variable_get('title')}}</title>
    <!-- vendor css -->
    <link href="{{asset('assets/lib/@fortawesome/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/lib/ionicons/css/ionicons.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/lib/select2/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/lib/timepicker/jquery.timepicker.min.css')}}" rel="stylesheet">
    
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/template.css')}}">
    <!-- Additional CSS -->
    @yield('css_component')

    @yield('css')

  </head>
  <body class="page-profile">

    @include('layouts.header')

    <div class="content content-fixed">
      @yield('content')
    </div><!-- content -->

    <script type="text/javascript"> var baseUrl = "{{config('app.url')}}" </script>
    <script src="{{asset('assets/lib/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('assets/lib/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <script src="{{asset('assets/js/template.js')}}"></script>
    
    <!-- append theme customizer -->
    <script src="{{asset('assets/lib/js-cookie/js.cookie.js')}}"></script>
    <script src="{{asset('assets/lib/select2/js/select2.min.js')}}"></script>
    <script src="{{asset('assets/lib/feather-icons/feather.min.js')}}"></script>
    <script src="{{asset('assets/lib/jqueryui/jquery-ui.min.js')}}"></script>
    <script src="{{asset('assets/lib/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
    <script src="{{asset('assets/lib/timepicker/jquery.timepicker.min.js')}}"></script>
    @yield('js_component')
    @yield('js')
    <script src="{{asset('assets/js/main.js')}}"></script>    
  </body>
</html>
