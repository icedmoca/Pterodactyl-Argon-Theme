{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.auth')

@section('title')
2FA Checkpoint
@endsection

@section('scripts')
    @parent
    <style>
        input::-webkit-outer-spin-button, input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
@endsection

@section('content')
<div class="header bg-gradient-primary py-7 py-lg-8">
  <div class="container">
    <div class="header-body text-center mb-7">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-6">
          <h1 class="text-white">Welcome!</h1>
          <p class="text-lead text-white">Please authenticate with a valid account in order to continue to the control panel.</p>
        </div>
      </div>
    </div>
  </div>
  <div class="separator separator-bottom separator-skew zindex-100">
    <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
      <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
    </svg>
  </div>
</div>
<div class="container mt--8 pb-5">
  <div class="row justify-content-center">
    <div class="col-lg-5 col-md-7">
      <div class="card bg-secondary shadow border-0">
        <div class="card-body px-lg-5 py-lg-5">
          <div class="text-center text-muted mb-4 mt--3">
            <small>Two-factor authentication token required to continue.</small>
          </div>
          <form role="form" id="totpForm" action="{{ route('auth.totp') }}" method="POST">
            <div class="form-group mb-3">
              <div class="input-group input-group-alternative">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-shield-alt"></i></span>
                </div>
                <input type="number" name="2fa_token" class="form-control" required placeholder="@lang('strings.2fa_token')" autofocus>
              </div>
            </div>
            <div class="text-center">
              {!! csrf_field() !!}
              <input type="hidden" name="verify_token" value="{{ $verify_key }}" />
              <button type="submit" class="btn btn-primary btn-block g-recaptcha mb-0">@lang('strings.submit')</button>
            </div>
          </form>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-6">
          <a href="#" class="text-light"><small>Disable two-factor authentication</small></a>
        </div>
        <div class="col-6 text-right">
              <a href="{{ route('index') }}" class="text-light"><small>Cancel and return</small></a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
