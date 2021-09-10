{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.admin')

@section('title')
    Server — {{ $server->name }}: Build Details
@endsection

@section('content-header')
    <h1>{{ $server->name }}<small>Control allocations and system resources for this server.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li><a href="{{ route('admin.servers') }}">Servers</a></li>
        <li><a href="{{ route('admin.servers.view', $server->id) }}">{{ $server->name }}</a></li>
        <li class="active">Build Configuration</li>
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
                <a class="nav-link mb-sm-3 mb-md-0 active" href="{{ route('admin.servers.view.build', $server->id) }}" role="tab">Build Configuration</a>
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
    <form action="{{ route('admin.servers.view.build', $server->id) }}" method="POST">
      <div class="row align-items-start">
        <div class="col-lg-5">
            <div class="card shadow mb-cs">
                <div class="card-header border-transparent">
                   <div class="row align-items-center">
                      <div class="col">
                         <h3 class="mb-0">System Resources</h3>
                      </div>
                   </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="memory" class="control-label">Allocated Memory</label>
                        <div class="input-group">
                            <input type="text" name="memory" data-multiplicator="true" class="form-control" value="{{ old('memory', $server->memory) }}"/>
                            <div class="input-group-append">
                               <span class="input-group-text">MB</span>
                            </div>
                        </div>
                        <p class="text-muted small">The maximum amount of memory allowed for this container. Setting this to <code>0</code> will allow unlimited memory in a container.</p>
                    </div>
                    <div class="form-group">
                        <label for="swap" class="control-label">Allocated Swap</label>
                        <div class="input-group">
                            <input type="text" name="swap" data-multiplicator="true" class="form-control" value="{{ old('swap', $server->swap) }}"/>
                            <div class="input-group-append">
                               <span class="input-group-text">MB</span>
                            </div>
                        </div>
                        <p class="text-muted small">Setting this to <code>0</code> will disable swap space on this server. Setting to <code>-1</code> will allow unlimited swap.</p>
                    </div>
                    <div class="form-group">
                        <label for="cpu" class="control-label">CPU Limit</label>
                        <div class="input-group">
                            <input type="text" name="cpu" class="form-control" value="{{ old('cpu', $server->cpu) }}"/>
                            <div class="input-group-append">
                               <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <p class="text-muted small">Each <em>physical</em> core on the system is considered to be <code>100%</code>. Setting this value to <code>0</code> will allow a server to use CPU time without restrictions.</p>
                    </div>
                    <div class="form-group">
                        <label for="io" class="control-label">Block IO Proportion</label>
                        <div>
                            <input type="text" name="io" class="form-control" value="{{ old('io', $server->io) }}"/>
                        </div>
                        <p class="text-muted small">Changing this value can have negative effects on all containers on the system. We strongly recommend leaving this value as <code>500</code>.</p>
                    </div>
                    <div class="form-group">
                        <label for="cpu" class="control-label">Disk Space Limit</label>
                        <div class="input-group">
                            <input type="text" name="disk" class="form-control" value="{{ old('disk', $server->disk) }}"/>
                            <div class="input-group-append">
                               <span class="input-group-text">MB</span>
                            </div>
                        </div>
                        <p class="text-muted small">This server will not be allowed to boot if it is using more than this amount of space. If a server goes over this limit while running it will be safely stopped and locked until enough space is available.</p>
                    </div>
                    <div class="form-group">
                        <label for="cpu" class="control-label">OOM Killer</label>
                        <div class="mb-1">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="pOomKillerEnabled" value="0" name="oom_disabled" @if(!$server->oom_disabled)checked @endif>
                                <label class="custom-control-label" for="pOomKillerEnabled">Enabled</label>
                            </div>
                            <div class="custom-control custom-radio" style="padding-left: 2.75rem;">
                                <input class="custom-control-input" type="radio" id="pOomKillerDisabled" value="1" name="oom_disabled" @if($server->oom_disabled)checked @endif>
                                <label class="custom-control-label" for="pOomKillerDisabled">Disabled</label>
                            </div>
                        </div>
                        <p class="text-muted small">
                            Enabling OOM killer may cause server processes to exit unexpectedly.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
                    <div class="card shadow mb-cs">
                        <div class="card-header border-transparent">
                           <div class="row align-items-center">
                              <div class="col">
                                 <h3 class="mb-0">Application Feature Limit</h3>
                              </div>
                           </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label for="cpu" class="control-label">Database Limit</label>
                                    <div>
                                        <input type="text" name="database_limit" class="form-control" value="{{ old('database_limit', $server->database_limit) }}"/>
                                    </div>
                                    <p class="text-muted small">The total number of databases a user is allowed to create for this server. Leave blank to allow unlimited.</p>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="cpu" class="control-label">Allocation Limit</label>
                                    <div>
                                        <input type="text" name="allocation_limit" class="form-control" value="{{ old('allocation_limit', $server->allocation_limit) }}"/>
                                    </div>
                                    <p class="text-muted small"><strong>This feature is not currently implemented.</strong> The total number of allocations a user is allowed to create for this server. Leave blank to allow unlimited.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow mb-cs">
                        <div class="card-header border-transparent">
                           <div class="row align-items-center">
                              <div class="col">
                                 <h3 class="mb-0">Allocation Management</h3>
                              </div>
                           </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="pAllocation" class="control-label">Game Port</label>
                                <select id="pAllocation" name="allocation_id" class="form-control">
                                    @foreach ($assigned as $assignment)
                                        <option value="{{ $assignment->id }}"
                                            @if($assignment->id === $server->allocation_id)
                                                selected="selected"
                                            @endif
                                        >{{ $assignment->alias }}:{{ $assignment->port }}</option>
                                    @endforeach
                                </select>
                                <p class="text-muted small">The default connection address that will be used for this game server.</p>
                            </div>
                            <div class="form-group">
                                <label for="pAddAllocations" class="control-label">Assign Additional Ports</label>
                                <div>
                                    <select name="add_allocations[]" class="form-control" multiple id="pAddAllocations">
                                        @foreach ($unassigned as $assignment)
                                            <option value="{{ $assignment->id }}">{{ $assignment->alias }}:{{ $assignment->port }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <p class="text-muted small">Please note that due to software limitations you cannot assign identical ports on different IPs to the same server.</p>
                            </div>
                            <div class="form-group">
                                <label for="pRemoveAllocations" class="control-label">Remove Additional Ports</label>
                                <div>
                                    <select name="remove_allocations[]" class="form-control" multiple id="pRemoveAllocations">
                                        @foreach ($assigned as $assignment)
                                            <option value="{{ $assignment->id }}">{{ $assignment->alias }}:{{ $assignment->port }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <p class="text-muted small">Simply select which ports you would like to remove from the list above. If you want to assign a port on a different IP that is already in use you can select it from the left and delete it here.</p>
                            </div>
                        </div>
                        <div class="card-footer">
                            {!! csrf_field() !!}
                            <button type="submit" class="btn btn-sm btn-primary pull-right">Update Build Configuration</button>
                        </div>
                    </div>
        </div>
      </div>
    </form>
@endsection

@section('footer-scripts')
    @parent
    <script>
    $('#pAddAllocations').select2();
    $('#pRemoveAllocations').select2();
    $('#pAllocation').select2();
    </script>
@endsection
