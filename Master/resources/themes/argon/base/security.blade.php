{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.master')

@section('title')
@lang('base.security.header')
@endsection

@section('content-header')
<h1>@lang('base.security.header')<small>@lang('base.security.header_sub')</small></h1>
<ol class="breadcrumb">
   <li><a href="{{ route('index') }}">@lang('strings.home')</a></li>
   <li><a href="{{ route('account') }}">@lang('strings.account')</a></li>
   <li class="active">@lang('strings.security')</li>
</ol>
@endsection

@section('content')
<div class="row mt--7">
   <div class="col-lg-6 mb-cs">
      <div class="card shadow">
         <div class="card-header {{ is_null($sessions) ? 'border-transparent' : 'border-0' }}">
            <div class="row align-items-center">
               <div class="col">
                  <h3 class="mb-0">@lang('base.security.sessions')</h3>
               </div>
            </div>
         </div>
         @if(!is_null($sessions))
         <div class="table-responsive">
            <table class="table align-items-center table-flush">
               <thead class="thead-light">
                  <tr>
                     <th>@lang('strings.id')</th>
                     <th>@lang('strings.ip')</th>
                     <th>@lang('strings.last_activity')</th>
                     <th></th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($sessions as $session)
                  <tr>
                     <td><code>{{ substr($session->id, 0, 6) }}</code></td>
                     <td>{{ $session->ip_address }}</td>
                     <td>{{ Carbon::createFromTimestamp($session->last_activity)->diffForHumans() }}</td>
                     <td>
                        <a href="{{ route('account.security.revoke', $session->id) }}">
                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> @lang('strings.revoke')</button>
                        </a>
                     </td>
                  </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
         @else
         <div class="card-body mb--2">
            <p class="text-muted">@lang('base.security.session_mgmt_disabled')</p>
         </div>
         @endif
      </div>
   </div>
   <div class="col-lg-6 mb-cs">
      <div class="card2">
         @if(Auth::user()->use_totp)
         <form action="{{ route('account.security.totp') }}" method="post">
            <div class="card shadow">
               <div class="card-header bg-transparent">
                  <div class="row align-items-center">
                     <div class="col">
                        <h3 class="mb-0">@lang('base.security.2fa_header')</h3>
                     </div>
                  </div>
               </div>
               <div class="card-body">
                  <p>@lang('base.security.2fa_enabled')</p>
                  <div class="form-group">
                     <label for="new_password_again" class="control-label">@lang('strings.2fa_token')</label>
                     <div>
                        <input type="text" class="form-control" name="token" />
                        <p class="text-muted small">@lang('base.security.2fa_token_help')</p>
                     </div>
                  </div>
               </div>
               <div class="card-footer mt--3">
                  {!! csrf_field() !!}
                  {{ method_field('DELETE') }}
                  <button type="submit" class="btn btn-danger btn-sm">@lang('base.security.disable_2fa')</button>
               </div>
            </div>
         </form>
         @else
         <form action="#" method="post" id="do_2fa">
            <div class="card shadow">
               <div class="card-header bg-transparent">
                  <div class="row align-items-center">
                     <div class="col">
                        <h3 class="mb-0">@lang('base.security.2fa_header')</h3>
                     </div>
                  </div>
               </div>
               <div class="card-body">
                  <p>
                     @lang('base.security.2fa_disabled')
                  </p>
               </div>
               <div class="card-footer">
                  {!! csrf_field() !!}
                  <button type="submit" class="btn btn-success btn-sm">@lang('base.security.enable_2fa')</button>
               </div>
            </div>
         </form>
         @endif
      </div>
   </div>
</div>
<div class="modal fade" id="open2fa" tabindex="-1" role="dialog" aria-labelledby="open2fa" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
         <form action="#" method="post" id="2fa_token_verify">
            <div class="modal-header">
               <h4 class="modal-title">@lang('base.security.2fa_qr')</h4>
            </div>
            <div class="modal-body" id="modal_insert_content">
               <div class="row">
                  <div class="col-lg-12" id="notice_box_2fa" style="display:none;"></div>
               </div>
               <div class="row">
                  <div class="col-lg-6 text-center">
                     <span id="hide_img_load"><i class="fas fa-spinner fa-spin"></i> Loading QR Code...</span><img src="" id="qr_image_insert" style="display:none;"/>
                  </div>
                  <div class="col-lg-6">
                     <div class="alert alert-info">@lang('base.security.2fa_checkpoint_help')</div>
                     <div class="form-group">
                        <label class="control-label" for="2fa_token">@lang('strings.2fa_token')</label>
                        {!! csrf_field() !!}
                        <input class="form-control" type="text" name="2fa_token" id="2fa_token" />
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-primary btn-sm" id="submit_action">@lang('strings.submit')</button>
               <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" id="close_reload">@lang('strings.close')</button>
            </div>
         </form>
      </div>
   </div>
</div>
@endsection

@section('footer-scripts')
  @parent
  {!! Theme::js('js/frontend/2fa-modal.js') !!}
@endsection
