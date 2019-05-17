@include('partials/admin.settings.notice')

@section('settings::nav')
@yield('settings::notice')
<div class="row mt--7 mb-cs">
   <div class="col-lg-12">
      <div class="card shadow bg-secondary">
        <div class="card-body bg-secondary" style="padding: 0.75rem">
          <ul class="nav nav-pills nav-fill flex-column flex-sm-row" id="tabs-text" role="tablist">
             <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0 {{ $activeTab === 'basic' ? 'active' : '' }}" href="{{ route('admin.settings') }}" role="tab">General</a>
             </li>
             <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0 {{ $activeTab === 'mail' ? 'active' : '' }}" href="{{ route('admin.settings.mail') }}" role="tab">Mail</a>
             </li>
             <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0 {{ $activeTab === 'advanced' ? 'active' : '' }}" href="{{ route('admin.settings.advanced') }}" role="tab">Advanced</a>
             </li>
          </ul>
        </div>
      </div>
   </div>
</div>
@endsection
