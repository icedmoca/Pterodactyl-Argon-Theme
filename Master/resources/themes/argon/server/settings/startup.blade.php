{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.master')

@section('title')
@lang('server.config.startup.header')
@endsection

@section('content-header')
<h1>@lang('server.config.startup.header')<small>@lang('server.config.startup.header_sub')</small></h1>
<ol class="breadcrumb">
   <li><a href="{{ route('index') }}">@lang('strings.home')</a></li>
   <li><a href="{{ route('server.index', $server->uuidShort) }}">{{ $server->name }}</a></li>
   <li>@lang('navigation.server.configuration')</li>
   <li class="active">@lang('navigation.server.startup_parameters')</li>
</ol>
@endsection

@section('content')
<div class="mt--7">
   <div class="row">
      <div class="col-lg-12 mb-cs">
         <div class="card shadow">
            <div class="card-header border-transparent">
               <div class="row align-items-center">
                  <div class="col">
                     <h3 class="mb-0">@lang('server.config.startup.command')</h3>
                  </div>
               </div>
            </div>
            <div class="card-body">
               <div class="form-group mb-0">
                  <input type="text" class="form-control" readonly value="{{ $startup }}" />
               </div>
            </div>
         </div>
      </div>
   </div>
   @can('edit-startup', $server)
   <form action="{{ route('server.settings.startup', $server->uuidShort) }}" method="POST">
      <div class="row">
         @foreach($variables as $v)
         <div class="col-lg-4 mb-cs">
            <div class="card shadow" style="min-height: 300px !important;">
               <div class="card-header border-transparent">
                  <div class="row align-items-center">
                     <div class="col">
                        <h3 class="mb-0">{{ $v->name }}<span class="mb-0 float-right">
                           @if($v->required && $v->user_editable )
                           <span class="badge badge-danger">@lang('strings.required')</span>
                           @elseif(! $v->required && $v->user_editable)
                           <span class="badge badge-primary">@lang('strings.optional')</span>
                           @endif
                           @if(! $v->user_editable)
                           <span class="badge badge-warning">@lang('strings.read_only')</span>
                           @endif
                           </span>
                        </h3>
                     </div>
                  </div>
               </div>
               <div class="card-body">
                  <input
                  @if($v->user_editable)
                  name="environment[{{ $v->env_variable }}]"
                  @else
                  readonly
                  @endif
                  class="form-control" type="text" value="{{ old('environment.' . $v->env_variable, $server_values[$v->env_variable]) }}" />
                  <p class="small text-muted">{{ $v->description }}</p>
               </div>
               <div class="card-footer">
                  <p class="no-margin text-muted small mb-0"><strong>@lang('server.config.startup.startup_regex'):</strong> <code>{{ $v->rules }}</code></p>
               </div>
            </div>
         </div>
         @endforeach
         <div class="col-lg-12 mb-cs">
            <div class="card shadow">
               <div class="card-footer">
                  {!! csrf_field() !!}
                  {!! method_field('PATCH') !!}
                  <input type="submit" class="btn btn-primary btn-sm float-right" value="@lang('server.config.startup.update')" />
               </div>
            </div>
         </div>
      </div>
   </form>
   @endcan
</div>
@endsection

@section('footer-scripts')
@parent
{!! Theme::js('js/frontend/server.socket.js') !!}
@endsection
