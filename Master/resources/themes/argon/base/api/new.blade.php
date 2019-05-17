@extends('layouts.master')

@section('title')
@lang('base.api.new.header')
@endsection

@section('content-header')
<h1>@lang('base.api.new.header')<small>@lang('base.api.new.header_sub')</small></h1>
<ol class="breadcrumb">
    <li><a href="{{ route('index') }}">@lang('strings.home')</a></li>
    <li class="active">@lang('navigation.account.api_access')</li>
    <li class="active">@lang('base.api.new.header')</li>
</ol>
@endsection

@section('content')
    <div class="mt--7">
        <form method="POST" action="{{ route('account.api.new') }}">
          <div class="row">
            <div class="col-lg-6 mb-cs">
                <div class="card shadow">
                  <div class="card-header bg-transparent">
                      <div class="row align-items-center">
                        <div class="col">
                          <h3 class="mb-0">New API Key</h3>
                        </div>
                      </div>
                  </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="control-label" for="memoField">Description</label>
                            <input id="memoField" type="text" name="memo" class="form-control" value="{{ old('memo') }}">
                            <p class="text-muted small no-margin">Set an easy to understand description for this API key to help you identify it later on.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-cs">
                <div class="card shadow">
                  <div class="card-header bg-transparent">
                      <div class="row align-items-center">
                        <div class="col">
                          <h3 class="mb-0">Restrictions</h3>
                        </div>
                      </div>
                  </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="control-label" for="memoField">Allowed Connection IPs</label>
                            <textarea id="allowedIps" name="allowed_ips" class="form-control" rows="5">{{ old('allowed_ips') }}</textarea>
                            <p class="text-muted small no-margin">If you would like to limit this API key to specific IP addresses enter them above, one per line. CIDR notation is allowed for each IP address. Leave blank to allow any IP address.</p>
                        </div>
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-primary btn-sm pull-right">Create API Key</button>
                    </div>
                </div>
            </div>
            </div>
        </form>
    </div>
@endsection
