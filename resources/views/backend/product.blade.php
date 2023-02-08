@extends('backend.backend_layout')

@section('title')
    Product   
@endsection

@section('main_content')
<div class="container-fluid px-4">

    <div class="d-flex justify-content-between">
        <div>
            <h1 class="my-4">Products</h1>
        </div>
        <div class="d-flex align-items-center">
            <button id="create-form-btn" type="button" class="btn btn-primary" >
                New Product
            </button>
        </div>
    </div>
    <div class="card mb-4">

        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td style="height: 120px;">{{$product->id}}</td>
                            <td style="height: 120px;"><img src="{{asset($product->image)}}" alt="{{$product->image}}" height="100%" width="100px"></td>
                            <td style="height: 120px;">{{$product->name}}</td>
                            <td style="height: 120px;">{{$product->price}}</td>
                            <td style="height: 120px;">{{$product->category->name}}</td>
                            <td style="height: 120px;">{{$product->description}}</td>
                            <td style="height: 120px;" class="d-flex">

                                <div>
                                    <button  class="edit-form-btn btn btn-success" data-id="{{$product->id}}">Edit</button>
                                </div>

                                @if (count($product->orderItems) < 1)
                                    <form class="mx-2" id="delete-form-id-{{$product->id}}" method="POST" action="{{route("product.destroy", $product->id)}}">
                                        @csrf
                                        @method("delete")
                                        <button type="button" class="delete-btn btn btn-danger">Delete</button>
                                    </form>
                                @endif
                            </td>
                        </tr>   
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>   

<div>
  
      <!-- Modal -->
      <div class="modal fade" id="modal-form" tabindex="-1" aria-labelledby="modal-form-label" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="modal-form-label"></h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{$status}}" id="form-status">
                    <input type="hidden" value="" id="image-url" name="image-url">
                    <div id="method-overide">

                    </div>

                    <div>
                        <input type="hidden" id="product-id" name="product_id" value="{{old("product_id")}}">
                    </div>

                    <div class="col-12" id="image-section">
                        <div id="edit-image-section">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation" id="old-img">
                                <button class="nav-link active" id="old-image-tab" data-bs-toggle="tab" data-bs-target="#old-image" type="button" role="tab" aria-controls="old-image" aria-selected="true">Product Image</button>
                                </li>
                                <li class="nav-item" role="presentation" id="new-img">
                                    <button class="nav-link" id="new-image-tab" data-bs-toggle="tab" data-bs-target="#new-image" type="button" role="tab" aria-controls="new-image" aria-selected="false">Change Image</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade" id="new-image" role="tabpanel" aria-labelledby="new-image-tab">
                                    <div class="mt-3">
                                      <input class="form-control @error('image') is-invalid @enderror" type="file" id="edit-form-file" name="image">
                                      @error('image')
                                            <div class="text-danger">
                                                    {{$message}}  
                                            </div>
                                      @enderror
                                    </div>    
                                </div>
                                <div class="tab-pane fade show active" id="old-image" role="tabpanel" aria-labelledby="old-image-tab">
                                    <div class="mt-3">
                                      <img src="{{old("image-url")}}" alt="" id="old-picture" width="120px" height="120px">
                                    </div>     
                                </div>
                            </div>
                        </div>
                        <div id="create-image-section">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation" id="new-img">
                                    <button class="nav-link active" id="new-image-tab" data-bs-toggle="tab" data-bs-target="#new-image" type="button" role="tab" aria-controls="new-image" aria-selected="false">Upload Image</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="new-image" role="tabpanel" aria-labelledby="new-image-tab">
                                    <div class="mt-3">
                                      <input class="form-control @error('image') is-invalid @enderror" type="file" id="create-form-file" name="image">
                                      @error('image')
                                        <div class="text-danger">
                                                {{$message}}  
                                        </div>
                                      @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="category-select" class="form-label">Category</label>
                        <select class="form-select" id="category-select" name="category_id">
                            @foreach ($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                      <label for="product-name" class="form-label">Product Name</label>
                      <input type="text" class="form-control @error("name") is-invalid @endError" id="product-name" name="name" value="{{old("name")}}">
                      @error('name')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>
                    <div class="col-12">
                        <label for="product-price" class="form-label">Price</label>
                        <input type="number" class="form-control @error("price") is-invalid @endError" id="product-price" name="price" value="{{old("price")}}">
                        @error('price')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label for="product-description" class="form-label">Product Description</label>
                        <textarea  cols="30" rows="5" class="form-control @error("description") is-invalid @endError" id="product-description" name="description">{{old("description")}}</textarea>
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary float-end">Save</button>
                    </div>

                  </form>
            </div>

          </div>
        </div>
      </div>

  
      <!-- Delete Modal -->
      <div class="modal fade" id="delete-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Warning</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div>Are you sure you want to delete this?</div>
            </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" data-target="none" id="confirm-delete-btn" class="btn btn-danger">Delete</button>
            </div>
          </div>
        </div>
      </div>
</div>
@endsection

@section('scripts')
<script src="{{asset("backend/js/modal-form.js")}}"></script>
<script src="{{asset("backend/js/delete-modal.js")}}"></script>
<script>

    function showCreateImageSection()
    {
        $("#edit-image-section").hide();
        $("#create-image-section").show();
        $("#edit-form-file").attr("disabled", true);
        $("#create-form-file").attr("disabled", false);
    }

    function showEditImageSection()
    {
        $("#edit-image-section #old-image-tab").tab("show");
        $("#create-image-section").hide();
        $("#edit-image-section").show();
        $("#create-form-file").attr("disabled", true);
        $("#edit-form-file").attr("disabled", false);
    }

    function showCreateForm()
    {
        showCreateImageSection();

        $("#modal-form-label").text("Create Product");
        $("#method-overide").html('');
        $("#modal-form form").attr("action", `{{route("product.store")}}`);
        $("#modal-form").modal("show");
    }
  
    function showEditForm(product_id, error)
    {
        console.log("prod : " + product_id);
        let route = `{{route('product.get-product')}}`;
        $.get(route, {id:product_id} , function(data) {
            console.log(data);
            if(!error)
                fillFormData(data);
            //$("#modal-form form").attr("action", `{{route("category.store")}}`);
  
            let formRoute = `{{route("product.update", ':product')}}`;
            formRoute = formRoute.replace(":product", product_id);
            console.log(formRoute);
                
            showEditImageSection();

            $("#modal-form-label").text("Edit Product");
            $("#method-overide").html(`@method('put')`);
            $("#modal-form form").attr("action", formRoute);
            $("#modal-form").modal("show");
        })
        //$("#modal-form form").attr("action");
    }
  
    function showCreateErrorForm()
    {
        showCreateForm();
    }
  
    function showEditErrorForm()
    {
        showEditForm($("#product-id").val(), true);
    }
  
    function fillFormData(data)
    {
        $("#category-select").val(data.product.category_id);
        $("#product-name").val(data.product.name);
        $("#product-price").val(data.product.price);
        $("#image-url").val(data.product.image);
        $("#old-picture").attr("src", data.product.image);
        $("#product-description").val(data.product.description);
    }
  
    function clearFormData()
    {
        $("#category-select").val(1);
        $("#product-id").val('');
        $("#product-name").val('');
        $("#product-price").val('');
        $("#product-description").val('');
    }
  
    function clearValidationErrors()
    {
        console.log("file " + $("#formFile").html());
        //$("#modal-form form").find(".form-control").removeClass("is-invalid");
        $("#modal-form form .form-control").removeClass("is-invalid");
        $("#modal-form form .text-danger").hide();
    }
  
    function checkFormStatusValue()
    {
        let status = $("#form-status").val();
        if(status == 2)
            showCreateErrorForm();
        else if(status == 3)
            showEditErrorForm();
  
        //alert(status);
    }
  
    function setHiddenID(id)
    {
        $("#product-id").val(id);
    }
  </script>   
@endsection