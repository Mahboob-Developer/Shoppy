@extends('User.masterview')

@section('content')
<div class="container pt-3">
    <div class="row">
        <div class="col-md-6 offset-md-3 col-10 offset-1">
            <div class="card shadow-lg border rounded">
                <div class="card-header">
                    <h3 class="card-title text-center">Registration to Shoppy</h3>
                </div>
                <div class="card-body">
                    <form action="{{ URL::to('/Adminsingup') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" value="{{ old('name') }}" name="name" id="registrationname" placeholder="Full name">
                            <label for="registrationname" class="form-label">Full Name</label>
                            <span class="text-danger">
                                @error('name')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" value="{{ old('number') }}" name="number" id="registrationmobile" placeholder="Mobile" maxlength="10">
                            <label for="registrationmobile" class="form-label">Mobile</label>
                            <span class="text-danger">
                                @error('number')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" value="{{ old('email') }}" name="email" id="registrationemail" placeholder="Email">
                            <label for="registrationemail" class="form-label">Email</label>
                            <span class="text-danger">
                                @error('email')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="mb-3 form-control">
                            <label for="gender" class="form-label">Select Gender</label>
                            <div>
                                <input type="radio" class="btn-check"  name="gender" id="Male" value="Male" checked>
                                <label class="btn btn-outline-secondary" for="Male">Male</label>

                                <input type="radio" class="btn-check"  name="gender" id="Female" value="Female">
                                <label class="btn btn-outline-secondary" for="Female">Female</label>
                                <span class="text-danger">
                                    @error('gender')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" value="{{ old('brand') }}" name="brand" id="registrationpincode" placeholder="Brand Name">
                            <label for="registrationpincode" class="form-label">Brand Name</label>
                            <span class="text-danger">
                                @error('brand')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" value="{{ old('pincode') }}" name="pincode" id="registrationpincode" placeholder="Pincode">
                            <label for="registrationpincode" class="form-label">Pincode</label>
                            <span class="text-danger">
                                @error('pincode')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" value="{{ old('address') }}" name="address" id="registrationaddress" placeholder="Address">
                            <label for="registrationaddress" class="form-label">Address</label>
                            <span class="text-danger">
                                @error('address')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" name="password" id="registrationpassword" placeholder="Password">
                            <label for="registrationpassword" class="form-label mb-1">Password</label>
                            <span class="text-danger">
                                @error('password')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" name="password_confirmation" id="registrationconfirm" placeholder="Confirm Password">
                            <label for="registrationconfirm" class="form-label">Confirm Password</label>
                            <span class="text-danger">
                                @error('password_confirmation')
                                    {{ $message }}
                                @enderror
                            </span>
                            <div class="float-end my-3">
                                <div class="input-group-append ms-2 input-group">
                                    <button class="btn btn-outline-secondary float-end rounded" type="button" id="showButton" onclick="togglePassword()">Show</button>
                                    <button class="btn btn-outline-secondary d-none rounded" type="button" id="hideButton" onclick="togglePassword()">Hide</button>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid w-100 mb-3">
                            <input type="submit" value="Register" class="btn btn-outline-primary"/>
                            <span class="my-3">
                                Already have an account? <a href="{{ URL::to('/') }}/Adminlogin">Login</a>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-floating > .form-label {
        margin-bottom: 0.5rem; /* Adjust the value as needed */
    }
</style>

<script>
    function togglePassword() {
        const passwordInput1 = document.getElementById('registrationpassword');
        const passwordInput2 = document.getElementById('registrationconfirm');
        const showButton = document.getElementById('showButton');
        const hideButton = document.getElementById('hideButton');

        if (passwordInput1.type === 'password') {
            passwordInput1.type = 'text';
            passwordInput2.type = 'text';
            showButton.classList.add('d-none');
            hideButton.classList.remove('d-none');
        } else {
            passwordInput1.type = 'password';
            passwordInput2.type = 'password';
            hideButton.classList.add('d-none');
            showButton.classList.remove('d-none');
        }
    }
</script>
@endsection
