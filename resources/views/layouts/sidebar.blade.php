<?php
// set collapsed class
function isCollapsed(array $controllerNameArray)
{
    $c_con_array = explode('.', Route::currentRouteName());
    $current_controller = $c_con_array[0];
    if (in_array($current_controller, $controllerNameArray)) {
        echo 'menu-open';
    }
}

// set active class in main menu
function isMenuActive(array $controllerNameArray)
{
    $c_con_array = explode('.', Route::currentRouteName());
    $current_controller = $c_con_array[0];
    if (in_array($current_controller, $controllerNameArray)) {
        echo 'active';
    }
}

// set active class
function isActive($routeName)
{
    if (Route::currentRouteName() == $routeName) {
        echo 'active';
    }
}
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ auth()->user()->type == 'admin' ? route('admin.home') : route('home') }}" class="brand-link">
    <span class="brand-text font-weight-light">EmployeeManagement</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        @isset(auth()->user()->detail->photo)
          <img src="/assets/images/employees_photos/{{ auth()->user()->detail->photo }}" class="img-circle elevation-2"
            alt="User Image">
        @else
          <img src="/assets/images/employees_photos/no_image.jpg" class="img-circle elevation-2" alt="User Image">
        @endisset

      </div>
      <div class="info">
        <a href="#" class="d-block">{{ auth()->user()->name }}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        {{-- Dashboard --}}
        <li class="nav-item">
          <a href="{{ auth()->user()->type == 'admin' ? route('admin.home') : route('home') }}"
            class="nav-link {{ auth()->user()->type == 'admin' ? isActive('admin.home') : isActive('home') }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>

        @if (auth()->user()->type == 'admin')
          {{-- Admin Section --}}

          {{-- Employees --}}
          <li class="nav-item {{ isCollapsed(['employees']) }}">
            <a href="#" class="nav-link {{ isMenuActive(['employees']) }}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Employees
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('employees.index') }}" class="nav-link {{ isActive('employees.index') }}">
                  <i class="fas fa-list nav-icon"></i>
                  <p>Employee List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('employees.create') }}" class="nav-link {{ isActive('employees.create') }}">
                  <i class="fas fa-plus nav-icon"></i>
                  <p>Add Employee</p>
                </a>
              </li>
            </ul>
          </li>
        @else
          {{-- Employees Section --}}
        @endif

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
