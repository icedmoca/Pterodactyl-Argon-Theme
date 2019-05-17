{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
<div class="card-header border-0">
   <div class="row align-items-center">
      <div class="col-lg-4">
         <h3 class="mb-0">/home/container{{ $directory['header'] }}</h3>
      </div>
      <div class="col-lg-8 text-right">
         <a href="/server/{{ $server->uuidShort }}/files/add/@if($directory['header'] !== '')?dir={{ $directory['header'] }}@endif" class="btn btn-success btn-sm btn-icon">
         <i class="fas fa-file-medical"></i> New File
         </a>
         <button class="btn btn-sm btn-success btn-icon" data-action="add-folder">
         <i class="fas fa-folder-plus"></i> New Folder
         </button>
         <label class="btn btn-sm btn-primary btn-icon mt-2">
         <i class="fas fa-file-upload"></i>Upload<input type="file" id="files_touch_target" class="d-none">
         </label>
         <button type="button" id="mass_actions" class="btn btn-sm btn-info dropdown-toggle disabled" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         <i class="fas fa-list"></i>@lang('server.files.mass_actions') <span class="caret"></span>
         </button>
         <ul class="dropdown-menu dropdown-massactions">
            <a class="dropdown-item" href="#" id="selective-deletion" data-action="selective-deletion">
            <i class="fas fa-trash"></i> @lang('server.files.delete')                    </a>
         </ul>
      </div>
   </div>
</div>
<div class="table-responsive no-padding">
   <table class="table table-sm table-hover align-items-center table-flush" id="file_listing" data-current-dir="{{ rtrim($directory['header'], '/') . '/' }}">
      <thead class="thead-light">
         <tr>
            <th scope="col" class="min-size file-manager-padding-right middle">
               <input type="checkbox" class="select-all-files d-none d-sm-table-cell middle" data-action="selectAll">
               <i class="fas fa-sync muted muted-hover use-pointer middle sync-icon" data-action="reload-files"></i>
            </th>
            <th scope="col" class="file-manager-padding-left">@lang('server.files.file_name')</th>
            <th scope="col" class="d-none d-sm-table-cell">@lang('server.files.size')</th>
            <th scope="col" class="d-none d-sm-table-cell">@lang('server.files.last_modified')</th>
            <th></th>
         </tr>
      </thead>
      <tbody id="append_files_to">
         @if (isset($directory['first']) && $directory['first'] === true)
         <tr data-type="disabled">
            <td class="min-size file-manager-padding-right middle"><i class="fas fa-folder middle"></i></td>
            <td class="file-manager-padding-left"><a href="/server/{{ $server->uuidShort }}/files" data-action="directory-view">&larr;</a></td>
            <td class="d-none d-sm-table-cell"></td>
            <td class="d-none d-sm-table-cell"></td>
            <td></td>
         </tr>
         @endif
         @if (isset($directory['show']) && $directory['show'] === true)
         <tr data-type="disabled">
            <td class="min-size file-manager-padding-right middle"><i class="fas fa-folder middle"></i></td>
            <td class="file-manager-padding-left" data-name="{{ rawurlencode($directory['link']) }}">
               <a href="/server/{{ $server->uuidShort }}/files" data-action="directory-view">&larr; {{ $directory['link_show'] }}</a>
            </td>
            <td class="d-none d-sm-table-cell"></td>
            <td class="d-none d-sm-table-cell"></td>
            <td></td>
         </tr>
         @endif
         @foreach ($folders as $folder)
         <tr data-type="folder">
            <td class="min-size file-manager-padding-right middle" data-identifier="type">
               <input type="checkbox" class="select-folder d-none d-sm-table-cell middle" data-action="addSelection">
               <i class="fas fa-folder middle folder-icon"></i>
            </td>
            <td class="file-manager-padding-left" data-identifier="name" data-name="{{ rawurlencode($folder['entry']) }}" data-path="@if($folder['directory'] !== ''){{ rawurlencode($folder['directory']) }}@endif/">
               <a href="/server/{{ $server->uuidShort }}/files" data-action="directory-view">{{ $folder['entry'] }}</a>
            </td>
            <td data-identifier="size" class="d-none d-sm-table-cell">{{ $folder['size'] }}</td>
            <td data-identifier="modified" class="d-none d-sm-table-cell">
               <?php $carbon = Carbon::createFromTimestamp($folder['date'])->timezone(config('app.timezone')); ?>
               @if($carbon->diffInMinutes(Carbon::now()) > 60)
               {{ $carbon->format('m/d/y H:i:s') }}
               @elseif($carbon->diffInSeconds(Carbon::now()) < 5 || $carbon->isFuture())
               <em>@lang('server.files.seconds_ago')</em>
               @else
               {{ $carbon->diffForHumans() }}
               @endif
            </td>
            <td class="text-right">
               <div class="dropdown disable-menu-hide">
                  <button class="btn btn-sm disable-menu-hide" data-action="toggleMenu" style="padding:2px 6px 0px; background-color: #fff; color: inherit;"><i class="fas fa-ellipsis-v disable-menu-hide"></i></button>
               </div>
            </td>
         </tr>
         @endforeach
         @foreach ($files as $file)
         <tr data-type="file" data-mime="{{ $file['mime'] }}">
            <td class="min-size file-manager-padding-right middle" data-identifier="type"><input type="checkbox" class="select-file d-none d-sm-table-cell middle" data-action="addSelection">
               {{--  oh boy --}}
               @if(in_array($file['mime'], [
               'application/x-7z-compressed',
               'application/zip',
               'application/x-compressed-zip',
               'application/x-tar',
               'application/x-gzip',
               'application/x-bzip',
               'application/x-bzip2',
               'application/java-archive'
               ]))
               <i class="far fa-file-archive middle file-icon"></i>
               @elseif(in_array($file['mime'], [
               'application/json',
               'application/javascript',
               'application/xml',
               'application/xhtml+xml',
               'text/xml',
               'text/css',
               'text/html',
               'text/x-perl',
               'text/x-shellscript'
               ]))
               <i class="far fa-file-code middle file-icon"></i>
               @elseif(starts_with($file['mime'], 'image'))
               <i class="far fa-file-image middle file-icon"></i>
               @elseif(starts_with($file['mime'], 'video'))
               <i class="far fa-file-video middle file-icon"></i>
               @elseif(starts_with($file['mime'], 'video'))
               <i class="far fa-file-audio middle file-icon"></i>
               @elseif(starts_with($file['mime'], 'application/vnd.ms-powerpoint'))
               <i class="far fa-file-powerpoint middle file-icon"></i>
               @elseif(in_array($file['mime'], [
               'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
               'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
               'application/msword'
               ]) || starts_with($file['mime'], 'application/vnd.ms-word'))
               <i class="far fa-file-word middle file-icon"></i>
               @elseif(in_array($file['mime'], [
               'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
               'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
               ]) || starts_with($file['mime'], 'application/vnd.ms-excel'))
               <i class="far fa-file-excel middle file-icon"></i>
               @elseif($file['mime'] === 'application/pdf')
               <i class="far fa-file-pdf middle file-icon"></i>
               @else
               <i class="far fa-file-alt middle file-icon"></i>
               @endif
            </td>
            <td class="file-manager-padding-left" data-identifier="name" data-name="{{ rawurlencode($file['entry']) }}" data-path="@if($file['directory'] !== ''){{ rawurlencode($file['directory']) }}@endif/">
               @if(in_array($file['mime'], $editableMime))
               @can('edit-files', $server)
               <a href="/server/{{ $server->uuidShort }}/files/edit/@if($file['directory'] !== ''){{ rawurlencode($file['directory']) }}/@endif{{ rawurlencode($file['entry']) }}" class="edit_file">{{ $file['entry'] }}</a>
               @else
               {{ $file['entry'] }}
               @endcan
               @else
               {{ $file['entry'] }}
               @endif
            </td>
            <td data-identifier="size" class="d-none d-sm-table-cell">{{ $file['size'] }}</td>
            <td data-identifier="modified" class="d-none d-sm-table-cell">
               <?php $carbon = Carbon::createFromTimestamp($file['date'])->timezone(config('app.timezone')); ?>
               @if($carbon->diffInMinutes(Carbon::now()) > 60)
               {{ $carbon->format('m/d/y H:i:s') }}
               @elseif($carbon->diffInSeconds(Carbon::now()) < 5 || $carbon->isFuture())
               <em>@lang('server.files.seconds_ago')</em>
               @else
               {{ $carbon->diffForHumans() }}
               @endif
            </td>
            <td class="text-right">
               <div class="dropdown disable-menu-hide">
                  <button class="btn btn-sm disable-menu-hide" data-action="toggleMenu" style="padding:2px 6px 0px; background-color: #fff; color: inherit;"><i class="fas fa-ellipsis-v disable-menu-hide"></i></button>
               </div>
            </td>
         </tr>
         @endforeach
      </tbody>
   </table>
</div>
