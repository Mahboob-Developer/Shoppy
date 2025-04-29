@extends('./user/masterview')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    {{-- css  --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}">    --}}

</head>

<body>
    @section('content')
    
    <!-- Navigation bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <!-- Brand name or logo with increased font size and left margin -->
            <a class="navbar-brand fw-bold ms-3 fs-3" href="{{url('home')}}">Shoppy</a>
            <!-- Toggler button for mobile view -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Navbar links and form -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <!-- Removed middle links -->
                </ul>
                <!-- Centered Search, Login, Add to Cart, and Become a Seller buttons -->
                <div class="d-flex mx-auto w-50">
                    <div class="input-group">
                        <input class="form-control fw-bolder font-monospace " type="search" placeholder="Search for products, brands, and more" aria-label="Search">
                        {{-- <span class="input-group-text">
                            <img src="uploads/webimage/search.png"  alt="" height="25px" width="25px">
                        </span> --}}
                    </div>
                </div>
                
                <div class="d-flex">
                    <a class="btn btn-outline-secondary  fw-bolder me-2" href="{{url('login')}}" role="button">
                        <img src="uploads/webimage/user.png" alt="User Icon" width="25" height="25" class="me-2">Login
                    </a>
                    <a class="btn btn-primary fw-bolder me-2" href="{{url('cart')}}" role="button">
                        <img src="uploads/webimage/shopping-cart.png" alt="" height="30px" width="30px"></i>
                        Cart
                    </a>
                    <a class="btn btn-success fw-bolder" href="#" role="button">Become a Seller</a>
                </div>
            </div>
        </div>
    </nav>
    @endsection
</body>

</html>
