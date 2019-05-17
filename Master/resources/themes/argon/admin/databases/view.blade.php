{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.admin')

@section('title')
    Database Hosts &rarr; View &rarr; {{ $host->name }}
@endsection

@section('content-header')
    <h1>{{ $host->name }}<small>Viewing associated databases and details for this database host.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li><a href="{{ route('admin.databases') }}">Database Hosts</a></li>
        <li class="active">{{ $host->name }}</li>
    </ol>
@endsection

@section('content')
<form action="{{ route('admin.databases.view', $host->id) }}" method="POST">
    <div class="row mt--7">
        <div class="col-lg-6 mb-cs">
            <div class="card shadow">
                <div class="card-header border-transparent">
                   <div class="row align-items-center">
                      <div class="col">
                         <h3 class="mb-0">Host Details</h3>
                      </div>
                   </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="pName" class="form-label">Name</label>
                        <input type="text" id="pName" name="name" class="form-control" value="{{ old('name', $host->name) }}" />
                    </div>
                    <div class="form-group">
                        <label for="pHost" class="form-label">Host</label>
                        <input type="text" id="pHost" name="host" class="form-control" value="{{ old('host', $host->host) }}" />
                        <p class="text-muted small">The IP address or FQDN that should be used when attempting to connect to this MySQL host <em>from the panel</em> to add new databases.</p>
                    </div>
                    <div class="form-group">
                        <label for="pPort" class="form-label">Port</label>
                        <input type="text" id="pPort" name="port" class="form-control" value="{{ old('port', $host->port) }}" />
                        <p class="text-muted small">The port that MySQL is running on for this host.</p>
                    </div>
                    <div class="form-group">
                        <label for="pNodeId" class="form-label">Linked Node</label>
                        <select name="node_id" id="pNodeId" class="form-control">
                            <option value="0">None</option>
                            @foreach($locations as $location)
                                <optgroup label="{{ $location->short }}">
                                    @foreach($location->nodes as $node)
                                        <option value="{{ $node->id }}" {{ $host->node_id !== $node->id ?: 'selected' }}>{{ $node->name }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        <p class="text-muted small no-margin">This setting does nothing other than default to this database host when adding a database to a server on the selected node.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-cs">
            <div class="card shadow">
                <div class="card-header border-transparent">
                   <div class="row align-items-center">
                      <div class="col">
                         <h3 class="mb-0">User Details</h3>
                      </div>
                   </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="pUsername" class="form-label">Username</label>
                        <input type="text" name="username" id="pUsername" class="form-control" value="{{ old('username', $host->username) }}" />
                        <p class="text-muted small">The username of an account that has enough permissions to create new users and databases on the system.</p>
                    </div>
                    <div class="form-group">
                        <label for="pPassword" class="form-label">Password</label>
                        <input type="password" name="password" id="pPassword" class="form-control" />
                        <p class="text-muted small">The password to the account defined. Leave blank to continue using the assigned password.</p>
                    </div>
                    <hr />
                    <p class="text-danger small text-left">The account defined for this database host <strong>must</strong> have the <code>WITH GRANT OPTION</code> permission. If the defined account does not have this permission requests to create databases <em>will</em> fail. <strong>Do not use the same account details for MySQL that you have defined for this panel.</strong></p>
                </div>
                <div class="card-footer mt--2">
                    {!! csrf_field() !!}
                    <button name="_method" value="PATCH" class="btn btn-sm btn-primary pull-right">Save</button>
                    <button name="_method" value="DELETE" class="btn btn-sm btn-danger pull-left muted muted-hover"><i class="fas fa-trash"></i></button>
                </div>
            </div>
        </div>
    </div>
</form>
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow">
            <div class="card-header border-0">
               <div class="row align-items-center">
                  <div class="col">
                     <h3 class="mb-0">Databases</h3>
                  </div>
               </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-items-center table-flush table-sm">
                  <thead class="thead-light">
                    <tr>
                        <th>Server</th>
                        <th>Database Name</th>
                        <th>Username</th>
                        <th>Connections From</th>
                        <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($databases as $database)
                        <tr>
                            <td class="middle"><a href="{{ route('admin.servers.view', $database->getRelation('server')->id) }}">{{ $database->getRelation('server')->name }}</a></td>
                            <td class="middle">{{ $database->database }}</td>
                            <td class="middle">{{ $database->username }}</td>
                            <td class="middle">{{ $database->remote }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.servers.view.database', $database->getRelation('server')->id) }}">
                                    <button class="btn btn-sm btn-primary">Manage</button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                  </tbody>
                </table>
            </div>
            @if($databases->hasPages())
                <div class="card-footer mb--3">
                    <div class="col-lg-12 text-center">{!! $databases->render() !!}</div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')
    @parent
    <script>
        $('#pNodeId').select2();
    </script>
@endsection
