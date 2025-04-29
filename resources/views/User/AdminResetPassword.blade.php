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
        <div class="row mt-md-5" style="height: 45vh;">
            <div class="col-md-5 offset-md-3 offset-1 col-10 px-5 shadow-lg border rounded">
                <div class="container">
                    <form class="p-3"  action="{{url('/')}}/AdminResetPassword" method="post" >
                        @csrf
                        <div class="modal-header d-md-block d-none">
                            <h1 class="modal-title fs-3  pb-4" id="staticBackdropLabel">
                                Reset your password
                            </h1>
                        </div>
                        <div class="modal-header d-md-none d-block">
                            <p class="modal-title fw-bold  pb-4" id="staticBackdropLabel">
                                Log In to Shoppy
                            </p>
                        </div>
                        <div class="form-floating mb-3 position-relative">
                            <input type="text" class="form-control" name="newpassword" id="newpassword" placeholder="Enter Your Mobile"  />
                            <label for="newpassword">New-Password</label>
                            <span class="text-danger">
                              @error('newpassword')
                              {{$message}}
                              @enderror
                          </span>
                        </div>
                        <div class="form-floating mb-3 position-relative">
                            <input type="text" class="form-control" name="conformpassword" id="conformpassword" placeholder="Enter Your Mobile"  />
                            <label for="conformpassword">Conform-Password</label>
                            <span class="text-danger">
                              @error('conformpassword')
                              {{$message}}
                              @enderror
                          </span>
                        </div>
                        <div class="d-grid gap-2 col-12 mx-auto">
                            <button type="submit" name="login" class="btn-lg btn btn-outline-primary">Reset Password</button>
                        </div>
                        <div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
   
    @endsection