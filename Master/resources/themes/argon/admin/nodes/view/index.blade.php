{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.admin')

@section('title')
    {{ $node->name }}
@endsection

@section('content-header')
    <h1>{{ $node->name }}<small>A quick overview of your node.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li><a href="{{ route('admin.nodes') }}">Nodes</a></li>
        <li class="active">{{ $node->name }}</li>
    </ol>
@endsection

@section('content')
<div class="row mt--7 mb-cs">
   <div class="col-lg-12">
      <div class="card shadow bg-secondary">
        <div class="card-body bg-secondary" style="padding: 0.75rem">
          <ul class="nav nav-pills nav-fill flex-column flex-sm-row" id="tabs-text" role="tablist">
             <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0 active" href="{{ route('admin.nodes.view', $node->id) }}" role="tab">About</a>
             </li>
             <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0" href="{{ route('admin.nodes.view.settings', $node->id) }}" role="tab">Settings</a>
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
<div class="row">
    <div class="col-lg-8 mb-cs">
        <div class="row">
            <div class="col-lg-12 mb-cs">
                <div class="card shadow">
                  <div class="card-header border-transparent">
                     <div class="row align-items-center">
                        <div class="col">
                           <h3 class="mb-0">Information</h3>
                        </div>
                     </div>
                  </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-items-center table-flush">
                          <tbody>
                            <tr>
                                <td>Daemon Version</td>
                                <td><code data-attr="info-version"><i class="fa fa-refresh fa-fw fa-spin"></i></code> (Latest: <code>{{ $version->getDaemon() }}</code>)</td>
                            </tr>
                            <tr>
                                <td>System Information</td>
                                <td data-attr="info-system"><i class="fa fa-refresh fa-fw fa-spin"></i></td>
                            </tr>
                            <tr>
                                <td>Total CPU Cores</td>
                                <td data-attr="info-cpus"><i class="fa fa-refresh fa-fw fa-spin"></i></td>
                            </tr>
                          <tbody>
                        </table>
                    </div>
                </div>
            </div>
            @if ($node->description)
                <div class="col-lg-12 mb-cs">
                    <div class="card shadow">
                      <div class="card-header border-transparent">
                         <div class="row align-items-center">
                            <div class="col">
                               <h3 class="mb-0">Description</h3>
                            </div>
                         </div>
                      </div>
                        <div class="card-body table-responsive">
                            <pre class="pre-alt">{{ $node->description }}</pre>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-lg-12">
                <div class="card shadow">
                  <div class="card-header border-transparent">
                     <div class="row align-items-center">
                        <div class="col">
                           <h3 class="mb-0">Delete Node</h3>
                        </div>
                     </div>
                  </div>
                    <div class="card-body">
                        <p class="no-margin">Deleting a node is a irreversible action and will immediately remove this node from the panel. There must be no servers associated with this node in order to continue.</p>
                    </div>
                    <div class="card-footer">
                        <form action="{{ route('admin.nodes.view.delete', $node->id) }}" method="POST">
                            {!! csrf_field() !!}
                            {!! method_field('DELETE') !!}
                            <button type="submit" class="btn btn-danger btn-sm pull-right" {{ ($node->servers_count < 1) ?: 'disabled' }}>Yes, Delete This Node</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
      @if($node->maintenance_mode)
      <div class="card card-stats shadow mb-4">
         <div class="card-body">
            <div class="row">
               <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">Maintenance Mode</h5>
                  <span class="h2 font-weight-bold mb-0">Enabled</span>
               </div>
               <div class="col-auto">
                  <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                     <i class="fas fa-wrench"></i>
                  </div>
               </div>
            </div>
            <p class="mt-0 mb-0 text-muted text-sm">
               <span>&nbsp;</span>
            </p>
         </div>
      </div>
      @endif
      <div class="card card-stats shadow mb-4">
         <div class="card-body">
            <div class="row">
               <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">Disk Space Allocated</h5>
                  <span class="h2 font-weight-bold mb-0">{{ $stats['disk']['value'] }} / {{ $stats['disk']['max'] }} MB</span>
               </div>
               <div class="col-auto">
                  <div class="icon icon-shape bg-{{ $stats['disk']['css'] }} text-white rounded-circle shadow">
                     <i class="fas fa-hdd"></i>
                  </div>
               </div>
            </div>
            <p class="mt-0 mb-0 text-muted text-sm">
               <span>Measured in Megabytes</span>
            </p>
         </div>
      </div>
      <div class="card card-stats shadow mb-4">
         <div class="card-body">
            <div class="row">
               <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">Memory Allocated</h5>
                  <span class="h2 font-weight-bold mb-0">{{ $stats['memory']['value'] }} / {{ $stats['memory']['max'] }} MB</span>
               </div>
               <div class="col-auto">
                  <div class="icon icon-shape bg-{{ $stats['memory']['css'] }} text-white rounded-circle shadow">
                     <i class="fas fa-memory"></i>
                  </div>
               </div>
            </div>
            <p class="mt-0 mb-0 text-muted text-sm">
               <span>Measured in Megabytes</span>
            </p>
         </div>
      </div>
      <div class="card card-stats shadow mb-4">
         <div class="card-body">
            <div class="row">
               <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">Total Servers</h5>
                  <span class="h2 font-weight-bold mb-0">{{ $node->servers_count }}</span>
               </div>
               <div class="col-auto">
                  <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                     <i class="fas fa-memory"></i>
                  </div>
               </div>
            </div>
            <p class="mt-0 mb-0 text-muted text-sm">
               <span>&nbsp;</span>
            </p>
         </div>
      </div>
    </div>
</div>
@endsection

@section('footer-scripts')
    @parent
    <script>
    (function getInformation() {
        $.ajax({
            method: 'GET',
            url: '{{ $node->scheme }}://{{ $node->fqdn }}:{{ $node->daemonListen }}/v1',
            timeout: 5000,
            headers: {
                'X-Access-Token': '{{ $node->daemonSecret }}'
            },
        }).done(function (data) {
            $('[data-attr="info-version"]').html(data.version);
            $('[data-attr="info-system"]').html(data.system.type + '(' + data.system.arch + ') <code>' + data.system.release + '</code>');
            $('[data-attr="info-cpus"]').html(data.system.cpus);
        }).fail(function (jqXHR) {

        }).always(function() {
            setTimeout(getInformation, 10000);
        });
    })();
    </script>
@endsection
