{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.master')

@section('title')
{{ trans('server.index.title', [ 'name' => $server->name]) }}
@endsection

@section('scripts')
@parent
{!! Theme::css('css/terminal.css') !!}
@endsection

@section('content-header')
<h1>@lang('server.index.header')<small>@lang('server.index.header_sub')</small></h1>
<ol class="breadcrumb">
   <li><a href="{{ route('index') }}">@lang('strings.servers')</a></li>
   <li class="active">{{ $server->name }}</li>
</ol>
@endsection

@section('content')
<div class="row mt--7">
   <div class="col-lg-12 mb-4">
       <div class="position-relative">
          <div id="terminal" style="width:100%;"></div>
          <div id="terminal_input" class="form-group no-margin">
             <div class="input-group pb-1">
                <div class="input-group-addon terminal_input--prompt">{{ $server->name }}:~/$</div>
                <input type="text" class="form-control terminal_input--input h-100">
             </div>
          </div>
          <div id="terminalNotify" class="terminal-notify hidden" data-toggle="tooltip" data-placement="top" title="Auto-scroll Console">
             <i class="fas fa-arrow-down"></i>
          </div>
          <div id="console-popout" href="{{ route('server.console', $server->uuidShort) }}" class="terminal-popout hidden" data-toggle="tooltip" data-placement="top" title="Pop-out Console">
             <i class="fas fa-expand"></i>
          </div>
       </div>
       <div class="text-center">
          @can('power-start', $server)<button class="btn btn-success disabled" data-attr="power" data-action="start">Start</button>@endcan
          @can('power-restart', $server)<button class="btn btn-primary disabled" data-attr="power" data-action="restart">Restart</button>@endcan
          @can('power-stop', $server)<button class="btn btn-danger disabled" data-attr="power" data-action="stop">Stop</button>@endcan
          @can('power-kill', $server)<button class="btn btn-danger disabled" data-attr="power" data-action="kill">Kill</button>@endcan
       </div>
   </div>
</div>
<div class="row">
   <div class="col-lg-6 mb-cs">
      <div class="card shadow">
         <div class="card-header bg-transparent">
            <div class="row align-items-center">
               <div class="col">
                  <h3 class="mb-0">Memory Usage</h3>
               </div>
            </div>
         </div>
         <div class="card-body">
            <canvas id="chart_memory" style="max-height:300px;"></canvas>
         </div>
      </div>
   </div>
   <div class="col-lg-6 mb-cs">
      <div class="card shadow">
         <div class="card-header bg-transparent">
            <div class="row align-items-center">
               <div class="col">
                  <h3 class="mb-0">CPU Usage</h3>
               </div>
            </div>
         </div>
         <div class="card-body">
            <canvas id="chart_cpu" style="max-height:300px;"></canvas>
         </div>
      </div>
   </div>
</div>
@endsection

@section('footer-scripts')
@parent
{!! Theme::js('vendor/ansi/ansi_up.js') !!}
{!! Theme::js('js/frontend/server.socket.js') !!}
{!! Theme::js('vendor/mousewheel/jquery.mousewheel-min.js') !!}
{!! Theme::js('js/frontend/console.js') !!}
{!! Theme::js('vendor/chartjs/chart.min.js') !!}
{!! Theme::js('vendor/jquery/date-format.min.js') !!}
@if($server->nest->name === 'Minecraft' && $server->nest->author === 'support@pterodactyl.io')
{!! Theme::js('js/plugins/minecraft/eula.js') !!}
@endif
{!! Theme::js('js/frontend/server.stats.js') !!}
@endsection
