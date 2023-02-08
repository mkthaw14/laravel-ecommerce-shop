@extends('frontend.layout')
@section('title')
    Check Out
@endsection
@section('main_section')
    <div class="container">
        <div class="row d-flex justify-content-center py-5">
            <form id="place-order-form" class="col-5 row g-3" action="" method="">

                <input type="hidden" id="csrf_token" name="_token" value="{{csrf_token()}}">
                <div class="col-12">
                  <label for="receiver-name" class="form-label">Receiver Name</label>
                  <input type="text" class="form-control @error("receiver_name") is-invalid @endError" id="receiver-name" name="receiver_name" value="{{old("receiver_name")}}">
                  @error('receiver_name')
                      <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-12">
                  <label for="receiver-address" class="form-label">Receiver Address</label>
                  <input type="text" class="form-control @error("receiver_address") is-invalid @endError" id="receiver-address" name="receiver_address" value="{{old("receiver_address")}}">
                  @error('receiver_address')
                      <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-12">
                    <label for="receiver-phone" class="form-label">Receiver Phone</label>
                    <input type="text" class="form-control @error("receiver_phone") is-invalid @endError" id="receiver-phone" name="receiver_phone" value="{{old("receiver_phone")}}">
                    @error('receiver_phone')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>

                        
                <div class="col-12">
                    <button type="button" id="place-order-btn" class="btn btn-dark float-end">Place Order</button>
                </div>
    
              </form>
        </div>
    </div>

@endsection

@section('scripts')

<script>
    const storgeKey = "cart-items";
    $(document).ready(function() {

        $("#place-order-btn").on("click", function(e) {
            e.preventDefault();
            alert("click");
            let postData = {
                _token : $("#csrf_token").val(),
                receiverName : $("#receiver-name").val(),
                receiverAddress : $("#receiver-address").val(),
                receiverPhone : $("#receiver-phone").val(),
                orderItems : JSON.parse(localStorage.getItem(storgeKey)),
            };

            $.ajax({
                url: "http://localhost:8000/shop/place-order",
                method: "POST",
                data : postData,
                success : function(res)
                {
                    console.log(res.message);
                    if(res.message == "success")
                    {
                        localStorage.clear();
                        window.location.href = "http://localhost:8000/";
                    }
                },
                error : function(res) {
                    console.log(res.responseJSON);
                }

            })
        });


    });
</script>
@endsection