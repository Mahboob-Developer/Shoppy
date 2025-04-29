@extends('Admin.MasterView') <!-- Assuming you have a layout named 'app.blade.php' -->

@section('location')
<p class="modal-title fs-2 fw-bold  mb-2" id="staticBackdropLabel">
    Check Refund Details
</p>

<div class="container-fluid table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th class="text-center">S.N</th>
                <th class="text-center">Image</th>
                <th class="text-center">Resept<span class="ms-1">ID</span></th>
                <th class="text-center">Shipping</th>
                <th class="text-center">Address</th>
                <th class="text-center">Pincode</th>
                <th class="text-center">Product<span class="ms-1">Name</span></th>
                <th class="text-center">Quantity</th>
                <th class="text-center">Size</th>
                <th class="text-center">Price</th>
                <th class="text-center">Discount<span class="ms-1">(%)</span></th>
                <th class="text-center">Total<span class="ms-1">price</span></th>
                <th class="text-center">Issues<span class="ms-1">Date</span></th>
                <th class="text-center">Delivery<span class="ms-1">Date</span></th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @php
                $sno=1;
            @endphp
            @foreach ($order as $orderItem)
                <tr>
                    <td class="text-center">{{$sno}}</td>
                    <td class="text-center">
                  <img class="rounded ResponsibeImage" src="{{ asset('Order/' . $orderItem['image']) }}" alt="main image">
              </td>
                    <td class="text-center">{{$orderItem['id']}}</td>
                    <td class="text-center">{{$orderItem['shipping_fee']}}</td>
                    <td class="text-center">{{$orderItem['tracking_address']}}</td>
                    <td class="text-center">{{$orderItem['pincode']}}</td>
                    <td class="text-center">{{$orderItem['name']}}</td>
                    <td class="text-center">{{$orderItem['quantity']}}</td>
                    <td class="text-center">{{$orderItem['size']}}</td>
                    <td class="text-center"><span>₹</span>{{number_format($orderItem['price'],2)}}</td>
                    <td class="text-center">{{$orderItem['discount']}}</td>
                    <td class="text-center">₹{{number_format($orderItem['total_price'],2)}}</td>
                    <td class="text-center">{{$orderItem['order_date']}}</td>
                    <td class="text-center">{{$orderItem['delivery_date']}}</td>
                    <td class="text-center d-flex">
                        @if ($orderItem['status'] == 'Refund')
                        <a href="{{URL::to('/OrderUpdate/RefundAccepted/'.$orderItem['id'])}}" class="mx-auto" id="completed">
                            <button  class="btnPrimary mx-1">
                                Accepted
                            </button>
                        </a>
                        @endif

                        @if ($orderItem['status'] == 'RefundAccepted')
                        <a href="{{URL::to('/OrderUpdate/Refunded/'.$orderItem['id'])}}" class="mx-auto" id="completed">
                            <button  class="btnPrimary mx-1">
                                Complete
                            </button>
                        </a>
                        @endif
                        @if ($orderItem['status'] == 'Refunded')
                        <span class="mx-auto" id="completed" @disabled(true)>
                            <button id="completeButton" class="btnPrimary mx-1" >
                                Done
                            </button>
                        </span>                         
                        @endif
                        @if ($orderItem['status'] =='RefundCancelled')
                            <span class="mx-auto" id="canceled" >
                                <input class="btnPrimary mx-1 d-flex" type="submit" value="Cancel" disabled>
                        </span>
                        @endif
                        @if ($orderItem['status'] != 'RefundCancelled' && $orderItem['status'] != 'Refunded')
                        <span class="mx-auto" id="canceled">
                            <a href="{{ URL::to('/RefundRequest/'.$orderItem['id']) }}" class="btnDanger mx-1 d-flex">
                                Cancel
                            </a>
                        </span>
                    @endif

                    </td>

                    @php
                        $sno+=1;
                    @endphp
                    
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{-- model for cancel button --}}

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Do you want to Cancel ?
        </div>
        <div class="modal-footer">
            <form method="POST" action="{{URL::to('/RefundCancel/'.($id??0))}}">
                @csrf
            <button type="submit" class="btnPrimary">Yes</button></form>
            <a href="{{ URL::to('/RefundRequest') }}" class="btn btnDanger">No</a>
        </div>
      </div>
    </div>
  </div>
  <script>
  document.addEventListener('DOMContentLoaded', function() {
    // Replace this condition with your actual server-side logic
    var id = {{ $id ?? 0}}; // Pass the $id variable from your Blade template

    if (id > 0) {
      var modal = new bootstrap.Modal(document.getElementById('staticBackdrop'), {});
      modal.show();
    }
  });
</script>
@endsection


