@extends('./User/masterview')

@section('content')

<div class="container-fluid px-5">
    <div class="row">
        @if ($productCount==0)
            <h1 class="text-center fs-3">No product found.</h1>
        @else
            @foreach ($product as $productItem)
                <div class="col-md-2 col-4 border rounded m-2 p-2 cardImage">
                    <!-- Product Image -->
                    <div style="flex: 1; overflow: hidden; border-radius: 2px; position: relative;">
                        <picture>
                            @if (Auth::guard('web')->check())
                                @php
                                    // Check if product is in the wishlist for the current user
                                    $isInWishlist = false;
                                    $wishlistItemId = null;

                                    if ($wishlistCount != 0) {
                                        foreach ($wishlist as $wishlistItem) {
                                            if ($wishlistItem['productid'] == $productItem['id']) {
                                                $isInWishlist = true;
                                                $wishlistItemId = $wishlistItem['id'];
                                                break; // exit loop once we find a match
                                            }
                                        }
                                    }
                                @endphp

                                <!-- Wishlist Heart Icon -->
                                <a href="{{ $isInWishlist ? URL::to('/Add-Wishlist/Delete/' . $wishlistItemId) : URL::to('/Add-Wishlist/Add/' . $productItem['id']) }}" 
                                   class="position-absolute end-0 fs-5 {{ $isInWishlist ? 'text-danger' : 'text-black-50' }}" 
                                   style="z-index: 1;">
                                    <i class="fa-solid fa-heart"></i>
                                </a>
                            @endif
                            @php
                                $totalrating = 0;
                                $countrating = 0;
                            @endphp
                            @foreach ($rating as $ratingItem)
                                @if ($productItem->id == $ratingItem->productid)
                                    @php
                                        $totalrating += $ratingItem->rating;
                                        $countrating += 1;
                                    @endphp
                                @endif
                            @endforeach
                            <!-- Product Link and Image -->
                            <a href="{{ URL::to('/allproduct/' . $productItem['id']) }}">
                                <img src="{{ asset('/Product/' . $productItem['mainimage']) }}" 
                                    alt="{{ $productItem['name'] }}" 
                                    style="width: 100%; object-fit: contain;">
                                     @if ($countrating > 0)
                                <span class="position-absolute border-transparent bottom-0 end-0 text-light bg-success px-1 border rounded" 
                                    style="z-index: 1; font-size: 10px;">
                                        {{ round($totalrating / $countrating, 1) }}<i class="fa-solid fa-star"></i>
                                </span>
                                 @endif
                            </a>

                        </picture>
                    </div>

                    <!-- Product Information -->
                    @php
                        // Calculate discount for relevant offers
                        $discount = 0;
                        foreach ($offer as $offerItem) {
                            if ($offerItem['category'] == 'All' || $offerItem['category'] == $productItem['category']) {
                                $discount += $offerItem['discount'];
                            }
                        }
                        $discountPrice = ($productItem['price'] * $discount) / 100;
                        $originalPrice = $productItem['price'] - $discountPrice;
                    @endphp

                    <div class="card-body text-center my-1">
                        <a href="{{ URL::to('/allproduct/' . $productItem['id']) }}" class="fs-md-4 fw-bold fs-5 nav-link d-md-block d-none">
                            {{ \Illuminate\Support\Str::limit($productItem['name'], 20) }}
                        </a>
                        <a href="{{ URL::to('/allproduct/' . $productItem['id']) }}" class="fs-md-4 fw-bold fs-5 nav-link d-md-none d-block">
                            {{ \Illuminate\Support\Str::limit($productItem['name'], 12) }}
                        </a>
                        <p class="card-text text-muted ">From ₹{{ number_format($originalPrice, 2) }} </p>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

@endsection
