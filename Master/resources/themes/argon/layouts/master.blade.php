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
                     @if(Auth::user()->root_admin)
                     <a href="{{ route('admin.index') }}" class="dropdown-item">
                     <i class="fas fa-fw fa-cog"></i>
                     <span>@lang('strings.admin_cp')</span>
                     </a>
                     @endif
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
               <form class="mt-4 mb-3 d-md-none" action="{{ route('index') }}" method="GET">
                  <div class="input-group input-group-rounded input-group-merge">
                     <input type="search" name="query" class="form-control form-control-rounded form-control-prepended" value="{{ request()->input('query') }}" placeholder="@lang('strings.search')" aria-label="Search">
                     <div class="input-group-prepend">
                        <div class="input-group-text">
                           <span class="fa fa-search"></span>
                        </div>
                     </div>
                  </div>
               </form>
               <ul class="navbar-nav">
                  <li class="nav-item">
                     <a class="nav-link {{ Route::currentRouteName() !== 'account' ?: 'active' }}" href="{{ route('account') }}">
                     <i class="fas fa-user"></i> @lang('navigation.account.my_account')
                     </a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link {{ Route::currentRouteName() !== 'account.security' ?: 'active' }}" href="{{ route('account.security')}}">
                     <i class="fas fa-lock"></i> @lang('navigation.account.security_controls')
                     </a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link {{ (Route::currentRouteName() !== 'account.api' && Route::currentRouteName() !== 'account.api.new') ?: 'active' }}" href="{{ route('account.api')}}">
                     <i class="fas fa-code"></i> @lang('navigation.account.api_access')
                     </a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link {{ Route::currentRouteName() !== 'index' ?: 'active' }}" href="{{ route('index')}}">
                     <i class="fas fa-server"></i> @lang('navigation.account.my_servers')
                     </a>
                  </li>
               </ul>
               @if (isset($server->name) && isset($node->name))
               <hr class="my-3">
               <h6 class="navbar-heading text-muted">@lang('navigation.server.header')</h6>
               <ul class="navbar-nav mb-md-3">
                  <li class="nav-item">
                     <a class="nav-link {{ Route::currentRouteName() !== 'server.index' ?: 'active' }}" href="{{ route('server.index', $server->uuidShort) }}">
                     <i class="fas fa-terminal"></i> @lang('navigation.server.console')
                     </a>
                  </li>
                  @can('list-files', $server)
                  <li class="nav-item">
                     <a class="nav-link {{ starts_with(Route::currentRouteName(), 'server.files') ? 'active' : '' }}" href="{{ route('server.files.index', $server->uuidShort) }}">
                     <i class="fas fa-folder-open"></i> @lang('navigation.server.file_management')
                     </a>
                  </li>
                  @endcan
                  @can('list-subusers', $server)
                  <li class="nav-item">
                     <a class="nav-link {{ starts_with(Route::currentRouteName(), 'server.subusers') ? 'active' : '' }}" href="{{ route('server.subusers', $server->uuidShort)}}">
                     <i class="fas fa-users"></i> @lang('navigation.server.subusers')
                     </a>
                  </li>
                  @endcan
                  @can('list-schedules', $server)
                  <li class="nav-item">
                     <a class="nav-link {{ starts_with(Route::currentRouteName(), 'server.schedules') ? 'active' : '' }}" href="{{ route('server.schedules', $server->uuidShort)}}">
                     <i class="fas fa-clock"></i> @lang('navigation.server.schedules')
                     </a>
                  </li>
                  @endcan
                  @can('view-databases', $server)
                  <li class="nav-item">
                     <a class="nav-link {{ starts_with(Route::currentRouteName(), 'server.databases') ? 'active' : '' }}" href="{{ route('server.databases.index', $server->uuidShort)}}">
                     <i class="fas fa-database"></i> @lang('navigation.server.databases')
                     </a>
                  </li>
                  @endcan
               </ul>
               @if(Gate::allows('view-startup', $server) || Gate::allows('access-sftp', $server) ||  Gate::allows('view-allocations', $server))
               <hr class="my-3">
               <h6 class="navbar-heading text-muted">Server Configuration</h6>
               <ul class="navbar-nav mb-md-3">
                  @can('view-name', $server)
                  <li class="nav-item">
                     <a class="nav-link {{ Route::currentRouteName() !== 'server.settings.name' ?: 'active' }}" href="{{ route('server.settings.name', $server->uuidShort) }}">
                     <i class="fas fa-tag"></i> @lang('navigation.server.server_name')
                     </a>
                  </li>
                  @endcan
                  @can('view-allocations', $server)
                  <li class="nav-item">
                     <a class="nav-link {{ Route::currentRouteName() !== 'server.settings.allocation' ?: 'active' }}" href="{{ route('server.settings.allocation', $server->uuidShort) }}">
                     <i class="fas fa-network-wired"></i> @lang('navigation.server.port_allocations')
                     </a>
                  </li>
                  @endcan
                  @can('access-sftp', $server)
                  <li class="nav-item">
                     <a class="nav-link {{ Route::currentRouteName() !== 'server.settings.sftp' ?: 'active' }}" href="{{ route('server.settings.sftp', $server->uuidShort) }}">
                     <i class="fas fa-copy"></i> @lang('navigation.server.sftp_settings')
                     </a>
                  </li>
                  @endcan
                  @can('view-startup', $server)
                  <li class="nav-item">
                     <a class="nav-link {{ Route::currentRouteName() !== 'server.settings.startup' ?: 'active' }}" href="{{ route('server.settings.startup', $server->uuidShort) }}">
                     <i class="fas fa-code"></i> @lang('navigation.server.startup_parameters')
                     </a>
                  </li>
                  @endcan
               </ul>
               @endif
               @if(Auth::user()->root_admin)
               <hr class="my-3">
               <h6 class="navbar-heading text-muted">@lang('navigation.server.admin_header')</h6>
               <ul class="navbar-nav mb-md-3">
                  <li class="nav-item">
                     <a class="nav-link" href="{{ route('admin.servers.view', $server->id) }}" target="_blank">
                     <i class="fas fa-cog"></i> @lang('navigation.server.admin')
                     </a>
                  </li>
               </ul>
               @endif
               @endif
            </div>
         </div>
      </nav>
      <div class="main-content">
         <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
            <div class="container-fluid">
               <span class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="{{ route('index') }}">@yield('title')</span>
               <form class="navbar-search navbar-search-dark form-inline mr-3 d-none d-md-flex ml-lg-auto" action="{{ route('index') }}" method="GET">
                  <div class="form-group mb-0">
                     <div class="input-group input-group-alternative">
                        <div class="input-group-prepend">
                           <span class="input-group-text"><i class="fas fa-search"></i></span>
                        </div>
                        <input class="form-control" name="query" value="{{ request()->input('query') }}" placeholder="@lang('strings.search')" type="text">
                     </div>
                  </div>
               </form>
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
                        @if(Auth::user()->root_admin)
                        <a href="{{ route('admin.index') }}" class="dropdown-item">
                        <i class="fas fa-fw fa-cog"></i>
                        <span>@lang('strings.admin_cp')</span>
                        </a>
                        @endif
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
                  @if (isset($server->name) && isset($node->name))
                  <div class="row">
                     @if(Route::currentRouteName() !== 'server.index')
                     <div class="col-lg-12">
                        <div class="card card-stats mb-4 mb-xl-0">
                           <div class="card-body">
                              <div class="row">
                                 <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Server</h5>
                                    <span class="h2 font-weight-bold mb-0">{{ $server->name }}</span>
                                 </div>
                                 <div class="col-auto" id="server_status_icon" data-toggle="tooltip" data-placement="top" title="Retrieving">
                                    <div class="icon icon-shape text-white rounded-circle shadow bg-default"><i class="fas fa-circle-notch fa-spin"></i></div>
                                 </div>
                              </div>
                              <p class="mt-3 mb-0 text-muted text-sm">
                                 <span class="">You're currently viewing this server.</span>
                              </p>
                           </div>
                        </div>
                     </div>
                     @else
                     <div class="col-xl-3 col-lg-6">
                        <div class="card card-stats mb-4 mb-xl-0">
                           <div class="card-body" style="min-height: 120px;">
                              <div class="row">
                                 <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Status</h5>
                                    <span id="server_stats_status"><span class="h4 font-weight-bold mb-0">Retrieving<span></span>
                                 </div>
                                 <div class="col-auto" id="server_status_icon" data-toggle="tooltip" data-placement="top" title="Retrieving">
                                    <div class="icon icon-shape text-white rounded-circle shadow bg-default"><i class="fas fa-circle-notch fa-spin"></i></div>
                                 </div>
                              </div>
                              <p class="mt-3 mb-0 text-muted text-sm">
                                 <span data-toggle="tooltip" data-html="true" data-placement="top" title="
                                 {{$server->name}}<br>
                                 <b>Node: </b>{{$server->getRelation('node')->name}}<br>
                                 <b>Server ID: </b>{{$server->uuidShort}}<br>
                                 ">Hover for Information</span>
                              </p>
                           </div>
                        </div>
                     </div>
                     <div class="col-xl-3 col-lg-6">
                        <div class="card card-stats mb-4 mb-xl-0">
                           <div class="card-body" style="min-height: 120px;">
                              <div class="row">
                                 <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Memory</h5>
                                    <span class="{{ $server->memory > 0 ? 'h2' : 'h4' }} font-weight-bold mb-0">
                                      @if($server->memory > 0)
                                      <span id="server_stats_memory">0</span>%
                                      @else
                                      <span id="server_stats_memory">0</span> MB
                                      @endif
                                    </span>
                                 </div>
                                 <div class="col-auto" id="server_memory_icon" data-toggle="tooltip" data-placement="top" title="0 / {{ $server->memory }} MB">
                                    <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                       <i class="fas fa-memory"></i>
                                    </div>
                                 </div>
                              </div>
                              <p class="mt-3 mb-0 text-muted text-sm">
                                 <span class="">
                                 @if($server->memory > 0)
                                 Measured in Percentage
                                 @else
                                 Measured in Megabytes
                                 @endif
                               </span>
                              </p>
                           </div>
                        </div>
                     </div>
                     <div class="col-xl-3 col-lg-6">
                        <div class="card card-stats mb-4 mb-xl-0">
                           <div class="card-body" style="min-height: 120px;">
                              <div class="row">
                                <div class="col">
                                   <h5 class="card-title text-uppercase text-muted mb-0">CPU</h5>
                                   <span class="h2 font-weight-bold mb-0"><span id="server_stats_cpu">0</span>%</span>
                                </div>
                                <div class="col-auto" id="server_cpu_icon" data-toggle="tooltip" data-placement="top" title="0%">
                                   <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                      <i class="fas fa-microchip"></i>
                                   </div>
                                </div>
                              </div>
                              <p class="mt-3 mb-0 text-muted text-sm">
                                 <span class="">Measured in Percentage</span>
                              </p>
                           </div>
                        </div>
                     </div>
                     <div class="col-xl-3 col-lg-6">
                        <div class="card card-stats mb-4 mb-xl-0">
                           <div class="card-body" style="min-height: 120px;">
                              <div class="row">
                                <div class="col">
                                   <h5 class="card-title text-uppercase text-muted mb-0">Disk</h5>
                                   <span class="{{ $server->memory > 0 ? 'h2' : 'h4' }} font-weight-bold mb-0">
                                     @if($server->disk > 0)
                                     <span id="server_stats_disk">0</span>%
                                     @else
                                     <span id="server_stats_disk">0</span> MB
                                     @endif
                                   </span>
                                </div>
                                 <div class="col-auto" id="server_disk_icon" data-toggle="tooltip" data-placement="top" title="0 / {{ $server->disk }} MB">
                                    <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                       <i class="fas fa-hdd"></i>
                                    </div>
                                 </div>
                              </div>
                              <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="">
                                 @if($server->disk > 0)
                                 Measured in Percentage
                                 @else
                                 Measured in Megabytes
                                 @endif
                                </span>
                              </p>
                           </div>
                        </div>
                     </div>
                     @endif
                  </div>
                  @endif
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
        {!! Theme::js('js/autocomplete.js?t={cache-version}') !!}
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
