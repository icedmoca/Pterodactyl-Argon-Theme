{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.admin')

@section('title')
    List Users
@endsection

@section('content-header')
    <h1>Users<small>All registered users on the system.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li class="active">Users</li>
    </ol>
@endsection

@section('search')
<form class="navbar-search navbar-search-dark form-inline mr-3 d-none d-md-flex ml-lg-auto" action="{{ route('admin.users') }}" method="GET">
   <div class="form-group mb-0">
      <div class="input-group input-group-alternative">
         <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
         </div>
         <input class="form-control" name="query" value="{{ request()->input('query') }}" placeholder="Search" type="text">
      </div>
   </div>
</form>
@endsection

@section('mobile-search')
<form class="mt-4 mb-3 d-md-none" action="{{ route('admin.users') }}" method="GET">
   <div class="input-group input-group-rounded input-group-merge">
      <input type="search" name="query" class="form-control form-control-rounded form-control-prepended" value="{{ request()->input('query') }}" placeholder="Search" aria-label="Search">
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
                     <h3 class="mb-0">User List</h3>
                  </div>
                  <div class="col text-right">
                     <a href="{{ route('admin.users.new') }}" class="btn btn-sm btn-primary">Create New</a>
                  </div>
               </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-items-center table-flush">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <th>Client Name</th>
                            <th>Username</th>
                            <th class="text-center">2FA</th>
                            <th class="text-center"><span data-toggle="tooltip" data-placement="top" title="Servers that this user is marked as the owner of.">Servers Owned</span></th>
                            <th class="text-center"><span data-toggle="tooltip" data-placement="top" title="Servers that this user can access because they are marked as a subuser.">Can Access</span></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="align-middle">
                                <td><code>{{ $user->id }}</code></td>
                                <td><a href="{{ route('admin.users.view', $user->id) }}">{{ $user->email }}</a> @if($user->root_admin)<i class="fas fa-star text-yellow"></i>@endif</td>
                                <td>{{ $user->name_last }}, {{ $user->name_first }}</td>
                                <td>{{ $user->username }}</td>
                                <td class="text-center">
                                    @if($user->use_totp)
                                        <i class="fas fa-lock text-green"></i>
                                    @else
                                        <i class="fas fa-unlock text-red"></i>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.servers', ['query' => $user->email]) }}">{{ $user->servers_count }}</a>
                                </td>
                                <td class="text-center">{{ $user->subuser_of_count }}</td>
                                <td class="text-center"><img src="https://www.gravatar.com/avatar/{{ md5(strtolower($user->email)) }}?s=100" style="height:20px;" class="rounded-circle" /></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($users->hasPages())
                <div class="card-footer mb--3">
                    <div class="col-lg-12 text-center">{!! $users->appends(['query' => Request::input('query')])->render() !!}</div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
