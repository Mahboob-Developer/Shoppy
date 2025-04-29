@extends('User.masterView')

@section('content')
    <div class="container my-3">
        <div class="row gap-5 mx-2">
            <div class="col-md-4 col-12 p-2 rounded shadow border text-center">
                <div id="imageContainer">
                    <img
                        style="height: 50vh;"
                        id="displayedImage"
                        src="{{ empty($user->image) ? asset('Profile/profile.png') : asset('Profile/'.$user->image) }}"
                        alt="Profile"
                        class="img-fluid rounded"
                    />

                    <form action="{{URL::to('/UserProfileForm')}}" method="post" enctype="multipart/form-data" class="my-3">
                        @csrf
                        <input type="file" id="profile_image" name="profile_image" hidden onchange="getImagePreview(event)"/>
                        <label class="btnPrimary btn" for="profile_image">Select Image</label>
                            
                        <input type="submit" value="Change Image" class="btnDanger" />
                    </form>
                </div>
            </div>
                <div class="col-md-7 col-12 shadow rounded border p-3">
                    <form method="post" action="{{URL::to('/')}}/ProfileUpdate">
                        @csrf
                    
                        <div class="form-floating w-100 mb-3">
                            <input
                                type="text"
                                class="form-control border"
                                name="fullname"
                                value="{{$user['fullname']}}"
                                id="fullname"
                                placeholder="Enter Your Full Name"
                            />
                            <label for="fullname">Your Name</label>
                            <span class="text-danger ms-1">
                                @error('fullname')
                                {{ $message }}
                                @enderror
                            </span>
                            
                        </div>
                        <div class="border rounded p-3 mb-3">
                            <label for="gender" class="form-label pe-3">Select Gender</label>
                            <span class="d-md-none d-block">
                                <br>
                            </span>
                            <input type="radio" class="btn-check" name="gender" id="Male" value="Male" autocomplete="on"
                                checked>
                            <label class="btn btn-light btn-outline-secondary " for="Male">Male</label>
                            <input type="radio" class="btn-check" name="gender" id="Female" value="Female" autocomplete="on">
                            <label class="btn btn-light btn-outline-secondary" for="Female">Female</label>
                            <span class="text-danger ms-1">
                                @error('gender')
                                {{ $message }}
                                @enderror
                            </span>
                        </div>
                    
                        <div class="form-floating w-100 mb-3">
                            <input
                                type="email"
                                class="form-control border"
                                name="email"
                                value="{{$user['email']}}"
                                id="email"
                                placeholder="Enter Your Email Address"
                            />
                            <label for="email">Your Email</label>
                            <span class="text-danger ms-1">
                                @error('email')
                                {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-floating w-100 mb-3">
                            <input
                                type="text"
                                class="form-control border"
                                name="mobile"
                                id="mobile"
                                value="{{$user['mobile']}}"
                                placeholder="Enter Your Mobile"
                                maxlength="10"
                            />
                            <label for="mobile">Mobile Number</label>
                            <span class="text-danger ms-1">
                                @error('mobile')
                                {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <button type="submit" name="save" class="btnPrimary w-25">Save</button>
                        <button  class="btnDanger w-25 mx-1"><a class="nav-link" href="{{URL::to('/UserProfile')}}">Cancel</a></button>
                    </form>
                </div>
        </div>
    </div>
@endsection
<script>
    function getImagePreview(event){
        var image = URL.createObjectURL(event.target.files[0]);
        var displayedImage = document.getElementById('displayedImage');
        displayedImage.src = image;
    }
</script>