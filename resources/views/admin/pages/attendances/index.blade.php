@extends('layouts.app')

@push('styles')
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">

  <!-- DataTables -->
  <link rel="stylesheet" href="/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="/assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="/assets/dist/css/adminlte.min.css">
@endpush

@push('scripts')
  <!-- DataTables  & Plugins -->
  <script src="/assets/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="/assets/plugins/jszip/jszip.min.js"></script>
  <script src="/assets/plugins/pdfmake/pdfmake.min.js"></script>
  <script src="/assets/plugins/pdfmake/vfs_fonts.js"></script>
  <script src="/assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="/assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="/assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

  <!-- AdminLTE App -->
  <script src="/assets/dist/js/adminlte.min.js"></script>

  <script>
    $(function() {
      $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        'order': [],
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
  </script>
@endpush

@section('title', 'Attendance List')

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Attendance List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
              <li class="breadcrumb-item active">Attendance List</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Attendances</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped text-center">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Job Title</th>
                      <th>Date</th>
                      <th>Entry Time (09:00 am)</th>
                      <th>Exit Time (05:00 pm)</th>
                      <th>Total Time</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($attendances as $item)
                      <tr>
                        <td>{{ $item->employee->name }}</td>
                        <td>{{ $item->employee->detail->job_title ?? '' }}</td>
                        <td>{{ date('d M, Y', strtotime($item->date)) }}</td>
                        @isset($item->entry_time)
                          {{-- check late entry --}}
                          <td>
                            <?php
                            $in_time = strtotime('09:00:59');
                            $entry_time = strtotime($item->entry_time);
                            ?>
                            @if ($in_time - $entry_time < 0)
                              <span class="badge badge-danger">{{ date('h:i a', strtotime($item->entry_time)) }}</span>
                            @else
                              <span class="badge badge-success">{{ date('h:i a', strtotime($item->entry_time)) }}</span>
                            @endif
                          </td>
                        @else
                          <td></td>
                        @endisset
                        @isset($item->exit_time)
                          {{-- check early leave --}}
                          <td>
                            <?php
                            $out_time = strtotime('17:00:00');
                            $exit_time = strtotime($item->exit_time);
                            ?>
                            @if ($exit_time - $out_time < 0)
                              <span class="badge badge-danger">{{ date('h:i a', strtotime($item->exit_time)) }}</span>
                            @else
                              <span class="badge badge-success">{{ date('h:i a', strtotime($item->exit_time)) }}</span>
                            @endif
                          </td>
                        @else
                          <td></td>
                        @endisset
                        <td>
                          @if ($item->entry_time != '' && $item->exit_time != '')
                            <?php
                            $time1 = $item->entry_time; // first time in hours:minutes format
                            $time2 = $item->exit_time; // second time in hours:minutes format
                            
                            // Convert times to minutes
                            $minutes1 = strtotime($time1) / 60;
                            $minutes2 = strtotime($time2) / 60;
                            
                            // Calculate the difference in minutes
                            $diff_minutes = $minutes2 - $minutes1;
                            
                            // Convert the difference back to hours and minutes
                            $hours = floor($diff_minutes / 60);
                            $minutes = $diff_minutes % 60;
                            ?>
                            @if ($hours < 8)
                              <span class="badge badge-danger">{{ $hours }} Hours : {{ $minutes }}
                                Minutes</span>
                            @else
                              <span class="badge badge-success">{{ $hours }} Hours : {{ $minutes }}
                                Minutes</span>
                            @endif
                          @else
                            N/A
                          @endif
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>Name</th>
                      <th>Job Title</th>
                      <th>Date</th>
                      <th>Entry Time (09:00 am)</th>
                      <th>Exit Time (05:00 pm)</th>
                      <th>Total Time</th>
                    </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection
