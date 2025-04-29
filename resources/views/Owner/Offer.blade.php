@extends('Owner.MasterView')

@php
    $id = $id ?? 0;
@endphp


@section('location')
<h3 class="m-3">Offer Details</h3>
<div class="container-fluid table-responsive my-2">
    <table class="table table-striped border">
        <thead>
            <tr>
                <th class="text-center">S.N</th>
                <th class="text-center">Offer Name</th>
                <th class="text-center">Category</th>
                <th class="text-center">Discount(%)</th>
                <th class="text-center">Starting</th>
                <th class="text-center">Ending</th>
                <th class="text-center">Image</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @php
                $sno=1;
            @endphp
            @foreach ($offer as $offerItem)
            <tr>
                <td class="text-center">{{$sno}}</td>
                <td class="text-center">{{$offerItem['name']}}</td>
                <td class="text-center">{{$offerItem['category']}}</td>
                <td class="text-center">{{$offerItem['discount']}}%</td>
                <td class="text-center">{{$offerItem['starting_date']}}</td>
                <td class="text-center">{{$offerItem['ending_date']}}</td>
                <td class="text-center">
                    <img class="rounded ResponsibeImage" src="{{ asset('Offer/' . $offerItem['image']) }}" alt={{$offerItem['image']}}>
                </td>
                <td class="text-center d-flex justify-content-center">
                    <a class="btnPrimary mx-1" href="{{ url('/OfferUpdate/' . $offerItem['id']) }}">Update</a>
                    <a class="btnPrimary mx-1" href="{{ url('/OfferDetails/' . $offerItem['id']) }}">Delete</a>
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
</div>

<div class="text-center my-2">
    <a class="nav-link" href="{{ URL::to('/') }}/OfferAdd">
        <button class="btnPrimary">Add to Category</button>
    </a>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="OfferDeleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="OfferDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{URL::to('/OfferDelete/'.$id)}}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="OfferDeleteModalLabel">Delete Offer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Do you want to delete this offer?
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btnPrimary">Yes</button>
                    <a href="{{ URL::to('/') }}/OfferDetails">
                    <button type="button" class="btnDanger" data-bs-dismiss="modal">No</button></a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var id = @json($id); // Pass the PHP variable to JavaScript
        if (id > 0) {
            var myModalEl = document.getElementById('OfferDeleteModal');
            var modal = new bootstrap.Modal(myModalEl);
            modal.show(); // Show the modal if id > 0
        }
    });
</script>
@endsection
