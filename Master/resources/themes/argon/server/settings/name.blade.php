{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.master')

@section('title')
@lang('server.config.name.header')
@endsection

@section('content-header')
<h1>@lang('server.config.name.header')<small>@lang('server.config.name.header_sub')</small></h1>
<ol class="breadcrumb">
   <li><a href="{{ route('index') }}">@lang('strings.home')</a></li>
   <li><a href="{{ route('server.index', $server->uuidShort) }}">{{ $server->name }}</a></li>
   <li>@lang('navigation.server.configuration')</li>
   <li class="active">@lang('navigation.server.server_name')</li>
</ol>
@endsection

@section('content')
<div class="row mt--7">
   <div class="col-lg-12">
      <form action="{{ route('server.settings.name', $server->uuidShort) }}" method="POST">
         <div class="card shadow">
            <div class="card-header border-transparent">
               <div class="row align-items-center">
                  <div class="col">
                     <h3 class="mb-0">@lang('server.config.name.header')</h3>
                  </div>
               </div>
            </div>
            <div class="card-body">
               <div class="form-group no-margin-bottom">
                  <div>
                     <input type="text" name="name" id="pServerName" class="form-control" value="{{ $server->name }}" />
                     <p class="small text-muted no-margin-bottom">@lang('server.config.name.details')</p>
                  </div>
               </div>
            </div>
            <div class="card-footer mt--4">
               {{ method_field('PATCH') }}
               {{ csrf_field() }}
               <input type="submit" class="btn btn-sm btn-primary float-right" value="@lang('strings.submit')" />
            </div>
         </div>
      </form>
   </div>
</div>
@endsection

@section('footer-scripts')
@parent
{!! Theme::js('js/frontend/server.socket.js') !!}
@endsection
