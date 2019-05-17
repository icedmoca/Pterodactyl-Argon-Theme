{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.master')

@section('title')
@lang('server.schedule.header')
@endsection

@section('content-header')
<h1>@lang('server.schedule.header')<small>@lang('server.schedule.header_sub')</small></h1>
<ol class="breadcrumb">
   <li><a href="{{ route('index') }}">@lang('strings.home')</a></li>
   <li><a href="{{ route('server.index', $server->uuidShort) }}">{{ $server->name }}</a></li>
   <li class="active">@lang('navigation.server.schedules')</li>
</ol>
@endsection

@section('content')
<div class="row mt--7">
   <div class="col-lg-12">
      <div class="card shadow">
         <div class="card-header border-0">
            <div class="row align-items-center">
               <div class="col">
                  <h3 class="mb-0">@lang('server.schedule.current')</h3>
               </div>
               <div class="col text-right">
                  <a href="{{ route('server.schedules.new', $server->uuidShort) }}" class="btn btn-sm btn-primary">Create New</a>
               </div>
            </div>
         </div>
         <div class="table-responsive">
            <table class="table align-items-center table-flush">
               <thead class="thead-light">
                  <tr>
                     <th scope="col">@lang('strings.name')</th>
                     <th scope="col">@lang('strings.queued')</th>
                     <th scope="col">@lang('strings.tasks')</th>
                     <th scope="col">@lang('strings.last_run')</th>
                     <th scope="col">@lang('strings.next_run')</th>
                     <th scope="col"></th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($schedules as $schedule)
                  <tr @if(! $schedule->is_active)class="muted muted-hover"@endif>
                  <td class="middle">
                     @can('edit-schedule', $server)
                     <a href="{{ route('server.schedules.view', ['server' => $server->uuidShort, '$schedule' => $schedule->hashid]) }}">
                     {{ $schedule->name ?? trans('server.schedule.unnamed') }}
                     </a>
                     @else
                     {{ $schedule->name ?? trans('server.schedule.unnamed') }}
                     @endcan
                  </td>
                  <td class="middle">
                     @if ($schedule->is_processing)
                     <span class="label label-success">@lang('strings.yes')</span>
                     @else
                     <span class="label label-default">@lang('strings.no')</span>
                     @endif
                  </td>
                  <td class="middle"><span class="label label-primary">{{ $schedule->tasks_count }}</span></td>
                  <td class="middle">
                     @if($schedule->last_run_at)
                     {{ Carbon::parse($schedule->last_run_at)->toDayDateTimeString() }}<br /><span class="text-muted small">({{ Carbon::parse($schedule->last_run_at)->diffForHumans() }})</span>
                     @else
                     <em class="text-muted">@lang('strings.not_run_yet')</em>
                     @endif
                  </td>
                  <td class="middle">
                     @if($schedule->is_active)
                     {{ Carbon::parse($schedule->next_run_at)->toDayDateTimeString() }}<br /><span class="text-muted small">({{ Carbon::parse($schedule->next_run_at)->diffForHumans() }})</span>
                     @else
                     <em>n/a</em>
                     @endif
                  </td>
                  <td class="middle">
                     @can('delete-schedule', $server)
                     <a class="btn btn-sm btn-danger" href="#" data-action="delete-schedule" data-schedule-id="{{ $schedule->hashid }}" data-toggle="tooltip" data-placement="top" title="@lang('strings.delete')"><i class="fas fa-fw fa-trash"></i></a>
                     @endcan
                     @can('toggle-schedule', $server)
                     <a class="btn btn-sm btn-primary" href="#" data-action="toggle-schedule" data-active="{{ $schedule->active }}" data-schedule-id="{{ $schedule->hashid }}" data-toggle="tooltip" data-placement="top" title="@lang('server.schedule.toggle')"><i class="fas fa-fw fa-eye-slash"></i></a>
                     <a class="btn btn-sm btn-success" href="#" data-action="trigger-schedule" data-schedule-id="{{ $schedule->hashid }}" data-toggle="tooltip" data-placement="top" title="@lang('server.schedule.run_now')"><i class="fas fa-fw fa-sync"></i></a>
                     @endcan
                  </td>
                  </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>
@endsection

@section('footer-scripts')
@parent
{!! Theme::js('js/frontend/server.socket.js') !!}
{!! Theme::js('js/frontend/tasks/management-actions.js') !!}
@endsection
