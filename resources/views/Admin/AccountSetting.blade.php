@extends('Admin.MasterView')

@section('location')
<div class="container my-3">
    <div class="row gap-3 ms-1">
        <div class="col-md-4 col-12 p-2 rounded shadow border text-center">
            <div id="imageContainer" class="mb-3 profile_image">
                <img style="height: 50vh;" id="displayedImage" src="{{ empty($admin['image']) ? asset('Profile/profile.jpg') : asset('Profile/' . $admin['image']) }}" alt="Profile" class="img-fluid rounded">
            </div>
        </div>
        <div class="col-md-7 col-12 shadow rounded border p-3">
            <form  action="{{URL::to('/')}}/AdminSetting" method="post" id="UserSetting">
                @csrf
               @if (session('message'))
                    <div class="alert alert-dismissible bg-{{ session('type') }} fade show" role="alert">
                        </strong> {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="form-floating w-100 mb-3">
                    <input type="password" class="form-control border" name="currentPassword" id="currentPassword" placeholder="Enter your Current password">
                    <label for="currentPassword">Current password</label>
                    <span class="text-danger ms-1">
                        @error('currentPassword')
                            {{ $message }}
                        @enderror
                      </span>
                </div>
                <div class="form-floating w-100 mb-3">
                    <input type="password" class="form-control border" name="newPassword" id="newPassword" placeholder="Enter your New password">
                    <label for="newPassword">New password</label>
                    <span class="text-danger ms-1">
                        @error('newPassword')
                            {{ $message }}
                        @enderror
                      </span>
                </div>
                <div class="form-floating w-100 mb-3">
                    <input type="password" class="form-control border" name="newPassword_confirmation" id="newPassword_confirmation" placeholder="Confirm your New password">
                    <label for="newPassword_confirmation">Confirm password</label>
                    <span class="text-danger ms-1">
                        @error('newPassword_confirmation')
                            {{ $message }}
                        @enderror
                      </span>
                </div>
                <div class="float-end">
                    <div class="input-group-append ms-2 input-group">
                        <button class="btn btn-outline-secondary float-end rounded" type="button" id="showButton" onclick="togglePassword()">Show</button>
                        <button class="btn btn-outline-secondary d-none rounded" type="button" id="hideButton" onclick="togglePassword()">Hide</button>
                    </div>
                </div>
                <div class="form-floating w-100 mb-3">
                    <input type="submit" class="btnPrimary" value="Change password">
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function togglePassword() {
        const passwordInput1 = document.getElementById('currentPassword');
        const passwordInput2 = document.getElementById('newPassword');
        const passwordInput3 = document.getElementById('newPassword_confirmation');
        const showButton = document.getElementById('showButton');
        const hideButton = document.getElementById('hideButton');

        if (passwordInput1.type === 'password') {
            passwordInput1.type = 'text';
            passwordInput2.type = 'text';
            passwordInput3.type = 'text';
            showButton.classList.add('d-none');
            hideButton.classList.remove('d-none');
        } else {
            passwordInput1.type = 'password';
            passwordInput2.type = 'password';
            passwordInput3.type = 'password';
            hideButton.classList.add('d-none');
            showButton.classList.remove('d-none');
        }
    }
</script>
@endsection
