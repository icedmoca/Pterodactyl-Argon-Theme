{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.admin')

@section('title')
    List Servers
@endsection

@section('content-header')
    <h1>Servers<small>All servers available on the system.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li class="active">Servers</li>
    </ol>
@endsection

@section('search')
<form class="navbar-search navbar-search-dark form-inline mr-3 d-none d-md-flex ml-lg-auto" action="{{ route('admin.servers') }}" method="GET">
   <div class="form-group mb-0">
      <div class="input-group input-group-alternative">
         <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
         </div>
         <input class="form-control" name="query" value="{{ request()->input('query') }}" placeholder="Search Servers" type="text">
      </div>
   </div>
</form>
@endsection

@section('mobile-search')
<form class="mt-4 mb-3 d-md-none" action="{{ route('admin.servers') }}" method="GET">
   <div class="input-group input-group-rounded input-group-merge">
      <input type="search" name="query" class="form-control form-control-rounded form-control-prepended" value="{{ request()->input('query') }}" placeholder="Search Servers" aria-label="Search Servers">
      <div class="input-group-prepend">
         <div class="input-group-text">
            <span class="fa fa-search"></span>
         </div>
      </div>
   </div>
</form>
@endsection

@section('content')
<div class="row mt--7">
    <div class="col-lg-12">
        <div class="card shadow">
            <div class="card-header border-0">
               <div class="row align-items-center">
                  <div class="col">
                     <h3 class="mb-0">Server List</h3>
                  </div>
                  <div class="col text-right">
                     <a href="{{ route('admin.servers.new') }}" class="btn btn-sm btn-primary">Create New</a>
                  </div>
               </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-items-center table-flush table-sm">
                      <thead class="thead-light">
                        <tr>
                            <th>Server Name</th>
                            <th>UUID</th>
                            <th>Owner</th>
                            <th>Node</th>
                            <th>Connection</th>
                            <th></th>
                            <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($servers as $server)
                            <tr data-server="{{ $server->uuidShort }}">
                                <td><a href="{{ route('admin.servers.view', $server->id) }}">{{ $server->name }}</a></td>
                                <td><code title="{{ $server->uuid }}">{{ $server->uuid }}</code></td>
                                <td><a href="{{ route('admin.users.view', $server->user->id) }}">{{ $server->user->username }}</a></td>
                                <td><a href="{{ route('admin.nodes.view', $server->node->id) }}">{{ $server->node->name }}</a></td>
                                <td>
                                    <code>{{ $server->allocation->alias }}:{{ $server->allocation->port }}</code>
                                </td>
                                <td class="text-center">
                                    @if($server->suspended)
                                        <span class="badge badge-danger">Suspended</span>
                                    @elseif(! $server->installed)
                                        <span class="badge badge-warning">Installing</span>
                                    @else
                                        <span class="badge badge-success">Active</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-sm btn-primary" href="{{ route('server.index', $server->uuidShort) }}"><i class="fas fa-wrench"></i></a>
                                    <a class="btn btn-sm btn-danger console-popout" href="{{ route('server.console', $server->uuidShort) }}"><i class="fas fa-terminal"></i></a>
                                </td>
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
    <script>
        $('.console-popout').on('click', function (event) {
            event.preventDefault();
            window.open($(this).attr('href'), 'Pterodactyl Console', 'width=800,height=400');
        });
    </script>
@endsection
