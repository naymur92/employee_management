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

@section('title', 'Show Employee')

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Show Employee</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('employees.index') }}">Employees</a></li>
              <li class="breadcrumb-item active">Show Employee</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-sm-12 col-md-6">
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">{{ $employee->name }}</h3>
              </div>
              <div class="card-body">
                <table class="table table-striped">
                  <tr>
                    <th>Name:</th>
                    <td>{{ $employee->name }}</td>
                  </tr>
                  @isset($employee->detail->photo)
                    <tr>
                      <th>Photo:</th>
                      <td><img src="/assets/images/employees_photos/{{ $employee->detail->photo }}" alt=""
                          class="img-thumbnail" width="150px"></td>
                    </tr>
                  @endisset

                  <tr>
                    <th>Email:</th>
                    <td>{{ $employee->email }}</td>
                  </tr>
                  <tr>
                    <th>Status:</th>
                    <td>{{ $employee->status }}</td>
                  </tr>
                  <tr>
                    <th>Type:</th>
                    <td>{{ $employee->type }}</td>
                  </tr>
                  <tr>
                    <th>Joined At:</th>
                    <td>{{ date('d M, Y - h:i a', strtotime($employee->created_at)) }}</td>
                  </tr>
                  @isset($employee->detail->job_title)
                    <tr>
                      <th>Job Title:</th>
                      <td>{{ $employee->detail->job_title }}</td>
                    </tr>
                  @endisset
                  @isset($employee->detail->gender)
                    <tr>
                      <th>Gender:</th>
                      <td>{{ $employee->detail->gender }}</td>
                    </tr>
                  @endisset
                  @isset($employee->detail->dob)
                    <tr>
                      <th>Date of Birth:</th>
                      <td>{{ date('d M, Y', strtotime($employee->detail->dob)) }}</td>
                    </tr>
                  @endisset

                  @foreach ($employee->contacts as $key => $item)
                    <tr>
                      <th>Contact {{ $key + 1 }}:</th>
                      <td>
                        <table class="table table-hover">
                          <tr>
                            <td><span class="mr-2"><strong>Name:</strong></span> {{ $item->contact_name }}</td>
                            <td><span class="mr-2"><strong>Email:</strong></span> {{ $item->contact_email }}</td>
                          </tr>
                          <tr>
                            <td><span class="mr-2"><strong>Phone:</strong></span> {{ $item->contact_phone }}</td>
                            <td><span class="mr-2"><strong>Relation:</strong></span> {{ $item->contact_relation }}</td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  @endforeach

                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer d-flex justify-content-between">
                <a class="btn btn-primary" href="{{ route('employees.index') }}"><i class="fas fa-angle-left"></i>
                  Back</a>
                @if (!$employee->type == 'admin' || $employee->id != Auth::user()->id)
                  <a class="btn btn-warning" href="{{ route('employees.edit', $employee->id) }}"><i
                      class="fa fa-pen"></i>
                    Edit</a>
                  @if ($employee->status == 'confirmed')
                    <form action="{{ route('employees.change_emp_status', $employee->id) }}" method="post">
                      @csrf
                      @method('put')
                      <input type="number" name="status" value="0" hidden>
                      <button class="btn btn-warning"><i class="fa fa-times"></i> Make
                        Pending</button>
                    </form>
                  @endif
                  @if ($employee->status == 'pending')
                    <form action="{{ route('employees.change_emp_status', $employee->id) }}" method="post">
                      @csrf
                      @method('put')
                      <input type="number" name="status" value="1" hidden>
                      <button class="btn btn-success"><i class="fa fa-check"></i>
                        Confirm</button>
                    </form>
                  @endif

                  <form action="{{ route('employees.destroy', $employee->id) }}"
                    onsubmit="return confirm('Are you want to sure to delete?')" method="post">
                    @csrf
                    @method('delete')
                    <button class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                  </form>
                @endif
              </div>
            </div>

          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection
