@extends('layouts.admin')
@include('partials/admin.settings.nav', ['activeTab' => 'basic'])
@section('title')
Statistics Overview
@endsection
@section('content-header')
<h1>Statistics Overview<small>Monitor your panel usage.</small></h1>
<ol class="breadcrumb">
   <li><a href="{{ route('admin.index') }}">Admin</a></li>
   <li class="active">Statistics</li>
</ol>
@endsection
@section('content')
<div class="row mt--7">
   <div class="col-lg-8 mb-cs">
      <div class="card shadow">
         <div class="card-header border-transparent">
            <div class="row align-items-center">
               <div class="col">
                  <h3 class="mb-0">System Information</h3>
               </div>
            </div>
         </div>
         <div class="card-body">
            <div class="row">
               <div class="col-lg-6">
                  <canvas id="servers_chart" width="100%" height="50"></canvas>
               </div>
               <div class="col-lg-6">
                  <canvas id="status_chart" width="100%" height="50"></canvas>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-lg-4 mb-cs">
      <div class="card card-stats shadow mb-4">
         <div class="card-body">
            <div class="row">
               <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">Servers</h5>
                  <span class="h2 font-weight-bold mb-0">{{ count($servers) }}</span>
               </div>
               <div class="col-auto">
                  <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                     <i class="fas fa-server"></i>
                  </div>
               </div>
            </div>
            <p class="mt-0 mb-0 text-muted text-sm" style="margin-top: -.19rem!important;">
               <span>&nbsp;</span>
            </p>
         </div>
      </div>
      <div class="card card-stats shadow mb-4">
         <div class="card-body">
            <div class="row">
               <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">Total used Memory</h5>
                  <span class="h2 font-weight-bold mb-0">{{ $totalServerRam }} MB</span>
               </div>
               <div class="col-auto">
                  <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                     <i class="fas fa-memory"></i>
                  </div>
               </div>
            </div>
            <p class="mt-0 mb-0 text-muted text-sm" style="margin-top: -.19rem!important;">
               <span>Measured in Megabytes</span>
            </p>
         </div>
      </div>
      <div class="card card-stats shadow mb-4">
         <div class="card-body">
            <div class="row">
               <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">Total used Disk</h5>
                  <span class="h2 font-weight-bold mb-0">{{ $totalServerDisk }} MB</span>
               </div>
               <div class="col-auto">
                  <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                     <i class="fas fa-hdd"></i>
                  </div>
               </div>
            </div>
            <p class="mt-0 mb-0 text-muted text-sm" style="margin-top: -.19rem!important;">
               <span>Measured in Megabytes</span>
            </p>
         </div>
      </div>
   </div>
</div>
<div class="row" style="padding-bottom: 0;">
   <div class="col-lg-8 mb-cs">
      <div class="card shadow">
         <div class="card-header border-transparent">
            <div class="row align-items-center">
               <div class="col">
                  <h3 class="mb-0">Nodes</h3>
               </div>
            </div>
         </div>
         <div class="card-body">
            <div class="row">
               <div class="col-lg-6">
                  <canvas id="ram_chart" width="100%" height="50"></canvas>
               </div>
               <div class="col-lg-6">
                  <canvas id="disk_chart" width="100%" height="50"></canvas>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-lg-4 mb-cs">
      <div class="card card-stats shadow mb-4">
         <div class="card-body">
            <div class="row">
               <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">Total RAM</h5>
                  <span class="h2 font-weight-bold mb-0">{{ $totalNodeRam }} MB</span>
               </div>
               <div class="col-auto">
                  <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                     <i class="fas fa-hdd"></i>
                  </div>
               </div>
            </div>
            <p class="mt-0 mb-0 text-muted text-sm" style="margin-top: -.19rem!important;">
               <span>Measured in Megabytes</span>
            </p>
         </div>
      </div>
      <div class="card card-stats shadow mb-4">
         <div class="card-body">
            <div class="row">
               <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">Total Disk Space</h5>
                  <span class="h2 font-weight-bold mb-0">{{ $totalNodeDisk }} MB</span>
               </div>
               <div class="col-auto">
                  <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                     <i class="fas fa-memory"></i>
                  </div>
               </div>
            </div>
            <p class="mt-0 mb-0 text-muted text-sm" style="margin-top: -.19rem!important;">
               <span>Measured in Megabytes</span>
            </p>
         </div>
      </div>
      <div class="card card-stats shadow mb-4">
         <div class="card-body">
            <div class="row">
               <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">Total Allocations</h5>
                  <span class="h2 font-weight-bold mb-0">{{ $totalAllocations }}</span>
               </div>
               <div class="col-auto">
                  <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                     <i class="fas fa-network-wired"></i>
                  </div>
               </div>
            </div>
            <p class="mt-0 mb-0 text-muted text-sm" style="margin-top: -.19rem!important;">
               <span>&nbsp;</span>
            </p>
         </div>
      </div>
   </div>
</div>
<div class="row">
   <div class="col-lg-3">
      <div class="card card-stats shadow mb-4">
         <div class="card-body">
            <div class="row">
               <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">Total Eggs</h5>
                  <span class="h2 font-weight-bold mb-0">{{ $eggsCount }}</span>
               </div>
               <div class="col-auto">
                  <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                     <i class="fas fa-gamepad"></i>
                  </div>
               </div>
            </div>
            <p class="mt-0 mb-0 text-muted text-sm" style="margin-top: -.19rem!important;">
               <span>&nbsp;</span>
            </p>
         </div>
      </div>
   </div>
   <div class="col-lg-3">
      <div class="card card-stats shadow mb-4">
         <div class="card-body">
            <div class="row">
               <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">Total Users</h5>
                  <span class="h2 font-weight-bold mb-0">{{ $usersCount }}</span>
               </div>
               <div class="col-auto">
                  <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                     <i class="fas fa-users"></i>
                  </div>
               </div>
            </div>
            <p class="mt-0 mb-0 text-muted text-sm" style="margin-top: -.19rem!important;">
               <span>&nbsp;</span>
            </p>
         </div>
      </div>
   </div>
   <div class="col-lg-3">
      <div class="card card-stats shadow mb-4">
         <div class="card-body">
            <div class="row">
               <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">Total Nodes</h5>
                  <span class="h2 font-weight-bold mb-0">{{ count($nodes) }}</span>
               </div>
               <div class="col-auto">
                  <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                     <i class="fas fa-server"></i>
                  </div>
               </div>
            </div>
            <p class="mt-0 mb-0 text-muted text-sm" style="margin-top: -.19rem!important;">
               <span>&nbsp;</span>
            </p>
         </div>
      </div>
   </div>
   <div class="col-lg-3">
      <div class="card card-stats shadow mb-4">
         <div class="card-body">
            <div class="row">
               <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">Total Databases</h5>
                  <span class="h2 font-weight-bold mb-0">{{ $databasesCount }}</span>
               </div>
               <div class="col-auto">
                  <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                     <i class="fas fa-database"></i>
                  </div>
               </div>
            </div>
            <p class="mt-0 mb-0 text-muted text-sm" style="margin-top: -.19rem!important;">
               <span>&nbsp;</span>
            </p>
         </div>
      </div>
   </div>
</div>
@endsection
@section('footer-scripts')
@parent
{!! Theme::js('vendor/chartjs/chart.min.js') !!}
{!! Theme::js('js/admin/statistics.js') !!}
@endsection
