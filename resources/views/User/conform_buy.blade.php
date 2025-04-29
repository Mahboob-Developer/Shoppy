@php
use Carbon\Carbon;

Carbon::setLocale('en_IN');
$currentDate = Carbon::now();
$activeOffers = [];
$discount = 0;

// Collect active offers and calculate total discount
foreach ($offer as $offerItem) {
    if ($currentDate->lessThanOrEqualTo($offerItem->ending_date) && $currentDate->greaterThanOrEqualTo($offerItem->starting_date)) {
        $activeOffers[] = $offerItem; // Collect active offers
        $discount += $offerItem['discount']; // Sum discounts
    }
}
@endphp

@extends('./user/masterview')
@section('content')

<div class="album bg-body-tertiary">
    <div class="container">
        <div class="row gap-md-4">
            <div class="col-lg-7 col-12">
                <div class="row border rounded shadow-sm p-2 ">
                    <p class="fs-md-5 fw-bold">
                        Login
                        <span><i class="fa-solid fa-check text-primary"></i><i class="fa-solid fa-check text-primary"></i></span>
                        <span class="fs-md-6 fw-none float-end">{{$user['fullname']}} {{$user['mobile']}}</span>
                    </p>
                </div>

                <div class="row border rounded shadow-sm p-2 deliver">
                    <p class="fs-md-5 fw-bold" id="delivery_address">
                        DELIVERY ADDRESS
                        <span><i class="fa-solid fa-check text-primary"></i><i class="fa-solid fa-check text-primary"></i></span>
                        <button class="btn btnPrimary float-end" onclick="change_address()">Change address</button>
                        <br>
                        <span class="fs--md-6 fw-normal deliver">{{$user['address']}} - {{$user['pincode']}}</span>
                    </p>

                    <p class="fs-md-5 fw-bold" style="display:none;" id="change_delivery_address">
                        DELIVERY ADDRESS
                        <span><i class="fa-solid fa-check text-success"></i></span>
                        <br>
                    </p>

                    <div class="row" id="change_address_form" style="display:none;">
                        <form action="{{ URL::to('UpdateAddress/' . $user['id']) }}" method="post" class="d-flex">
                            @csrf
                            <div class="col-4">
                                <input type="text" name="address" id="address" value="{{ old('address', $user['address']) }}" placeholder="Address" class="form-floating form-control py-1" required>
                                <span id="address_error" class="text-danger"></span>
                            </div>
                            <div class="col-4 ms-2">
                                <input type="text" name="pincode" id="pincode" value="{{ old('pincode', $user['pincode']) }}" placeholder="Pincode" class="form-floating form-control py-1" maxlength="6" pattern="\d{6}" title="Enter a valid 6-digit pincode">
                                <span id="pincode_error" class="text-danger"></span>
                            </div>
                            <div class="col-4 ms-2">
                                <input type="submit" class="btn btnPrimary float-end py-1" value="Save Address" name="save_address">
                            </div>
                        </form>

                    </div>
                </div>

                <div class="row border rounded shadow-sm p-2 deliver">
                    <p class="fs-md-5 fw-bold">ORDER SUMMARY</p>
                    <div class="row">
                        <div class="col-3">
                            <img src="{{ asset('Product/'.$product['mainimage']) }}" class="img-fluid w-100" style="height:15vh;" alt="">
                        </div>
                        <div class="col-9">
                            <div class="row">
                                <div class="col-md-5 col-12 deliver">
                                    <p>
                                        <span class="d-md-none d-block">Delivery by {{$currentDate->format('D M d')}} | <span class="text-primary">Free</span><br></span>
                                        {{$product['name']}}<br>
                                        <span class="">Size: {{$size}}</span>
                                    </p>
                                </div>
                                <div class="col-md-7 d-md-block d-none deliver">
                                    <p>Delivery by {{$currentDate->format('D M d')}} | <span class="text-primary">Free</span></p>
                                </div>
                                @php
                                    $discountPrice = ($product['price'] * $discount) / 100;
                                    $originalPrice = $product['price'] - $discountPrice;
                                @endphp
                                <div class="col-12 deliver">
                                    <p>
                                        <span class="px-md-2 fs-md-5 fw-bold">₹{{number_format($originalPrice, 2)}}</span>
                                        <s class="px-2 text-danger">₹{{number_format($product['price'])}}</s>
                                        <span class="text-primary">{{$discount}}% Off Offer Applied</span>
                                    </p>
                                </div>
                                <div class="w-50">
                                    <div class="quantity rounded d-flex">
                                        <button class="btn btn-outline-secondary border-left-0" id="decrementBtn" onclick="decrementQuantity({{ $product['id'] }}, {{ $quantity }}, '{{ $size }}')" @if ($quantity == 1) disabled @endif>-</button>
                                        <input type="text" class="text-center" maxlength="2" max="10" value="{{ $quantity }}" name="qty" id="qty" readonly>
                                        <button class="btn btn-outline-secondary border-right-0" id="incrementBtn" onclick="incrementQuantity({{ $product['id'] }}, {{ $quantity }}, '{{ $size }}')" @if ($product['quantity'] == $quantity) disabled @endif>+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row border rounded shadow-sm p-2 deliver">
                    <p class="fs-md-5 fw-bold">PAYMENT ORDER</p>
                    <p><input type="radio" name="paytem" value="cash" checked>Cash on Delivery</p>
                    <form action="{{URL::to('/AddBuy/'.$product['id'].'/'.$quantity.'/'.$size.'/'.$discount)}}" method="get">
                        @csrf
                        <div class="d-flex justify-content-center align-items-center text-center">
                            <input type="submit" value="Continue" name="continue" class="btnPrimary mx-2 w-25">
                            <a href="{{URL::to('/allproduct/'.$product['id'])}}" class="btnDanger mx-2 w-25">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-4 col-12 p-md-2 p-4 border rounded shadow-sm">
                <p class="fs-md-5 fw-bold">PRICE</p>
                <hr>
                <p>Price ({{$quantity}} item) <span class="float-end">₹{{number_format(($product['price'] * $quantity), 2)}}</span></p>
                <p>Discount <span class="float-end">{{$discount}}%</span></p>
                <p>Discount Amount <span class="float-end">₹{{number_format($discountPrice * $quantity, 2)}}</span></p>
                <p>Delivery Charges<span class="float-end text-dark"><s class="border-end border-2 border-dark pe-1 text-success me-1">₹100</s>Free</span></p>
                <hr>
                <p class="fw-bold fs-md-5">Total Payable<span class="float-end text-dark">₹{{number_format(($originalPrice * $quantity), 2)}}</span></p>
                <hr>
            </div>
        </div>
    </div>
</div>

<script>
    function change_address() {
        document.getElementById('delivery_address').style.display = "none";
        document.getElementById('change_delivery_address').style.display = "block";
        document.getElementById('change_address_form').style.display = "block";
    }

    function incrementQuantity(productId, currentQuantity, size) {
        let newQuantity = currentQuantity + 1;
        let url = `/conformBuy/${productId}/${newQuantity}/${size}`;
        window.location.href = url;
    }

    function decrementQuantity(productId, currentQuantity, size) {
        let newQuantity = currentQuantity - 1;
        let url = `/conformBuy/${productId}/${newQuantity}/${size}`;
        window.location.href = url;
    }
</script>
<!-- Footer include (reuse the same footer across pages) -->
@endsection
yy