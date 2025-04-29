@extends('Admin.MasterView')

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
            ['Product' => '/Products', 'image' => 'product.jpg', 'title' => 'Product', 'card' => 'Product'],
            ['Product' => '/ProductAdd', 'image' => 'product.jpg', 'title' => 'Product Insert', 'card' => 'productInsert'],
            ['Product' => '/OrderProduct', 'image' => 'Order.jpg', 'title' => 'Order', 'card' => 'Order'],
            ['Product' => '/RefundRequest', 'image' => 'refundRequest.jpg', 'title' => 'Refund Request', 'card' => 'RefundRequest'],
            ['Product' => '/Account Setting', 'image' => 'setting copy.webp', 'title' => 'Setting', 'card' => 'Setting'],
            ['Product' => '/ProfileAdmin', 'image' => 'profile.jpg', 'title' => 'Profile', 'card' => 'Profile']
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
