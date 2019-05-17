{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.admin')

@section('title')
    Administration
@endsection

@section('content-header')
    <h1>Administrative Overview<small>A quick glance at your system.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li class="active">Index</li>
    </ol>
@endsection

@section('content')
<div class="row mt--7">
    <div class="col-lg-12 mb-4">
        <div class="card shadow">
            <div class="card-header border-transparent">
                <div class="row align-items-center">
                   <div class="col">
                      <h3 class="mb-0">System Information</h3>
                   </div>
                </div>
            </div>
            <div class="card-body">
                @if ($version->isLatestPanel())
                    You are running Pterodactyl Panel version <code>{{ config('app.version') }}</code>. Your panel is up-to-date!
                @else
                    Your panel is <strong>not up-to-date!</strong> The latest version is <a href="https://github.com/Pterodactyl/Panel/releases/v{{ $version->getPanel() }}" target="_blank"><code>{{ $version->getPanel() }}</code></a> and you are currently running version <code>{{ config('app.version') }}</code>.
                @endif
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-3 col-lg-6 text-center mb-4 mb-xl-0">
        <a href="{{ $version->getDiscord() }}"><button class="btn btn-warning" style="width:100%;"><i class="fas fa-fw fa-life-ring"></i> Get Help <small>(via Discord)</small></button></a>
    </div>
    <div class="col-xl-3 col-lg-6 text-center mb-4 mb-xl-0">
        <a href="https://docs.pterodactyl.io"><button class="btn btn-primary" style="width:100%;"><i class="fas fa-fw fa-link"></i> Documentation</button></a>
    </div>
    <div class="col-xl-3 col-lg-6 text-center mb-4 mb-xl-0">
        <a href="https://github.com/Pterodactyl/Panel"><button class="btn btn-primary" style="width:100%;"><i class="fab fa-fw fa-github"></i> Github</button></a>
    </div>
    <div class="col-xl-3 col-lg-6 text-center mb-4 mb-xl-0">
        <a href="https://donorbox.org/pterodactyl"><button class="btn btn-success" style="width:100%;"><i class="fas fa-fw fa-money-bill"></i> Support the Project</button></a>
    </div>
</div>
@endsection
