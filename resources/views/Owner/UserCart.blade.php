@extends('Owner.MasterView')

   <!-- Navbar include (reuse the same header/navigation bar across pages) -->
   @section('location')
   <!-- Main container for the cart page -->
   <div class="container-fluid py-5">
       <div class="container py-2">
           <!-- Table to display cart items -->
           <div class="table-responsive">
               <table class="table">
                   <thead>
                     <tr>
                       <th scope="col">Products</th>
                       <th scope="col">Name</th>
                       <th scope="col">Price</th>
                       <th scope="col">Quantity</th>
                       <th scope="col">Total</th>
                       <th scope="col">Handle</th>
                     </tr>
                   </thead>
                   <tbody>
                       <!-- Row for iPhone 12 -->
                       

                       <tr>
                           <th scope="row">
                               <!-- Product image -->
                               <div class="d-flex align-items-center">
                                   <img src="uploads/webimage/pocom6.png" class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px;" alt="Poco M6 Pro 5G">
                               </div>
                           </th>
                           <td>
                               <!-- Product name -->
                               <p class="mb-0 mt-4">Poco M6 Pro 5G</p>
                           </td>
                           <td>
                               <!-- Product price -->
                               <p class="mb-0 mt-4">₹17,999</p>
                           </td>
                           <td>
                               <!-- Quantity selector -->
                               <div class="input-group quantity mt-4 " style="width:10vw">
                                   <div class="input-group-btn">
                                       <button class="btn btn-sm btn-minus rounded-circle bg-light border">
                                           <img src="uploads/webimage/minus.png" alt="Decrease quantity" height="20vh">
                                       </button>
                                   </div>
                                   <input type="text" class="form-control form-control-sm text-center border-0" value="1">
                                   <div class="input-group-btn">
                                       <button class="btn btn-sm btn-plus rounded-circle bg-light border">
                                           <img src="uploads/webimage/plus.png" alt="Increase quantity" height="19vh">
                                       </button>
                                   </div>
                               </div>
                           </td>
                           <td>
                               <!-- Total price for the item -->
                               <p class="mb-0 mt-4">₹2.99</p>
                           </td>
                           <td>
                               <!-- Remove item button -->
                               <button class="btn btn-md rounded-circle bg-light border mt-4">
                                   <img src="uploads/webimage/delete.png" alt="Remove item" height="16vh">
                               </button>
                           </td>
                       </tr>

                       
                   </tbody>
               </table>
           </div>
       </div>
   </div>
    <!-- Footer include (reuse the same footer across pages) -->
    @endsection
