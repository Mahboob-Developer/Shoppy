@extends('Owner.MasterView')

@php
    $type = request('type', '');  // Ensure you are retrieving the 'type' from the request
    $id = request('id', 0);       // Ensure you are retrieving the 'id' from the request
@endphp

@section('location')
<div class="container-fluid table-responsive my-2">
    <table class="table table-striped">
        <thead>
            <tr>
                <th class="text-center">S.N</th>
                <th class="text-center">Image</th>
                <th class="text-center">Full Name</th>
                <th class="text-center">Shop Name</th>
                <th class="text-center">Phone</th>
                <th class="text-center">E-mail</th>
                <th class="text-center">Gender</th>
                <th class="text-center">Pincode</th>
                <th class="text-center">Address</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sallerDetail as $sallerItem)
                @if ($sallerItem->status != 'Owner')
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">
                            <img class="rounded ResponsibeImage" 
                                 src="{{ empty($sallerItem->image) ? asset('Profile/profile.png') : asset('Profile/'.$sallerItem->image) }}" 
                                 alt="Profile">
                        </td>
                        <td class="text-center">{{ $sallerItem->fullname }}</td>
                        <td class="text-center">{{ $sallerItem->brand }}</td>
                        <td class="text-center">{{ $sallerItem->mobile }}</td>
                        <td class="text-center">{{ $sallerItem->email }}</td>
                        <td class="text-center">{{ $sallerItem->gender }}</td>
                        <td class="text-center">{{ $sallerItem->pincode }}</td>
                        <td class="text-center">{{ $sallerItem->address }}</td>
                        <td class="text-center">
                            <span class="mx-auto d-flex">
                                @if ($sallerItem->status == 'Admin')
                                    <a href="{{ URL::to('/Saller/Block/'.$sallerItem->id) }}" class="btnDanger">Block</a>
                                @endif
                                @if ($sallerItem->status == 'Block')
                                    <a href="{{ URL::to('/Saller/Unblock/'.$sallerItem->id) }}" class="btnDanger">UnBlock</a>
                                @endif
                                @if ($sallerItem->status == 'Pending')
                                    <button type="button" class="btnPrimary" disabled>InActive</button>
                                @endif
                                @if ($sallerItem->status != 'Pending')
                                    <a href="{{ URL::to('/Saller/Delete/'.$sallerItem->id) }}" class="btnPrimary">Delete</a>
                                @endif
                            </span>
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal for Action -->
<form id="SallerActionForm" method="POST" action="{{ URL::to('/SallerActionForm/' . $type . '/' . $id) }}">
    @csrf
    <div class="modal fade" id="SallerAction" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Do you want to {{ $type }}?
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btnPrimary">Yes</button>
                    <a href="{{ URL::to('/Saller') }}" class="btn btnDanger">No</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var id = "{{ $id }}";
        var type = "{{ $type }}";

        if (id > 0 && type) {
            var myModalEl = document.getElementById('SallerAction');
            var modal = new bootstrap.Modal(myModalEl);
            modal.show(); // Show the modal
        }
    });
</script>
