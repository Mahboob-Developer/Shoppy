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
                    <h1>sdgdsfdsxgds</h1>
                    <form class="p-3"  action="{{url('/')}}/AdminForget" method="post" >
                        @csrf
                        <div class="modal-header d-md-block d-none">
                            <h1 class="modal-title fs-3  pb-4" id="staticBackdropLabel">
                                Enter the email address assod
                                sed with your account
                            </h1>
                        </div>
                        <div class="modal-header d-md-none d-block">
                            <p class="modal-title fw-bold  pb-4" id="staticBackdropLabel">
                                Log In to Shoppy
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
                            <button type="submit" name="login" class="btn-lg btn btn-outline-primary">Send</button>
                            <span class="my-3">Don't have account ? <a href="{{url('Adminsingup')}}">Create account</a></span>
                        </div>
                        <div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
   
    @endsection