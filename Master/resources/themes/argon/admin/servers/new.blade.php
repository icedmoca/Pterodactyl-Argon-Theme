{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.admin')

@section('title')
    New Server
@endsection

@section('content-header')
    <h1>Create Server<small>Add a new server to the panel.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li><a href="{{ route('admin.servers') }}">Servers</a></li>
        <li class="active">Create Server</li>
    </ol>
@endsection

@section('content')
<form action="{{ route('admin.servers.new') }}" method="POST">
    <div class="row mt--7 mb-cs">
        <div class="col-lg-12">
            <div class="card shadow">
              <div class="card-header border-transparent">
                 <div class="row align-items-center">
                    <div class="col">
                       <h3 class="mb-0">Core Details</h3>
                    </div>
                 </div>
              </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pName">Server Name</label>
                            <input type="text" class="form-control" id="pName" name="name" value="{{ old('name') }}" placeholder="Server Name">
                            <p class="small text-muted no-margin">Character limits: <code>a-z A-Z 0-9 _ - .</code> and <code>[Space]</code> (max 200 characters).</p>
                        </div>
                        <div class="form-group">
                            <label for="pUserId">Server Owner</label>
                            <select class="form-control" style="padding-left:0;" name="owner_id" id="pUserId"></select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="description" class="control-label">Server Description</label>
                            <textarea name="description" rows="3" class="form-control">{{ old('description') }}</textarea>
                            <p class="text-muted small">A brief description of this server.</p>
                        </div>
                        <div class="form-group mb-0" style="margin-top: 2.25rem;">
                            <div class="custom-control custom-checkbox no-margin-bottom">
                                <input class="custom-control-input" id="pStartOnCreation" name="start_on_completion" type="checkbox" value="1" checked />
                                <label class="custom-control-label" for="pStartOnCreation" class="strong">Start Server when Installed</label>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-cs">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="overlay" id="allocationLoader" style="display:none;"><i class="fas fa-sync fa-spin"></i></div>
                <div class="card-header border-transparent">
                   <div class="row align-items-center">
                      <div class="col">
                         <h3 class="mb-0">Allocation Management</h3>
                      </div>
                   </div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-sm-4">
                        <label for="pNodeId">Node</label>
                        <select name="node_id" id="pNodeId" class="form-control">
                            @foreach($locations as $location)
                                <optgroup label="{{ $location->long }} ({{ $location->short }})">
                                @foreach($location->nodes as $node)

                                <option value="{{ $node->id }}"
                                    @if($location->id === old('location_id')) selected @endif
                                >{{ $node->name }}</option>

                                @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        <p class="small text-muted no-margin">The node which this server will be deployed to.</p>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="pAllocation">Default Allocation</label>
                        <select name="allocation_id" id="pAllocation" class="form-control"></select>
                        <p class="small text-muted no-margin">The main allocation that will be assigned to this server.</p>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="pAllocationAdditional">Additional Allocation(s)</label>
                        <select name="allocation_additional[]" id="pAllocationAdditional" class="form-control" multiple></select>
                        <p class="small text-muted no-margin">Additional allocations to assign to this server on creation.</p>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-cs">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="overlay" id="allocationLoader" style="display:none;"><i class="fa fa-refresh fa-spin"></i></div>
                <div class="card-header border-transparent">
                   <div class="row align-items-center">
                      <div class="col">
                         <h3 class="mb-0">Application Feature Limits</h3>
                      </div>
                   </div>
                </div>
                <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="cpu" class="control-label">Database Limit</label>
                        <div>
                            <input type="text" name="database_limit" class="form-control" value="{{ old('database_limit', 0) }}"/>
                        </div>
                        <p class="text-muted small">The total number of databases a user is allowed to create for this server. Leave blank to allow unlimited.</p>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="cpu" class="control-label">Allocation Limit</label>
                        <div>
                            <input type="text" name="allocation_limit" class="form-control" value="{{ old('allocation_limit', 0) }}"/>
                        </div>
                        <p class="text-muted small">The total number of allocations a user is allowed to create for this server. Leave blank to allow unlimited.</p>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-cs">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-header border-transparent">
                   <div class="row align-items-center">
                      <div class="col">
                         <h3 class="mb-0">Resource Management</h3>
                      </div>
                   </div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-sm-4">
                        <label for="pMemory">Memory</label>
                        <div class="input-group">
                            <input type="text" value="{{ old('memory') }}" class="form-control" name="memory" id="pMemory" />
                            <div class="input-group-append">
                               <span class="input-group-text">MB</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="pSwap">Swap</label>
                        <div class="input-group">
                            <input type="text" value="{{ old('swap', 0) }}" class="form-control" name="swap" id="pSwap" />
                            <div class="input-group-append">
                               <span class="input-group-text">MB</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <p class="text-muted small">If you do not want to assign swap space to a server, simply put <code>0</code> for the value, or <code>-1</code> to allow unlimited swap space. If you want to disable memory limiting on a server, simply enter <code>0</code> into the memory field.<p>
                    </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-sm-4">
                          <label for="pDisk">Disk Space</label>
                          <div class="input-group">
                              <input type="text" class="form-control" value="{{ old('disk') }}" name="disk" id="pDisk" />
                              <div class="input-group-append">
                                 <span class="input-group-text">MB</span>
                              </div>
                          </div>
                      </div>
                      <div class="form-group col-sm-4">
                          <label for="pCPU">CPU Limit</label>
                          <div class="input-group">
                              <input type="text" class="form-control" value="{{ old('cpu', 0) }}" name="cpu" id="pCPU" />
                              <div class="input-group-append">
                                 <span class="input-group-text">%</span>
                              </div>
                          </div>
                      </div>
                      <div class="form-group col-sm-4">
                          <label for="pIO">Block IO Weight</label>
                          <div class="input-group">
                              <input type="text" class="form-control" value="{{ old('io', 500) }}" name="io" id="pIO" />
                              <div class="input-group-append">
                                 <span class="input-group-text">I/O</span>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <p class="text-muted small mb-0">If you do not want to limit CPU usage, set the value to <code>0</code>. To determine a value, take the number of <em>physical</em> cores and multiply it by 100. For example, on a quad core system <code>(4 * 100 = 400)</code> there is <code>400%</code> available. To limit a server to using half of a single core, you would set the value to <code>50</code>. To allow a server to use up to two physical cores, set the value to <code>200</code>. BlockIO should be a value between <code>10</code> and <code>1000</code>. Please see <a href="https://docs.docker.com/engine/reference/run/#/block-io-bandwidth-blkio-constraint" target="_blank">this documentation</a> for more information about it.<p>
                      </div>
                      </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-cs">
            <div class="card shadow">
                <div class="card-header border-transparent">
                   <div class="row align-items-center">
                      <div class="col">
                         <h3 class="mb-0">Nest Configuration</h3>
                      </div>
                   </div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-md-12">
                        <label for="pNestId">Nest</label>
                        <select name="nest_id" id="pNestId" class="form-control">
                            @foreach($nests as $nest)
                                <option value="{{ $nest->id }}"
                                    @if($nest->id === old('nest_id'))
                                        selected="selected"
                                    @endif
                                >{{ $nest->name }}</option>
                            @endforeach
                        </select>
                        <p class="small text-muted m-0">Select the Nest that this server will be grouped under.</p>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="pEggId">Egg</label>
                        <select name="egg_id" id="pEggId" class="form-control"></select>
                        <p class="small text-muted m-0">Select the Egg that will define how this server should operate.</p>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="pPackId">Data Pack</label>
                        <select name="pack_id" id="pPackId" class="form-control"></select>
                        <p class="small text-muted m-0">Select a data pack to be automatically installed on this server when first created.</p>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="custom-control custom-checkbox mb-0">
                            <input class="custom-control-input" id="pSkipScripting" name="skip_scripts" type="checkbox" value="1" />
                            <label class="custom-control-label" for="pSkipScripting" class="strong">Skip Egg Install Script</label>
                        </div>
                        <p class="small text-muted m-0">If the selected Egg has an install script attached to it, the script will run during install after the pack is installed. If you would like to skip this step, check this box.</p>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header border-transparent">
                   <div class="row align-items-center">
                      <div class="col">
                         <h3 class="mb-0">Docker Configuration</h3>
                      </div>
                   </div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-md-12">
                        <label for="pDefaultContainer">Docker Image</label>
                        <input id="pDefaultContainer" name="image" value="{{ old('image') }}" class="form-control" />
                        <p class="small text-muted m-0">This is the default Docker image that will be used to run this server.</p>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-cs">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header border-transparent">
                   <div class="row align-items-center">
                      <div class="col">
                         <h3 class="mb-0">Startup Configuration</h3>
                      </div>
                   </div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-lg-12">
                        <label for="pStartup">Startup Command</label>
                        <input type="text" id="pStartup" value="{{ old('startup') }}" class="form-control" name="startup" />
                        <p class="small text-muted no-margin">The following data substitutes are available for the startup command: <code>@{{SERVER_MEMORY}}</code>, <code>@{{SERVER_IP}}</code>, and <code>@{{SERVER_PORT}}</code>. They will be replaced with the allocated memory, server IP, and server port respectively.</p>
                    </div>
                    </div>
                </div>
                <div class="card-header border-transparent mt--5">
                   <div class="row align-items-center">
                      <div class="col">
                         <h3 class="mb-0">Service Variables</h3>
                      </div>
                   </div>
                </div>
                <div class="card-body">
                <div class="row" id="appendVariablesTo">
                  </div>
                </div>
                <div class="card-footer">
                    {!! csrf_field() !!}
                    <input type="submit" class="btn btn-sm btn-success pull-right" value="Create Server" />
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('footer-scripts')
    @parent
    {!! Theme::js('vendor/lodash/lodash.js') !!}
    {!! Theme::js('js/admin/new-server.js') !!}
@endsection
