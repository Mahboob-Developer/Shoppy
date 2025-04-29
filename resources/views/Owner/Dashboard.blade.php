@extends('Owner.MasterView')

@section('location')
<script>
    function MouseEnter(id) {
        document.getElementById(id).style.backgroundColor = "rgba(1, 0, 1, 0.8)";
        document.getElementById(id + '-title').style.display = "block";
        document.getElementById(id + '-id').style.display = "none";

    }

    function MouseLeave(id) {
        document.getElementById(id).style.backgroundColor = "rgba(0, 0, 1, 0.3)";
        document.getElementById(id + '-title').style.display = "none";
        document.getElementById(id + '-id').style.display = "block";

    }
</script>

<section class="mx-3">
    <div class="row">
        @foreach ([
            ['Product' => '/ProductDetails', 'image' => 'product.jpg', 'title' => 'Product', 'card' => 'Product'],
            ['Product' => '/User', 'image' => 'Customer.jpg', 'title' => 'User', 'card' => 'productInsert'],
            ['Product' => '/Saller', 'image' => 'Saller.jpeg', 'title' => 'Saller', 'card' => 'Order'],
            ['Product' => '/ContactUs', 'image' => 'Contact.jpg', 'title' => 'Contact-Us', 'card' => 'RefundRequest'],
            ['Product' => '/Catagorydetails', 'image' => 'catagory.png', 'title' => 'Catagory', 'card' => 'catagory'],
            ['Product' => '/OfferDetails', 'image' => 'Offer.webp', 'title' => 'Offer', 'card' => 'Offer']
        ] as $item)
        <div class="col-12 col-lg-4 col-md-4 my-4 p-3">
            <a href="{{ $item['Product'] }}" class="nav-link" onmouseover="MouseEnter('{{ $item['card'] }}')" onmouseout="MouseLeave('{{ $item['card'] }}')">
                <div class="card bg-dark text-white" style="background-image: url('../images/Admin/{{ $item['image'] }}'); height: 30vh; background-repeat: no-repeat; background-position: center; background-size: cover; position: relative; overflow: hidden;">
                    <div class="card-img-overlay d-flex align-items-center justify-content-center" id="{{ $item['card'] }}" style="background-color: rgba(1, 0, 0, 0.3);">
                        <h1 class="text-center mt-5" style="display: none" id="{{ $item['card'] }}-title">{{ $item['title'] }}</h1>
                    </div>
                </div>
                <h1 class="text-center" id="{{ $item['card'] }}-id" >{{ $item['title'] }}</h1>
            </a>
        </div>
        @endforeach
    </div>
</section>
@endsection
