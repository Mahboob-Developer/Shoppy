@extends('user.masterview')
@section('content')
      <!-- Desktop View (medium and up) -->
  
@section('content')
    @if (session('warning'))
        <div class="alert alert-danger alert-dismissible bg-warning fade show" role="alert">
        <strong>{{ session('warning') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-dark alert-dismissible bg-success fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
<!-- Desktop View (medium and up) -->
<div class="container mt-3 d-none d-md-block">
@php
    $orderCount=0
@endphp
    @foreach ($order as $orderItem)
        <div class="row mb-4 p-3 border rounded border-gray">
            @php
            $orderCount+=1;
                // Assuming $orderItem->delivery_date is in 'Y-m-d' format
                $date = $orderItem->delivery_date;

                // Check if the date is valid before proceeding
                $dateIsValid = DateTime::createFromFormat('Y-m-d', $date) !== false;

                if ($dateIsValid) {
                    // Create DateTime object for delivery date
                    $dateObject = new DateTime($date);
                    $formattedDate = $dateObject->format('D, M j'); // Format as 'Fri, May 24'

                    // Create DateTime object for expiry date, add 7 days
                    $deliveryExpiry = new DateTime($date);
                    $deliveryExpiry->modify('+7 days');
                    $RefundExpiry= new DateTime($date);
                    $RefundExpiry->modify('+7 days');
                    $refundDate=$deliveryExpiry->format('Y-m-d');
                    $expiryDate = $deliveryExpiry->format('Y-m-d'); // Convert to 'Y-m-d' format

                    // Get the current date in 'Y-m-d' format
                    $currentDate = \Carbon\Carbon::now()->toDateString();

                    // Check if current date is less than or equal to expiry date
                    $showRatingAndReviewButton = $currentDate <= $expiryDate;
                } else {
                    // Handle invalid date scenario
                    $formattedDate = 'Invalid date';
                    $expiryDate = 'Invalid date';
                    $showRatingAndReviewButton = false;
                }
            @endphp

            <p class="text-dark">
                @if (in_array($orderItem->status, ['Completed', 'Refund', 'RefundCancel', 'Refunded']))
                    Delivered
                @else
                    Arriving
                @endif 
                : {{ $formattedDate }}
            </p>

            <div class="row">
                <div class="col-2">
                    <img class="rounded img-fluid" src="{{ asset('Order/' . $orderItem->image) }}" alt="product image">
                </div>
                <div class="col-10">
                    <div class="row">
                        <div class="col-8">
                            <a href="{{ URL::to('allproduct/' . $orderItem->product_id) }}" class="nav-link fs-3 fw-semibold">
                                 {{ \Illuminate\Support\Str::limit($orderItem['name'], 50) }}
                            </a>
                            @foreach ($admin as $adminItem)
                                @if ($orderItem->adminid == $adminItem->id)
                                    <p class="text-muted">Sold by: {{ $adminItem->fullname }}.</p>
                                @endif
                            @endforeach
                            <span>
                                <small class="btn btn-sm btn-light text-muted">Size: {{ $orderItem->size }}</small>
                                <small class="btn btn-sm btn-light text-muted">Qty: {{ $orderItem->quantity }}</small>
                            </span>
                            <p class="text-muted">
                                Price: ₹{{ number_format($orderItem->total_price, 2) }}
                                <span class="text-success ms-2">{{ $orderItem->discount }}% Off</span>
                            </p>
                        </div>
                        <div class="col-4">
                            <div class="d-flex flex-column">
                                @if ($showRatingAndReviewButton)
                                    @if (in_array($orderItem->status, ['processing', 'Accepted']))
                                        <a href="{{ URL::to('/Order/Cancel/' . $orderItem->id) }}" class="btn btn-danger mb-2">Cancel Order</a>
                                    @endif
                                @endif
                                @php
                                    $totalrating = 0;
                                @endphp

                                @if (in_array($orderItem->status, ['Completed', 'Refund', 'RefundCancel', 'Refunded', 'RefundCancelled', 'RefundAccepted']))
                                    @if (!empty($rating))
                                        @foreach ($rating as $ratingItem) 
                                            @if ($ratingItem->productid == $orderItem->product_id)
                                                @php
                                                    $totalrating += 1;
                                                @endphp
                                            @endif
                                        @endforeach
                                    @endif
                                @endif

                                @if ($totalrating == 0)
                                    <a href="{{ URL::to('/Buy/' . $orderItem->id) }}" class="btn btn-primary mb-2">Rating & Review</a>
                                @endif

                                @if ($orderItem->status=='Completed')              
                                        <a href="{{ URL::to('/Order/Refund/' . $orderItem->id) }}" class="btn btn-success mb-2">Refund Request</a>
                                    @endif

                                @if ($orderItem->status == 'Refund' || $orderItem->status=='RefundAccepted')
                                    @if ($showRatingAndReviewButton)
                                        <a href="{{ URL::to('/Order/RefundCancel/' . $orderItem->id) }}" class="btn btn-danger mb-2">Refund Cancel</a>
                                    @endif
                                @endif
                                @if ($orderItem->status == 'Refunded')
                                    <button class="btn btn-success mb-2" disabled>Refunded in {{$user->mobile}}</button>
                                @endif

                                @if ($orderItem->status == 'Cancelled')
                                    <button class="btn btn-danger mb-2" disabled>Cancelled</button>
                                @endif
                                @if ($orderItem->status == 'RefundCancelled')
                                    <button class="btn btn-danger mb-2" disabled>Refund Cancelled</button>
                                @endif
                                @if (in_array($orderItem->status, ['Completed', 'Refund', 'RefundCancel','Refunded','RefundCancelled','RefundAccepted']))
                                    <a href="{{URL::to('/InvoiceUser/Generate/'.$orderItem->id)}}" class="btn btn-outline-secondary">Download</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    @if ($orderCount==0)
        <h1 class="text-center">No Order</h1>
    @endif
</div>

    <!--  Mobile View (below medium) -->
<div class="container-fluid d-md-none mt-3">
    @foreach ($order as $orderItem)
        <div class="row border rounded border-gray mb-4">
            @php
                $orderCount+=1;
                // Assume $orderItem->delivery_date is in 'Y-m-d' format
                $date = $orderItem->delivery_date;
                $dateObject = new DateTime($date);
                $formattedDate = $dateObject->format('D, M j');

                // Calculate expiry date for showing the "Rating & Review" button
                $deliveryExpiry = new \Carbon\Carbon($date);
                $deliveryExpiry->addDays(7);
                $currentDate = \Carbon\Carbon::now();
                
                // Show the "Rating & Review" button if within 7 days of delivery
                $showRatingAndReviewButton = $currentDate->lessThanOrEqualTo($deliveryExpiry);
            @endphp

             <p class=" text-dark">
                @if (in_array($orderItem->status, ['Completed', 'Refund', 'RefundCancel', 'Refunded']))
                    Delivered
                @else
                    Arriving
                @endif 
                : {{ $formattedDate }}
            </p>
            <div class="row">
                <div class="col-4">
                    <img class="img-fluid rounded" src="{{ asset('Order/' . $orderItem->image) }}" alt="product image">
                </div>
                <div class="col-8">
                    <div class="row">
                        <div class="col-12">
                            <a href="{{ URL::to('/allproduct/' . $orderItem->product_id) }}" class="nav-link fs-4 fw-semibold">
                                {{ \Illuminate\Support\Str::limit($orderItem['name'], 23) }}
                            </a>
                            @foreach ($admin as $adminItem)
                                @if ($orderItem->adminid == $adminItem->id)
                                    <p class="text-muted">Sold by: {{ $adminItem->fullname }}.</p>
                                @endif
                            @endforeach
                            <span>
                                <small class="text-muted">Size: {{ $orderItem->size }}</small>
                                <small class="text-muted">Qty: {{ $orderItem->quantity }}</small>
                            </span>
                            <p class="text-muted">
                                Price: ₹{{ number_format($orderItem->total_price, 2) }}  
                                <span class="text-success ms-2">{{ $orderItem->discount }}% Off</span>
                            </p>
                        </div>
                        <div class="col-12">
                            <div class="d-flex flex-column">
                                @if ($showRatingAndReviewButton)
                                    @if (in_array($orderItem->status, ['processing', 'Accepted']))
                                        <a href="{{ URL::to('/Order/Cancel/' . $orderItem->id) }}" class="btn btn-danger  btn-sm mb-2">Cancel Order</a>
                                    @endif
                                @endif
                                @php
                                    $totalrating = 0;
                                @endphp

                                @if (in_array($orderItem->status, ['Completed', 'Refund', 'RefundCancel', 'Refunded', 'RefundCancelled', 'RefundAccepted']))
                                    @if (!empty($rating))
                                        @foreach ($rating as $ratingItem) 
                                            @if ($ratingItem->productid == $orderItem->product_id)
                                                @php
                                                    $totalrating += 1;
                                                @endphp
                                            @endif
                                        @endforeach
                                    @endif
                                @endif

                                @if ($totalrating == 0)
                                    <a href="{{ URL::to('/Buy/' . $orderItem->id) }}" class="btn btn-primary  btn-sm mb-2">Rating & Review</a>
                                @endif

                                @if ($orderItem->status=='Completed')              
                                        <a href="{{ URL::to('/Order/Refund/' . $orderItem->id) }}" class="btn btn-success  btn-sm mb-2">Refund Request</a>
                                    @endif

                                @if ($orderItem->status == 'Refund' || $orderItem->status=='RefundAccepted')
                                    @if ($showRatingAndReviewButton)
                                        <a href="{{ URL::to('/Order/RefundCancel/' . $orderItem->id) }}" class="btn btn-danger  btn-sm mb-2">Refund Cancel</a>
                                    @endif
                                @endif
                                @if ($orderItem->status == 'Refunded')
                                    <button class="btn btn-success  btn-sm mb-2" disabled>Refunded in {{$user->mobile}}</button>
                                @endif

                                @if ($orderItem->status == 'Cancelled')
                                    <button class="btn btn-danger  btn-sm mb-2" disabled>Cancelled</button>
                                @endif
                                @if ($orderItem->status == 'RefundCancelled')
                                    <button class="btn btn-danger  btn-sm mb-2" disabled>Refund Cancelled</button>
                                @endif
                                @if (in_array($orderItem->status, ['Completed', 'Refund', 'RefundCancel','Refunded','RefundCancelled','RefundAccepted']))
                                    <a href="{{URL::to('/InvoiceUser/Generate/'.$orderItem->id)}}" class="btn btn-outline-secondary btn-sm">Download</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    @if ($orderCount==0)
        <h1 class="text-center">No Order</h1>
    @endif
</div>


<!-- Modal for rating & review -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdrop">Rating And Review</h5>
            <a href="{{URL::to('/Buy')}}" class="btn-close" ></a>
        </div>
        <div class="modal-body">
            <form action="{{ URL::to('/RatingForm/'.($id ?? 0)) }}" method="POST">
            @csrf
            <div class="border rounded bg-light w-100 p-3 mb-3">
                <label for="rating" class="form-label pe-3">Rating</label>
                
                <input type="radio" class="btn-check" name="rating" id="one" value="1" autocomplete="off">
                <label id="1" onmouseover="enterone()" class="fs-4" for="one">
                    <i id="onestar" class="fa-solid fa-star"></i>
                </label>

                <input type="radio" class="btn-check" name="rating" id="two" value="2" autocomplete="off">
                <label id="2" onmouseover="entertwo()" class="fs-4" for="two">
                    <i id="twostar" class="fa-solid fa-star"></i>
                </label>

                <input type="radio" class="btn-check" name="rating" id="three" value="3" autocomplete="off">
                <label id="3" onmouseover="enterthree()" class="fs-4" for="three">
                    <i id="threestar" class="fa-solid fa-star"></i>
                </label>

                <input type="radio" class="btn-check" name="rating" id="four" value="4" autocomplete="off">
                <label id="4" onmouseover="enterfour()" class="fs-4" for="four">
                    <i id="fourstar" class="fa-solid fa-star"></i>
                </label>

                <input type="radio" class="btn-check" name="rating" id="five" value="5" autocomplete="off">
                <label id="5" onmouseover="enterfive()" class="fs-4" for="five">
                    <i id="fivestar" class="fa-solid fa-star"></i>
                </label>
            </div>

            <div class="form-floating w-100 mb-3">
                <input type="text" class="form-control border bg-light" name="review" id="review" placeholder="Enter Your opinion">
                <label for="review">Enter Your Review</label>
            </div>
            
            <div class="col text-center">
                <input type="submit" value="Submit" class="btn btn-outline-primary w-50">
            </div>
        </form>

        </div>
      </div>
    </div>
  </div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
    // Example ID value (this could be dynamic)
    var id = {{ $id ?? 0 }};

    // Check if the ID matches the condition
    if (id >0) {
        var modal = new bootstrap.Modal(document.getElementById('staticBackdrop'), {
            keyboard: false
        });
        modal.show();
    }
});
    
    // for mouse enter 
    function enterone() {
    document.getElementById('onestar').style.color = '#ffc107';
    resetStars(['twostar', 'threestar', 'fourstar', 'fivestar']);
    document.getElementById('one').checked = true;  // Select the radio
}

function entertwo() {
    setStars(['onestar', 'twostar']);
    resetStars(['threestar', 'fourstar', 'fivestar']);
    document.getElementById('two').checked = true;  // Select the radio
}

function enterthree() {
    setStars(['onestar', 'twostar', 'threestar']);
    resetStars(['fourstar', 'fivestar']);
    document.getElementById('three').checked = true;  // Select the radio
}

function enterfour() {
    setStars(['onestar', 'twostar', 'threestar', 'fourstar']);
    resetStars(['fivestar']);
    document.getElementById('four').checked = true;  // Select the radio
}

function enterfive() {
    setStars(['onestar', 'twostar', 'threestar', 'fourstar', 'fivestar']);
    document.getElementById('five').checked = true;  // Select the radio
}

function setStars(starIds) {
    starIds.forEach(id => document.getElementById(id).style.color = '#ffc107');
}

function resetStars(starIds) {
    starIds.forEach(id => document.getElementById(id).style.color = 'black');
}

</script>