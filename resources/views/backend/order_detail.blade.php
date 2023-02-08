@extends('backend.backend_layout')
@section('title')
    Order Detail
@endsection
@section('main_content')
<div class="container-fluid px-4">

    <div class="d-flex justify-content-between">
        <div>
            <h1 class="my-4">Order Detail</h1>
        </div>
        <div class="d-flex align-items-center">
            @if (! $order->isCancelledOrReceived())
              <form id="update-status-form" action="{{route("order.update-status", $order->id)}}" method="POST">
                @csrf
                @method('patch')
                <button id="update-status-btn" data-id="{{$order->id}}" class="btn btn-success mx-3">
                  Mark as <span class="text-capitalize">
                    {{$order->getNextStatusName()}}</span> 
                </button>
              </form>
            @endif
            @if (! $order->isCancelledOrReceived())
              <form id="cancel-status-form" action="{{route("order.status-cancel", $order->id)}}" method="POST">
                @csrf
                @method('patch')
                <button id="status-cancel-btn" class="btn btn-danger">Mark as Cancelled</button>
              </form>
            @endif

        </div>
    </div>


    <div class="row">
        <div class="col-sm-6 mb-3">
          <div class="card">
            <div class="card-body">
                <div class="">
                    <div class="row">
                        <div class="col"><h6>Order ID</h6></div>
                        <div class="col">{{$order->id}}</div>
                    </div>
                    <div class="row">
                        <div class="col"><h6>Order Date</h6></div>
                        <div class="col">{{$order->created_at}}</div>
                    </div>
                    <div class="row">
                        <div class="col"><h6>Order Status</h6></div>
                        <div class="col fw-bold">{{$order->status}}</div>
                    </div>
                    <div class="row">
                      <div class="col"><h6>Receiver Name</h6></div>
                      <div class="col">{{$order->receiver_name}}</div>
                    </div>
                    <div class="row">
                      <div class="col"><h6>Receiver Phone</h6></div>
                      <div class="col">{{$order->receiver_phone}}</div>
                    </div>
                    <div class="row">
                        <div class="col"><h6>Receiver Address</h6></div>
                        <div class="col">{{$order->receiver_address}}</div>
                    </div>
                    <div class="row">
                        <div class="col"><h6>Total Amount</h6></div>
                        <div class="col">{{$order->total_amount}}</div>
                    </div>
                </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6 mb-3">
          <div class="card">
            <div class="card-body">
                <div class="">
                    <div class="row">
                        <div class="col"><h6>Customer</h6></div>
                        <div class="col">{{$order->user->name}}</div>
                    </div>
                    <div class="row">
                        <div class="col"><h6>Phone</h6></div>
                        <div class="col">{{$order->user->phone}}</div>
                    </div>
                    <div class="row">
                        <div class="col"><h6>Email</h6></div>
                        <div class="col">{{$order->user->email}}</div>
                    </div>
                    <div class="row">
                        <div class="col"><h6>Address</h6></div>
                        <div class="col">{{$order->user->address}}</div>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    <div class="card mb-4">

        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($order->orderItems as $item)
                        <tr>
                            <td style="height: 120px;">{{$item->product->id}}</td>
                            <td style="height: 120px;"><img src="{{asset($item->product->image)}}" alt="{{$item->product->image}}" height="100%"></td>
                            <td style="height: 120px;">{{$item->product->name}}</td>
                            <td style="height: 120px;">{{$item->product->price}}</td>
                            <td style="height: 120px;">{{$item->qty}}</td>
                        </tr>   
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>   

<div>
  

      <!-- Confirm Modal -->
      <div class="modal fade" id="confirm-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Confirm</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div>Please confirm the action?</div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" data-target="none" id="confirm-btn" class="btn btn-success">Confirm</button>
            </div>
          </div>
        </div>
      </div>
</div>
@endsection

@section('scripts')
   <script>
      $(document).ready(function() {
          $("#update-status-btn").on("click", function(e) {
             e.preventDefault();
             
             console.log("click");
             setTargetForm(this);
             alertUser();
          });

          $("#status-cancel-btn").on("click", function(e) {
             e.preventDefault();

             setTargetForm(this);
             alertUser();
             console.log("op");
          })

          $("#confirm-btn").on("click", function(){
            submitTargetForm(this);
          });
      }); 

      function alertUser()
      {
          $("#confirm-modal").modal("show");
      }

      function setTargetForm(element)
      {
          let el = $(element).closest("form");

          console.log($(el).attr("id"));

          $("#confirm-btn").data("target", $(el).attr("id"));
      }

      function submitTargetForm(element)
      {
          let form = $(element).data("target");
          console.log("target " + form);
          $("#" + form).submit();
      }
    </script> 
@endsection