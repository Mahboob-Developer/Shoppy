@extends('Owner.MasterView')

@section('location')
    <div class="container my-3">
        <div class="row gap-5 mx-2">
            @if (session('success'))
                        <div class="alert alert-success alert-dismissible bg-success fade show" role="alert">
                            <strong>{{ session('success') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
            <div class="col-md-4 col-12 p-2 rounded shadow border text-center">
                <div id="imageContainer">
                    <img
                        style="height: 50vh;"
                        id="displayedImage"
                        src="{{ empty($admin->image) ? asset('Profile/profile.png') : asset('Profile/'.$admin->image) }}"
                        alt="Profile"
                        class="img-fluid rounded"
                    />

                    <form action="{{ URL::to('/ownerprofile') }}" method="post" enctype="multipart/form-data" class="my-3">
                        @csrf
                        <input type="file" id="profile_image" name="profile_image" hidden onchange="getImagePreview(event)"  />
                    <label class="btnPrimary btn" for="profile_image">Select Image</label>

                        <input type="submit" value="Change Image" class="btnDanger" />
                    </form>
                </div>
            </div>

            {{-- this is user for disable form for show data from database --}}
            <div class="col-md-7 col-12 shadow rounded border p-3 " id="disable_form">
                <form method="post" action="#">
                    @csrf
                    <div class="form-floating w-100 mb-3">
                        <input
                            type="text"
                            class="form-control border bg-light"
                            name="fullname"
                            id="fullname"
                            placeholder="Enter Your Full Name"
                            value="{{$admin->fullname}}"
                            disabled
                        />
                        <label for="floatingInput">Your Name</label>
                    </div>
                    <div class="border rounded bg-light  w-100 p-3 mb-3">
                        <label for="gender" class="form-label pe-3">Select Gender</label>
                        <input type="radio" class="btn-check readonly" name="gender" id="Male" value="male"
                            autocomplete="off" {{$admin->gender=='male'?'checked':''}} disabled>
                        <label class="btn btn-light btn-outline-secondary readonly" for="Male">Male</label>
    
                        <input type="radio" class="btn-check readonly" name="gender" id="Female" value="female"
                            autocomplete="off" {{$admin->gender=='female'?'checked':''}}  disabled>
                        <label class="btn btn-light btn-outline-secondary readonly" for="Female">Female</label>
                    </div>
                    <div class="form-floating w-100 mb-3">
                        <input
                            type="text"
                            class="form-control bg-light border"
                            name="email"
                            id="email"
                            placeholder="Enter Your Email Address"
                            value="{{$admin->email}}"
                            disabled
                        />
                        <label for="floatingInput">Your Email</label>
                    </div>
                    <div class="form-floating w-100 mb-3">
                        <input
                            type="text"
                            class="form-control bg-light border"
                            name="mobile"
                            id="mobile"
                            value="{{$admin->mobile}}"
                            placeholder="Enter Your Mobile"
                            maxlength="10"
                            disabled
                        />
                        <label for="floatingInput">Mobile Number</label>
                    </div>
                    <button type="button" class="btnPrimary w-25"><a class="nav-link" href="{{URL::to('/AccountUpdate')}}">Edit</a></button>
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