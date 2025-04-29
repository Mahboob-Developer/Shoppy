@extends('./user/masterview')

@section('content')
<style>
    .password-toggle-icon {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
    }
</style>

<div class="container">
    <div class="row mt-md-5" style="height: 45vh;">
        <div class="col-md-5 offset-md-3 offset-1 col-10 px-5 shadow-lg border rounded">
            <div class="container">
                <form class="p-3" action="{{ url('/ResetPassword/' . $status . '/' . $token) }}" method="post">
                    @csrf
                    <div class="modal-header d-md-block d-none">
                        <h1 class="modal-title fs-3 pb-4">Reset your password</h1>
                    </div>
                    <div class="modal-header d-md-none d-block">
                        <p class="modal-title fw-bold pb-4">Log In to Shoppy</p>
                    </div>
                    
                    <!-- New Password Input -->
                    <div class="form-floating mb-3 position-relative">
                        <input type="password" class="form-control" name="newpassword" id="newpassword" placeholder="New Password" />
                        <label for="newpassword">New Password</label>
                        <span class="text-danger">
                            @error('newpassword')
                                {{ $message }}
                            @enderror
                        </span>
                        <span class="password-toggle-icon fs-4" onclick="togglePasswordVisibility('newpassword')">&#x1F441;</span>
                    </div>

                    <!-- Confirm Password Input -->
                    <div class="form-floating mb-3 position-relative">
                        <input type="password" class="form-control" name="conformpassword" id="conformpassword" placeholder="Confirm Password" />
                        <label for="conformpassword">Confirm Password</label>
                        <span class="text-danger">
                            @error('conformpassword')
                                {{ $message }}
                            @enderror
                        </span>
                        <span class="password-toggle-icon fs-4" onclick="togglePasswordVisibility('conformpassword')">&#x1F441;</span>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid gap-2 col-12 mx-auto">
                        <button type="submit" name="login" class="btn-lg btn btn-outline-primary">Reset Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePasswordVisibility(fieldId) {
        var field = document.getElementById(fieldId);
        if (field.type === "password") {
            field.type = "text";
        } else {
            field.type = "password";
        }
    }
</script>

@endsection
