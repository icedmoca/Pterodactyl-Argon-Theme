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

      <link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-touch-icon.png">
      <link rel="icon" type="image/png" href="/favicons/favicon-32x32.png" sizes="32x32">
      <link rel="icon" type="image/png" href="/favicons/favicon-16x16.png" sizes="16x16">
      <link rel="manifest" href="/favicons/manifest.json">
      <link rel="mask-icon" href="/favicons/safari-pinned-tab.svg" color="#bc6e3c">
      <link rel="shortcut icon" href="/favicons/favicon.ico">
      <meta name="msapplication-config" content="/favicons/browserconfig.xml">
      <meta name="theme-color" content="#ffffff">

      @section('scripts')
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
      {!! Theme::css('vendor/fontawesome/v5/css/all.min.css?t={cache-version}') !!}
      {!! Theme::css('vendor/argon/css/argon.min.css?t={cache-version}') !!}
      {!! Theme::css('css/style.css?t={cache-version}') !!}
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
      @show
   </head>
   <body class="bg-default">
      <div class="main-content">
         <nav class="navbar navbar-top navbar-horizontal navbar-expand-md navbar-dark">
            <div class="container px-4">
               <a class="navbar-brand" href="{{ route('index') }}">
               <img src="{!! Theme::url('img/logo-white.png?t={cache-version}') !!}">
               </a>
               <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse-main" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
               </button>
               <div class="collapse navbar-collapse" id="navbar-collapse-main">
                  <div class="navbar-collapse-header d-md-none">
                     <div class="row">
                        <div class="col-6 collapse-brand">
                           <a href="{{ route('index') }}">
                           <img src="{!! Theme::url('img/logo.png?t={cache-version}') !!}">
                           </a>
                        </div>
                        <div class="col-6 collapse-close">
                           <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                           <span></span>
                           <span></span>
                           </button>
                        </div>
                     </div>
                  </div>
                  <ul class="navbar-nav ml-auto">
                     <li class="nav-item">
                        <a class="nav-link nav-link-icon" href="#">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="nav-link-inner--text">Client Area</span>
                        </a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link nav-link-icon" href="#">
                        <i class="fas fa-life-ring"></i>
                        <span class="nav-link-inner--text">Support Center</span>
                        </a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link nav-link-icon" href="{{ route('index') }}">
                        <i class="fas fa-th"></i>
                        <span class="nav-link-inner--text">Control Panel</span>
                        </a>
                     </li>
                  </ul>
               </div>
            </div>
         </nav>
         @yield('content')
      </div>
      <footer class="py-5">
         <div class="container">
            <div class="row align-items-center justify-content-xl-between">
               <div class="col-xl-6">
                  <div class=" text-center text-xl-left login-copyright">
                     Copyright &copy; {{ date('Y') }} <a href="#" class="font-weight-bold" target="_blank">{{ config('app.name', 'Pterodactyl') }}</a>
                  </div>
               </div>
               <div class="col-xl-6">
                  <ul class="nav nav-footer justify-content-center justify-content-xl-end">
                     <li class="nav-item login-copyright">
                        <a href="https://pterodactyl.io/" class="nav-link" target="_blank">Proudly powered by Pterodactyl Software</a>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
      </footer>
      {!! Theme::js('vendor/jquery/jquery.min.js?t={cache-version}') !!}
      {!! Theme::js('vendor/bootstrap/v4/dist/js/bootstrap.bundle.min.js?t={cache-version}') !!}
      {!! Theme::js('js/autocomplete.js?t={cache-version}') !!}
      {!! Theme::js('vendor/argon/js/argon.min.js?t={cache-version}') !!}
   </body>
</html>
