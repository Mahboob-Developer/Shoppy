<!DOCTYPE html>
<html lang="en">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
</head>
<body>
  <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
  Launch static backdrop modal
</button>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="form-control mb-3">
          <label for="gender" class="form-label">Select Rating </label>
          <div>
              <input type="radio" class="btn-check" name="gender" id="Male" value="Male" checked>
              <label class="btn btn-outline-secondary" for="Male"><i class="fa fa-star-sharp"></i></label>

              <input type="radio" class="btn-check" name="gender" id="Female" value="Female">
              <label class="btn btn-outline-secondary" for="Female"><i class="fa fa-star-sharp"></i></label>
              <span class="text-danger">
                  @error('gender')
                  {{$message}}
                  @enderror
              </span>
              
          </div>
      </div>

      <div class="form-group">
                <label for="rating">Rating:</label>
                <div class="star-rating">
                    <input type="radio" name="rating" id="rating-5" value="5"><label for="rating-5"><i class="fa-solid fa-star-sharp"></i></label>
                    <input type="radio" name="rating" id="rating-4" value="4"><label for="rating-4">&#9733;</label>
                    <input type="radio" name="rating" id="rating-3" value="3"><label for="rating-3">&#9733;</label>
                    <input type="radio" name="rating" id="rating-2" value="2"><label for="rating-2">&#9733;</label>
                    <input type="radio" name="rating" id="rating-1" value="1"><label for="rating-1">&#9733;</label>
                </div>
            </div>
            <div class="form-floating mb-3">
              <input type="text" class="form-control" name="brand" id="brand" placeholder="Enter product quantity" value="{{ old('brand') }}" />
              <label for="brand">Brand Name</label>
              <span id="" class="text-danger ms-1">
                @error('brand')
                    {{ $message }}
                @enderror
              </span>
            </div>
            <div class="form-floating mb-3">
              <input type="text" class="form-control" name="brand" id="brand" placeholder="Enter product quantity" value="{{ old('brand') }}" />
              <label for="brand">Brand Name</label>
              <span id="" class="text-danger ms-1">
                @error('brand')
                    {{ $message }}
                @enderror
              </span>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Understood</button>
      </div>
    </div>
  </div>
</div>
</body>
</html>
