{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.master')

@section('title')
@lang('server.config.database.header')
@endsection

@section('content-header')
<h1>@lang('server.config.database.header')<small>@lang('server.config.database.header_sub')</small></h1>
<ol class="breadcrumb">
   <li><a href="{{ route('index') }}">@lang('strings.home')</a></li>
   <li><a href="{{ route('server.index', $server->uuidShort) }}">{{ $server->name }}</a></li>
   <li>@lang('navigation.server.configuration')</li>
   <li class="active">@lang('navigation.server.databases')</li>
</ol>
@endsection

@section('content')
<div class="row mt--7">
   <div class="{{ $allowCreation && Gate::allows('create-database', $server) ? 'col-lg-8' : 'col-lg-12' }} mb-cs">
      <div class="card shadow">
        <div class="card-header {{ count($databases) > 0 ? 'border-0' : 'border-transparent' }}">
           <div class="row align-items-center">
              <div class="col">
                 <h3 class="mb-0">@lang('server.config.database.your_dbs')</h3>
              </div>
           </div>
        </div>
         @if(count($databases) > 0)
         <div class="table-responsive">
            <table class="table align-items-center table-flush">
               <thead class="thead-light">
                  <tr>
                     <th>@lang('strings.database')</th>
                     <th>@lang('strings.username')</th>
                     <th>@lang('strings.password')</th>
                     <th>@lang('server.config.database.host')</th>
                     @can('reset-db-password', $server)
                     <th></th>
                     @endcan
                  </tr>
               </thead>
               <tbody>
                  @foreach($databases as $database)
                  <tr>
                     <td class="middle">{{ $database->database }}</td>
                     <td class="middle">{{ $database->username }}</td>
                     <td class="middle">
                        <code class="toggle-display" style="cursor:pointer" data-toggle="tooltip" data-placement="right" title="Click to Reveal">
                        <i class="fas fa-lock"></i> &bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;
                        </code>
                        <code class="d-none" data-attr="set-password">
                        {{ Crypt::decrypt($database->password) }}
                        </code>
                     </td>
                     <td class="middle"><code>{{ $database->host->host }}:{{ $database->host->port }}</code></td>
                     @if(Gate::allows('reset-db-password', $server) || Gate::allows('delete-database', $server))
                     <td class="float-right">
                        @can('reset-db-password', $server)
                        <button class="btn btn-sm btn-primary" style="margin-right:10px;" data-action="reset-password" data-id="{{ $database->id }}">
                        <i class="fas fa-fw fa-sync"></i> @lang('server.config.database.reset_password')
                        </button>
                        @endcan
                        @can('delete-database', $server)
                        <button class="btn btn-sm btn-danger" data-action="delete-database" data-id="{{ $database->id }}">
                        <i class="fas fa-fw fa-trash"></i>
                        </button>
                        @endcan
                     </td>
                     @endif
                  </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
         @else
         <div class="card-body">
            <div class="alert alert-info mb-0">
               @lang('server.config.database.no_dbs')
            </div>
         </div>
         @endif
      </div>
   </div>
   @if($allowCreation && Gate::allows('create-database', $server))
   <div class="col-lg-4 mb-cs">
      @if($overLimit)
      <div class="card shadow">
         <div class="card-header border-transparent">
            <div class="row align-items-center">
               <div class="col">
                  <h3 class="mb-0">Create New Database</h3>
               </div>
            </div>
         </div>
         <div class="card-body">
            <div class="alert alert-danger mb-0">
               You are currently using <strong>{{ count($databases) }}</strong> of your <strong>{{ $server->database_limit ?? '∞' }}</strong> allowed databases.
            </div>
         </div>
      </div>
      @else
      <form action="{{ route('server.databases.new', $server->uuidShort) }}" method="POST">
         <div class="card shadow">
            <div class="card-header border-transparent">
               <div class="row align-items-center">
                  <div class="col">
                     <h3 class="mb-0">Create New Database</h3>
                  </div>
               </div>
            </div>
            <div class="card-body">
               <div class="form-group">
                  <label for="pDatabaseName" class="control-label">Database</label>
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text">s{{ $server->id }}_</span>
                     </div>
                     <input id="pDatabaseName" type="text" name="database" class="form-control" placeholder="database" />
                  </div>
               </div>
               <div class="form-group">
                  <label for="pRemote" class="control-label">Connections</label>
                  <input id="pRemote" type="text" name="remote" class="form-control" value="%" />
                  <p class="text-muted small">This should reflect the IP address that connections are allowed from. Uses standard MySQL notation. If unsure leave as <code>%</code>.</p>
               </div>
            </div>
            <div class="card-footer mt--3">
               {!! csrf_field() !!}
               <div>
                  <p class="text-muted small">You are currently using <strong>{{ count($databases) }}</strong> of <strong>{{ $server->database_limit ?? '∞' }}</strong> databases. A username and password for this database will be randomly generated after form submission.</p>
               </div>
               <div class="float-right">
                  <input type="submit" class="btn btn-sm btn-success" value="Create Database" />
               </div>
            </div>
         </div>
      </form>
      @endif
   </div>
   @endif
</div>
@endsection

@section('footer-scripts')
@parent
{!! Theme::js('js/frontend/server.socket.js') !!}
<script>
   $(function () {
       $('[data-toggle="tooltip"]').tooltip()
   });
   $('.toggle-display').on('click', function () {
       $(this).parent().find('code[data-attr="set-password"]').removeClass('d-none');
       $(this).hide();
   });
   @can('reset-db-password', $server)
       $('[data-action="reset-password"]').click(function (e) {
           e.preventDefault();
           var block = $(this);
           $(this).addClass('disabled').find('i').addClass('fa-spin');
           $.ajax({
               type: 'PATCH',
               url: Router.route('server.databases.password', { server: Pterodactyl.server.uuidShort }),
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'),
               },
               data: {
                   database: $(this).data('id')
               }
           }).done(function (data) {
               block.parent().parent().find('[data-attr="set-password"]').html(data.password);
           }).fail(function(jqXHR) {
               console.error(jqXHR);
               var error = 'An error occurred while trying to process this request.';
               if (typeof jqXHR.responseJSON !== 'undefined' && typeof jqXHR.responseJSON.error !== 'undefined') {
                   error = jqXHR.responseJSON.error;
               }
               swal({
                   type: 'error',
                   title: 'Whoops!',
                   text: error
               });
           }).always(function () {
               block.removeClass('disabled').find('i').removeClass('fa-spin');
           });
       });
   @endcan
   @can('delete-database', $server)
       $('[data-action="delete-database"]').click(function (event) {
           event.preventDefault();
           var self = $(this);
           swal({
               title: '',
               type: 'warning',
               text: 'Are you sure that you want to delete this database? There is no going back, all data will immediately be removed.',
               showCancelButton: true,
               confirmButtonText: 'Delete',
               confirmButtonColor: '#d9534f',
               closeOnConfirm: false,
               showLoaderOnConfirm: true,
           }, function () {
               $.ajax({
                   method: 'DELETE',
                   url: Router.route('server.databases.delete', { server: '{{ $server->uuidShort }}', database: self.data('id') }),
                   headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
               }).done(function () {
                   self.parent().parent().slideUp();
                   swal.close();
               }).fail(function (jqXHR) {
                   console.error(jqXHR);
                   swal({
                       type: 'error',
                       title: 'Whoops!',
                       text: (typeof jqXHR.responseJSON.error !== 'undefined') ? jqXHR.responseJSON.error : 'An error occurred while processing this request.'
                   });
               });
           });
       });
   @endcan
</script>
@endsection
