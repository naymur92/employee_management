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

@section('title', 'Contact List')

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Contact List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a
                  href="{{ auth()->user()->type == 'admin' ? route('admin.home') : route('home') }}">Home</a></li>
              <li class="breadcrumb-item active">Contacts</li>
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
                <h3 class="card-title">Contacts of {{ auth()->user()->name }}</h3>
              </div>
              <div class="card-body">
                <table class="table table-striped">

                  @forelse ($contacts as $key => $item)
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
                  @empty
                    No Contact Founds!!
                  @endforelse

                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <a class="btn btn-primary"
                  href="{{ auth()->user()->type == 'admin' ? route('admin.home') : route('home') }}"><i
                    class="fas fa-angle-left"></i>
                  Back</a>
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
