@extends('Admin.MasterView')

@section('location')
<div class="container">
    <div class="col-md-6 col-12 border rounded shadow-sm offset-md-3 p-3 mt-2">
        <p class="modal-title fs-2 fw-bold mb-2" id="staticBackdropLabel">
            Update Product
        </p>
        @php
            // Replace this with the actual dynamic ID if available
            $id = $product->id;
        @endphp
        <form action="{{ URL::to('/ProductUpdateForm/' . $id) }}" method="post" id="offer_edit" enctype="multipart/form-data">
            @csrf

            <!-- Product Name -->
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="ProductName" id="ProductName" placeholder="Enter product name" value="{{ old('ProductName', $product['name']) }}" />
                <label for="ProductName">Product Name</label>
                <span id="product_name_error" class="text-danger ms-1">
                    @error('ProductName')
                        {{ $message }}
                    @enderror
                </span>
            </div>

            <!-- Category Selection -->
            <div class="mb-3 border rounded p-3">
                <label for="category" class="form-label me-3">Select Category:</label>
                <select class="w-25 select bg-transparent border border-none border-bottom" name="category" id="category" onchange="submitForm()">
                    <option value="">Select</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category['name'] }}" {{ old('category', $product['category']) == $category['name'] ? 'selected' : '' }}>
                            {{ $category['name'] }}
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

            <!-- Size Selection -->
            <div class="border rounded p-3 mb-3">
    <label>Select Size:</label>
    @php
        // Convert size strings to arrays if necessary
        $selectedSizes = old('productSize', is_array($product['size']) ? $product['size'] : explode(',', $product['size']));
    @endphp
    @foreach ($categories as $category)
        @if (old('category', $product['category']) == $category['name'])
            @foreach (explode(',', $category['size']) as $size)
                <input type="checkbox" class="btn-check" name="productSize[]" id="{{ $size }}" value="{{ $size }}" autocomplete="off" 
                    {{ in_array($size, $selectedSizes) ? 'checked' : '' }}>
                <label class="btn btn-light btn-outline-secondary" for="{{ $size }}">{{ $size }}</label>
            @endforeach
        @endif
    @endforeach
    <br>
    <span id="product_size_error" class="text-danger">
        @error('productSize')
            {{ $message }}
        @enderror
    </span>
</div>

            <!-- Brand Name -->
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="brand" id="brand" placeholder="Enter brand name" value="{{ old('brand', $product['brand']) }}" />
                <label for="brand">Brand Name</label>
                <span id="brand_error" class="text-danger ms-1">
                    @error('brand')
                        {{ $message }}
                    @enderror
                </span>
            </div>

            <!-- Product Quantity -->
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="quantity" id="quantity" placeholder="Enter product quantity" value="{{ old('quantity', $product['quantity']) }}" />
                <label for="quantity">Product Quantity</label>
                <span id="product_quantity_error" class="text-danger ms-1">
                    @error('quantity')
                        {{ $message }}
                    @enderror
                </span>
            </div>

            <!-- Product Price -->
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="product_price" id="product_price" placeholder="Enter product price" value="{{ old('product_price', $product['price']) }}" />
                <label for="product_price">Product Price</label>
                <span id="product_price_error" class="text-danger ms-1">
                    @error('product_price')
                        {{ $message }}
                    @enderror
                </span>
            </div>

            <!-- Product Description -->
            <div class="form-floating mb-3">
                <textarea class="form-control" name="description" id="description" placeholder="Enter description" cols="30" rows="3">{{ old('description', $product['description']) }}</textarea>
                <label for="description">Product Details Seprated by comma ' , '</label>
                <span id="description_error" class="text-danger ms-1">
                    @error('description')
                        {{ $message }}
                    @enderror
                </span>
            </div>

            <!-- Images Upload -->
            @foreach (['first' => 'Main Image', 'second' => 'Second Image', 'third' => 'Third Image', 'fourth' => 'Fourth Image'] as $name => $label)
                <div class="form-floating mb-3">
                    <input type="file" class="form-control" name="{{ $name }}" id="{{ $name }}" placeholder="Enter {{ strtolower($label) }}" />
                    <label for="{{ $name }}">{{ $label }}</label>
                    <span id="{{ $name }}_error" class="text-danger ms-1">
                        @error($name)
                            {{ $message }}
                        @enderror
                    </span>
                </div>
            @endforeach

            <!-- Submit and Cancel Buttons -->
            <div class="d-grid gap-2 mx-3">
                <button type="submit" name="submitbutton" class="w-100 btn-lg btnPrimary">Submit</button>
                <a href="/Products">
                    <button type="button" class="w-100 btn-lg btnDanger">Cancel</button>
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    function submitForm() {
        document.getElementById('offer_edit').submit();
    }
</script>
@endsection
