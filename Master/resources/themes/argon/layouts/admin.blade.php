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
        {!! Theme::css('vendor/select2/dist/css/select2.min.css?t={cache-version}') !!}
        {!! Theme::css('vendor/argon/css/argon.min.css?t={cache-version}') !!}
        {!! Theme::css('vendor/sweetalert/sweetalert.min.css?t={cache-version}') !!}
        {!! Theme::css('vendor/animate/animate.min.css?t={cache-version}') !!}
        {!! Theme::css('css/style.css?t={cache-version}') !!}
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
      @show
   </head>
   <body>
      <nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
         <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand pt-1" href="{{ route('index') }}" style="padding-top: .50rem !important;">
            <img src="{!! Theme::url('img/logo.png?t={cache-version}') !!}">
            </a>
            <ul class="nav align-items-center d-md-none">
               <li class="nav-item dropdown">
                  <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                        <img alt="User Image" src="https://www.gravatar.com/avatar/{{ md5(strtolower(Auth::user()->email)) }}?s=160">
                        </span>
                     </div>
                  </a>
                  <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                     <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Welcome!</h6>
                     </div>
                     <a href="{{ route('account') }}" class="dropdown-item">
                     <i class="fas fa-fw fa-user"></i>
                     <span>@lang('navigation.account.my_account')</span>
                     </a>
                     <a href="{{ route('index') }}" class="dropdown-item">
                     <i class="fas fa-fw fa-times-circle"></i>
                     <span>Exit Admin Control</span>
                     </a>
                     <div class="dropdown-divider"></div>
                     <a href="{{ route('auth.logout') }}" class="dropdown-item logoutButton">
                     <i class="fas fa-fw fa-sign-out-alt"></i>
                     <span>@lang('strings.logout')</span>
                     </a>
                  </div>
               </li>
            </ul>
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
               <div class="navbar-collapse-header d-md-none">
                  <div class="row">
                     <div class="col-6 collapse-brand">
                        <a href="{{ route('index') }}">
                        <img src="{!! Theme::url('img/logo.png?t={cache-version}') !!}">
                        </a>
                     </div>
                     <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                        <span></span>
                        <span></span>
                        </button>
                     </div>
                  </div>
               </div>
               @yield('mobile-search')
               <ul class="navbar-nav">
                  <li class="nav-item">
                     <a class="nav-link {{ Route::currentRouteName() !== 'admin.index' ?: 'active' }}" href="{{ route('admin.index') }}">
                     <i class="fas fa-home"></i> Overview
                     </a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link {{ Route::currentRouteName() !== 'admin.statistics' ?: 'active' }}" href="{{ route('admin.statistics') }}">
                     <i class="fas fa-tachometer-alt"></i> Statistics
                     </a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link {{ ! starts_with(Route::currentRouteName(), 'admin.settings') ?: 'active' }}" href="{{ route('admin.settings')}}">
                     <i class="fas fa-wrench"></i> Settings
                     </a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link {{ ! starts_with(Route::currentRouteName(), 'admin.api') ?: 'active' }}" href="{{ route('admin.api.index')}}">
                     <i class="fas fa-gamepad"></i> Application API
                     </a>
                  </li>
               </ul>
               <hr class="my-3">
               <h6 class="navbar-heading text-muted">Management</h6>
               <ul class="navbar-nav mb-md-3">
                  <li class="nav-item">
                     <a class="nav-link {{ ! starts_with(Route::currentRouteName(), 'admin.databases') ?: 'active' }}" href="{{ route('admin.databases') }}">
                     <i class="fas fa-database"></i> Databases
                     </a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link {{ ! starts_with(Route::currentRouteName(), 'admin.locations') ?: 'active' }}" href="{{ route('admin.locations') }}">
                     <i class="fas fa-globe-americas"></i> Locations
                     </a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link {{ ! starts_with(Route::currentRouteName(), 'admin.nodes') ?: 'active' }}" href="{{ route('admin.nodes') }}">
                     <i class="fas fa-network-wired"></i> Nodes
                     </a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link {{ ! starts_with(Route::currentRouteName(), 'admin.servers') ?: 'active' }}" href="{{ route('admin.servers') }}">
                     <i class="fas fa-server"></i> Servers
                     </a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link {{ ! starts_with(Route::currentRouteName(), 'admin.users') ?: 'active' }}" href="{{ route('admin.users') }}">
                     <i class="fas fa-users"></i> Users
                     </a>
                  </li>
               </ul>
               <hr class="my-3">
               <h6 class="navbar-heading text-muted">Service Management</h6>
               <ul class="navbar-nav mb-md-3">
                  <li class="nav-item">
                     <a class="nav-link {{ ! starts_with(Route::currentRouteName(), 'admin.nests') ?: 'active' }}" href="{{ route('admin.nests') }}">
                     <i class="fas fa-th-large"></i> Nests
                     </a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link {{ ! starts_with(Route::currentRouteName(), 'admin.packs') ?: 'active' }}" href="{{ route('admin.packs') }}">
                     <i class="fas fa-archive"></i> Packs
                     </a>
                  </li>
               </ul>
            </div>
         </div>
      </nav>
      <div class="main-content">
         <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
            <div class="container-fluid">
               <span class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="{{ route('index') }}">@yield('title')</span>
               @yield('search')
               <ul class="navbar-nav align-items-center d-none d-md-flex">
                  <li class="nav-item dropdown">
                     <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="media align-items-center">
                           <span class="avatar avatar-sm rounded-circle">
                           <img alt="Image placeholder" src="https://www.gravatar.com/avatar/{{ md5(strtolower(Auth::user()->email)) }}?s=160">
                           </span>
                           <div class="media-body ml-2 d-none d-lg-block">
                              <span class="mb-0 text-sm  font-weight-bold">{{ Auth::user()->name_first }} {{ Auth::user()->name_last }}</span>
                           </div>
                        </div>
                     </a>
                     <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                        <div class=" dropdown-header noti-title">
                           <h6 class="text-overflow m-0">Welcome!</h6>
                        </div>
                        <a href="{{ route('account') }}" class="dropdown-item">
                        <i class="fas fa-fw fa-user"></i>
                        <span>@lang('navigation.account.my_account')</span>
                        </a>
                        <a href="{{ route('index') }}" class="dropdown-item">
                        <i class="fas fa-fw fa-times-circle"></i>
                        <span>Exit Admin Control</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('auth.logout') }}" class="dropdown-item logoutButton">
                        <i class="fas fa-fw fa-sign-out-alt"></i>
                        <span>@lang('strings.logout')</span>
                        </a>
                     </div>
                  </li>
               </ul>
            </div>
         </nav>
         <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
            <div class="container-fluid">
               <div class="header-body">
                  @if (count($errors) > 0)
                  <div class="alert alert-danger mt-4 mb--2">
                     @lang('base.validation_error')<br><br>
                     <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                     </ul>
                  </div>
                  @endif
                  @foreach (Alert::getMessages() as $type => $messages)
                  @foreach ($messages as $message)
                  <div class="alert alert-{{ $type }} mt-4 mb--2 alert-dismissable" role="alert">
                     {!! $message !!}
                  </div>
                  @endforeach
                  @endforeach
               </div>
            </div>
         </div>
         <div class="container-fluid mb-5">
            @yield('content')
         </div>
      </div>
      @section('footer-scripts')
        {!! Theme::js('js/keyboard.polyfill.js?t={cache-version}') !!}
        <script>keyboardeventKeyPolyfill.polyfill();</script>
        {!! Theme::js('js/laroute.js?t={cache-version}') !!}
        {!! Theme::js('vendor/jquery/jquery.min.js?t={cache-version}') !!}
        {!! Theme::js('vendor/sweetalert/sweetalert.min.js?t={cache-version}') !!}
        {!! Theme::js('vendor/bootstrap/v4/dist/js/bootstrap.bundle.min.js?t={cache-version}') !!}
        {!! Theme::js('vendor/slimscroll/jquery.slimscroll.min.js?t={cache-version}') !!}
        {!! Theme::js('vendor/socketio/socket.io.v203.min.js?t={cache-version}') !!}
        {!! Theme::js('vendor/bootstrap-notify/bootstrap-notify.min.js?t={cache-version}') !!}
        {!! Theme::js('js/admin/functions.js?t={cache-version}') !!}
        {!! Theme::js('js/autocomplete.js?t={cache-version}') !!}
        {!! Theme::js('vendor/select2/dist/js/select2.full.min.js?t={cache-version}') !!}
        {!! Theme::js('vendor/argon/js/argon.min.js?t={cache-version}') !!}
        @if(Auth::user()->root_admin)
        <script>
           $('.logoutButton').on('click', function (event) {
               event.preventDefault();

               var that = this;
               swal({
                   title: 'Do you want to log out?',
                   type: 'warning',
                   showCancelButton: true,
                   confirmButtonColor: '#d9534f',
                   cancelButtonColor: '#d33',
                   confirmButtonText: 'Log out'
               }, function () {
                   window.location = $(that).attr('href');
               });
           });
        </script>
        @endif
      @show
   </body>
</html>
