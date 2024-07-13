<!DOCTYPE html>
<html lang="en-us"><head>
  <base href="{{'http://xuong-laravel.test/'}}">
  <meta charset="utf-8">
  <title>@yield('title')</title>

  <!-- mobile responsive meta -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="description" content="This is meta description">
  <meta name="author" content="Themefisher">
  <meta name="generator" content="Hugo 0.74.3" />

  <!-- plugins -->
  
  <link rel="stylesheet" href="{{ asset('theme/client/plugins/bootstrap/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('theme/client/plugins/themify-icons/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('theme/client/plugins/slick/slick.css') }}">

  <!-- Main Stylesheet -->
  <link rel="stylesheet" href="{{ asset('theme/client/css/style.css') }}" media="screen">

  <!--Favicon-->
  <link rel="shortcut icon" href="{{ asset('theme/client/images/favicon.png') }}" type="image/x-icon">
  <link rel="icon" href="{{ asset('theme/client/images/favicon.png') }}" type="image/x-icon">
</head>
<body>
  <!-- navigation -->
  @include('layouts.header')
  <!-- /navigation -->
<div id="content">
    @yield('content')
</div>

@include('layouts.footer')


  <!-- JS Plugins -->
  <script src="{{ asset('theme/client/plugins/jQuery/jquery.min.js') }}"></script>

  <script src="{{ asset('theme/client/plugins/bootstrap/bootstrap.min.js') }}"></script>

  <script src="{{ asset('theme/client/plugins/slick/slick.min.js') }}"></script>

  <script src="{{ asset('theme/client/plugins/instafeed/instafeed.min.js') }}"></script>


  <!-- Main Script -->
  <script src="{{ asset('theme/client/js/script.js') }}"></script></body>
</html>