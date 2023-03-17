@extends('layouts.app')

@push('styles')
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/assets/dist/css/adminlte.min.css">

  <style>
    .fieldset {
      border: 1px solid #6c757d;
      border-radius: 5px;
      padding: 10px;
    }

    .fieldset legend {
      width: fit-content
    }

    .contact-body {
      position: relative;
    }

    .add-more-btn {
      position: absolute;
      top: -17px;
      right: 10px;
    }

    .contact {
      position: relative;
    }

    .contact .remove-btn {
      position: absolute;
      top: -17px;
      right: 7px;
      cursor: pointer;
    }

    .invalid-feedback {
      display: block
    }
  </style>
@endpush

@push('scripts')
  <!-- overlayScrollbars -->
  <script src="/assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
  <!-- AdminLTE App -->
  <script src="/assets/dist/js/adminlte.js"></script>
  <script>
    $(function() {
      bsCustomFileInput.init();
    });
  </script>

  <script>
    $(document).ready(function() {
      var content = $('#contact-fields').html();

      $('.add-more-btn').click(function(event) {
        event.preventDefault();

        let htmlContent = '<fieldset class="fieldset contact"><legend><small>Contact ' + ($('.contact')
            .length + 1) +
          '</small></legend>' + content + '<i class="fas fa-trash text-danger remove-btn"></i></fieldset>'

        $('.contact-body').append(htmlContent);

        console.log(htmlContent);

      });

      jQuery(document).on('click', '.remove-btn', function() {
        jQuery(this).closest('.contact').remove();
        $('.contact').each(function(i) {
          $(this).find('small').html('Contact ' + (i + 1));
        });
      })
    });
  </script>
@endpush

@section('title', 'Add Employee')

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Employee</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('employees.index') }}">Employees</a></li>
              <li class="breadcrumb-item active">Add Employee</li>
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
            <form action="{{ route('employees.store') }}" method="post" enctype="multipart/form-data">
              @csrf

              <div class="card card-info">
                <div class="card-header">
                  <h3 class="card-title">Employee Information</h3>
                </div>
                <div class="card-body">
                  <fieldset class="fieldset">
                    <legend><strong>Employee Info</strong></legend>

                    {{-- Name --}}
                    <div class="form-group">
                      <label for="_name"><strong>Employee Fullname</strong></label>
                      <div class="input-group mb-3">
                        <input type="text" name="name" id="_name"
                          class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                          placeholder="Full Name">
                      </div>

                      @error('name')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>

                    {{-- Email --}}
                    <div class="form-group">
                      <label for="_email"><strong>Email</strong></label>
                      <div class="input-group mb-3">
                        <input type="email" name="email" id="_email"
                          class="form-control  @error('email') is-invalid @enderror" value="{{ old('email') }}"
                          placeholder="Email">
                        <div class="input-group-append">
                          <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        </div>
                      </div>

                      @error('email')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>

                    <div class="row">
                      <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                          <label for="_status"><strong>Select Status</strong></label>
                          <div class="input-group mb-3">
                            <select type="select" name="status" id="_status"
                              class="form-control @error('status') is-invalid @enderror">
                              <option value="" selected disabled>Select One</option>
                              <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Pending</option>
                              <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Confirmed</option>
                            </select>
                            <div class="input-group-append">
                              <span class="input-group-text"><i class="fas fa-check"></i></span>
                            </div>
                          </div>

                          @error('status')
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                        </div>
                      </div>
                      <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                          <label for="_type"><strong>Select Type</strong></label>
                          <div class="input-group mb-3">
                            <select type="select" name="type" id="_type"
                              class="form-control @error('type') is-invalid @enderror">
                              <option value="" selected disabled>Select One</option>
                              <option value="0" {{ old('type') == '0' ? 'selected' : '' }}>Employee</option>
                              <option value="1" {{ old('type') == '1' ? 'selected' : '' }}>Admin</option>
                            </select>
                            <div class="input-group-append">
                              <span class="input-group-text"><i class="fas fa-user-shield"></i></span>
                            </div>
                          </div>

                          @error('type')
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="_pass"><strong>Password</strong></label>
                      <div class="input-group">
                        <input type="text" name="password" value="abcd1234" class="form-control" disabled>
                        <div class="input-group-append">
                          <span class="input-group-text">
                            <i class="fas fa-lock"></i>
                          </span>
                        </div>
                      </div>
                    </div>
                  </fieldset>

                  <fieldset class="fieldset">
                    <legend><strong>Employee Details</strong></legend>

                    {{-- Job Title --}}
                    <div class="form-group">
                      <label for="_job"><strong>Job Title</strong></label>
                      <div class="input-group mb-3">
                        <input type="text" name="jobtitle" id="_job"
                          class="form-control @error('jobtitle') is-invalid @enderror" value="{{ old('jobtitle') }}"
                          placeholder="Job Title">
                        <div class="input-group-append">
                          <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                        </div>
                      </div>

                      @error('jobtitle')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>

                    {{-- Address --}}
                    <div class="form-group">
                      <label for="_addr"><strong>Address</strong></label>
                      <textarea name="address" id="_addr" class="form-control @error('address') is-invalid @enderror" rows="5">{{ old('address') }}</textarea>

                      @error('address')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>

                    <div class="row">
                      {{-- Gender --}}
                      <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                          <label for="_gender"><strong>Select Gender</strong></label>
                          <div class="input-group mb-3">
                            <select type="select" name="gender" id="_gender"
                              class="form-control @error('gender') is-invalid @enderror">
                              <option value="" selected disabled>Select One</option>
                              <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                              <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                            <div class="input-group-append">
                              <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                            </div>
                          </div>

                          @error('gender')
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                        </div>
                      </div>

                      {{-- DOB --}}
                      <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                          <label for="_dob"><strong>Select Date Of Birth</strong></label>
                          <div class="input-group mb-3">
                            <input type="date" name="dob" id="_dob"
                              class="form-control @error('dob') is-invalid @enderror" value="{{ old('dob') }}"
                              placeholder="Select DOB">
                            <div class="input-group-append">
                              <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                            </div>
                          </div>

                          @error('dob')
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                        </div>
                      </div>
                    </div>

                    {{-- Photo --}}
                    <div class="form-group">
                      <label for="_photo">Photo</label>
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" name="photo"
                            class="custom-file-input @error('photo') is-invalid @enderror" id="_photo">
                          <label class="custom-file-label" for="_photo">Choose file</label>
                        </div>
                        <div class="input-group-append">
                          <span class="input-group-text"><i class="fas fa-image"></i></span>
                        </div>
                      </div>

                      @error('photo')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </fieldset>

                  <fieldset class="fieldset contact-body">
                    <legend><strong>Employee Contact Info</strong></legend>

                    <fieldset class="fieldset contact">
                      <legend><small>Contact 1</small></legend>

                      <div id="contact-fields">
                        <div class="row">
                          <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                              <label><strong>Name</strong></label>
                              <div class="input-group mb-3">
                                <input type="text" name="contact_name[]" value="{{ old('contact_name.0') }}"
                                  class="form-control @error('contact_name.*') is-invalid @enderror">
                                <div class="input-group-append">
                                  <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                              </div>

                              @error('contact_name.*')
                                <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          </div>
                          <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                              <label><strong>Email</strong></label>
                              <div class="input-group mb-3">
                                <input type="email" name="contact_email[]" value="{{ old('contact_email.0') }}"
                                  class="form-control @error('contact_email.*') is-invalid @enderror">
                                <div class="input-group-append">
                                  <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                              <label><strong>Phone Number</strong></label>
                              <div class="input-group mb-3">
                                <input type="text" name="contact_phone[]" value="{{ old('contact_phone.0') }}"
                                  class="form-control @error('contact_phone.*') is-invalid @enderror">
                                <div class="input-group-append">
                                  <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                </div>
                              </div>

                              @error('contact_phone.*')
                                <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          </div>
                          <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                              <label><strong>Relation</strong></label>
                              <div class="input-group mb-3">
                                <input type="text" name="contact_relation[]"
                                  value="{{ old('contact_relation.0') }}"
                                  class="form-control @error('contact_relation.*') is-invalid @enderror">
                                <div class="input-group-append">
                                  <span class="input-group-text"><i class="fas fa-people-arrows"></i></span>
                                </div>
                              </div>

                              @error('contact_relation.*')
                                <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          </div>
                        </div>
                      </div>

                    </fieldset>

                    <button class="btn btn-primary add-more-btn"><i class="fas fa-plus mr-2"></i>Add More
                      Contact</button>
                  </fieldset>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <input type="submit" value="Add Employee" class="btn btn-success float-right">
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
