{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.admin')

@section('title')
    Egg &rarr; {{ $egg->name }} &rarr; Variables
@endsection

@section('content-header')
    <h1>{{ $egg->name }}<small>Managing variables for this Egg.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li><a href="{{ route('admin.nests') }}">Nests</a></li>
        <li><a href="{{ route('admin.nests.view', $egg->nest->id) }}">{{ $egg->nest->name }}</a></li>
        <li><a href="{{ route('admin.nests.egg.view', $egg->id) }}">{{ $egg->name }}</a></li>
        <li class="active">Variables</li>
    </ol>
@endsection

@section('content')
<div class="row mt--7">
    <div class="col-md-12">
       <div class="card shadow bg-secondary mb-cs">
         <div class="card-body bg-secondary" style="padding: 0.75rem">
           <ul class="nav nav-pills nav-fill flex-column flex-sm-row" id="tabs-text" role="tablist">
              <li class="nav-item">
                 <a class="nav-link mb-sm-3 mb-md-0" href="{{ route('admin.nests.egg.view', $egg->id) }}" role="tab">Configuration</a>
              </li>
              <li class="nav-item">
                 <a class="nav-link mb-sm-3 mb-md-0 active" href="{{ route('admin.nests.egg.variables', $egg->id) }}" role="tab">Variables</a>
              </li>
              <li class="nav-item">
                 <a class="nav-link mb-sm-3 mb-md-0" href="{{ route('admin.nests.egg.scripts', $egg->id) }}" role="tab">Scripts</a>
              </li>
           </ul>
         </div>
       </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card shadow mb-cs">
            <div class="card-footer">
                <a href="#" class="btn btn-sm btn-success pull-right" data-toggle="modal" data-target="#newVariableModal">Create New Variable</a>
            </div>
        </div>
    </div>
</div>
<div class="row">
    @foreach($egg->variables as $variable)
        <div class="col-sm-6">
          <form action="{{ route('admin.nests.egg.variables.edit', ['id' => $egg->id, 'variable' => $variable->id]) }}" method="POST">
            <div class="card shadow">
                <div class="card-header border-transparent">
                   <div class="row align-items-center">
                      <div class="col">
                         <h3 class="mb-0">{{ $variable->name }}</h3>
                      </div>
                   </div>
                </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" value="{{ $variable->name }}" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3">{{ $variable->description }}</textarea>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="form-label">Environment Variable</label>
                                <input type="text" name="env_variable" value="{{ $variable->env_variable }}" class="form-control" />
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">Default Value</label>
                                <input type="text" name="default_value" value="{{ $variable->default_value }}" class="form-control" />
                            </div>
                            <div class="col-md-12">
                                <p class="text-muted small">This variable can be accessed in the startup command by using <code>{{ $variable->env_variable }}</code>.</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Permissions</label>
                            <select name="options[]" class="pOptions form-control" multiple>
                                <option value="user_viewable" {{ (! $variable->user_viewable) ?: 'selected' }}>Users Can View</option>
                                <option value="user_editable" {{ (! $variable->user_editable) ?: 'selected' }}>Users Can Edit</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Input Rules</label>
                            <input type="text" name="rules" class="form-control" value="{{ $variable->rules }}" />
                            <p class="text-muted small">These rules are defined using standard Laravel Framework validation rules.</p>
                        </div>
                    </div>
                    <div class="card-footer">
                        {!! csrf_field() !!}
                        <button class="btn btn-sm btn-primary pull-right" name="_method" value="PATCH" type="submit">Save</button>
                        <button class="btn btn-sm btn-danger pull-left" data-action="delete" name="_method" value="DELETE" type="submit"><i class="fas fa-trash"></i></button>
                    </div>
            </div>
            </form>
        </div>
    @endforeach
</div>
<div class="modal fade" id="newVariableModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create New Egg Variable</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="{{ route('admin.nests.egg.variables', $egg->id) }}" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label">Name <span class="field-required"></span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Description</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="control-label">Environment Variable <span class="field-required"></span></label>
                            <input type="text" name="env_variable" class="form-control" value="{{ old('env_variable') }}" />
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Default Value</label>
                            <input type="text" name="default_value" class="form-control" value="{{ old('default_value') }}" />
                        </div>
                        <div class="col-md-12">
                            <p class="text-muted small">This variable can be accessed in the startup command by entering <code>@{{environment variable value}}</code>.</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Permissions</label>
                        <select name="options[]" class="pOptions form-control" multiple>
                            <option value="user_viewable">Users Can View</option>
                            <option value="user_editable">Users Can Edit</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Input Rules <span class="field-required"></span></label>
                        <input type="text" name="rules" class="form-control" value="{{ old('rules', 'required|string|max:20') }}" placeholder="required|string|max:20" />
                        <p class="text-muted small">These rules are defined using standard Laravel Framework validation rules.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    {!! csrf_field() !!}
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm ml-auto">Create Variable</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')
    @parent
    <script>
        $('.pOptions').select2();
        $('[data-action="delete"]').on('mouseenter', function (event) {
            $(this).html('<i class="fas fa-trash"></i> Delete Variable');
        }).on('mouseleave', function (event) {
            $(this).html('<i class="fas fa-trash"></i>');
        });
    </script>
@endsection
