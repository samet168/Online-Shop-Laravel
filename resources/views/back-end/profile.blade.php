@extends('back-end.components.master')
@section('contens')
  <div class="row">

    <div class="col-md-4 grid-margin">
      <div class="card">
        <div class="card-body">
         
        </div>
      </div>
    </div>

    <div class="col-md-8 grid-margin">
        
        <div class="card">
          <div class="card-body">
            {{-- alert success --}}
               @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex justify-content-between px-2" role="alert">
                   <strong>{{ Session::get('success') }}</strong> 
                   <i data-bs-dismiss="alert" aria-label="Close" class="bi bi-x-lg"></i>  
                </div>
              @endif



                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="me-2 mb-2 nav-link  {{ Session::has('profile') ? 'active' : ' '  }} " id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Overview</button>
                        <button class="mx-1 mb-2 nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Edit Profile</button>
                        <button class="mx-1 mb-2 nav-link" id="nav-saling-tab" data-bs-toggle="tab" data-bs-target="#nav-saling" type="button" role="tab" aria-controls="nav-saling" aria-selected="false">Saling</button>
                        <button class="mx-1 mb-2 nav-link {{ Session::has('password') ? 'active' : ' '  }} " id="nav-change-pass-tab" data-bs-toggle="tab" data-bs-target="#nav-change-pass" type="button" role="tab" aria-controls="nav-change-pass" aria-selected="false">Change Password</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">

                    {{-- Overview --}}
                    <div class="tab-pane fade {{ Session::has('profile') ? 'show active' : ' '  }} p-3" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">

                    <form method="POST" action="{{ route('profile.update') }}" class="p-4 formUpdateProfile" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Profile Image</label>
                            <div class="show-profile">
                                <!-- hidden input ទទួល filename ពី AJAX -->
                                <input type="hidden" name="image_name" id="image_name">

                                <img class="img-md rounded-circle" src="{{ asset('uploads/user/'.Auth::user()->image) }}" alt="Profile image">

                                <label for="image" class="btn choose"><i class="bi bi-pen text-primary"></i></label>
                                <br><br>
                                <button type="button" class="btn btn-info btn-sm" onclick="changeImageProfile('.formUpdateProfile')">
                                    <i class="bi bi-upload"></i> Upload
                                </button>
                                <input type="file" name="image" id="image" class="d-none">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}">
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}">
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ Auth::user()->phone }}">
                        </div>

                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>
                        
                    </div>

                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">...</div>
                    <div class="tab-pane fade" id="nav-saling" role="tabpanel" aria-labelledby="nav-saling-tab" tabindex="0">...</div>
                    
                    {{-- Change password --}}
                    <div class="tab-pane fade  {{ Session::has('password') ? 'show active' : ' '  }} p-3" id="nav-change-pass" role="tabpanel" aria-labelledby="nav-change-pass-tab" tabindex="0">

                        <form action="{{ route('profile.change.password') }}" class=" p-4 border" method="POST" >
                            @csrf
                            <div class="form-group">
                                <label for="current_pass">Current Password</label>
                                <input type="password" class="form-control @error('current_pass') is-invalid  @enderror" id="current_pass" name="current_pass">
                                @error('current_pass')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="new_pass">New Password</label>
                                <input type="password" class="form-control @error('new_pass') is-invalid  @enderror" id="new_pass" name="new_pass">
                                @error('new_pass')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="c_password">Confirm Password</label>
                                <input type="password" class="form-control @error('c_password') is-invalid  @enderror" id="c_password" name="c_password">
                                @error('c_password')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                       

                    </div>

                </div>
          </div>
        </div>
      </div>

  </div>
@endsection

@section('scripts')
  <script>
    const changeImageProfile = (form) => {
        let payload = new FormData($(form)[0]);
        $.ajax({
            type: "POST",
            url: "{{ route('profile.change.image') }}",
            data: payload,
            dataType: "json",
            processData: false,
            contentType: false,
            success: function (response) {
                console.log(response);
                 if(response.status == 200){
                    $(".show-profile img").attr('src',`{{ asset('uploads/temp/${response.image}') }}`);

                    $("#image_name").val(response.image);
                    console.log(response.image);
                    $("#image").val('');
                    
                
                    Message(response.message);
                }else{
                    Message(response.message,false);
                }
            }
        });
    }
  </script>
@endsection