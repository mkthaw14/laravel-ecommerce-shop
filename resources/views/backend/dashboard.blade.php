@extends('backend.backend_layout')
@section('title')
    DashBoard
@endsection
@section('main_content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">Categories</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    {{count($categories)}}
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">Product</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    {{count($products)}}
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">Orders</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    {{count($orders)}}
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">Total Order Amount</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    ${{$numberOfOrderAmount}}

                </div>
            </div>
        </div>
    </div>

</div>  
@endsection