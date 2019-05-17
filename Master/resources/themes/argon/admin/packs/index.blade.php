{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.admin')

@section('title')
    List Packs
@endsection

@section('content-header')
    <h1>Packs<small>All service packs available on the system.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li class="active">Packs</li>
    </ol>
@endsection

@section('search')
<form class="navbar-search navbar-search-dark form-inline mr-3 d-none d-md-flex ml-lg-auto" action="{{ route('admin.packs') }}" method="GET">
   <div class="form-group mb-0">
      <div class="input-group input-group-alternative">
         <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
         </div>
         <input class="form-control" name="query" value="{{ request()->input('query') }}" placeholder="Search Packs" type="text">
      </div>
   </div>
</form>
@endsection

@section('mobile-search')
<form class="mt-4 mb-3 d-md-none" action="{{ route('admin.packs') }}" method="GET">
   <div class="input-group input-group-rounded input-group-merge">
      <input type="search" name="query" class="form-control form-control-rounded form-control-prepended" value="{{ request()->input('query') }}" placeholder="Search Packs" aria-label="Search Packs">
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
    <div class="col-md-12">
        <div class="card shadow">
          <div class="card-header border-0">
             <div class="row align-items-center">
                <div class="col">
                   <h3 class="mb-0">Pack List</h3>
                </div>
                <div class="col text-right">
                   <a href="{{ route('admin.packs.new') }}" class="btn btn-sm btn-primary">Create New</a>
                </div>
             </div>
          </div>
            <div class="table-responsive">
                <table class="table table-hover align-items-center table-flush">
                      <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Pack Name</th>
                            <th>Version</th>
                            <th>Description</th>
                            <th>Egg</th>
                            <th class="text-center">Servers</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($packs as $pack)
                            <tr>
                                <td class="middle" data-toggle="tooltip" data-placement="right" title="{{ $pack->uuid }}"><code>{{ $pack->id }}</code></td>
                                <td class="middle"><a href="{{ route('admin.packs.view', $pack->id) }}">{{ $pack->name }}</a></td>
                                <td class="middle"><code>{{ $pack->version }}</code></td>
                                <td class="col-md-6">{{ str_limit($pack->description, 150) }}</td>
                                <td class="middle"><a href="{{ route('admin.nests.egg.view', $pack->egg->id) }}">{{ $pack->egg->name }}</a></td>
                                <td class="middle text-center">{{ $pack->servers_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($packs->hasPages())
                <div class="card-footer mb--3">
                    <div class="col-lg-12 text-center">{!! $packs->appends(['query' => Request::input('query')])->render() !!}</div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
