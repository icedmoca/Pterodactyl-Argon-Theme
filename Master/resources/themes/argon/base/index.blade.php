{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.master')

@section('title')
@lang('base.index.header')
@endsection

@section('content-header')
<h1>@lang('base.index.header')<small>@lang('base.index.header_sub')</small></h1>
<ol class="breadcrumb">
   <li><a href="{{ route('index') }}">@lang('strings.home')</a></li>
   <li class="active">@lang('strings.servers')</li>
</ol>
@endsection

@section('content')
<div class="row mt--7">
   <div class="col-lg-12 mb-4">
      <div class="card shadow">
         <div class="card-header border-0">
            <div class="row align-items-center">
               <div class="col">
                  <h3 class="mb-0">@lang('base.index.list')</h3>
               </div>
               <div class="col text-right">
                  <a href="#" class="btn btn-sm btn-primary">Order New</a>
               </div>
            </div>
         </div>
         <div class="table-responsive">
            <table class="table align-items-center table-flush">
               <thead class="thead-light">
                  <tr>
                     <th scope="col">@lang('strings.id')</th>
                     <th scope="col">@lang('strings.name')</th>
                     <th scope="col">@lang('strings.node')</th>
                     <th scope="col" class="d-none d-lg-table-cell">@lang('strings.memory')</th>
                     <th scope="col" class="d-none d-lg-table-cell">@lang('strings.cpu')</th>
                     <th scope="col" class="d-none d-lg-table-cell">Disk</th>
                     <th scope="col">@lang('strings.connection')</th>
                     <th scope="col">@lang('strings.relation')</th>
                     <th scope="col">@lang('strings.status')</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($servers as $server)
                      <tr class="dynamic-update" data-server="{{ $server->uuidShort }}">
                         <td><code>{{ $server->uuidShort }}</code></td>
                         <td>
                           <a href="{{ route('server.index', $server->uuidShort) }}">{{ $server->name }}</a>
                           @if(!empty($server->description))
                           <br>
                           <span class="text-muted">{{ str_limit($server->description, 400) }}</span>
                           @endif
                         </td>
                         <td>{{ $server->getRelation('node')->name }}</td>
                         <td class="d-none d-lg-table-cell"><span data-action="memory">0</span> / {{ $server->memory === 0 ? '∞' : $server->memory }} MB</td>
                         <td class="d-none d-lg-table-cell"><span data-action="cpu" data-cpumax="{{ $server->cpu }}">0</span>%</td>
                         <td class="d-none d-lg-table-cell"><span data-action="disk">0</span> / {{ $server->disk === 0 ? '∞' : $server->disk }} MB</td>
                         <td>
                             <code>{{ $server->getRelation('allocation')->alias }}:{{ $server->getRelation('allocation')->port }}</code>
                        </td>
                         <td>
                            @if($server->user->id === Auth::user()->id)
                                <span class="badge badge-pill badge-primary">@lang('strings.owner')</span>
                            @elseif(Auth::user()->root_admin)
                                <span class="badge badge-pill badge-danger">@lang('strings.admin')</span>
                            @else
                                <span class="badge badge-pill badge-info">@lang('strings.subuser')</span>
                            @endif
                         </td>
                         @if($server->node->maintenance_mode)
                            <td ><span class="badge badge-dot"> <i class="bg-warning"></i> Maintenance </span></td>
                         @else
                            <td data-action="status"><span class="badge badge-dot"> <i class="bg-default"></i> Retrieving </span></td>
                         @endif
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
    {!! Theme::js('js/frontend/serverlist.js') !!}
@endsection
