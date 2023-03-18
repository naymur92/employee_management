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

    .contact .remove-btn,
    .contact-delete-btn {
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
      var content =
        '<div class="row"><div class="col-sm-12 col-md-6"><div class="form-group"><label><strong>Name</strong></label><div class="input-group mb-3"><input type="text" name="contact_name[]" class="form-control"><div class="input-group-append"><span class="input-group-text"><i class="fas fa-user"></i></span></div></div></div></div><div class="col-sm-12 col-md-6"><div class="form-group"><label><strong>Email</strong></label><div class="input-group mb-3"><input type="email" name="contact_email[]" class="form-control"><div class="input-group-append"><span class="input-group-text"><i class="fas fa-envelope"></i></span></div></div></div></div></div><div class="row"><div class="col-sm-12 col-md-6"><div class="form-group"><label><strong>Phone Number</strong></label><div class="input-group mb-3"><input type="text" name="contact_phone[]" class="form-control"><div class="input-group-append"><span class="input-group-text"><i class="fas fa-phone"></i></span></div></div></div></div><div class="col-sm-12 col-md-6"><div class="form-group"><label><strong>Relation</strong></label><div class="input-group mb-3"><input type="text" name="contact_relation[]" class="form-control"><div class="input-group-append"><span class="input-group-text"><i class="fas fa-people-arrows"></i></span></div></div></div></div></div>';

      $('.add-more-btn').click(function(event) {
        event.preventDefault();

        let htmlContent = '<fieldset class="fieldset contact"><legend><small>Contact ' + ($('.contact')
            .length + 1) +
          '</small></legend>' + content + '<i class="fas fa-trash text-danger remove-btn"></i></fieldset>'

        $('.contact-body').append(htmlContent);
      });

      jQuery(document).on('click', '.remove-btn', function() {
        jQuery(this).closest('.contact').remove();
        $('.contact').each(function(i) {
          $(this).find('small').html('Contact ' + (i + 1));
        });
      })

      // delete contact
      $('.contact-delete-btn').on('click', function(e) {
        e.preventDefault();

        var url = $(this).attr('href');

        // csrf bind
        var token = $("meta[name='csrf-token']").attr("content");

        $.ajax({
          url: url,
          type: "DELETE",
          data: {
            _token: token
          },
          success: function(data) {
            // console.log(data)
            // alert(data.success);
            if (data.success) {
              location.reload();
            }
          },
        });
      });
    });
  </script>
@endpush

@section('title', 'Edit Profile')

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a
                  href="{{ auth()->user()->type == 'admin' ? route('admin.home') : route('home') }}">Home</a></li>
              <li class="breadcrumb-item active">Edit Profile</li>
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
            <form action="{{ route('profile.update', $employee->id) }}" method="post" enctype="multipart/form-data">
              @csrf

              <div class="card card-info">
                <div class="card-header">
                  <h3 class="card-title">{{ $employee->name }}</h3>
                </div>
                <div class="card-body">
                  <fieldset class="fieldset">
                    <legend><strong>Employee Info</strong></legend>

                    {{-- Name --}}
                    <div class="form-group">
                      <label for="_name"><strong>Employee Fullname</strong></label>
                      <div class="input-group mb-3">
                        <input type="text" name="name" id="_name"
                          class="form-control @error('name') is-invalid @enderror"
                          value="{{ old('name', $employee->name) }}" placeholder="Full Name">
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
                          class="form-control @error('email') is-invalid @enderror"
                          value="{{ old('email', $employee->email) }}" placeholder="Email">
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
                          <label for="_pass"><strong>Password</strong></label>
                          <div class="input-group mb-3">
                            <input type="password" id="_pass" name="password" value="{{ old('password') }}"
                              class="form-control @error('password') is-invalid @enderror">
                            <div class="input-group-append">
                              <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            </div>
                          </div>

                          @error('password')
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                        </div>
                      </div>
                      <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                          <label for="_conf_pass"><strong>Retype Password</strong></label>
                          <div class="input-group mb-3">
                            <input type="password" id="_conf_pass" name="password_confirmation"
                              class="form-control @error('password') is-invalid @enderror">
                            <div class="input-group-append">
                              <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </fieldset>

                  <fieldset class="fieldset">
                    <legend><strong>Employee Details</strong></legend>

                    {{-- Address --}}
                    <div class="form-group">
                      <label for="_addr"><strong>Address</strong></label>
                      <textarea name="address" id="_addr" class="form-control @error('address') is-invalid @enderror" rows="5">{{ old('address', $employee->detail->address ?? '') }}</textarea>

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
                              <option value="Male"
                                {{ old('gender', $employee->detail->gender ?? '') == 'Male' ? 'selected' : '' }}>Male
                              </option>
                              <option value="Female"
                                {{ old('gender', $employee->detail->gender ?? '') == 'Female' ? 'selected' : '' }}>Female
                              </option>
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
                              class="form-control @error('dob') is-invalid @enderror"
                              value="{{ old('dob', $employee->detail->dob ?? '') }}" placeholder="Select DOB">
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

                    @foreach ($employee->contacts as $key => $item)
                      <fieldset class="fieldset contact">
                        <legend><small>Contact {{ $key + 1 }}</small></legend>

                        <input type="number" name="contact_id[{{ $key }}]" value="{{ $item->id }}"
                          hidden>
                        <div class="row">
                          <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                              <label><strong>Name</strong></label>
                              <div class="input-group mb-3">
                                <input type="text" name="contact_name[{{ $key }}]"
                                  value="{{ old('contact_name.' . $key, $item->contact_name) }}" class="form-control">
                                <div class="input-group-append">
                                  <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                              <label><strong>Email</strong></label>
                              <div class="input-group mb-3">
                                <input type="email" name="contact_email[{{ $key }}]"
                                  value="{{ old('contact_email.' . $key, $item->contact_email) }}"
                                  class="form-control">
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
                                <input type="text" name="contact_phone[{{ $key }}]"
                                  value="{{ old('contact_phone.' . $key, $item->contact_phone) }}"
                                  class="form-control">
                                <div class="input-group-append">
                                  <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                              <label><strong>Relation</strong></label>
                              <div class="input-group mb-3">
                                <input type="text" name="contact_relation[{{ $key }}]"
                                  value="{{ old('contact_relation.' . $key, $item->contact_relation) }}"
                                  class="form-control">
                                <div class="input-group-append">
                                  <span class="input-group-text"><i class="fas fa-people-arrows"></i></span>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <a href="{{ route('profile.delete_contact', $item->id) }}" class="contact-delete-btn"><i
                            class="fas fa-trash text-danger "></i></a>
                      </fieldset>
                    @endforeach


                    <button class="btn btn-primary add-more-btn"><i class="fas fa-plus mr-2"></i>Add More
                      Contact</button>
                  </fieldset>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <a class="btn btn-primary" href="{{ route('profile.show') }}"><i class="fas fa-angle-left"></i>
                    Back</a>
                  <input type="submit" value="Update Profile" class="btn btn-success float-right">
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
