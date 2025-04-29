<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta charset="UTF-8">
    <title>Shoppy</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />

   <!-- Favicon -->
   <link rel="icon" href="{{ asset('images/logo2.png') }}" sizes="32x32" type="image/png">

   <!-- Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

   <!-- Fonts and Icons -->
   <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>


   <!-- CSS Files -->
   <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/css/All.css') }}">
</head>
<body>
    <div class="wrapper">
      <!-- Sidebar -->
      <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header " data-background-color="dark">
            <a href="{{URL::to('/AdminIndex')}}" class="d-flex d-block d-md-none ms-5">
              <img
              src="{{ asset('images/logo2.png') }}"
              alt="logo"
              class="img-fluid rounded"
              style="height: 5vh"
          />
                      </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <div class="dropdown float-end  more">
              <img class="rounded-circle" 
     src="{{ empty($admin->image) ? asset('Profile/profile.png') : asset('Profile/'.$admin->image) }}" id="dropdownMenuButton2" data-bs-toggle="dropdown"  aria-expanded="false" 
     alt="Profile" 
     style="height:5vh">

              
              <ul class="dropdown-menu dropdown-user  me-3 text-light" style="background-color: rgb(32, 41, 64)" aria-labelledby="dropdownMenuButton2">
                <div class="dropdown-user-scroll scrollbar-outer">
                  <li>
                    <div class="user-box">
                      <div class="avatar-lg">
                        <img
                    src="{{ empty($admin->image) ? asset('Profile/profile.png') : asset('Profile/'.$admin->image) }}"
                    alt="image profile"
                    class="avatar-img rounded"
                />

                      </div>
                      <div class="u-text">
                        <h4>{{$admin['fullname']}}</h4>
                        <p>{{$admin['email']}}</p>
                      </div>
                    </div>
                  </li>
                  <li>
                    <hr class="text-light my-0 py-0" >
                    <a class="text-light ps-3" href="{{URL::to('/ProfileAdmin')}}">My Profile</a>
                    <hr class="text-light my-0 py-0" >
                    <a class="text-light ps-3" href="{{URL::to('/Account Setting')}}">Account Setting</a>
                    <hr class="text-light my-0 py-0" >
                    <div class="dropdown-item text-light" style="cursor: pointer" onclick="event.preventDefault(); document.getElementById('LogoutForm').submit();" ><i class="fa-sharp fa-solid fa-right-from-bracket"></i>Log out</div>
                  </li>
                </div>
              </ul>
          </div>
          </div>
          <!-- End Logo Header -->
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <ul class="nav nav-secondary">
              <li class="nav-item active">
                <a
                  href="{{URL::to('/AdminIndex')}}"
                >
                <i class="fa-solid fa-gauge"></i> 
                  <p>Dashboard</p>
                </a>
              </li>
              <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">Components</h4>
              </li>
              <li class="nav-item">
                <a href="{{URL::to('/Products')}}">
                  <i class="fas fa-layer-group"></i>
                  <p>Product</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{URL::to('/ProductAdd')}}">
                  <i class="fas fa-th-list"></i>
                  <p>Product Add</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{URL::to('/OrderProduct')}}">
                  <i class="fas fa-pen-square"></i>
                  <p>Order</p>
                  <span class="badge badge-success">{{$orderCount!=0?$orderCount:''}}</span>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{URL::to('/RefundRequest')}}">
                  <i class="fas fa-table"></i>
                  <p>Refund Request</p>
                  <span class="badge badge-success">{{$refundCount!=0?$refundCount:''}}</span>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{URL::to('/ProfileAdmin')}}">
                  <i class="far fa-chart-bar"></i>
                  <p>Profile</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{URL::to('/Account Setting')}}">
                  <i class="fa-solid fa-gear"></i>
                  <p>Account Setting</p>
                </a>
              </li>
              <li class="nav-item" style="cursor: pointer" onclick="event.preventDefault(); document.getElementById('LogoutForm').submit();" >
                <a >
                  <i class="fa-sharp fa-solid fa-right-from-bracket"></i>
                  <p>Log Out</p>
                </a>
              </li>
            </ul>
          </div>
          
        </div>
      </div>
      <!-- End Sidebar -->

      <div class="main-panel">
        <div class="main-header">
          <div class="main-header-logo">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="dark">
              <a href="index.html" class="logo">
                <img src="{{ asset('images/logo2.png') }}" alt="" class="img-fluid rounded" style="height: 5vh"/>
              </a>
              <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                  <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                  <i class="gg-menu-left"></i>
                </button>
              </div>
              <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
              </button>
            </div>
            <!-- End Logo Header -->
          </div>
          <!-- Navbar Header -->
          <nav
            class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom " data-background-color="dark"
          >
            <div class="container-fluid">
              <div class="my-1 d-md-block d-none">
              <a href="{{URL::to('/AdminIndex')}}">
                <img
                src="{{ asset('images/logo2.png') }}"
                alt=""
                class="img-fluid rounded"
                style="height: 8vh"
            />
                          </a>
            </div>

              <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">

                <li class="nav-item topbar-user dropdown hidden-caret">
                  <a
                    class="dropdown-toggle profile-pic"
                    data-bs-toggle="dropdown"
                    href="#"
                    aria-expanded="false"
                  >
                    <div class="avatar-sm">
                      <img
                      src="{{ empty($admin->image) ? asset('Profile/profile.png') : asset('Profile/'.$admin->image) }}"
                        alt="profile"
                        class="avatar-img rounded-circle"
                      />
                    </div>
                    <span class="profile-username">
                      <span class="op-7">Hi,</span>
                      <span class="fw-bold">{{$admin['fullname']}}</span>
                    </span>
                  </a>
                  <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">
                      <li>
                        <div class="user-box">
                          <div class="avatar-lg">
                            <img
                              src="{{ empty($admin->image) ? asset('Profile/profile.png') : asset('Profile/'.$admin->image) }}"
                              alt="image profile"
                              class="avatar-img rounded"
                            />
                          </div>
                          <div class="u-text text-light">
                            <h4>{{$admin['fullname']}}</h4>
                            <p>{{$admin['email']}}</p>
                          </div>
                        </div>
                      </li>
                      <li>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{URL::to('/ProfileAdmin')}}">My Profile</a>
                        {{-- <a class="dropdown-item" href="#">My Balance</a> --}}
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{URL::to('/Account Setting')}}">Account Setting</a>
                        <div class="dropdown-divider"></div>
                        <div class="dropdown-item text-light" style="cursor: pointer" onclick="event.preventDefault(); document.getElementById('LogoutForm').submit();" ><i class="fa-sharp fa-solid fa-right-from-bracket"></i>Log out</div>
                      </li>
                    </div>
                  </ul>
                </li>
              </ul>
            </div>
          </nav>
          <!-- End Navbar -->
        </div>


        {{-- for logout functionality  --}}
        <span class="d-none">
          <form id="LogoutForm" action="{{URL::to('/LogoutAdmin')}}" method="POST">
            @csrf
          </form>
        </span>
        <div class="container mx-3 py-5">
          @yield('location')
        </div>
      </div>

    
      <!-- End Custom template -->
    </div>
 <!-- Core JS Files -->
<script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>

<!-- jQuery Scrollbar -->
<script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

<!-- Chart JS -->
<!-- Include any chart JS files here if needed -->

<!-- Kaiadmin JS -->
<script src="{{ asset('assets/js/kaiadmin.min.js') }}"></script>

   
  </body>
</html>
