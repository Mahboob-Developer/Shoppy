@extends('Owner.MasterView')
@php
    $id = request('id', 0); // Default to 0 if not provided
    $button = request('button'); // Retrieve button parameter
@endphp
@section('location')
<h3 class="m-3">Product Details</h3>
<div class="container-fluid table-responsive ">
    <table class="table table-striped">
        <thead>
            <tr>
                <th class="text-center">S.N</th>
                <th class="text-center">Saller ID</th>
                <th class="text-center">Name</th>
                <th class="text-center">Category</th>
                <th class="text-center">Company</th>
                <th class="text-center">Rating<span class="text-danger">(2)</span></th>
                <th class="text-center">Size</th>
                <th class="text-center">Quantity</th>
                <th class="text-center">Stock</th>
                <th class="text-center">Price</th>
                <th class="text-center">Description</th>
                <th class="text-center">First</th>
                <th class="text-center">Second</th>
                <th class="text-center">Third</th>
                <th class="text-center">Fourth</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @php
                $sno=1;
            @endphp
                      @foreach ($products as $product)
            <tr>
                <td class="text-center">{{$sno}}</td>
                <td class="text-center">{{$product['adminid']}}</td>
                <td class="text-center">{{$product['name']}}</td>
                <td class="text-center">{{$product['category']}}</td>
                <td class="text-center">{{$product['brand']}}</td>
                <td class="text-center">4.5 <span class="text-warning"><i class="fa fa-star"></i></span></td>
                <td class="text-center">{{$product['size']}}</td>
                <td class="text-center">{{$product['quantity']}}</td>
                <td class="text-center">{{$product['stock']}}</td>
                <td class="text-center">₹{{ number_format($product['price'], 2) }}</td>
                <td class="text-center text-truncate" style="max-width: 150px;">{{$product['description']}}</td>
                <td class="text-center">
                    <img class="rounded img-fluid ResponsibeImage" src="{{ asset('Product/' . $product['mainimage']) }}" alt="{{$product['mainimage']}}">
                </td>
                <td class="text-center">
                    <img class="rounded img-fluid ResponsibeImage" src="{{ asset('Product/' . $product['sideone']) }}" alt="{{$product['sideone']}}">
                </td>
                <td class="text-center">
                    <img class="rounded img-fluid ResponsibeImage" src="{{ asset('Product/' . $product['sidetwo']) }}" alt="{{$product['sidetwo']}}">
                </td>
                <td class="text-center">
                    <img class="rounded img-fluid ResponsibeImage" src="{{ asset('Product/' . $product['sidethree']) }}" alt="{{$product['sidethree']}}">
                </td>
                
                <td class="text-center">
                    <span class="mx-auto d-flex">
                        @if ($product['status'] == 'Active')
                            <!-- Link to block the product -->
                            <a href="{{ url('/ProductDetails/' . $product['id'] . '/Block') }}" class="btnPrimary">
                                Block
                            </a>

                            <!-- Link to delete the product -->
                            <a href="{{ url('/ProductDetails/' . $product['id'].'/Delete') }}" class="btnDanger">
                                Delete
                            </a>
                        @else
                            <!-- Link to unblock the product -->
                            <a href="{{ url('/ProductDetails/' . $product['id'] . '/Unblock') }}" class="btnPrimary">
                                Unblock
                            </a>

                            <!-- Link to delete the product -->
                            <a href="{{ url('/ProductDetails/' . $product['id'].'/Delete') }}" class="btnDanger">
                                Delete
                            </a>
                        @endif
                    </span>
                </td>



            </tr>
            @php
                $sno++;
            @endphp
            @endforeach
        </tbody>
    </table>
</div> 
<!-- Modal for Delete -->
<form id="deleteForm" method="POST" action="{{ URL::to('/ProductDetailsAction/' . $id.'/'.$button) }}">
    @csrf
    <div class="modal fade" id="Delete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Do you want to {{$button}}?
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btnPrimary">Yes</button>
                    <a href="{{URL::to('/ProductDetails')}}" class="btn btnDanger">No</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var id = @json($id);
        var button = @json($button);

        if (id > 0) {
            if (button == 'Delete' || button == 'Unblock'||button == 'Block') {
                var myModalEl = document.getElementById('Delete');
                var modal = new bootstrap.Modal(myModalEl);
                modal.show(); // Show the Delete modal
            }
        }
    });
</script>