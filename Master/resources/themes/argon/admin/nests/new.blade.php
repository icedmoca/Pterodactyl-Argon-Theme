{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.admin')

@section('title')
    New Nest
@endsection

@section('content-header')
    <h1>New Nest<small>Configure a new nest to deploy to all nodes.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li><a href="{{ route('admin.nests') }}">Nests</a></li>
        <li class="active">New</li>
    </ol>
@endsection

@section('content')
<form action="{{ route('admin.nests.new') }}" method="POST">
    <div class="row mt--7">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header border-transparent">
                   <div class="row align-items-center">
                      <div class="col">
                         <h3 class="mb-0">New Nest</h3>
                      </div>
                   </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="control-label">Name</label>
                        <div>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" />
                            <p class="text-muted"><small>This should be a descriptive category name that encompasses all of the eggs within the nest.</small></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Description</label>
                        <div>
                            <textarea name="description" class="form-control" rows="6">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    {!! csrf_field() !!}
                    <button type="submit" class="btn btn-sm btn-primary pull-right">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
