@extends('Owner.MasterView')
@php
    $totalDiscount=0;
    $totalPrice=0;
@endphp
@section('location')
<div class="container my-3 me-3 p-5 py-3 bg-white">
    <div class="row">
        <!-- Cart Item Details -->
        <div class="col-md-7 col-12 border-end border-secondary border-2 my-1">
            <div class="d-flex justify-content-between align-items-center border-bottom border-secondary border-3 mx-1 text-dark">
                <p class="fw-bold fs-5 mb-0">TOTAL ITEM ({{$totalCart}}) {{$currentDate}}</p>
                <span class="d-flex gap-2 fw-bold fs-5">
                    <a style="cursor: pointer" class="nav-link border-end border-secondary border-3 pe-2" @if ($totalCart!=0)
                        href="{{URL::to('/Remove-cart/Remove/0/')}}"
                    @endif >REMOVE</a>
                    <a style="cursor: pointer" class="nav-link" @if ($totalCart!=0)
                        href="{{URL::to('/Remove-cart/Wishlist/0/')}}"
                    @endif >MOVE TO WISHLIST</a>
                </span>
            </div>
            <div class="container">
                @if ($totalCart == 0)
                    <p class="text-center fw-blod text-dark fs-4 my-4">Cart is empty</p>
                @endif
                @foreach ($cart as $cartItem)
                    @foreach ($product as $productItem) 
                    @if($cartItem['productid'] == $productItem['id'])
                    <div class="row border border-secondary-300 rounded p-md-3 p-2 mx-md-0 mx-1 mt-4">
                        <div class="col-3 d-flex flex-md-column align-items-center justify-content-center mb-md-3 ">
                            <a href="{{URL::to('/allproduct/'.$productItem['id'])}}">
                                <img src="{{ asset('Product/'.$productItem['mainimage']) }}" alt="Product Image" class="img-fluid">
                            </a>
                        </div>
                        <div class="col-9 d-flex flex-column">
                            <div class="d-flex flex-column mb-md-3">
                                <span class="fw-bold fs-3 d-none d-md-block"><a href="{{URL::to('/allproduct/'.$productItem['id'])}}" class="text-dark">{{$productItem['name']}}</a><a href="{{URL::to('/OwnerAction/Delete/'.$cartItem['id'])}}" class="float-end nav-link "><i class="fa-solid fa-xmark"></i></a></span>    
                                <span class="fw-bold fs-5 d-block d-md-none"><a href="{{URL::to('/allproduct/'.$productItem['id'])}}" class="text-dark">{{$productItem['name']}}</a><a href="{{URL::to('/OwnerAction/Delete/'.$cartItem['id'])}}" class="float-end nav-link"><i class="fa-solid fa-xmark"></i></a></span>    
                                <span class="text-muted py-1">
                                    @foreach ($adminDetails as $adminItem)
                                    @if ($productItem['adminid'] == $adminItem['id'])
                                        Sold by: {{$adminItem['fullname']}}
                                    @endif
                                    @endforeach
                                    </span>
                            </div>
                            <div class="d-flex flex-wrap mb-md-3">
                                <div class="d-flex align-items-center me-2 bg-light rounded px-2 py-1 text-muted">
                                    <span>Size:<select class=" border border-none text-muted">
                                        @foreach (explode(',', $productItem['size']) as $index => $point)
                                        <option value="{{$point}}" {{$index == 0?'selected':''}}>{{$point}}</option>
                                        @endforeach
                                    </select>
                                </span>
                                </div>
                                <div class="d-flex align-items-center bg-light rounded px-2 py-1  text-muted">
                                    <span>Qty: <select class=" border border-none text-muted">
                                        @for ($i=1;$i<=$productItem['quantity'];$i++)
                                             <option value="{{$i}}" {{$i == 0?'selected':''}}>{{$i}}</option>
                                        @endfor
                                    </select>
                                </span>
                                </div>
                            </div>
                            @php
                                        $discountPercent = 0;
                                        foreach ($offer as $offerItem) {
                                          if ($offerItem['category'] == 'All' || $offerItem['category'] == $productItem['category']) {
                                              if ($offerItem->starting_date <= $currentDate && $offerItem->ending_date >= $currentDate) {
                                                  $discountPercent += $offerItem->discount;
                                              }
                                          }
                                      }

                                        $totalDiscount +=$discountPercent;
                                        $totalPrice += $productItem['price'];
                                    @endphp
                            <div class="d-flex align-items-center">
                                <h6 class="mb-0">₹{{number_format($productItem['price']-(($productItem['price']*$discountPercent)/100),2)}} <s class="text-danger mx-2">₹{{number_format($productItem['price'],2)}}</s> 
                                <span class="text-success">
                                    {{ $discountPercent }}% OFF
                                </span>
                            </h6>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                @endforeach
            </div>
        </div>
        
         <!-- Price Details Section -->
    <div class="col-md-5 mx-auto d-flex flex-column gap-3 bg-white pt-2 px-4 rounded-lg">
      <!-- Title -->
      <h5 class="fw-semibold text-dark">PRICE DETAILS ({{$totalCart}} items)</h5>

      <!-- Price Breakdown -->
      <div class="d-flex justify-content-between">
        <p class="mb-0 text-muted">Total MRP</p>
        <p class="mb-0 text-dark">₹{{number_format($totalPrice,2)}}</p>
      </div>

      <div class="d-flex justify-content-between">
        <p class="mb-0 text-muted">Discount (%)</p>
        <p class="mb-0 text-success">{{ $totalCart != 0 ? number_format(($totalDiscount / $totalCart), 2) : '0' }}
</p>
      </div>

      <div class="d-flex justify-content-between">
        <p class="mb-0 text-muted">Discount Amount</p>
        <p class="mb-0 text-success">₹{{$totalCart != 0 ?number_format(($totalPrice*($totalDiscount/$totalCart)/100),2):0}}</p>
      </div>

      <div class="d-flex justify-content-between">
        <p class="mb-0 text-muted">Shipping Fee</p>
        <div class="d-flex">
          <p class="mb-0 text-decoration-line-through text-dark">₹100</p>
          <p class="mb-0 ms-2 text-success">FREE</p>
        </div>
      </div>

      <!-- Divider -->
      <hr>

      <!-- Total Amount -->
      <div class="d-flex justify-content-between fw-semibold">
        <h6 class="text-dark">Total Amount</h6>
        <h6 class="text-dark">₹{{$totalCart != 0 ?number_format(($totalPrice-($totalPrice*($totalDiscount/$totalCart)/100)),2):0}}</h6>
      </div>

      <!-- Place Order Button -->
      <button class="btn btn-dark w-100 mt-3">PLACE ORDER</button>
    </div>
    </div>
</div>
@endsection
