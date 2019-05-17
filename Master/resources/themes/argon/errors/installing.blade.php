{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.error')

@section('title')
    @lang('base.errors.installing.header')
@endsection

@section('content-header')
@endsection

@section('content')
<div class="row mt--7">
    <div class="col-md-8 offset-md-2 col-sm-10 offset-sm-1 col-12">
        <div class="card">
            <div class="progress">
                <div class="progress-bar bg-info progress-bar-striped progress-bar-animated" style="width: 75%"></div>
            </div>
            <div class="card-body text-center">
                <p class="text-muted">@lang('base.errors.installing.desc')</p>
            </div>
            <div class="card-footer">
                <a href="{{ URL::previous() }}"><button class="btn btn-sm btn-info">&larr; @lang('base.errors.return')</button></a>
                <a href="/"><button class="btn btn-sm btn-primary">@lang('base.errors.home')</button></a>
            </div>
        </div>
    </div>
</div>
@endsection
