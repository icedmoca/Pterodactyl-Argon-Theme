{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.master')

@section('title')
@lang('server.users.new.header')
@endsection

@section('content-header')
<h1>@lang('server.users.edit.header')<small>@lang('server.users.edit.header_sub')</small></h1>
<ol class="breadcrumb">
   <li><a href="{{ route('index') }}">@lang('strings.home')</a></li>
   <li><a href="{{ route('server.index', $server->uuidShort) }}">{{ $server->name }}</a></li>
   <li><a href="{{ route('server.subusers', $server->uuidShort) }}">@lang('navigation.server.subusers')</a></li>
   <li class="active">@lang('server.users.update')</li>
</ol>
@endsection

@section('content')
<div class="mt--7">
   @can('edit-subuser', $server)
   <form action="{{ route('server.subusers.view', [ 'uuid' => $server->uuidShort, 'subuser' => $subuser->hashid ]) }}" method="POST">
      @endcan
      <div class="row">
         <div class="col-lg-12 mb-cs">
            <div class="card shadow">
               <div class="card-header border-transparent">
                  <div class="row align-items-center">
                     <div class="col">
                        <h3 class="mb-0">@lang('server.users.new.email')</h3>
                     </div>
                  </div>
               </div>
               <div class="card-body">
                  <div class="form-group">
                     <div>
                        {!! csrf_field() !!}
                        <input type="email" class="form-control" disabled value="{{ $subuser->user->email }}" />
                        <p class="text-muted small">@lang('server.users.new.email_help')</p>
                     </div>
                  </div>
               </div>
               @can('edit-subuser', $server)
               <div class="card-footer mt--4">
                  <div class="btn-group float-left">
                     <a id="selectAllCheckboxes" href="#" class="btn btn-sm btn-info">@lang('strings.select_all')</a>
                     <a id="unselectAllCheckboxes" href="#" class="btn btn-sm btn-info">@lang('strings.select_none')</a>
                  </div>
                  {!! method_field('PATCH') !!}
                  <input type="submit" name="submit" value="@lang('server.users.update')" class="float-right btn btn-sm btn-success" />
               </div>
               @endcan
            </div>
         </div>
      </div>
      <div class="row">
         @foreach($permlist as $block => $perms)
         <div class="col-lg-6 mb-cs">
            <div class="card shadow">
               <div class="card-header border-transparent">
                  <div class="row align-items-center">
                     <div class="col">
                        <h3 class="mb-0">@lang('server.users.new.' . $block . '_header')</h3>
                     </div>
                  </div>
               </div>
               <div class="card-body">
                  @foreach($perms as $permission => $daemon)
                  <div class="form-group mb-0">
                     <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" id="{{ $permission }}" name="permissions[]" type="checkbox" @if(isset($permissions[$permission]))checked="checked"@endif @cannot('edit-subuser', $server)disabled="disabled"@endcannot value="{{ $permission }}"/>
                        <label class="custom-control-label" for="{{ $permission }}" class="strong">
                        @lang('server.users.new.' . str_replace('-', '_', $permission) . '.title')
                        </label>
                     </div>
                     <p class="text-muted small">@lang('server.users.new.' . str_replace('-', '_', $permission) . '.description')</p>
                  </div>
                  @endforeach
               </div>
            </div>
         </div>
         @if ($loop->iteration % 2 === 0)
         <div class="clearfix visible-lg-block visible-md-block visible-sm-block"></div>
         @endif
         @endforeach
      </div>
      @can('edit-subuser', $server)
   </form>
   @endcan
</div>
@endsection

@section('footer-scripts')
@parent
{!! Theme::js('js/frontend/server.socket.js') !!}
<script type="text/javascript">
   $(document).ready(function () {
       $('#selectAllCheckboxes').on('click', function () {
           $('input[type=checkbox]').prop('checked', true);
       });
       $('#unselectAllCheckboxes').on('click', function () {
           $('input[type=checkbox]').prop('checked', false);
       });
   })
</script>
@endsection
