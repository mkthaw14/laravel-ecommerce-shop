@extends('frontend.layout')
@section('title')
    Cart 
@endsection
@section('main_section')
    <div class="container px-4 px-lg-5 mt-5">
        <div class="mb-3">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="cart-table">

                </tbody>
                <tfoot id="cart-footer">
                </tfoot>
           </table>
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
  
                      <div class="col-12">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error("email") is-invalid @endError" id="email" name="email" value="{{old("email")}}">
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="col-12">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control @error("password") is-invalid @endError" id="password" name="password" value="{{old("password")}}">
                        @error('password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="col-12">
                        <label for="shipping-address" class="form-label">Shipping Address</label>
                        <input type="text" class="form-control @error("shipping_address") is-invalid @endError" id="shipping-address" name="shipping_address" value="{{old("shipping_address")}}">
                        @error('shipping_address')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      
                      <div class="col-12">
                          <button type="submit" class="btn btn-dark float-end">Place Order</button>
                      </div>
  
                    </form>
              </div>
  
            </div>
          </div>
        </div>
  
  </div>
@endsection

@section('scripts')
<script>
    const checkOutRoute = `{{route("shop.check-out")}}`;
</script>
<script src="{{asset("frontend/js/add-to-cart.js")}}"></script>

@endsection