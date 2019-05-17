{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.admin')

@section('title')
    Locations &rarr; View &rarr; {{ $location->short }}
@endsection

@section('content-header')
    <h1>{{ $location->short }}<small>{{ str_limit($location->long, 75) }}</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li><a href="{{ route('admin.locations') }}">Locations</a></li>
        <li class="active">{{ $location->short }}</li>
    </ol>
@endsection

@section('content')
<div class="row mt--7">
    <div class="col-lg-6">
      <form action="{{ route('admin.locations.view', $location->id) }}" method="POST">
        <div class="card shadow">
            <div class="card-header border-transparent">
               <div class="row align-items-center">
                  <div class="col">
                     <h3 class="mb-0">Location Details</h3>
                  </div>
               </div>
            </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="pShort" class="form-label">Short Code</label>
                        <input type="text" id="pShort" name="short" class="form-control" value="{{ $location->short }}" />
                    </div>
                    <div class="form-group">
                        <label for="pLong" class="form-label">Description</label>
                        <textarea id="pLong" name="long" class="form-control" rows="4">{{ $location->long }}</textarea>
                    </div>
                </div>
                <div class="card-footer">
                    {!! csrf_field() !!}
                    {!! method_field('PATCH') !!}
                    <button name="action" value="edit" class="btn btn-sm btn-primary pull-right">Save</button>
                    <button name="action" value="delete" class="btn btn-sm btn-danger pull-left muted muted-hover"><i class="fas fa-trash"></i></button>
                </div>
        </div>
      </form>
    </div>
    <div class="col-lg-6">
        <div class="card shadow">
            <div class="card-header border-transparent">
               <div class="row align-items-center">
                  <div class="col">
                     <h3 class="mb-0">Nodes</h3>
                  </div>
               </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-items-center table-flush">
                  <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>FQDN</th>
                        <th>Servers</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($location->nodes as $node)
                        <tr>
                            <td><code>{{ $node->id }}</code></td>
                            <td><a href="{{ route('admin.nodes.view', $node->id) }}">{{ $node->name }}</a></td>
                            <td><code>{{ $node->fqdn }}</code></td>
                            <td>{{ $node->servers->count() }}</td>
                        </tr>
                    @endforeach
                  </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
