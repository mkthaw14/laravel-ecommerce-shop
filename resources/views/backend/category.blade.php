@extends('backend.backend_layout')
@section('title')
    Category
@endsection
@section('main_content')
<div class="container-fluid px-4">

    <div class="d-flex justify-content-between">
        <div>
            <h1 class="my-4">Categories</h1>
        </div>
        <div class="d-flex align-items-center">
            <button id="create-form-btn" type="button" class="btn btn-primary" >
                New Category
            </button>
        </div>
    </div>
    <div class="card mb-4">

        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Products</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{$category->id}}</td>
                            <td>{{$category->name}}</td>
                            <td>{{count($category->products)}}</td>
                            <td class="d-flex">
                                <button  class="edit-form-btn btn btn-success" data-id="{{$category->id}}">Edit</button>
                                @if(count($category->products) < 1)
                                  <form class="mx-2" id="delete-form-id-{{$category->id}}" method="POST" action="{{route("category.destroy", $category->id)}}">
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
                <form class="row g-3" action="" method="POST">
                    @csrf
                    <input type="hidden" value="{{$status}}" id="form-status">
                    <div id="method-overide">

                    </div>

                    <div>
                        <input type="hidden" id="category-id" name="category_id" value="{{old("category_id")}}">
                    </div>
                    <div class="col-12">
                      <label for="category-name" class="form-label">Category Name</label>
                      <input type="text" class="form-control @error("name") is-invalid @endError" id="category-name" name="name" value="{{old("name")}}">
                      @error('name')
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


  function showCreateForm()
  {
      $("#modal-form-label").text("Create Category");
      $("#method-overide").html('');
      $("#modal-form form").attr("action", `{{route("category.store")}}`);
      $("#modal-form").modal("show");
  }

  function showEditForm(category_id, error)
  {
      let route = `{{route('category.get-category')}}`;
      $.get(route, {id:category_id} , function(data) {
          console.log(data);
          if(!error)
              fillFormData(data);
          //$("#modal-form form").attr("action", `{{route("category.store")}}`);

          let formRoute = `{{route("category.update", ':category')}}`;
          formRoute = formRoute.replace(":category", category_id);
          console.log(formRoute);
                  
          $("#modal-form-label").text("Edit Category");
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
      showEditForm($("#category-id").val(), true);
  }

  function fillFormData(data)
  {
      $("#category-name").val(data.category.name);
  }

  function clearFormData()
  {
      $("#category-id").val('');
      $("#category-name").val('');
  }

  function clearValidationErrors()
  {
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
      $("#category-id").val(id);
  }
</script>   
@endsection