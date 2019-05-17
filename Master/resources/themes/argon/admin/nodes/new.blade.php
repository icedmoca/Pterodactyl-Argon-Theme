{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.admin')

@section('title')
    Nodes &rarr; New
@endsection

@section('content-header')
    <h1>New Node<small>Create a new local or remote node for servers to be installed to.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li><a href="{{ route('admin.nodes') }}">Nodes</a></li>
        <li class="active">New</li>
    </ol>
@endsection

@section('content')
<form action="{{ route('admin.nodes.new') }}" method="POST">
    <div class="row mt--7">
        <div class="col-lg-6">
            <div class="card shadow">
                <div class="card-header border-transparent">
                   <div class="row align-items-center">
                      <div class="col">
                         <h3 class="mb-0">Basic Details</h3>
                      </div>
                   </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="pName" class="form-label">Name</label>
                        <input type="text" name="name" id="pName" class="form-control" value="{{ old('name') }}"/>
                        <p class="text-muted small">Character limits: <code>a-zA-Z0-9_.-</code> and <code>[Space]</code> (min 1, max 100 characters).</p>
                    </div>
                    <div class="form-group">
                        <label for="pDescription" class="form-label">Description</label>
                        <textarea name="description" id="pDescription" rows="4" class="form-control">{{ old('description') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="pLocationId" class="form-label">Location</label>
                        <select name="location_id" id="pLocationId">
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}" {{ $location->id != old('location_id') ?: 'selected' }}>{{ $location->short }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Node Visibility</label>
                        <div class="mb-1">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="pPublicTrue" value="1" name="public" checked>
                                <label class="custom-control-label" for="pPublicTrue"> Public </label>
                            </div>
                            <div class="custom-control custom-radio" style="padding-left: 2.75rem;">
                                <input class="custom-control-input" type="radio" id="pPublicFalse" value="0" name="public">
                                <label class="custom-control-label" for="pPublicFalse"> Private </label>
                            </div>
                        </div>
                        <p class="text-muted small">By setting a node to <code>private</code> you will be denying the ability to auto-deploy to this node.
                    </div>
                    <div class="form-group">
                        <label for="pFQDN" class="form-label">FQDN</label>
                        <input type="text" name="fqdn" id="pFQDN" class="form-control" value="{{ old('fqdn') }}"/>
                        <p class="text-muted small">Please enter domain name (e.g <code>node.example.com</code>) to be used for connecting to the daemon. An IP address may be used <em>only</em> if you are not using SSL for this node.</p>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Communicate Over SSL</label>
                        <div class="mb-1">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="pSSLTrue" value="https" name="scheme" checked>
                                <label class="custom-control-label" for="pSSLTrue"> Use SSL Connection</label>
                            </div>
                            <div class="custom-control custom-radio" style="padding-left: 2.75rem;">
                                <input class="custom-control-input" type="radio" id="pSSLFalse" value="http" name="scheme" @if(request()->isSecure()) disabled @endif>
                                <label class="custom-control-label" for="pSSLFalse"> Use HTTP Connection</label>
                            </div>
                        </div>
                        @if(request()->isSecure())
                            <p class="text-danger small">Your Panel is currently configured to use a secure connection. In order for browsers to connect to your node it <strong>must</strong> use a SSL connection.</p>
                        @else
                            <p class="text-muted small">In most cases you should select to use a SSL connection. If using an IP Address or you do not wish to use SSL at all, select a HTTP connection.</p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="form-label">Behind Proxy</label>
                        <div class="mb-1">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="pProxyFalse" value="0" name="behind_proxy" checked>
                                <label class="custom-control-label" for="pProxyFalse"> Not Behind Proxy </label>
                            </div>
                            <div class="custom-control custom-radio" style="padding-left: 2.75rem;">
                                <input class="custom-control-input" type="radio" id="pProxyTrue" value="1" name="behind_proxy">
                                <label class="custom-control-label" for="pProxyTrue"> Behind Proxy </label>
                            </div>
                        </div>
                        <p class="text-muted small">If you are running the daemon behind a proxy such as Cloudflare, select this to have the daemon skip looking for certificates on boot.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow">
                <div class="card-header border-transparent">
                   <div class="row align-items-center">
                      <div class="col">
                         <h3 class="mb-0">Configuration</h3>
                      </div>
                   </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="pDaemonBase" class="form-label">Daemon Server File Directory</label>
                            <input type="text" name="daemonBase" id="pDaemonBase" class="form-control" value="/srv/daemon-data" />
                            <p class="text-muted small">Enter the directory where server files should be stored. <strong>If you use OVH you should check your partition scheme. You may need to use <code>/home/daemon-data</code> to have enough space.</strong></p>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pMemory" class="form-label">Total Memory</label>
                            <div class="input-group">
                                <input type="text" name="memory" data-multiplicator="true" class="form-control" id="pMemory" value="{{ old('memory') }}"/>
                                <div class="input-group-append">
                                   <span class="input-group-text">MB</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pMemoryOverallocate" class="form-label">Memory Over-Allocation</label>
                            <div class="input-group">
                                <input type="text" name="memory_overallocate" class="form-control" id="pMemoryOverallocate" value="{{ old('memory_overallocate') }}"/>
                                <div class="input-group-append">
                                   <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <p class="text-muted small">Enter the total amount of memory available for new servers. If you would like to allow overallocation of memory enter the percentage that you want to allow. To disable checking for overallocation enter <code>-1</code> into the field. Entering <code>0</code> will prevent creating new servers if it would put the node over the limit.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="pDisk" class="form-label">Total Disk Space</label>
                            <div class="input-group">
                                <input type="text" name="disk" data-multiplicator="true" class="form-control" id="pDisk" value="{{ old('disk') }}"/>
                                <div class="input-group-append">
                                   <span class="input-group-text">MB</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pDiskOverallocate" class="form-label">Disk Over-Allocation</label>
                            <div class="input-group">
                                <input type="text" name="disk_overallocate" class="form-control" id="pDiskOverallocate" value="{{ old('disk_overallocate') }}"/>
                                <div class="input-group-append">
                                   <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <p class="text-muted small">Enter the total amount of disk space available for new servers. If you would like to allow overallocation of disk space enter the percentage that you want to allow. To disable checking for overallocation enter <code>-1</code> into the field. Entering <code>0</code> will prevent creating new servers if it would put the node over the limit.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="pDaemonListen" class="form-label">Daemon Port</label>
                            <input type="text" name="daemonListen" class="form-control" id="pDaemonListen" value="8080" />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pDaemonSFTP" class="form-label">Daemon SFTP Port</label>
                            <input type="text" name="daemonSFTP" class="form-control" id="pDaemonSFTP" value="2022" />
                        </div>
                        <div class="col-md-12">
                            <p class="text-muted small">The daemon runs its own SFTP management container and does not use the SSHd process on the main physical server. <Strong>Do not use the same port that you have assigned for your physical server's SSH process.</strong> If you will be running the daemon behind CloudFlare&reg; you should set the daemon port to <code>8443</code> to allow websocket proxying over SSL.</p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    {!! csrf_field() !!}
                    <button type="submit" class="btn btn-success btn-sm pull-right">Create Node</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('footer-scripts')
    @parent
    <script>
        $('#pLocationId').select2();
    </script>
@endsection
