@extends('layouts.admin')

@section('title')
    Application API
@endsection

@section('content-header')
    <h1>Application API<small>Create a new application API key.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li><a href="{{ route('admin.api.index') }}">Application API</a></li>
        <li class="active">New Credentials</li>
    </ol>
@endsection

@section('content')
<form method="POST" action="{{ route('admin.api.new') }}">
    <div class="row mt--7 align-items-start">
        <div class="col-lg-8 mb-cs">
            <div class="card shadow">
                <div class="card-header border-transparent">
                   <div class="row align-items-center">
                      <div class="col">
                         <h3 class="mb-0">Select Permissions</h3>
                      </div>
                   </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-items-center table-flush table-sm">
                      <tbody>
                        @foreach($resources as $resource)
                            <tr>
                                <td><strong>{{ str_replace('_', ' ', title_case($resource)) }}</strong></td>
                                <td class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="r_{{ $resource }}" name="r_{{ $resource }}" value="{{ $permissions['r'] }}">
                                    <label class="custom-control-label" for="r_{{ $resource }}">Read</label>
                                </td>
                                <td class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="rw_{{ $resource }}" name="r_{{ $resource }}" value="{{ $permissions['rw'] }}">
                                    <label class="custom-control-label" for="rw_{{ $resource }}">Read &amp; Write</label>
                                </td>
                                <td class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="n_{{ $resource }}" name="r_{{ $resource }}" value="{{ $permissions['n'] }}" checked>
                                    <label class="custom-control-label" for="n_{{ $resource }}">None</label>
                                </td>
                            </tr>
                        @endforeach
                      </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-cs">
            <div class="card shadow">
              <div class="card-header border-transparent">
                 <div class="row align-items-center">
                    <div class="col">
                       <h3 class="mb-0">Description</h3>
                    </div>
                 </div>
              </div>
                <div class="card-body">
                    <div class="form-group">
                        <input id="memoField" type="text" name="memo" class="form-control">
                        <p class="text-muted small no-margin">Once you have assigned permissions and created this set of credentials you will be unable to come back and edit it. If you need to make changes down the road you will need to create a new set of credentials.</p>
                    </div>
                </div>
                <div class="card-footer mt--3">
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-success btn-sm pull-right">Create Credentials</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('footer-scripts')
    @parent
    <script>
    </script>
@endsection
