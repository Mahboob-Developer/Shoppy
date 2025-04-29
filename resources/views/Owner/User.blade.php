@extends('Owner.MasterView')

@php
    $sno=1;
    $id=$id ?? 0;
    $BuyCount=$BuyCount??0;
    $CartCount=$CartCount??0;
@endphp

@section('location')
<div class="container-fluid table-responsive ">  
    @if (session('success'))
                        <div class="alert alert-success alert-dismissible bg-success fade show" role="alert">
                            <strong>{{ session('success') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
    <table class="table table-striped">
        <thead>
            <tr>
                <th class="text-center">S.N</th>
                <th class="text-center">Image</th>
                <th class="text-center">Full Name</th>
                <th class="text-center">Phone</th>
                <th class="text-center">E-mail</th>
                <th class="text-center">Gender</th>
                <th class="text-center">Pincode</th>
                <th class="text-center">Address</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($userDetail as $user)
            <tr>
                <td class="text-center">{{$sno}}</td>
                <td class="text-center">
                    <img class="rounded ResponsibeImage" src="{{ empty($user->image) ? asset('Profile/profile.png') : asset('Profile/'.$user->image) }}" alt="Profile" >
                </td>
                <td class="text-center">{{$user['fullname']}}</td>
                <td class="text-center">{{$user['mobile']}}</td>
                <td class="text-center">{{$user['email']}}</td>
                <td class="text-center">{{$user['gender']}}</td>
                <td class="text-center">{{$user['pincode']}}</td>
                <td class="text-center">{{$user['address']}}</td>
                <td class="text-center">
                    <span class="mx-auto d-flex">
                        @if ($user->status=='Inactive')
                            <button type="button" class="btnPrimary" disabled>Inactive</button>                    
                        @else
                            <a href="{{URL::to('/User/'.$user->id)}}" class="btnPrimary">
                            View
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

<!-- Modal -->
<div class="modal fade" id="Operation" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="Operation" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="Operation">Shoppy</h1>
          <a href="{{URL::to('/User')}}" class="btn-close" ></a>
        </div>
        <div class="modal-body">
          Which operation do you want to perform?
        </div>
        <div class="modal-footer">
            @if ($BuyCount>0)
            <a class="btnPrimary" href="{{ URL::to('/UserAction/Order/'.$id??0) }}">Order</a>
            @endif
            @if ($CartCount>0)
            <a class="btnPrimary" href="{{ URL::to('/UserAction/Cart/'.$id??0) }}">Cart</a>
            @endif
                @if ($presentUser['status'] == 'Active')
                    <a class="btnPrimary" href="{{ URL::to('/UserAction/Block/'.$id??0) }}">Block</a>
                @endif

                @if ($presentUser['status'] == 'Block')
                    <a class="btnPrimary" href="{{ URL::to('/UserAction/Unblock/'.$id??0) }}">Unblock</a>
                @endif
            <a class="btnPrimary" href="{{ URL::to('/UserAction/Delete/'.$id??0) }}">Delete</a>
        </div>
      </div>
    </div>
  </div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var id = @json($id ?? 0);

        // If id is greater than 0, show the modal
        if (id > 0) {
            var modalEl = document.getElementById('Operation');
            var modal = new bootstrap.Modal(modalEl);
            modal.show();
        }
    });
</script>
@endsection
