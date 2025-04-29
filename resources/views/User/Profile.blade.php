@extends('User.masterview')

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
                        <input type="file" id="profile_image" name="profile_image" hidden onchange="getImagePreview(event)"  />
                        <label class="btnPrimary btn" for="profile_image">Select Image</label>

                        <input type="submit" value="Change Image" class="btnDanger" />
                    </form>
                </div>
            </div>

            {{-- this is user for disable form for show data from database --}}
            <div class="col-md-7 col-12 shadow rounded border p-3 " id="disable_form">
                    <div class="form-floating w-100 mb-3">
                        <input
                            type="text"
                            class="form-control border bg-light"
                            name="fullname"
                            id="fullname"
                            placeholder="Enter Your Full Name"
                            value="{{$user['fullname']}}"
                            disabled
                        />
                        <label for="floatingInput">Your Name</label>
                    </div>
                    <div class="border rounded bg-light  w-100 p-3 mb-3">
                        <label for="gender" class="form-label pe-3">Select Gender</label>
                        <input type="radio" class="btn-check readonly" name="gender" id="Male" value="male"
                            autocomplete="off" {{($user['gender']=='male')?'checked':''}} disabled>
                        <label class="btn btn-light btn-outline-secondary readonly" for="Male">Male</label>
    
                        <input type="radio" class="btn-check readonly" name="gender" id="Female" value="female"
                            autocomplete="off" {{($user['gender']=='female')?'checked':''}}  disabled>
                        <label class="btn btn-light btn-outline-secondary readonly" for="Female">Female</label>
                    </div>
                    <div class="form-floating w-100 mb-3">
                        <input
                            type="text"
                            class="form-control bg-light border"
                            name="email"
                            id="email"
                            placeholder="Enter Your Email Address"
                            value="{{$user['email']}}"
                            disabled
                        />
                        <label for="floatingInput">Your Email</label>
                    </div>
                    <div class="form-floating w-100 mb-3">
                        <input
                            type="text"
                            class="form-control bg-light border"
                            name="mobile"
                            value="{{$user['mobile']}}"
                            id="mobile"
                            placeholder="Enter Your Mobile"
                            maxlength="10"
                            disabled
                        />
                        <label for="floatingInput">Mobile Number</label>
                    </div><a class="nav-link btnPrimary w-25 text-center" href="{{ URL::to('/ProfileUpdate') }}">Edit</a>
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