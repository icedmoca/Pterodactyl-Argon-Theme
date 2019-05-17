{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.admin')

@section('title')
    {{ $node->name }}: Servers
@endsection

@section('content-header')
    <h1>{{ $node->name }}<small>All servers currently assigned to this node.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li><a href="{{ route('admin.nodes') }}">Nodes</a></li>
        <li><a href="{{ route('admin.nodes.view', $node->id) }}">{{ $node->name }}</a></li>
        <li class="active">Servers</li>
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
                <a class="nav-link mb-sm-3 mb-md-0" href="{{ route('admin.nodes.view.configuration', $node->id) }}" role="tab">Configuration</a>
             </li>
             <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0" href="{{ route('admin.nodes.view.allocation', $node->id) }}" role="tab">Allocation</a>
             </li>
             <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0 active" href="{{ route('admin.nodes.view.servers', $node->id) }}" role="tab">Servers</a>
             </li>
          </ul>
        </div>
      </div>
   </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow">
            <div class="card-header border-0">
               <div class="row align-items-center">
                  <div class="col">
                     <h3 class="mb-0">Process Manager</h3>
                  </div>
               </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-items-center table-flush">
                  <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Server Name</th>
                        <th>Owner</th>
                        <th>Service</th>
                        <th class="text-center">Memory</th>
                        <th class="text-center">Disk</th>
                        <th class="text-center">CPU</th>
                        <th class="text-center">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($servers as $server)
                        <tr data-server="{{ $server->uuid }}">
                            <td><code>{{ $server->uuidShort }}</code></td>
                            <td><a href="{{ route('admin.servers.view', $server->id) }}">{{ $server->name }}</a></td>
                            <td><a href="{{ route('admin.users.view', $server->owner_id) }}">{{ $server->user->username }}</a></td>
                            <td>{{ $server->nest->name }} ({{ $server->egg->name }})</td>
                            <td class="text-center"><span data-action="memory">NaN</span> / {{ $server->memory === 0 ? '∞' : $server->memory }} MB</td>
                            <td class="text-center">{{ $server->disk }} MB</td>
                            <td class="text-center"><span data-action="cpu" data-cpumax="{{ $server->cpu }}">NaN</span> %</td>
                            <td class="text-center" data-action="status"><span class="badge badge-dot"> <i class="bg-default"></i> Retrieving </span></td>
                        </tr>
                    @endforeach
                  </tbody>
                </table>
            </div>
            @if($servers->hasPages())
                <div class="card-footer mb--3">
                    <div class="col-lg-12 text-center">{!! $servers->appends(['query' => Request::input('query')])->render() !!}</div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')
    @parent
    {!! Theme::js('js/admin/node/view-servers.js') !!}
@endsection
