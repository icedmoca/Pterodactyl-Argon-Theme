{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.admin')

@section('title')
    Server — {{ $server->name }}: Manage
@endsection

@section('content-header')
    <h1>{{ $server->name }}<small>Additional actions to control this server.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li><a href="{{ route('admin.servers') }}">Servers</a></li>
        <li><a href="{{ route('admin.servers.view', $server->id) }}">{{ $server->name }}</a></li>
        <li class="active">Manage</li>
    </ol>
@endsection

@section('content')
<div class="row mt--7 mb-cs">
   <div class="col-lg-12">
      <div class="card shadow bg-secondary">
        <div class="card-body bg-secondary" style="padding: 0.75rem">
          <ul class="nav nav-pills nav-fill flex-column flex-sm-row" id="tabs-text" role="tablist">
             <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0" href="{{ route('admin.servers.view', $server->id) }}" role="tab">About</a>
             </li>
             @if($server->installed === 1)
             <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0" href="{{ route('admin.servers.view.details', $server->id) }}" role="tab">Details</a>
             </li>
             <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0 " href="{{ route('admin.servers.view.build', $server->id) }}" role="tab">Build Configuration</a>
             </li>
             <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0 " href="{{ route('admin.servers.view.startup', $server->id) }}" role="tab">Startup</a>
             </li>
             <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0" href="{{ route('admin.servers.view.database', $server->id) }}" role="tab">Database</a>
             </li>
             <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0 active" href="{{ route('admin.servers.view.manage', $server->id) }}" role="tab">Manage</a>
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
    <div class="col-lg-4 mb-cs">
        <div class="card shadow">
            <div class="card-header border-transparent">
               <div class="row align-items-center">
                  <div class="col">
                     <h3 class="mb-0">Reinstall Server</h3>
                  </div>
               </div>
            </div>
            <div class="card-body">
                <p>This will reinstall the server with the assigned pack and service scripts. <strong>Danger!</strong> This could overwrite server data.</p>
            </div>
            <div class="card-footer mt--3">
                @if($server->installed === 1)
                    <form action="{{ route('admin.servers.view.manage.reinstall', $server->id) }}" method="POST">
                        {!! csrf_field() !!}
                        <button type="submit" class="btn btn-sm btn-danger">Reinstall Server</button>
                    </form>
                @else
                    <button class="btn btn-sm btn-danger disabled">Server Must Install Properly to Reinstall</button>
                @endif
            </div>
        </div>
    </div>
    <div class="col-lg-4 mb-cs">
        <div class="card shadow">
            <div class="card-header border-transparent">
               <div class="row align-items-center">
                  <div class="col">
                     <h3 class="mb-0">Install Status</h3>
                  </div>
               </div>
            </div>
            <div class="card-body">
                <p>If you need to change the install status from uninstalled to installed, or vice versa, you may do so with the button below.</p>
            </div>
            <div class="card-footer mt--3">
                <form action="{{ route('admin.servers.view.manage.toggle', $server->id) }}" method="POST">
                    {!! csrf_field() !!}
                    <button type="submit" class="btn btn-sm btn-primary">Toggle Install Status</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4 mb-cs">
        <div class="card shadow">
            <div class="card-header border-transparent">
               <div class="row align-items-center">
                  <div class="col">
                     <h3 class="mb-0">Rebuild Container</h3>
                  </div>
               </div>
            </div>
            <div class="card-body">
                <p>This will trigger a rebuild of the server container when it next starts up. This is useful if you modified the server configuration file manually, or something just didn't work out correctly.</p>
            </div>
            <div class="card-footer mt--3">
                <form action="{{ route('admin.servers.view.manage.rebuild', $server->id) }}" method="POST">
                    {!! csrf_field() !!}
                    <button type="submit" class="btn btn-sm btn-default">Rebuild Server Container</button>
                </form>
            </div>
        </div>
    </div>
    @if(! $server->suspended)
        <div class="col-lg-4 mb-cs">
            <div class="card shadow">
                <div class="card-header border-transparent">
                   <div class="row align-items-center">
                      <div class="col">
                         <h3 class="mb-0">Suspend Server</h3>
                      </div>
                   </div>
                </div>
                <div class="card-body">
                    <p>This will suspend the server, stop any running processes, and immediately block the user from being able to access their files or otherwise manage the server through the panel or API.</p>
                </div>
                <div class="card-footer mt--3">
                    <form action="{{ route('admin.servers.view.manage.suspension', $server->id) }}" method="POST">
                        {!! csrf_field() !!}
                        <input type="hidden" name="action" value="suspend" />
                        <button type="submit" class="btn btn-sm btn-warning">Suspend Server</button>
                    </form>
                </div>
            </div>
        </div>
    @else
        <div class="col-lg-4 mb-cs">
            <div class="card shadow">
                <div class="card-header border-transparent">
                   <div class="row align-items-center">
                      <div class="col">
                         <h3 class="mb-0">Unsuspend Server</h3>
                      </div>
                   </div>
                </div>
                <div class="card-body">
                    <p>This will unsuspend the server and restore normal user access.</p>
                </div>
                <div class="card-footer mt--3">
                    <form action="{{ route('admin.servers.view.manage.suspension', $server->id) }}" method="POST">
                        {!! csrf_field() !!}
                        <input type="hidden" name="action" value="unsuspend" />
                        <button type="submit" class="btn btn-sm btn-success">Unsuspend Server</button>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
