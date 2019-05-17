{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.admin')

@section('title')
    {{ $node->name }}: Configuration
@endsection

@section('content-header')
    <h1>{{ $node->name }}<small>Your daemon configuration file.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li><a href="{{ route('admin.nodes') }}">Nodes</a></li>
        <li><a href="{{ route('admin.nodes.view', $node->id) }}">{{ $node->name }}</a></li>
        <li class="active">Configuration</li>
    </ol>
@endsection

@section('content')
<div class="row mt--7 mb-cs">
   <div class="col-lg-12">
      <div class="card shadow bg-secondary">
        <div class="card-body bg-secondary" style="padding: 0.75rem">
          <ul class="nav nav-pills nav-fill flex-column flex-sm-row" id="tabs-text" role="tablist">
             <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0" href="{{ route('admin.nodes.view', $node->id) }}" role="tab">About</a>
             </li>
             <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0" href="{{ route('admin.nodes.view.settings', $node->id) }}" role="tab">Settings</a>
             </li>
             <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0 active" href="{{ route('admin.nodes.view.configuration', $node->id) }}" role="tab">Configuration</a>
             </li>
             <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0" href="{{ route('admin.nodes.view.allocation', $node->id) }}" role="tab">Allocation</a>
             </li>
             <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0" href="{{ route('admin.nodes.view.servers', $node->id) }}" role="tab">Servers</a>
             </li>
          </ul>
        </div>
      </div>
   </div>
</div>
<div class="row">
    <div class="col-lg-8 mb-cs">
        <div class="card shadow">
            <div class="card-header border-transparent">
               <div class="row align-items-center">
                  <div class="col">
                     <h3 class="mb-0">Configuration File</h3>
                  </div>
               </div>
            </div>
            <div class="card-body">
                <pre class="no-margin">{{ $node->getConfigurationAsJson(true) }}</pre>
            </div>
            <div class="card-footer">
                <p class="no-margin mb-0">This file should be placed in your daemon's <code>config</code> directory in a file called <code>core.json</code>.</p>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card shadow">
            <div class="card-header border-transparent">
               <div class="row align-items-center">
                  <div class="col">
                     <h3 class="mb-0">Auto-Deploy</h3>
                  </div>
               </div>
            </div>
            <div class="card-body">
                <p class="text-muted small">To simplify the configuration of nodes it is possible to fetch the config from the panel. A token is required for this process. The button below will generate a token and provide you with the commands necessary for automatic configuration of the node. <em>Tokens are only valid for 5 minutes.</em></p>
            </div>
            <div class="card-footer">
                <button type="button" id="configTokenBtn" class="btn btn-sm btn-primary btn-block">Generate Token</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')
    @parent
    <script>
    $('#configTokenBtn').on('click', function (event) {
        $.getJSON('{{ route('admin.nodes.view.configuration.token', $node->id) }}').done(function (data) {
            swal({
                type: 'success',
                title: 'Token created.',
                text: 'Your token will expire <strong>in 5 minutes.</strong><br /><br />' +
                      '<p>To auto-configure your node run the following command:<br /><small><pre>npm run configure -- --panel-url {{ config('app.url') }} --token ' + data.token + '</pre></small></p>',
                html: true
            })
        }).fail(function () {
            swal({
                title: 'Error',
                text: 'Something went wrong creating your token.',
                type: 'error'
            });
        });
    });
    </script>
@endsection
