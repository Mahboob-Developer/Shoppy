@extends('Owner.MasterView')
@section('location')
<div class="container">
    <div class="col-md-6 col-12 border rounded shadow-sm offset-md-3 p-3 mt-3">
      <p class="modal-title fs-2 fw-bold  mb-2" id="staticBackdropLabel">
       Catagory Updating
      </p>
      <form action="{{URL::to('/CatagoryAdd')}}" method="post" id="catagoryUpdate" enctype="multipart/form-data">
        @csrf
        <div class="modal-header"></div>

        <div class="form-floating mb-3">
          <input type="text" class="form-control" name="Name" id="Name" placeholder="Enter Catagory Name" value="{{ old('Name') }}" />
          <label for="Name">Enter Catagory Name</label>
          <span id="Name_error" class="text-danger ms-1">
            @error('Name')
                {{ $message }}
            @enderror
          </span>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="Size" id="Size" placeholder="Enter Size" value="{{ old('Size') }}" />
            <label for="Name">Enter Size seperated by comma ( , )</label>
            <span id="Size_error" class="text-danger ms-1">
              @error('Size')
                  {{ $message }}
              @enderror
            </span>
          </div>
        

        <div class="form-floating mb-3">
          <input type="file" class="form-control" name="image" id="image" placeholder="Enter main image" />
          <label for="first">Choose Image</label>
          <span id="image_error" class="text-danger ms-1">
            @error('image')
                {{ $message }}
            @enderror
          </span>
        </div>
        <div class="d-grid gap-2 mx-3">
          <button type="submit" name="submit" class="w-100 btn-lg btnPrimary" >Submit</button>
          <a href="/Catagorydetails">
            <button type="button" class="w-100 btn-lg btnDanger">Cancel</button>
          </a>
        </div>
      </form>
    </div>
  </div>
@endsection
