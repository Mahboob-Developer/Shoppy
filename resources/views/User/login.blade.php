@extends('./user/masterview')
<style>
    .password-toggle-icon {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
    }
</style>
    @section('content')
    <div class="container">
        <div class="row mt-md-5 loginadmin">
            <div class="py-3 col-md-5 offset-md-3 offset-1 col-10 px-5 shadow-lg border rounded">
                <div class="container p-3">
                    <form  action="{{url('/login')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header d-md-block d-none">
                            <h1 class="modal-title fs-3 text-center  pb-4" id="staticBackdropLabel">
                               Log In to Shoopy
                            </h1>
                        </div>
                        <div class="modal-header d-md-none d-block">
                            <p class="modal-title fw-bold text-center  pb-4" id="staticBackdropLabel">
                                Log In to Shoppy
                            </p>
                        </div>
                        @if (session('success'))
                            <div class="alert alert-dark alert-dismissible bg-success fade show" role="alert">
                        <strong>{{ session('success') }}</strong> .
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif
                         @if (session('danger'))
                            <div class="alert alert-dark alert-dismissible bg-danger fade show" role="alert">
                        <strong>{{ session('danger') }}</strong> .
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif
                        <div class="form-floating mb-3 position-relative">
                            <input type="text" class="form-control" name="email" id="loginmobile" placeholder="Enter Your Mobile"  />
                            <label for="loginmobile">Email</label>
                            <span class="text-danger">
                              @error('email')
                              {{$message}}
                              @enderror
                          </span>
                        </div>
                        <div class="form-floating mb-3 position-relative">
                            <input type="password" class="form-control" name="password" id="loginpassword" placeholder="Enter Your Password">
                            <label for="loginpassword">Password</label>
                            <span class="text-danger">
                                @error('password')
                                {{$message}}
                                @enderror
                            </span>
                            <a href="{{ URL::to('/Forget/User') }}" class="text-primary float-end pt-1">Forget Password?</a>
                            <span class="password-toggle-icon position-absolute end-0 top-50 translate-middle-y me-3" onclick="togglePassword()">
                                <i id="eyeIcon" class="fas fa-eye"></i>
                            </span>
                        </div>
                        <div class="d-grid gap-2 col-12 mx-auto">
                            <button type="submit" name="login" class="d-md-block d-none btn-lg btn btn-outline-primary">Login</button>
                            <button type="submit" name="login" class="d-md-none d-block btn-sm btn btn-outline-primary">Login</button>
                            <span class="my-3 d-md-flex d-none">Don't have account ? <a href="{{url('sign_up')}}">Create account</a></span>
                            <small class="my-3 d-md-none d-flex">Don't have account ? <a href="{{url('sign_up')}}">Create account</a></small>
                        </div>
                        <div>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function togglePassword() {
            var passwordInput = document.getElementById("loginpassword");
            var eyeIcon = document.getElementById("eyeIcon");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            }
        }
    </script>
    @endsection