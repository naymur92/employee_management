<nav class="main-header navbar navbar-expand navbar-dark">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="{{ auth()->user()->type == 'admin' ? route('admin.home') : route('home') }}" class="nav-link">Home</a>
    </li>
    @if (Route::currentRouteName() == 'home' || Route::currentRouteName() == 'admin.home')
      @if (!isset($if_att_exists->entry_time) || $if_att_exists->entry_time == '')
        <li class="nav-item d-none d-sm-inline-block">
          <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#staticBackdrop">
            Start Attendance
          </button>
        </li>
      @endif
      @if (isset($if_att_exists->entry_time) && $if_att_exists->entry_time != '' && $if_att_exists->exit_time == '')
        <li class="nav-item d-none d-sm-inline-block">
          <form action="{{ route('end-attendance') }}" method="post">
            @csrf
            <button class="btn btn-outline-success ml-2">
              End Attendance
            </button>
          </form>
        </li>
      @endif
    @endif

  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Navbar Search -->
    <li class="nav-item">
      <a class="nav-link" data-widget="navbar-search" href="#" role="button">
        <i class="fas fa-search"></i>
      </a>
      <div class="navbar-search-block">
        <form class="form-inline">
          <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-navbar" type="submit">
                <i class="fas fa-search"></i>
              </button>
              <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
        </form>
      </div>
    </li>

    <!-- Notifications Dropdown Menu -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        <span class="badge badge-warning navbar-badge">15</span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-item dropdown-header">15 Notifications</span>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-envelope mr-2"></i> 4 new messages
          <span class="float-right text-muted text-sm">3 mins</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-users mr-2"></i> 8 friend requests
          <span class="float-right text-muted text-sm">12 hours</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-file mr-2"></i> 3 new reports
          <span class="float-right text-muted text-sm">2 days</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
      </div>
    </li>

    <!-- User Dropdown Menu -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="fas fa-user-shield"></i>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-item dropdown-header">{{ auth()->user()->name }} ({{ auth()->user()->type }})</span>
        <div class="dropdown-divider"></div>
        <a href="{{ route('profile.show') }}" class="dropdown-item">
          <i class="fas fa-user mr-2"></i> Profile
        </a>
        <div class="dropdown-divider"></div>
        <a href="{{ route('profile.contacts') }}" class="dropdown-item">
          <i class="fas fa-users mr-2"></i> Contacts
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item d-flex justify-content-end" href="{{ route('logout') }}"
          onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <button class="btn btn-outline-danger">{{ __('Logout') }}</button>
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
          @csrf
        </form>
      </div>
    </li>
  </ul>
</nav>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
  aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Start Attendance</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('start-attendance') }}" method="post" id="attendance_start_form">
          @csrf
        </form>
        <div class="d-flex justify-content-center">
          {{-- push button --}}
          <button class="button-hold">
            <div>
              <svg class="icon" viewBox="0 0 16 16">
                <polygon points="1.3,6.7 2.7,8.1 7,3.8 7,16 9,16 9,3.8 13.3,8.1 14.7,6.7 8,0"></polygon>
              </svg>
              <svg class="progress" viewBox="0 0 32 32">
                <circle r="8" cx="16" cy="16" />
              </svg>
              <svg class="tick" viewBox="0 0 24 24">
                <polyline points="18,7 11,16 6,12" />
              </svg>
            </div>
          </button>
        </div>
        <div class="d-flex justify-content-center mt-2">
          <h4>Push to confirm</h4>
        </div>

      </div>

    </div>
  </div>
</div>
