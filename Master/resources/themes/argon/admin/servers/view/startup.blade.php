{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.admin')

@section('title')
    Server — {{ $server->name }}: Startup
@endsection

@section('content-header')
    <h1>{{ $server->name }}<small>Control startup command as well as variables.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li><a href="{{ route('admin.servers') }}">Servers</a></li>
        <li><a href="{{ route('admin.servers.view', $server->id) }}">{{ $server->name }}</a></li>
        <li class="active">Startup</li>
    </ol>
@endsection

@section('content')
<div class="row mt--7 mb-cs">
   <div class="col-lg-12">
      <div class="card shadow bg-secondary">
        <div class="card-body bg-secondary" style="padding: 0.75rem">
          <ul class="nav nav-pills nav-fill flex-column flex-sm-row" id="tabs-text" role="tablist">
             <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0" href="{{ route('admin.servers.view', $server->id) }}" role="tab">About</a>
             </li>
             @if($server->installed === 1)
             <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0" href="{{ route('admin.servers.view.details', $server->id) }}" role="tab">Details</a>
             </li>
             <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0 " href="{{ route('admin.servers.view.build', $server->id) }}" role="tab">Build Configuration</a>
             </li>
             <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0 active" href="{{ route('admin.servers.view.startup', $server->id) }}" role="tab">Startup</a>
             </li>
             <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0" href="{{ route('admin.servers.view.database', $server->id) }}" role="tab">Database</a>
             </li>
             <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0" href="{{ route('admin.servers.view.manage', $server->id) }}" role="tab">Manage</a>
             </li>
             @endif
             <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0" href="{{ route('admin.servers.view.delete', $server->id) }}" role="tab">Delete</a>
             </li>
             <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0" href="{{ route('server.index', $server->uuidShort) }}" role="tab"><i class="fas fa-external-link-alt"></i></a>
             </li>
          </ul>
        </div>
      </div>
   </div>
</div>
<form action="{{ route('admin.servers.view.startup', $server->id) }}" method="POST">
    <div class="row mb-cs">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header border-transparent">
                   <div class="row align-items-center">
                      <div class="col">
                         <h3 class="mb-0">Startup Command Modification</h3>
                      </div>
                   </div>
                </div>
                <div class="card-body">
                    <label for="pStartup" class="form-label">Startup Command</label>
                    <input id="pStartup" name="startup" class="form-control" type="text" value="{{ old('startup', $server->startup) }}" />
                    <p class="small text-muted">Edit your server's startup command here. The following variables are available by default: <code>@{{SERVER_MEMORY}}</code>, <code>@{{SERVER_IP}}</code>, and <code>@{{SERVER_PORT}}</code>.</p>
                </div>
                <div class="card-body mt--5">
                    <label for="pDefaultStartupCommand" class="form-label">Default Service Start Command</label>
                    <input id="pDefaultStartupCommand" class="form-control" type="text" readonly />
                </div>
                <div class="card-footer">
                    {!! csrf_field() !!}
                    <button type="submit" class="btn btn-primary btn-sm pull-right">Save Modifications</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-cs">
                <div class="card-header border-transparent">
                   <div class="row align-items-center">
                      <div class="col">
                         <h3 class="mb-0">Service Configuration</h3>
                      </div>
                   </div>
                </div>
                <div class="card-body row">
                    <div class="col-md-12">
                        <p class="small text-danger">
                            Changing any of the below values will result in the server processing a re-install command. The server will be stopped and will then proceed.
                            If you are changing the pack, existing data <em>may</em> be overwritten. If you would like the service scripts to not run, ensure the box is checked at the bottom.
                        </p>
                        <p class="small text-danger">
                            <strong>This is a destructive operation in many cases. This server will be stopped immediately in order for this action to proceed.</strong>
                        </p>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="pNestId">Nest</label>
                        <select name="nest_id" id="pNestId" class="form-control">
                            @foreach($nests as $nest)
                                <option value="{{ $nest->id }}"
                                    @if($nest->id === $server->nest_id)
                                        selected
                                    @endif
                                >{{ $nest->name }}</option>
                            @endforeach
                        </select>
                        <p class="small text-muted m-0">Select the Nest that this server will be grouped into.</p>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="pEggId">Egg</label>
                        <select name="egg_id" id="pEggId" class="form-control"></select>
                        <p class="small text-muted m-0">Select the Egg that will provide processing data for this server.</p>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="pPackId">Data Pack</label>
                        <select name="pack_id" id="pPackId" class="form-control"></select>
                        <p class="small text-muted m-0">Select a data pack to be automatically installed on this server when first created.</p>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="custom-control custom-checkbox mb-0">
                            <input class="custom-control-input" id="pSkipScripting" name="skip_scripts" type="checkbox" value="1" @if($server->skip_scripts) checked @endif />
                            <label class="custom-control-label" for="pSkipScripting" class="strong">Skip Egg Install Script</label>
                        </div>
                        <p class="small text-muted m-0">If the selected Egg has an install script attached to it, the script will run during install after the pack is installed. If you would like to skip this step, check this box.</p>
                    </div>
                </div>
            </div>
            <div class="card shadow mb-cs">
                <div class="card-header border-transparent">
                   <div class="row align-items-center">
                      <div class="col">
                         <h3 class="mb-0">Docker Container Configuration</h3>
                      </div>
                   </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="pDockerImage" class="control-label">Image</label>
                        <input type="text" name="docker_image" id="pDockerImage" value="{{ $server->image }}" class="form-control" />
                        <p class="text-muted small">The Docker image to use for this server. The default image for the selected egg is <code id="setDefaultImage"></code>.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row" id="appendVariablesTo"></div>
        </div>
    </div>
</form>
@endsection

@section('footer-scripts')
    @parent
    {!! Theme::js('vendor/lodash/lodash.js') !!}
    <script>
    $(document).ready(function () {
        $('#pPackId').select2({placeholder: 'Select a Service Pack'});
        $('#pEggId').select2({placeholder: 'Select a Nest Egg'}).on('change', function () {
            var selectedEgg = _.isNull($(this).val()) ? $(this).find('option').first().val() : $(this).val();
            var parentChain = _.get(Pterodactyl.nests, $("#pNestId").val());
            var objectChain = _.get(parentChain, 'eggs.' + selectedEgg);

            $('#setDefaultImage').html(_.get(objectChain, 'docker_image', 'undefined'));
            $('#pDockerImage').val(_.get(objectChain, 'docker_image', 'undefined'));
            if (objectChain.id === parseInt(Pterodactyl.server.egg_id)) {
                $('#pDockerImage').val(Pterodactyl.server.image);
            }

            if (!_.get(objectChain, 'startup', false)) {
                $('#pDefaultStartupCommand').val(_.get(parentChain, 'startup', 'ERROR: Startup Not Defined!'));
            } else {
                $('#pDefaultStartupCommand').val(_.get(objectChain, 'startup'));
            }

            $('#pPackId').html('').select2({
                data: [{id: '0', text: 'No Service Pack'}].concat(
                    $.map(_.get(objectChain, 'packs', []), function (item, i) {
                        return {
                            id: item.id,
                            text: item.name + ' (' + item.version + ')',
                        };
                    })
                ),
            });

            if (Pterodactyl.server.pack_id !== null) {
                $('#pPackId').val(Pterodactyl.server.pack_id);
            }

            $('#appendVariablesTo').html('');
            $.each(_.get(objectChain, 'variables', []), function (i, item) {
                var setValue = _.get(Pterodactyl.server_variables, item.env_variable, item.default_value);
                var isRequired = (item.required === 1) ? '<span class="badge badge-danger">Required</span> ' : '';
                var dataAppend = ' \
                    <div class="col-md-12"> \
                        <div class="card shadow mb-cs"> \
                            <div class="card-header border-transparent"> \
                               <div class="row align-items-center"> \
                                  <div class="col"> \
                                     <h3 class="mb-0">' + isRequired + item.name + '</h3> \
                                  </div> \
                               </div> \
                            </div> \
                            <div class="card-body"> \
                                <input name="environment[' + item.env_variable + ']" class="form-control" type="text" id="egg_variable_' + item.env_variable + '" /> \
                                <p class="small text-muted m-0">' + item.description + '</p> \
                            </div> \
                            <div class="card-footer"> \
                                <p class="text-muted small m-0"><strong>Startup Command Variable:</strong> <code>' + item.env_variable + '</code><br/>\
                                <strong>Input Rules:</strong> <code>' + item.rules + '</code></p> \
                            </div> \
                        </div> \
                    </div>';
                $('#appendVariablesTo').append(dataAppend).find('#egg_variable_' + item.env_variable).val(setValue);
            });
        });

        $('#pNestId').select2({placeholder: 'Select a Nest'}).on('change', function () {
            $('#pEggId').html('').select2({
                data: $.map(_.get(Pterodactyl.nests, $(this).val() + '.eggs', []), function (item) {
                    return {
                        id: item.id,
                        text: item.name,
                    };
                }),
            });

            if (_.isObject(_.get(Pterodactyl.nests, $(this).val() + '.eggs.' + Pterodactyl.server.egg_id))) {
                $('#pEggId').val(Pterodactyl.server.egg_id);
            }

            $('#pEggId').change();
        }).change();
    });
    </script>
@endsection
