<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Include Bootstrap JavaScript bundle (with Popper) -->
    <link rel="icon" href="{{ asset('images/logo2.png') }}" sizes="32x32" type="image/png">

   <!-- Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

   <!-- Fonts and Icons -->
   <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>


   <!-- CSS Files -->
   <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/css/All.css') }}">

    <!-- Core JS Files -->
<script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>

    <title>Shoopy</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
        <div class="container-fluid">
            <!-- Brand name or logo with increased font size and left margin -->
            <a class="navbar-brand fw-bold ms-3 fs-3" href="{{url('/')}}"><img class="img-fluid rounded"
                style="height: 8vh" src="{{ asset('images/logo2.png') }}" alt="logo"></a>
            <!-- Toggler button for mobile view -->
            <button class="navbar-toggler text-bg-dark" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon "></span>
            </button>
            <!-- Navbar links and form -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Centered Search, Login, Add to Cart, and Become a Seller buttons -->
                    <form class="d-md-flex d-md-block d-none mx-auto w-50" action="{{URL::to('/Search')}}" method="GET">
                    <div class="input-group ">
                        <input class="form-control fw-bolder font-monospace searchInput" type="text" name="search" placeholder="Search for products, brands, and more">
                        <button type="submit" class="input-group-text bg-white">
                            <img src="{{asset('uploads/webimage/search.png')}}"  alt="" height="25px" width="25px">
                        </button>
                    </div>
                    </form>
                <form  class="d-md-flex d-md-none d-block mx-auto w-100 my-1" action="{{URL::to('/Search')}}" method="GET">
                    <div class="input-group">
                        <input class="form-control fw-bolder font-monospace searchInput" type="text" name="search" placeholder="Search for products, brands, and more" aria-label="Search">
                        <button type="submit" class="input-group-text">
                            <img src="{{asset('uploads/webimage/search.png')}}"  alt="" height="25px" width="25px">
                        </button>
                    </div>
                </form>
                <div class="d-flex">
                    <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">

                        <li class="nav-item topbar-user dropdown hidden-caret">
                            @if (Auth::guard('web')->check())
                                 <a
                            class="dropdown-toggle profile-pic btn btn-outline-secondary  fw-bolder me-2 my-md-0 my-1"
                            data-bs-toggle="dropdown"
                            href="#"
                            aria-expanded="false"
                          ><div class="avatar-sm">
                            <img src="{{ empty($user->image) ? asset('Profile/profile.png') : asset('Profile/'.$user->image) }}" alt="User Image" width="30" height="30 " class="me-2">
                            </div>
                            <span class="profile-username">
                              <span class="op-7">Hi,</span>
                              <span class="fw-bold">{{$user->fullname}}</span>
                            </span>
                          </a>
                            
                          <ul class="dropdown-menu dropdown-user animated fadeIn">
                            <div class="dropdown-user-scroll scrollbar-outer">
                              <li>
                                <div class="user-box">
                                  <div class="avatar-lg">
                                    <img
                                      src="{{ empty($user->image) ? asset('Profile/profile.png') : asset('Profile/'.$user->image) }}"
                                      alt="image profile"
                                      class="avatar-img rounded"
                                    />
                                  </div>
                                  <div class="u-text">
                                    <h4>{{$user['fullname']}}</h4>
                                    <p>{{$user['email']}}</p>
                                  </div>
                                </div>
                              </li>
                              <li>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{URL::to('/UserProfile')}}">My Profile</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{URL::to('/Buy')}}">Order</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{URL::to('/Wishlist')}}">Wishlist</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{URL::to('/UserSetting')}}">Account Setting</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{URL::to('/Logout')}}"><i class="fa-sharp fa-solid fa-right-from-bracket"></i>Logout</a>
                              </li>
                            </div>
                          </ul>
                        </li>
                      </ul>
                                                 

                      <span class="d-md-block d-none ">
                        <a class="btn btn-primary fw-bolder me-2" href="{{url('cart')}}" role="button" title="Cart">
                        <img src="{{asset('uploads/webimage/shopping-cart.png')}}" alt="" width="25" height="25" class="me-2"></i>
                        Cart
                    </a> 
                    @endif
                   @if (!Auth::guard('web')->check())
                    <span class="d-md-flex d-none">
                    <a class="btn btn-outline-secondary fw-bolder me-2" href="{{url('login')}}" role="button" title="Login">
                        <img src="{{asset('uploads/webimage/user.png')}}" alt="User Icon" width="25" height="25" class="me-2">Login
                    </a>
                    @endif
                    <a class="btn btn-success fw-bolder" target="_blank" href="{{url('Adminlogin')}}"  role="button" title="Saller"><i class="fa-solid fa-shop me-3"></i>Become a Seller</a>
                    </span>
                </span>
                </div>
                <span class="d-md-none d-block ">
                    @if (!Auth::guard('web')->check())
                    <a class="btn btn-outline-secondary my-1 d-block fw-bolder me-2" href="{{url('login')}}" role="button">
                        <img src="{{asset('uploads/webimage/user.png')}}" alt="User Icon" width="25" height="25" class="me-2">Login
                    </a>
                    @endif
                    <a class="btn btn-primary d-block my-1 fw-bolder me-2 " href="{{url('cart')}}" role="button">
                        <img src="{{asset('uploads/webimage/shopping-cart.png')}}" alt="" height="30px" width="30px"></i>
                        Cart
                    </a>
                    <a class="btn btn-success d-block my-1 fw-bolder " target="_blank" href="{{url('Adminlogin')}}" role="button">Become a Seller</a>
                </span>
            </div>
        </div>
    </nav>


 @yield('content')


 <footer class="mt-3 p-3 p-md-0" style="background-color: rgba(143, 142, 152, 0.57); border: 2px solid rgba(143, 142, 152, 0.57);">
    <div class="container">
        <footer class="py-5">
            <div class="row">
                <div class="col-5 col-md-2 mb-3 border-end border-dark">
                    <h5>ABOUT</h5>
                    <ul class="nav flex-column">
                        @if (Auth::guard('web')->check())
                        <li class="nav-item mb-2"><a href="{{URL::to('/UserProfile')}}" class="nav-link p-0 text-dark">Account</a></li>
                        @endif
                         @if (!Auth::guard('web')->check())
                        <li class="nav-item mb-2"><a href="{{URL::to('/login')}}" class="nav-link p-0 text-dark">Login</a></li>
                        @endif
                        <li class="nav-item mb-2"><a href="{{URL::to('/Adminlogin')}}" class="nav-link p-0 text-dark">Become a seller</a></li>
                    </ul>
                </div>

                <div class="col-7 col-md-3 mb-3 ps-3">
                    <h5>Mail Us:</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2">Shoppy Internet Private Limited,</li>
                        <li class="nav-item mb-2">Building Shoppy, Lumbini &</li>
                        <li class="nav-item mb-2">Colve Embassy Tech Village</li>
                        <li class="nav-item mb-2">Outer Highway, Lumbini</li>
                        <li class="nav-item mb-2">Lumbini 32900</li>
                        <li class="nav-item mb-2">Lumbini, Nepal</li>
                    </ul>
                </div>

                <div class="col-sm-6 col-md-3 col-12 mb-3 text-sm-start text-center">
                    <h5>Registered Office Address</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2">Shoppy Internet Private Limited,</li>
                        <li class="nav-item mb-2">Building Shoppy, Lumbini &</li>
                        <li class="nav-item mb-2">Colve Embassy Tech Village</li>
                        <li class="nav-item mb-2">Outer Highway, Lumbini</li>
                        <li class="nav-item mb-2">Lumbini 32900</li>
                        <li class="nav-item mb-2">Lumbini, Nepal</li>
                        <li class="nav-item mb-2"><a class="nav-link text-dark" href="tel:+9777393936844"><i class="fas fa-phone pe-2"></i>: 73-939-368-44</a></li>
                    </ul>
                </div>

                <div class="col-md-4 col-sm-6 mb-3">
                    <form method="post" action="{{URL::to('/Contact')}}">
                        @csrf
                        <h5>Contact Us for any problems</h5>
                        <p>Your problem will be solved directly by email</p>
                        <div class="d-flex flex-column flex-sm-row w-100 gap-2 bg-transparent">
                            <input type="text" name="email" value="{{old('email')}}" class="form-control bg-transparent border-dark" placeholder="Email Address" />
                            <label for="newsletter1" class="visually-hidden">Email address</label>
                        </div>
                        @error('email')
                            <span class="text-danger">{{$message}}</span>
                        @enderror

                        <div class="d-flex flex-column flex-sm-row w-100 gap-2 my-2">
                            <div class=" ">
                            <input type="text" name="problem" class="form-control bg-transparent border-dark " placeholder="Your Problems" />
                            <label for="newsletter1" class="visually-hidden">Your Problems</label>
                        @error('problem')
                            <span class="text-danger">{{$message}}</span>
                        @enderror     
                    </div>
                            <button type="submit" class="btn btnPrimary contactbtn" type="button">Contact</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="d-flex flex-column flex-sm-row justify-content-between py-4 my-4 border-top border-dark">
                <p class="mb-0">
                    <a href="/" class="d-flex fs-2 text-primary  nav-link">
                        <img class="img-fluid rounded"
                        style="height: 10vh" src="{{ asset('images/logo2.png') }}" alt="logo">
                    </a>
                    © 2024 Company, Inc. All rights reserved.
                </p>
                <ul class="list-unstyled d-flex fs-3 mb-0">
                    <li class="ms-3"><a class="link-body-emphasis text-success" href="https://wa.me/+977982743971"><i class="fab fa-whatsapp-square"></i></a></li>
                    <li class="ms-3"><a class="link-body-emphasis text-danger" href="#"><i class="fab fa-instagram"></i></a></li>
                    <li class="ms-3"><a class="link-body-emphasis text-primary" href="#"><i class="fab fa-facebook"></i></a></li>
                    <li class="ms-3"><a class="link-body-emphasis text-primary" href="#"><i class="fab fa-linkedin"></i></a></li>
                </ul>
            </div>
        </footer>
    </div>
</footer>

</body>
</html>