@section('tasks::chain-template')
<div class="card-footer task-list-item" data-target="task-clone">
   <div class="row">
      <div class="form-group col-lg-3">
         <label>@lang('server.schedule.task.time')</label>
         <div class="row">
            <div class="col-lg-4">
               <select name="tasks[time_value][]" class="form-control">
                  @foreach(range(0, 59) as $number)
                  <option value="{{ $number }}">{{ $number }}</option>
                  @endforeach
               </select>
            </div>
            <div class="col-lg-8">
               <select name="tasks[time_interval][]" class="form-control ml-lg-2">
                  <option value="s">@lang('strings.seconds')</option>
                  <option value="m">@lang('strings.minutes')</option>
               </select>
            </div>
         </div>
      </div>
      <div class="form-group col-lg-3">
         <label class="control-label">@lang('server.schedule.task.action')</label>
         <div>
            <select name="tasks[action][]" class="form-control">
               <option value="command">@lang('server.schedule.actions.command')</option>
               <option value="power">@lang('server.schedule.actions.power')</option>
            </select>
         </div>
      </div>
      <div class="form-group col-lg-6">
         <label class="control-label">@lang('server.schedule.task.payload')</label>
         <div data-attribute="remove-task-element">
            <div class="row">
               <div class="col-lg-10">
                  <input type="text" name="tasks[payload][]" class="form-control">
               </div>
               <div class="col-lg-2">
                  <div class="input-group-btn">
                     <button type="button" class="btn btn-danger disabled remove-task btn-block" data-action="remove-task"><i class="fas fa-trash"></i></button>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@show
