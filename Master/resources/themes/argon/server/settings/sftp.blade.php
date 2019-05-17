{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.master')

@section('title')
@lang('server.config.sftp.header')
@endsection

@section('content-header')
<h1>@lang('server.config.sftp.header')<small>@lang('server.config.sftp.header_sub')</small></h1>
<ol class="breadcrumb">
   <li><a href="{{ route('index') }}">@lang('strings.home')</a></li>
   <li><a href="{{ route('server.index', $server->uuidShort) }}">{{ $server->name }}</a></li>
   <li>@lang('navigation.server.configuration')</li>
   <li class="active">@lang('navigation.server.sftp_settings')</li>
</ol>
@endsection

@section('content')
<div class="row mt--7">
   <div class="col-lg-12">
      <div class="card shadow">
         <div class="card-header border-transparent">
            <div class="row align-items-center">
               <div class="col">
                  <h3 class="mb-0">@lang('server.config.sftp.details')</h3>
               </div>
            </div>
         </div>
         <div class="card-body">
            <div class="form-group">
               <label class="control-label">@lang('server.config.sftp.conn_addr')</label>
               <div>
                  <input type="text" class="form-control" readonly value="sftp://{{ $node->fqdn }}:{{ $node->daemonSFTP }}" />
               </div>
            </div>
            <div class="form-group">
               <label for="password" class="control-label">@lang('strings.username')</label>
               <div>
                  <input type="text" class="form-control" readonly value="{{ auth()->user()->username }}.{{ $server->uuidShort }}" />
               </div>
            </div>
         </div>
         <div class="card-footer mt--4">
            <p class="small text-muted mb-0">@lang('server.config.sftp.warning')</p>
         </div>
      </div>
   </div>
</div>
@endsection

@section('footer-scripts')
@parent
{!! Theme::js('js/frontend/server.socket.js') !!}
@endsection
