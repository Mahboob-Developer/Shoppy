@extends('User.masterview')
   @php
    $date = \Carbon\Carbon::now()->format('Y-m-d');
    $activeOffers = []; // Array to hold active offers
    $discount = 0;
    $ratingFive = $ratingFour = $ratingThree = $ratingTwo = $ratingOne = $totalrating = 0;
    @endphp
    @foreach ($offer as $offerItem)
        @if ($date <= $offerItem->ending_date && $date >= $offerItem->starting_date)
            @php
                $activeOffers[] = $offerItem; // Collect active offers
            @endphp
        @endif
    @endforeach

    @foreach ($activeOffers as $index => $offerItem)
    @php
        $discount += $offerItem['discount'];
    @endphp
    @endforeach

   <script>
    function onImageHover(id) {
        const imgElement = document.getElementById(id);
        const imgSrc = imgElement.src;
        document.getElementById('main').src = imgSrc;
    }
</script>

    @section('content')
    @if (session('success'))
    <div class="alert alert-success alert-dismissible bg-success fade show mx-2" role="alert">
  <strong>{{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
    <div class="container-fluid my-md-3 " style="margin-top:1vh;">
        <div class="row px-sm-4 bg-light main">
            <div class="col-lg-5 col-12 rounded-2 main2 border mt-md-2 shadow-lg">
                <div class="row">
                    <div class="col-9 p-2 d-flex">
                        <div class="main_shoes card flex-grow-1 shadow-sm rounded">
                            @if (Auth::guard('web')->check())
                                <!-- Like Button -->
                               <a href="{{ URL::to('Add-Wishlist/' . ($wishlistCount == 1 ? 'Delete' : 'Add') . '/' . $product->id) }}" class="nav-link position-absolute end-0 top-0 p-2 fs-2 {{ $wishlistCount == 1 ? 'text-danger' : 'text-light-50' }}" style="z-index: 1;">
                                    <i class="fa-solid fa-heart"></i>
                                </a>

                            @endif 

                        
                        <!-- Product Image -->
                            <img id="main" src="{{ asset('Product/'.$product['mainimage']) }}" class="card-img-top mainImageForProduct" alt="{{$product['mainimage']}}">
                    </div>

                    </div>
                    <div class="col-3 p-1 ps-2 d-block gap-2">
                        <div class="row">
                        <div class="col-12 pt-2">
                            <div class="side_shoes card shadow-sm rounded">
                                    <img src="{{ asset('Product/'.$product['mainimage']) }}" id="first" class="card-img-top" alt="{{$product['mainimage']}}" onmouseover="onImageHover('first')">
                            </div>
                        </div>
                        <div class="col-12 pt-2">
                            <div class="side_shoes card shadow-sm rounded">
                                    <img src="{{ asset('Product/'.$product['sideone']) }}" id="second" class="card-img-top" alt="{{$product['sideone']}}" onmouseover="onImageHover('second')">
                            </div>
                        </div>
                        <div class="col-12 pt-2">
                            <div class="side_shoes card shadow-sm rounded">
                                    <img src="{{ asset('Product/'.$product['sidetwo']) }}" id="third" class="card-img-top" alt="{{$product['sidetwo']}}" onmouseover="onImageHover('third')">
                            </div>
                        </div>
                        <div class="col-12 pt-2">
                            <div class="side_shoes card shadow-sm rounded">
                                    <img src="{{ asset('Product/'.$product['sidethree']) }}" id="forth" class="card-img-top" alt="{{$product['sidethree']}}" onmouseover="onImageHover('forth')">
                            </div>
                        </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-7 rounded-2 border mt-2 p-3 shadow-lg ">
                <div class="col-12 ps-2">
                    <p class="text-dark">
                         {{$product['name']}}<br>
                         @if (!empty($ratingReviews))

                            @foreach ($ratingReviews as $ratingReviewItem)
                              
                                @php
                                    // Count how many ratings for each score
                                    if($ratingReviewItem->rating == '5'){
                                        $ratingFive += 1;
                                    }
                                    if($ratingReviewItem->rating == '4'){
                                        $ratingFour += 1;
                                    }
                                    if($ratingReviewItem->rating == '3'){
                                        $ratingThree += 1;
                                    }
                                    if($ratingReviewItem->rating == '2'){
                                        $ratingTwo += 1;
                                    }
                                    if($ratingReviewItem->rating == '1'){
                                        $ratingOne += 1;
                                    }
                                    // Sum all ratings to calculate the average
                                    $totalrating += $ratingReviewItem->rating;
                                @endphp
                            @endforeach

                            @if ($ratingReviewCount > 0)
                                <b class="border border-none w-25 ms-3 table rounded bg-success text-light px-2" style="margin-top:-5vh; z-index:11;">
                                    {{$totalrating / $ratingReviewCount}} 
                                    <i class="fa-solid fa-star text-warning ps-1"></i>
                                </b>
                            @endif
                        @endif

                    </p>
                    <hr>
                    <p class="nav-link active fs-5">
                        <span class="fw-bold text-dark">{{$product->brand}}</span>
                    </p>
                    <hr>
                    <p class="d-flex">
                        @php
                            $discountprice = ($product['price'] * $discount) / 100;
                            $originalPrice=$product['price'] - $discountprice 
                        @endphp

                        <span class="price fs-3 text-dark">₹{{ number_format($originalPrice, 2) }}</span>&nbsp;&nbsp;
                        <s class="text-danger mt-2">₹{{number_format($product['price'],2)}}</s>&nbsp;&nbsp;
                       <span class="text-success mt-2">{{ $discount }}% off</span>

                    </p>
                    <hr>
                    <h5 class="text-dark fw-semibold">Product Details</h5>
                    <div class="scrollspy-example" style=" height:15vh; overflow-y: auto;">
                        <ul>
                        @foreach (explode(',', $product['description']) as $point)
                            <li class="text-dark">{{ $point }}</li><br>
                        @endforeach
                        </ul>
                    </div>

                    <hr>
                    <form method="get" action="{{URL::to('conform_buy/'.$product['id'].'/1')}}">
                        @csrf
                        <div class="mb-2">
                            <label>Size</label>
                            <div class="d-flex flex-wrap gap-2">
                                @php
                                    $sizes = explode(',', $product['size']);
                                @endphp
                                @foreach ($sizes as $key => $size)
                                    <input type="radio" class="btn-check" name="size" id="size_{{ $key }}" value="{{ $size }}" autocomplete="off" {{ $key === 0 ? 'checked' : '' }}>
                                    <label class="btn btn-light btn-outline-dark" for="size_{{ $key }}">{{ $size }}</label>
                                    
                                    @if (($key + 1) % 5 == 0)
                                        <br> <!-- Line break after every 5 sizes -->
                                    @endif
                                @endforeach
                            </div>


                        <hr>
                        <div class="d-flex gap-2">
                            @if ($product->stock>0)
                                @if (Auth::guard('web')->check())
                                    <button type="submit" class="btn btn-sm  btnPrimary w-50 p-md-3 p-sm-2 fs-lg-5 fs-6">Buy</button>
                                <a href="{{URL::to('/Add Cart/'.$product['id'])}}" class="btn btn-sm btnDanger w-50 p-md-3 p-sm-2 fs-lg-5 fs-6">Add to Cart</a>
                                @else
                                    <a href="{{URL::to('/login')}}" type="button" class="btn btn-sm  btnPrimary w-50 p-md-3 p-sm-2 fs-lg-5 fs-6" >Buy</a>
                                <a href="{{URL::to('/login')}}" class="btn btn-sm btnDanger w-50 p-md-3 p-sm-2 fs-lg-5 fs-6">Add to Cart</a>
                                @endif                                
                            @else
                                <button type="button" class="btn btn-danger w-50 p-md-3 p-sm-2 fs-lg-5 fs-6">Out Of Stock</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if (!empty($ratingReviews))
        <div class="container-fluid mt-3">
            <div class="row px-sm-4 bg-light main">
                <h4 class="text-dark">Rating & Review</h4>
                <!-- Rating Section -->
                <div class="col-md-5 col-12 rounded border mt-md-2 shadow-lg p-3 main2">
                    <div class="row">
                        <div class="col-4 ">
                            <p class="position-relative ps-2">
                                <b class="fs-3 position-absolute" style="top: 0; left: 0;">
                                    {{$totalrating/$ratingReviewCount}}<i class="fas fa-star ps-1 text-warning"></i>
                                </b>
                                <br>
                                <br>
                                <b class="text-dark ">
                                    {{$totalrating}} Rating &amp; <br> {{$ratingReviewCount}} Reviews
                                </b>
                            </p>
                        </div>
                        <div class="col-8">
                            <div>
                               @php
                                    $stars = 5; // Start with 5 stars
                                @endphp

                                @for ($i = 1; $i <= 5; $i++)
                                    <b>
                                        {{ $stars }} 
                                        @for($j = 1; $j <= $stars; $j++) <!-- Loop to print stars -->
                                            <i class="fas fa-star text-warning"></i>
                                        @endfor
                                        @for($j = 1; $j <= 5-$stars; $j++) <!-- Loop to print stars -->
                                            <i class="fas fa-star text-dark"></i>
                                        @endfor
                                    </b>

                                    <span class="ps-2">
                                        @if ($stars == 5)
                                            {{ $ratingFive }}
                                        @elseif ($stars == 4)
                                            {{ $ratingFour }}
                                        @elseif ($stars == 3)
                                            {{ $ratingThree }}
                                        @elseif ($stars == 2)
                                            {{ $ratingTwo }}
                                        @elseif ($stars == 1)
                                            {{ $ratingOne }}
                                        @endif
                                    </span>
                                    <br>

                                    @php
                                        $stars--; // Decrease the star count for the next iteration
                                    @endphp
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reviews Section -->
                <div class="col-sm-12 col-md-7 rounded border mt-2 p-3 shadow-lg overflow-auto" style="height: 20vh;">
                    @foreach ($ratingReviews as $ratingReviewItem)
                        @foreach ($userdetails as $userdetailsItem)
                            @if ($ratingReviewItem->userid==$userdetailsItem->id)
                                <div class="mb-3">
                                    <p class="fw-bold text-dark d-flex align-items-center">
                                        <img class="img-fluid rounded-circle review_image me-2" src="{{ empty($userdetailsItem->image) ? asset('Profile/profile.png') : asset('Profile/'.$userdetailsItem->image) }}" alt="Md Asraf Ali">
                                        {{$userdetailsItem->fullname}}
                                    </p>
                                    <p class="ms-5">{{$ratingReviewItem->review}}</p>
                                    <hr>
                                </div>
                            @endif
                        @endforeach
                     @endforeach
                </div>
            </div>
        </div>
    @endif

    @endsection