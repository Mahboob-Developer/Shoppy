@extends('./User/masterview')
    @section('content')
    <!-- Main content container -->
    <div class="container-fluid table-responsive my-2">
      <table class="table table-striped ">
          <tbody>
            @foreach ($category as $categoryItem)
              <td class="text-center mb-4 hover-effect">
                <a href="{{url('Search/'.$categoryItem['name'])}}" class="nav-link">
                    <img src="{{ asset('Catagory/'. $categoryItem['image']) }}" class="bd-placeholder-img rounded-circle" style="height: 100px; width: 100px;" alt="{{$categoryItem['name']}}">
                    <p class="fs-5 pt-3">{{$categoryItem['name']}}</p>
                </a>
          </td>
            @endforeach
               </tbody>
      </table>
    </div>
   <div id="myCarousel" class="carousel slide mb-6" data-bs-ride="carousel" data-bs-pause="hover">
    <div class="carousel-indicators">
    @php
        $date = \Carbon\Carbon::now()->format('Y-m-d');
        $activeOffers = []; // Array to hold active offers
    @endphp
    @foreach ($offer as $offerItem)
        @if ($date <= $offerItem->ending_date && $date >= $offerItem->starting_date)
            @php
                $activeOffers[] = $offerItem; // Collect active offers
            @endphp
        @endif
    @endforeach

    @foreach ($activeOffers as $index => $offerItem)
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="{{ $index }}"
                class="{{ $index === 0 ? 'active' : '' }}" aria-label="Slide {{ $index + 1 }}"></button>
    @endforeach
</div>

    
    <!-- Carousel items -->
    <div class="carousel-inner">
    @foreach ($activeOffers as $index => $offerItem)
        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
            <img src="{{ asset('Offer/' . $offerItem['image']) }}" alt="{{ $offerItem['name'] }}" class="d-block w-100">
        </div>
    @endforeach
</div>
    @if (count($activeOffers)>1)
    <!-- Carousel controls -->
    <button class="carousel-control-prev " type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
        @endif
</div>
{{-- this is used for Best product  --}}
  <div class="container-fluid px-5">
    @foreach ($category as $categoryItem)
    @php
    $count=0
    @endphp
    @foreach ($product as $productItem)
      @if($productItem['category'] == $categoryItem['name'])
      @php
      $count += 1;
      @endphp
      @endif
    @endforeach
    @if ($count > 0)
      <h3>Best Deals On {{$categoryItem['name']}}</h3>
    <div class="table-responsive">
      <table class="table table-striped">
        <div class="row">
          <td class="d-flex">
          @foreach ($product as $productItem)
          @if($productItem['category'] == $categoryItem['name'])
          <div class="col-md-2 col-4 border rounded m-2 p-2 cardImage">
            <a class="nav-link" href="{{URL::to('/allproduct/'.$productItem['id'])}}">
              <!-- Product Image -->
              <div style="flex: 1; overflow: hidden; border-radius: 2px; position: relative;">
                <picture>
                  <img src="{{asset('/Product/'.$productItem['mainimage'])}}" alt="Product Image" >
                </picture>
              </div>
              @php
              $discount=0;
                @endphp
              @foreach ($offer as $offerItem)
                @php
                  $discount += $offerItem['discount'];
                @endphp
              @endforeach
              @php
                  $discountprice = ($productItem['price'] * $discount) / 100;
                  $originalPrice=$productItem['price'] - $discountprice 
                @endphp

              <!-- Product Information -->
              <div class="card-body text-center">
               <h5 class="fs-md-4 fw-bold fs-5 d-md-block d-none">{{ \Illuminate\Support\Str::limit($productItem['name'], 20) }}</h5>
                <h5 class="fs-md-4 fw-bold fs-5 d-md-none d-block">{{ \Illuminate\Support\Str::limit($productItem['name'], 13) }}</h5>
                <p class="card-text text-muted">From ₹{{number_format($originalPrice,2)}}</p>
              </div>
            </a>
          </div>
          @endif
          @endforeach
          </td>
        </div>
      </table>
    </div>
        @endif
    @endforeach
    {{-- for top deal  --}}
 @foreach ($category as $categoryItem)
    @php
    $count=0
    @endphp
    @foreach ($product as $productItem)
      @if($productItem['category'] == $categoryItem['name'])
      @php
      $count += 1;
      @endphp
      @endif
    @endforeach
    @if ($count > 0)
      <h3>Top Deals On {{$categoryItem['name']}}</h3>
    <div class="table-responsive">
      <table class="table table-striped">
        <div class="row">
          <td class="d-flex">
          @foreach ($product as $productItem)
          @if($productItem['category'] == $categoryItem['name'])
          <div class="col-md-2 col-4 border rounded m-2 p-2 cardImage">
            <a class="nav-link" href="{{URL::to('/allproduct/'.$productItem['id'])}}">
              <!-- Product Image -->
              <div style="flex: 1; overflow: hidden; border-radius: 2px; position: relative;">
                <picture>
                  <img src="{{asset('/Product/'.$productItem['mainimage'])}}" alt="Product Image" >
                </picture>
              </div>
              @php
              $discount=0;
                @endphp
              @foreach ($offer as $offerItem)
                @php
                  $discount += $offerItem['discount'];
                @endphp
              @endforeach
              @php
                  $discountprice = ($productItem['price'] * $discount) / 100;
                  $originalPrice=$productItem['price'] - $discountprice 
                @endphp

              <!-- Product Information -->
              <div class="card-body text-center">
                <h5 class="fs-md-4 fw-bold fs-5 d-md-block d-none">{{ \Illuminate\Support\Str::limit($productItem['name'], 20) }}</h5>
                <h5 class="fs-md-4 fw-bold fs-5 d-md-none d-block">{{ \Illuminate\Support\Str::limit($productItem['name'], 13) }}</h5>
                <p class="card-text text-muted">From ₹{{number_format($originalPrice,2)}}</p>
              </div>
            </a>
          </div>
          @endif
          @endforeach
          </td>
        </div>
      </table>
    </div>
        @endif
    @endforeach
</div>
  </div>
    <!-- Footer include (reuse the same footer across pages) -->
    @endsection