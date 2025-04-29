@extends('Owner.MasterView')
@php
$id = $id ?? 0;
@endphp
@section('location')
<h3 class="m-3">Catagory Details</h3>
<div class="container-fluid table-responsive my-2">
    <table class="table table-striped border">
        <thead>
            <tr>
                <th class="text-center">S.N</th>
                <th class="text-center">Catagory</th>
                <th class="text-center">Size</th>
                <th class="text-center">Image</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>            
        @php
            $sno=1;
        @endphp
            @foreach ($catagory as $category)
                <tr>
                <td class="text-center">{{$sno}}</td>
                <td class="text-center">{{$category['name']}}</td>
                <td class="text-center">{{$category['size']}}</td>
                <td class="text-center">
                    <img class="rounded ResponsibeImage" src="{{ asset('Catagory/'. $category['image']) }}" alt="{{$category['imgage']}}">
                </td>
                <td class="text-center d-flex">
                    <span class="mx-auto my-2">
                        <a href="{{ route('CatagoryUpdate',$category['id']) }}"  class="btnPrimary">
                            Update
                        </a>

                        <a href="{{ route('Catagorydetails', $category['id'])}}" class="btnDanger">
                            Delete
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
<div class="text-center my-2">
    <!-- Button trigger modal -->
    <a class="nav-link" href="{{ URL::to('/CatagoryAdd') }}">
        <button class="btnPrimary">
            Add to Catagory
        </button>
    </a>
</div>

<!-- Modal -->
<form id="deleteForm" method="POST" action="{{ URL::to('/CatagoryAction/' . $id) }}">
            @csrf
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Do you want to Delete?
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btnPrimary">Yes</button>
                    <a href="{{ URL::to('/') }}/Catagorydetails" class="btn btnDanger">No</a>
                </div>
            </div>
        </div>
    </div>  
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var id = @json($id); // Pass the PHP variable to JavaScript
        if (id >0) {
            var myModalEl = document.getElementById('staticBackdrop');
            var modal = new bootstrap.Modal(myModalEl);
            modal.show(); // Show the modal if id > 0
        }
    });
</script>
@endsection
