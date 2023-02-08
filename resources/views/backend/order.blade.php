@extends('backend.backend_layout')
@section('title')
    Order
@endsection
@section('main_content')
<div class="container-fluid px-4">

    <div class="d-flex justify-content-between">
        <div>
            <h1 class="my-4">Orders</h1>
        </div>
        <div class="d-flex align-items-center">

        </div>
    </div>
    <div class="card mb-4">

        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Customer</th>
                        <th>Receiver</th>
                        <th>Receiver Address</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{$order->id}}</td>
                            <td>{{$order->created_at}}</td>
                            <td>{{$order->status}}</td>
                            <td>{{$order->user->name}}</td>
                            <td>{{$order->receiver_name}}</td>
                            <td>{{$order->receiver_address}}</td>
                            <td class="d-flex">
                                <a href="{{route("order.show", $order->id)}}" class="btn btn-success">Detail</a>
                                @if($order->status == "cancelled" || $order->status == "received")
                                  <form class="mx-2" id="delete-form-id-{{$order->id}}" method="POST" action="{{route("order.destroy", $order->id)}}">
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
<script src="{{asset("backend/js/delete-modal.js")}}"></script>
@endsection