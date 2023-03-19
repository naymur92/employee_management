@extends('layouts.app')

@push('styles')
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/assets/dist/css/adminlte.min.css">
@endpush

@push('scripts')
  <!-- AdminLTE App -->
  <script src="/assets/dist/js/adminlte.js"></script>
@endpush

@section('title', 'Report Query - Admin Panel')

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Report Query</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
              <li class="breadcrumb-item active">Generate Report</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        {{-- form 1 --}}
        <div class="row justify-content-center">
          <div class="col-sm-12">
            <form action="{{ route('admin_reports.generate') }}" method="post">
              @csrf
              <div class="card card-info">
                <div class="card-header">
                  <h3 class="card-title">Generate attendance report between two dates</h3>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-12 col-md-3">
                      <div class="form-group">
                        <label for="_pos"><strong>Select Position</strong></label>
                        <select name="position" id="_pos" class="form-control">
                          <option value="" selected>All</option>
                          @foreach ($positions as $item)
                            <option value="{{ $item }}">{{ $item }}</option>
                          @endforeach
                        </select>
                        @if (auth()->user()->attendances->last()->date == date('Y-m-d') &&
                                auth()->user()->attendances->last()->exit_time == '')
                          okay
                        @else
                          false
                        @endif
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                      <div class="form-group">
                        <label for="_emp"><strong>Select Employee</strong></label>
                        <select name="employee" id="_emp" class="form-control">
                          <option value="" selected>All</option>
                          @foreach ($employees as $item)
                            <option value="{{ $item->id }}">
                              {{ $item->name }} ({{ $item->email }}) -
                              {{ $item->detail->job_title ?? '' }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                      <div class="form-group">
                        <label for="_start"><strong>Start Date</strong></label>
                        <input type="date" id="_start" name="start_date" class="form-control" required>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                      <div class="form-group">
                        <label for="_end"><strong>End Date</strong></label>
                        <input type="date" id="_end" name="end_date" class="form-control" required>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <input type="submit" value="Generate Report" class="btn btn-success float-right">
                </div>
              </div>
            </form>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection
