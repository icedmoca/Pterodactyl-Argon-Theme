{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.admin')

@section('title')
    Server — {{ $server->name }}
@endsection

@section('content-header')
    <h1>{{ $server->name }}<small>{{ str_limit($server->description) }}</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li><a href="{{ route('admin.servers') }}">Servers</a></li>
        <li class="active">{{ $server->name }}</li>
    </ol>
@endsection

@section('content')
<div class="row mt--7 mb-cs">
   <div class="col-lg-12">
      <div class="card shadow bg-secondary">
        <div class="card-body bg-secondary" style="padding: 0.75rem">
          <ul class="nav nav-pills nav-fill flex-column flex-sm-row" id="tabs-text" role="tablist">
             <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0 active" href="{{ route('admin.servers.view', $server->id) }}" role="tab">About</a>
             </li>
             @if($server->installed === 1)
             <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0" href="{{ route('admin.servers.view.details', $server->id) }}" role="tab">Details</a>
             </li>
             <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0" href="{{ route('admin.servers.view.build', $server->id) }}" role="tab">Build Configuration</a>
             </li>
             <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0" href="{{ route('admin.servers.view.startup', $server->id) }}" role="tab">Startup</a>
             </li>
             <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0" href="{{ route('admin.servers.view.database', $server->id) }}" role="tab">Database</a>
             </li>
             <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0" href="{{ route('admin.servers.view.manage', $server->id) }}" role="tab">Manage</a>
             </li>
             @endif
             <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0" href="{{ route('admin.servers.view.delete', $server->id) }}" role="tab">Delete</a>
             </li>
             <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0" href="{{ route('server.index', $server->uuidShort) }}" role="tab"><i class="fas fa-external-link-alt"></i></a>
             </li>
          </ul>
        </div>
      </div>
   </div>
</div>
<div class="row">
    <div class="col-sm-8 mb-cs">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow">
                    <div class="card-header border-transparent">
                       <div class="row align-items-center">
                          <div class="col">
                             <h3 class="mb-0">Information</h3>
                          </div>
                       </div>
                    </div>
                    <div class="table-responsive no-padding">
                        <table class="table table-sm table-hover align-items-center table-flush">
                            <tr>
                                <td>Internal Identifier</td>
                                <td><code>{{ $server->id }}</code></td>
                            </tr>
                            <tr>
                                <td>External Identifier</td>
                                @if(is_null($server->external_id))
                                    <td><span class="badge badge-primary">Not Set</span></td>
                                @else
                                    <td><code>{{ $server->external_id }}</code></td>
                                @endif
                            </tr>
                            <tr>
                                <td>UUID / Docker Container ID</td>
                                <td><code>{{ $server->uuid }}</code></td>
                            </tr>
                            <tr>
                                <td>Service</td>
                                <td>
                                    <a href="{{ route('admin.nests.view', $server->nest_id) }}">{{ $server->nest->name }}</a> ::
                                    <a href="{{ route('admin.nests.egg.view', $server->egg_id) }}">{{ $server->egg->name }}</a>
                                </td>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td>{{ $server->name }}</td>
                            </tr>
                            <tr>
                                <td>Memory</td>
                                <td><code>{{ $server->memory }}MB</code> / <code data-toggle="tooltip" data-placement="top" title="Swap Space">{{ $server->swap }}MB</code></td>
                            </tr>
                            <tr>
                                <td>Disk Space</td>
                                <td><code>{{ $server->disk }}MB</code></td>
                            </tr>
                            <tr>
                                <td>Block IO Weight</td>
                                <td><code>{{ $server->io }}</code></td>
                            </tr>
                            <tr>
                                <td>CPU Limit</td>
                                <td><code>{{ $server->cpu }}%</code></td>
                            </tr>
                            <tr>
                                <td>Default Connection</td>
                                <td><code>{{ $server->allocation->ip }}:{{ $server->allocation->port }}</code></td>
                            </tr>
                            <tr>
                                <td>Connection Alias</td>
                                <td>
                                    @if($server->allocation->alias !== $server->allocation->ip)
                                        <code>{{ $server->allocation->alias }}:{{ $server->allocation->port }}</code>
                                    @else
                                        <span class="badge badge-primary">No Alias Assigned</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
      @if($server->suspended)
            <div class="card card-stats bg-warning shadow mb-4">
               <div class="card-body">
                  <div class="row">
                     <div class="col">
                        <span class="h2 font-weight-bold mb-0 text-white">Suspended</span>
                     </div>
                  </div>
               </div>
            </div>
      @endif
      @if($server->installed !== 1)
          <div class="card card-stats bg-{{ (! $server->installed) ? 'primary' : 'warning' }} shadow mb-4">
             <div class="card-body">
                <div class="row">
                   <div class="col">
                      <span class="h2 font-weight-bold mb-0 text-white">{{ (! $server->installed) ? 'Installing' : 'Install Failed' }}</span>
                   </div>
                </div>
             </div>
          </div>
      @endif
      <div class="card card-stats shadow mb-4">
         <div class="card-body">
            <div class="row">
               <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">Server Owner</h5>
                  <span class="h2 font-weight-bold mb-0">{{ str_limit($server->user->username, 16) }}</span>
               </div>
               <div class="col-auto">
                  <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                     <i class="fas fa-user"></i>
                  </div>
               </div>
            </div>
            <p class="mt-0 mb-0 text-muted text-sm">
               <span><a href="{{ route('admin.users.view', $server->user->id) }}">More info</a></span>
            </p>
         </div>
      </div>
      <div class="card card-stats shadow mb-4">
         <div class="card-body">
            <div class="row">
               <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">Server Node</h5>
                  <span class="h2 font-weight-bold mb-0">{{ str_limit($server->node->name, 16) }}</span>
               </div>
               <div class="col-auto">
                  <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                     <i class="fas fa-user"></i>
                  </div>
               </div>
            </div>
            <p class="mt-0 mb-0 text-muted text-sm">
               <span><a href="{{ route('admin.nodes.view', $server->node->id) }}">More info</a></span>
            </p>
         </div>
      </div>
    </div>
</div>
@endsection
