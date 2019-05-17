{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}
{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}

@extends('layouts.admin')

@section('title')
{{ $node->name }}: Settings
@endsection

@section('content-header')
<h1>{{ $node->name }}<small>Configure your node settings.</small></h1>
<ol class="breadcrumb">
   <li><a href="{{ route('admin.index') }}">Admin</a></li>
   <li><a href="{{ route('admin.nodes') }}">Nodes</a></li>
   <li><a href="{{ route('admin.nodes.view', $node->id) }}">{{ $node->name }}</a></li>
   <li class="active">Settings</li>
</ol>
@endsection

@section('content')
<div class="row mt--7 mb-cs">
   <div class="col-lg-12">
      <div class="card shadow bg-secondary">
         <div class="card-body bg-secondary" style="padding: 0.75rem">
            <ul class="nav nav-pills nav-fill flex-column flex-sm-row" id="tabs-text" role="tablist">
               <li class="nav-item">
                  <a class="nav-link mb-sm-3 mb-md-0" href="{{ route('admin.nodes.view', $node->id) }}" role="tab">About</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link mb-sm-3 mb-md-0 active" href="{{ route('admin.nodes.view.settings', $node->id) }}" role="tab">Settings</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link mb-sm-3 mb-md-0" href="{{ route('admin.nodes.view.configuration', $node->id) }}" role="tab">Configuration</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link mb-sm-3 mb-md-0" href="{{ route('admin.nodes.view.allocation', $node->id) }}" role="tab">Allocation</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link mb-sm-3 mb-md-0" href="{{ route('admin.nodes.view.servers', $node->id) }}" role="tab">Servers</a>
               </li>
            </ul>
         </div>
      </div>
   </div>
</div>
<form action="{{ route('admin.nodes.view.settings', $node->id) }}" method="POST">
   <div class="row align-items-start">
     <div class="col-lg-6">
        <div class="card shadow mb-cs">
           <div class="card-header border-transparent">
              <div class="row align-items-center">
                 <div class="col">
                    <h3 class="mb-0">Settings</h3>
                 </div>
              </div>
           </div>
           <div class="card-body">
              <div class="form-group">
                 <label for="name" class="control-label">Node Name</label>
                 <div>
                    <input type="text" autocomplete="off" name="name" class="form-control" value="{{ old('name', $node->name) }}" />
                    <p class="text-muted"><small>Character limits: <code>a-zA-Z0-9_.-</code> and <code>[Space]</code> (min 1, max 100 characters).</small></p>
                 </div>
              </div>
              <div class="form-group">
                 <label for="description" class="control-label">Description</label>
                 <div>
                    <textarea name="description" id="description" rows="4" class="form-control">{{ $node->description }}</textarea>
                 </div>
              </div>
              <div class="form-group">
                 <label for="name" class="control-label">Location</label>
                 <div>
                    <select name="location_id" class="form-control">
                    @foreach($locations as $location)
                    <option value="{{ $location->id }}" {{ (old('location_id', $node->location_id) === $location->id) ? 'selected' : '' }}>{{ $location->long }} ({{ $location->short }})</option>
                    @endforeach
                    </select>
                 </div>
              </div>
              <div class="form-group">
                 <label for="public" class="control-label">Allow Automatic Allocation <sup><a data-toggle="tooltip" data-placement="top" title="Allow automatic allocation to this Node?">?</a></sup></label>
                 <div class="mb-1">
                   <div class="custom-control custom-radio">
                      <input class="custom-control-input" type="radio" id="public_1" value="1" name="public" {{ (old('public', $node->public) == true) ? 'checked' : '' }}>
                      <label class="custom-control-label" for="public_1">Yes</label>
                   </div>
                   <div class="custom-control custom-radio" style="padding-left: 2.75rem;">
                      <input class="custom-control-input" type="radio"  id="public_0" value="0" name="public" {{ (old('public', $node->public) == false) ? 'checked' : '' }}>
                      <label class="custom-control-label" for="public_0">No</label>
                   </div>
                 </div>
              </div>
              <div class="form-group">
                 <label for="fqdn" class="control-label">Fully Qualified Domain Name</label>
                 <div>
                    <input type="text" autocomplete="off" name="fqdn" class="form-control" value="{{ old('fqdn', $node->fqdn) }}" />
                 </div>
                 <p class="text-muted"><small>Please enter domain name (e.g <code>node.example.com</code>) to be used for connecting to the daemon. An IP address may only be used if you are not using SSL for this node.
                    <a tabindex="0" data-toggle="popover" data-trigger="focus" title="Why do I need a FQDN?" data-content="In order to secure communications between your server and this node we use SSL. We cannot generate a SSL certificate for IP Addresses, and as such you will need to provide a FQDN.">Why?</a>
                    </small>
                 </p>
              </div>
              <div class="form-group">
                 <label class="form-label"><span class="badge badge-warning"><i class="fa fa-power-off"></i></span> Communicate Over SSL</label>
                 <div class="mb-1">
                    <div class="custom-control custom-radio">
                       <input class="custom-control-input" type="radio" id="pSSLTrue" value="https" name="scheme" {{ (old('scheme', $node->scheme) === 'https') ? 'checked' : '' }}>
                       <label class="custom-control-label" for="pSSLTrue"> Use SSL Connection</label>
                    </div>
                    <div class="custom-control custom-radio" style="padding-left: 2.75rem;">
                       <input class="custom-control-input" type="radio" id="pSSLFalse" value="http" name="scheme" {{ (old('scheme', $node->scheme) !== 'https') ? 'checked' : '' }}>
                       <label class="custom-control-label" for="pSSLFalse"> Use HTTP Connection</label>
                    </div>
                 </div>
                 <p class="text-muted small">In most cases you should select to use a SSL connection. If using an IP Address or you do not wish to use SSL at all, select a HTTP connection.</p>
              </div>
              <div class="form-group">
                 <label class="form-label"><span class="badge badge-warning"><i class="fa fa-power-off"></i></span> Behind Proxy</label>
                 <div class="mb-1">
                    <div class="custom-control custom-radio">
                       <input class="custom-control-input" type="radio" id="pProxyFalse" value="0" name="behind_proxy" {{ (old('behind_proxy', $node->behind_proxy) == false) ? 'checked' : '' }}>
                       <label class="custom-control-label" for="pProxyFalse"> Not Behind Proxy </label>
                    </div>
                    <div class="custom-control custom-radio" style="padding-left: 2.75rem;">
                       <input class="custom-control-input" type="radio" id="pProxyTrue" value="1" name="behind_proxy" {{ (old('behind_proxy', $node->behind_proxy) == true) ? 'checked' : '' }}>
                       <label class="custom-control-label" for="pProxyTrue"> Behind Proxy </label>
                    </div>
                 </div>
                 <p class="text-muted small">If you are running the daemon behind a proxy such as Cloudflare, select this to have the daemon skip looking for certificates on boot.</p>
              </div>
              <div class="form-group">
                 <label class="form-label"><span class="badge badge-warning"><i class="fa fa-wrench"></i></span> Maintenance Mode</label>
                 <div class="mb-1">
                    <div class="custom-control custom-radio">
                       <input class="custom-control-input" type="radio" id="pMaintenanceFalse" value="0" name="maintenance_mode" {{ (old('behind_proxy', $node->maintenance_mode) == false) ? 'checked' : '' }}>
                       <label class="custom-control-label" for="pMaintenanceFalse"> Disabled</label>
                    </div>
                    <div class="custom-control custom-radio" style="padding-left: 2.75rem;">
                       <input class="custom-control-input" type="radio" id="pMaintenanceTrue" value="1" name="maintenance_mode" {{ (old('behind_proxy', $node->maintenance_mode) == true) ? 'checked' : '' }}>
                       <label class="custom-control-label" for="pMaintenanceTrue"> Enabled</label>
                    </div>
                 </div>
                 <p class="text-muted small">If the node is marked as 'Under Maintenance' users won't be able to access servers that are on this node.</p>
              </div>
           </div>
        </div>
     </div>
     <div class="col-lg-6">
  <div class="card shadow mb-cs">
     <div class="card-header border-transparent">
        <div class="row align-items-center">
           <div class="col">
              <h3 class="mb-0">Allocation Limits</h3>
           </div>
        </div>
     </div>
     <div class="card-body">
        <div class="row">
           <div class="form-group col-lg-6">
              <label for="memory" class="control-label">Total Memory</label>
              <div class="input-group">
                 <input type="text" name="memory" class="form-control" data-multiplicator="true" value="{{ old('memory', $node->memory) }}"/>
                 <div class="input-group-append">
                    <span class="input-group-text">MB</span>
                 </div>
              </div>
           </div>
           <div class="form-group col-lg-6">
              <label for="memory_overallocate" class="control-label">Overallocate</label>
              <div class="input-group">
                 <input type="text" name="memory_overallocate" class="form-control" value="{{ old('memory_overallocate', $node->memory_overallocate) }}"/>
                 <div class="input-group-append">
                    <span class="input-group-text">%</span>
                 </div>
              </div>
           </div>
           <div class="col-md-12">
              <p class="text-muted small">Enter the total amount of memory available on this node for allocation to servers. You may also provide a percentage that can allow allocation of more than the defined memory.</p>
           </div>
        </div>
        <div class="row">
           <div class="form-group col-lg-6">
              <label for="disk" class="control-label">Disk Space</label>
              <div class="input-group">
                 <input type="text" name="disk" class="form-control" data-multiplicator="true" value="{{ old('disk', $node->disk) }}"/>
                 <div class="input-group-append">
                    <span class="input-group-text">MB</span>
                 </div>
              </div>
           </div>
           <div class="form-group col-lg-6">
              <label for="disk_overallocate" class="control-label">Overallocate</label>
              <div class="input-group">
                 <input type="text" name="disk_overallocate" class="form-control" value="{{ old('disk_overallocate', $node->disk_overallocate) }}"/>
                 <div class="input-group-append">
                    <span class="input-group-text">%</span>
                 </div>
              </div>
           </div>
           <div class="col-md-12">
              <p class="text-muted small">Enter the total amount of disk space available on this node for server allocation. You may also provide a percentage that will determine the amount of disk space over the set limit to allow.</p>
           </div>
        </div>
     </div>
  </div>
  <div class="card shadow mb-cs">
     <div class="card-header border-transparent">
        <div class="row align-items-center">
           <div class="col">
              <h3 class="mb-0">General Configuration</h3>
           </div>
        </div>
     </div>
     <div class="card-body">
        <div class="row">
           <div class="form-group col-lg-12">
              <label for="disk_overallocate" class="control-label">Maximum Web Upload Filesize</label>
              <div class="input-group">
                 <input type="text" name="upload_size" class="form-control" value="{{ old('upload_size', $node->upload_size) }}"/>
                 <div class="input-group-append">
                    <span class="input-group-text">MB</span>
                 </div>
              </div>
              <p class="text-muted"><small>Enter the maximum size of files that can be uploaded through the web-based file manager.</small></p>
           </div>
        </div>
        <div class="row">
           <div class="form-group col-lg-6">
              <label for="daemonListen" class="control-label"><span class="badge badge-warning"><i class="fa fa-power-off"></i></span> Daemon Port</label>
              <div>
                 <input type="text" name="daemonListen" class="form-control" value="{{ old('daemonListen', $node->daemonListen) }}"/>
              </div>
           </div>
           <div class="form-group col-lg-6">
              <label for="daemonSFTP" class="control-label"><span class="badge badge-warning"><i class="fa fa-power-off"></i></span> Daemon SFTP Port</label>
              <div>
                 <input type="text" name="daemonSFTP" class="form-control" value="{{ old('daemonSFTP', $node->daemonSFTP) }}"/>
              </div>
           </div>
           <div class="col-md-12">
              <p class="text-muted"><small>The daemon runs its own SFTP management container and does not use the SSHd process on the main physical server. <Strong>Do not use the same port that you have assigned for your physical server's SSH process.</strong></small></p>
           </div>
        </div>
     </div>
  </div>
</div>
   </div>
   <div class="row align-items-start">
     <div class="col-lg-12">
       <div class="card shadow mb-cs">
          <div class="card-header border-transparent">
             <div class="row align-items-center">
                <div class="col">
                   <h3 class="mb-0">Save Settings</h3>
                </div>
             </div>
          </div>
          <div class="card-body">
            <div class="row">
             <div class="form-group col-lg-6">
                <div class="custom-control custom-checkbox">
                   <input class="custom-control-input" type="checkbox" name="reset_secret" id="reset_secret" />
                   <label class="custom-control-label" for="reset_secret" class="control-label">Reset Daemon Master Key</label>
                </div>
                <p class="text-muted"><small>Resetting the daemon master key will void any request coming from the old key. This key is used for all sensitive operations on the daemon including server creation and deletion. We suggest changing this key regularly for security.</small></p>
             </div>
             </div>
          </div>
          <div class="card-footer mt--4">
             {!! method_field('PATCH') !!}
             {!! csrf_field() !!}
             <button type="submit" class="btn btn-sm btn-primary pull-right">Save Changes</button>
          </div>
       </div>
    </div>
   </div>
</form>
@endsection

@section('footer-scripts')
@parent
<script>
   $('[data-toggle="popover"]').popover({
       placement: 'auto'
   });
   $('select[name="location_id"]').select2();
</script>
@endsection
