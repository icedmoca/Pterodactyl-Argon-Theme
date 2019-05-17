{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>{{ config('app.name', 'Pterodactyl') }} - @yield('title')</title>
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
      <meta name="_token" content="{{ csrf_token() }}">

      <link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-touch-icon.png">
      <link rel="icon" type="image/png" href="/favicons/favicon-32x32.png" sizes="32x32">
      <link rel="icon" type="image/png" href="/favicons/favicon-16x16.png" sizes="16x16">
      <link rel="manifest" href="/favicons/manifest.json">
      <link rel="mask-icon" href="/favicons/safari-pinned-tab.svg" color="#bc6e3c">
      <link rel="shortcut icon" href="/favicons/favicon.ico">
      <meta name="msapplication-config" content="/favicons/browserconfig.xml">
      <meta name="theme-color" content="#ffffff">

      @include('layouts.scripts')

      @section('scripts')
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        {!! Theme::css('vendor/fontawesome/v5/css/all.min.css?t={cache-version}') !!}
        {!! Theme::css('vendor/argon/css/argon.min.css?t={cache-version}') !!}
        {!! Theme::css('vendor/animate/animate.min.css?t={cache-version}') !!}
        {!! Theme::css('css/style.css?t={cache-version}') !!}
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
      @show
   </head>
   <body>
      <div class="main-content">
         <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
            <div class="container-fluid" style="min-height: 50px;">
               <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="{{ route('index') }}">Control Panel</a>
            </div>
         </nav>
         <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
            <div class="container-fluid">
               <div class="header-body">
               </div>
            </div>
         </div>
         <div class="container-fluid mb-5">
            @yield('content')
         </div>
      </div>
      @section('footer-scripts')
        {!! Theme::js('js/laroute.js?t={cache-version}') !!}
        {!! Theme::js('vendor/jquery/jquery.min.js?t={cache-version}') !!}
        {!! Theme::js('vendor/bootstrap/v4/dist/js/bootstrap.bundle.min.js?t={cache-version}') !!}
        {!! Theme::js('vendor/slimscroll/jquery.slimscroll.min.js?t={cache-version}') !!}
        {!! Theme::js('vendor/argon/js/argon.min.js?t={cache-version}') !!}
      @show
   </body>
</html>
