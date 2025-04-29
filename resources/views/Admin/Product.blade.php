@extends('Admin.MasterView')
@section('location')
<p class="modal-title fs-2 fw-bold mb-2" id="staticBackdropLabel">
   Product Details
</p>
<div class="container-fluid table-responsive">
   
    <table class="table table-striped">
        <thead>
            <tr>
                <th class="text-center">S.N</th>
                <th class="text-center">Name</th>
                <th class="text-center">Catagory</th>
                <th class="text-center">Company</th>
                <th class="text-center">Rating</th>
                <th class="text-center">Size</th>
                <th class="text-center">Total<span class="ms-2">Quantity</span></th>
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
            $sno=1
          @endphp
                      @foreach ($products as $product)
            <tr>
                <td class="text-center">{{$sno}}</td>
                <td class="text-center">{{$product['name']}}</td>
                <td class="text-center">{{$product['category']}}</td>
                <td class="text-center">{{$product['brand']}}</td>
                <td class="text-center">4.5 <span class="text-warning"><i class="fa fa-star"></i></span></td>
                <td class="text-center">{{$product['size']}}</td>
                <td class="text-center">{{$product['quantity']}}</td>
                <td class="text-center">{{$product['quantity']}}</td>
                <td class="text-center">{{$product['price']}}</td>
                <td class="text-center text-truncate" style="max-width: 150px;">{{$product['description']}}</td>
                <td class="text-center">
                  <img class="rounded ResponsibeImage" src="{{ asset('Product/' . $product['mainimage']) }}" alt="main image">
              </td>
                <td class="text-center"><img class=" rounded ResponsibeImage" src="{{ asset('Product/' . $product['sideone']) }}" alt="side one"></td>
                <td class="text-center"><img class=" rounded ResponsibeImage" src="{{ asset('Product/' . $product['sidetwo']) }}" alt="side two"></td>
                <td class="text-center"><img class=" rounded ResponsibeImage" src="{{ asset('Product/' . $product['sidethree']) }}" alt="side three"></td>
                <td class="text-center">
                    <span class="mx-auto d-flex">
                        <a href="{{ route('ProductUpdate', $product['id']) }}">
                            <button class="btnPrimary mx-1 d-flex">Update</button>
                        </a>
                          <a href="{{ URL::to('/Products/' . $product['id']) }}">
                              <button class="btnDanger mx-1 d-flex">Delete</button>
                          </a>

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
<div class="text-center  my-4">
    <a href="ProductAdd" class="btnPrimary ">Add to Product</a>
</div>
{{-- model open for delete  --}}
<!-- Button trigger modal -->

  
  <!-- Modal -->
  <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a href="{{URL::to('/Products')}}" class="btn-close" ></a>
            </div>  
            <div class="modal-body">
                Do you want to delete?
            </div>
            <div class="modal-footer">
             <form action="{{URL::to('/')}}/productDelete/{{$id??0}}" method="POST" style="display: inline;">
    @csrf
    <button type="submit" class="btnPrimary" id="confirmDelete">Yes</button>
    <a class="btn btnDanger" href="{{ URL::to('/Products') }}">No</a>
</form>


            </div>
        </div>
    </div>
</div>

  {{-- script for the model  --}}
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
</script>

@endsection
