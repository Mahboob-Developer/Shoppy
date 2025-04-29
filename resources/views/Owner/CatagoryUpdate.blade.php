@extends('Owner.MasterView')
@section('location')
@php
    $id=$id;
@endphp
<div class="container">
    <div class="col-md-6 col-12 border rounded shadow-sm offset-md-3 p-3 mt-3">
      <p class="modal-title fs-2 fw-bold  mb-2" id="staticBackdropLabel">
       Catagory Updating
      </p>
      <form action="{{URL::to('/CatagoryUpdate',['id'=>$id])}}" method="post" id="catagoryUpdate" enctype="multipart/form-data">
        @csrf
        <div class="modal-header"></div>

        <div class="form-floating mb-3">
          <input type="text" class="form-control" name="Name" id="Name" placeholder="Enter Catagory Name" value="{{ $category['name']}}" />
          <label for="Name">Enter Catagory Name</label>
          <span id="Name_error" class="text-danger ms-1">
            @error('Name')
                {{ $message }}
            @enderror
          </span>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="Size" id="Size" placeholder="Enter Size" value="{{$category['size']}}" />
            <label for="Name">Enter Size seperated by comma ( , )</label>
            <span id="Size_error" class="text-danger ms-1">
              @error('Size')
                  {{ $message }}
              @enderror
            </span>
          </div>
        

        <div class="form-floating mb-3">
          <input type="file" class="form-control" name="image" id="image" placeholder="Enter main image" value="{{$category['image']}}" />
          <label for="first">Choose Image</label>
          <span id="image_error" class="text-danger ms-1">
            @error('image')
                {{ $message }}
            @enderror
          </span>
        </div>
        <div class="d-grid gap-2 mx-3">
          <button type="submit" name="submit" class="w-100 btn-lg btnPrimary" >Submit</button>
          <a href="{{URL::to('/Catagorydetails')}}">
            <button type="button" class="w-100 btn-lg btnDanger">Cancel</button>
          </a>
        </div>
      </form>
    </div>
  </div>
@endsection
