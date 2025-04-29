@extends('Owner.MasterView')

@section('location')
<div class="container">
    <div class="col-md-6 col-12 border rounded shadow-sm offset-md-3 p-3 mt-3">
        <p class="modal-title fs-2 fw-bold mb-2" id="staticBackdropLabel">
            Offer Add
        </p>
        <form action="{{ URL::to('/OfferUpdate/' . $id) }}" method="post" id="OfferAdd" enctype="multipart/form-data">
            @csrf
            <div class="modal-header"></div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="Name" id="Name" placeholder="Enter Offer Name" value="{{ old('Name', $offer['name']) }}" />
                <label for="Name">Enter Name</label>
                <span id="Name_error" class="text-danger ms-1">
                    @error('Name')
                        {{ $message }}
                    @enderror
                </span>
            </div>

            <div class="mb-3 border rounded p-3">
                <label for="category" class="form-label me-3">Select Category:</label>
                <select class="w-25 select bg-transparent border border-none border-bottom" name="category" id="category">
                    <option value="">Select</option>
                    <option value="All" {{ old('category', $offer['category']) == 'All' ? 'selected' : '' }}>All</option>
                    @foreach ($category as $categoryItem)
                        <option value="{{ $categoryItem['name'] }}" {{ old('category', $offer['category']) == $categoryItem['name'] ? 'selected' : '' }}>
                            {{ $categoryItem['name'] }}
                        </option>
                    @endforeach
                </select>
                <br>
                <span id="category_error" class="text-danger">
                    @error('category')
                        {{ $message }}
                    @enderror
                </span>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="Discount" id="Discount" placeholder="Enter Discount Offer (%)" value="{{ old('Discount', $offer['discount']) }}" />
                <label for="Discount">Discount Offer (%)</label>
                <span class="text-danger ms-1">
                    @error('Discount')
                        {{ $message }}
                    @enderror
                </span>
            </div>

            <div class="form-floating mb-3">
                <input type="date" class="form-control" value="{{ old('starting', $offer['starting_date']) }}" name="starting" id="starting" />
                <label for="starting">Starting Date</label>
                <span id="starting_error" class="text-danger ms-1">
                    @error('starting')
                        {{ $message }}
                    @enderror
                </span>
            </div>

            <div class="form-floating mb-3">
                <input type="date" class="form-control" value="{{ old('ending', $offer['ending_date']) }}" name="ending" id="ending" />
                <label for="ending">Ending Date</label>
                <span id="ending_error" class="text-danger ms-1">
                    @error('ending')
                        {{ $message }}
                    @enderror
                </span>
            </div>

            <div class="form-floating mb-3">
                <input type="file" class="form-control" name="image" id="image" placeholder="Choose Image" />
                <label for="image">Choose Image</label>
                <span id="image_error" class="text-danger ms-1">
                    @error('image')
                        {{ $message }}
                    @enderror
                </span>
            </div>

            <div class="d-grid gap-2 mx-3">
                <button type="submit" name="submit" class="w-100 btn-lg btnPrimary">Submit</button>
                <a href="{{ URL::to('/') }}/OfferDetails">
                    <button type="button" class="w-100 btn-lg btnDanger">Cancel</button>
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
