{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.master')

@section('title')
@lang('server.files.edit.header')
@endsection

@section('content-header')
<h1>@lang('server.files.edit.header')<small>@lang('server.files.edit.header_sub')</small></h1>
<ol class="breadcrumb">
   <li><a href="{{ route('index') }}">@lang('strings.home')</a></li>
   <li><a href="{{ route('server.index', $server->uuidShort) }}">{{ $server->name }}</a></li>
   <li><a href="{{ route('server.files.index', $server->uuidShort) }}">@lang('navigation.server.file_browser')</a></li>
   <li class="active">@lang('navigation.server.edit_file')</li>
</ol>
@endsection

@section('content')
<div class="row mt--7">
   <div class="col-lg-12">
      <div class="card shadow">
         <div class="card-header border-transparent">
            <div class="row align-items-center">
               <div class="col">
                  <h3 class="mb-0">{{ $file }}</h3>
               </div>
               <div class="col text-right">
                  <a href="/server/{{ $server->uuidShort }}/files#{{ rawurlencode($directory) }}" class="btn btn-sm btn-primary">@lang('server.files.edit.return')</a>
               </div>
            </div>
         </div>
         <input type="hidden" name="file" value="{{ $file }}" />
         <textarea id="editorSetContent" class="d-none">{{ $contents }}</textarea>
         <div class="overlay" id="editorLoadingOverlay"><i class="fas fa-sync fa-spin"></i></div>
         <div class="card-body" style="height:500px;" id="editor"></div>
         <div class="card-footer">
            <button class="btn btn-sm btn-success" id="save_file"><i class="fas fa-fw fa-save"></i> &nbsp;@lang('server.files.edit.save')</button>
            <a href="/server/{{ $server->uuidShort }}/files#{{ rawurlencode($directory) }}" class="float-right"><button class="btn btn-danger btn-sm">@lang('server.files.edit.return')</button></a>
         </div>
      </div>
   </div>
</div>
@endsection

@section('footer-scripts')
@parent
{!! Theme::js('js/frontend/server.socket.js') !!}
{!! Theme::js('vendor/ace/ace.js') !!}
{!! Theme::js('vendor/ace/ext-modelist.js') !!}
{!! Theme::js('vendor/ace/ext-whitespace.js') !!}
{!! Theme::js('js/frontend/files/editor.js') !!}
<script>
   $(document).ready(function () {
       Editor.setValue($('#editorSetContent').val(), -1);
       Editor.getSession().setUndoManager(new ace.UndoManager());
       $('#editorLoadingOverlay').hide();
   });
</script>
@endsection
