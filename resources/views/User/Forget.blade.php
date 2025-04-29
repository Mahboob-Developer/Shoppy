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
        @if (session('danger'))
                        <div class="alert alert-danger alert-dismissible bg-danger fade show" role="alert">
                            <strong>{{ session('danger') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
        <div class="row mt-md-5" style="height: 45vh;">
            <div class="col-md-5 offset-md-3 offset-1 col-10 px-5 shadow-lg border rounded">
                <div class="container">
                    <form class="p-3"  action="{{url('/Forget/'.$status)}}" method="post" >
                        @csrf
                        <div class="modal-header d-md-block d-none">
                            <h1 class="modal-title fs-3  pb-4" id="staticBackdropLabel">
                                Enter the email address assodsed with your account
                            </h1>
                        </div>
                        <div class="modal-header d-md-none d-block">
                            <p class="modal-title fw-bold  pb-4" id="staticBackdropLabel">
                                Enter the email address assodsed with your account
                            </p>
                        </div>
                        <div class="form-floating mb-3 position-relative">
                            <input type="text" class="form-control" name="email" id="loginmobile" placeholder="Enter Your Mobile"  />
                            <label for="loginmobile">Email</label>
                            <span class="text-danger">
                              @error('email')
                              {{$message}}
                              @enderror
                          </span>
                        </div>
                        <div class="d-grid gap-2 col-12 mx-auto">
                            <button type="submit" name="login" class="btn-lg d-md-block d-none btn btn-outline-primary">Send</button>
                            <button type="submit" name="login" class="d-md-none d-block btn-sm btn btn-outline-primary">Send</button>
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
   
    @endsection