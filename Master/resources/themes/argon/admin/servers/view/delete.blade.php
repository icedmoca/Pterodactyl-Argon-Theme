{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.admin')

@section('title')
    Server — {{ $server->name }}: Delete
@endsection

@section('content-header')
    <h1>{{ $server->name }}<small>Delete this server from the panel.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li><a href="{{ route('admin.servers') }}">Servers</a></li>
        <li><a href="{{ route('admin.servers.view', $server->id) }}">{{ $server->name }}</a></li>
        <li class="active">Delete</li>
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
                <a class="nav-link mb-sm-3 mb-md-0" href="{{ route('admin.servers.view.manage', $server->id) }}" role="tab">Manage</a>
             </li>
             @endif
             <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0 active" href="{{ route('admin.servers.view.delete', $server->id) }}" role="tab">Delete</a>
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
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header border-transparent">
               <div class="row align-items-center">
                  <div class="col">
                     <h3 class="mb-0">Safely Delete Server</h3>
                  </div>
               </div>
            </div>
            <div class="card-body">
                <p>This action will attempt to delete the server from both the panel and daemon. If either one reports an error the action will be cancelled.</p>
                <p class="text-danger small">Deleting a server is an irreversible action. <strong>All server data</strong> (including files and users) will be removed from the system.</p>
            </div>
            <div class="card-footer mt--3">
                <form action="{{ route('admin.servers.view.delete', $server->id) }}" method="POST">
                    {!! csrf_field() !!}
                    <button type="submit" class="btn btn-sm btn-danger">Safely Delete This Server</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header border-transparent">
               <div class="row align-items-center">
                  <div class="col">
                     <h3 class="mb-0">Force Delete Server</h3>
                  </div>
               </div>
            </div>
            <div class="card-body">
                <p>This action will attempt to delete the server from both the panel and daemon. If the daemon does not respond, or reports an error the deletion will continue.</p>
                <p class="text-danger small">Deleting a server is an irreversible action. <strong>All server data</strong> (including files and users) will be removed from the system. This method may leave dangling files on your daemon if it reports an error.</p>
            </div>
            <div class="card-footer mt--3">
                <form action="{{ route('admin.servers.view.delete', $server->id) }}" method="POST">
                    {!! csrf_field() !!}
                    <input type="hidden" name="force_delete" value="1" />
                    <button type="submit" class="btn btn-sm btn-danger">Forcibly Delete This Server</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')
    @parent
    <script>
    $('form[data-action="delete"]').submit(function (event) {
        event.preventDefault();
        swal({
            title: '',
            type: 'warning',
            text: 'Are you sure that you want to delete this server? There is no going back, all data will immediately be removed.',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            confirmButtonColor: '#d9534f',
            closeOnConfirm: false
        }, function () {
            event.target.submit();
        });
    });
    </script>
@endsection
