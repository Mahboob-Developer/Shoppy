@extends('./User/masterview')

@section('content')

<div class="container-fluid px-5">
        <div class="row">
            @if ($wishlistCount != 0)
                @foreach ($wishlist as $wishlistItem)
                    @php
                        // Get the product details for the wishlist item
                        $productItem = $product->firstWhere('id', $wishlistItem->productid);

                        // Calculate the discount based on offers
                        $discount = 0;
                        foreach ($offer as $offerItem) {
                            if ($offerItem['category'] == 'All' || $offerItem['category'] == $productItem['category']) {
                                $discount += $offerItem['discount'];
                            }
                        }

                        // Calculate discounted price
                        $discountPrice = ($productItem['price'] * $discount) / 100;
                        $originalPrice = $productItem['price'] - $discountPrice;
                    @endphp

                    <div class="col-md-2 col-4 border rounded m-2 p-2 cardImage">
                        <!-- Product Image -->
                        <div style="flex: 1; overflow: hidden; border-radius: 2px; position: relative;">
                            <a href="{{ URL::to('/Add-Wishlist/Delete/' . $wishlistItem->productid) }}" 
                               class="position-absolute end-0 fs-5 text-danger" 
                               style="z-index: 1;">
                                <i class="fa-solid fa-heart"></i>
                            </a>

                            <a href="{{ URL::to('/allproduct/' . $productItem['id']) }}">
                                <img src="{{ asset('/Product/' . $productItem['mainimage']) }}" 
                                     alt="{{ $productItem['name'] }}" 
                                     style="width: 100%; object-fit: contain;">
                                <span class="position-absolute border-transparent bottom-0 end-0 text-light bg-success px-1 border rounded" 
                                      style="z-index: 1; font-size: 10px;">
                                    1.8<i class="fa-solid fa-star"></i>
                                </span>
                            </a>
                        </div>

                        <!-- Product Information -->
                        <div class="card-body text-center my-1">
                            <a href="{{ URL::to('/allproduct/' . $productItem['id']) }}" class="fs-md-4 fw-bold fs-5 nav-link">
                                {{ \Illuminate\Support\Str::limit($productItem['name'], 10) }}
                            </a>
                            <p class="card-text text-muted">From ₹{{ number_format($originalPrice, 2) }}</p>
                        </div>
                    </div>
                @endforeach
            @else
                <h4 class="text-center fw-bold">No items in the wishlist.</h4>
            @endif
        </div>
</div>

@endsection
