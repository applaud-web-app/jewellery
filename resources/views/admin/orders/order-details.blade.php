@extends('admin.master')
@section('title')
Orders Details
@endsection
@section('content')
@push('styles')
<link rel="stylesheet" href="{{asset("assets/admin/vendor/sweetalert2/dist/sweetalert2.min.css")}}">
@endpush
<section class="content-body">
    <!-- row -->
    <div class="container-fluid">
        <div class="mb-sm-3 d-flex flex-wrap align-items-center text-head">
            <h2 class="mb-3 me-auto">Order ID: {{$order->order_id}}</h2>
            <div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                    <li class="breadcrumb-item"><a href="/admin/all-orders">Orders</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Orders Details</a></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-12">
                <div class="card h-auto">
                    <div class="card-header">
                        <div>
                            <h4 class="mb-0 text-black">Order ID: {{$order->order_id}}</h4>
                            <p class="mb-0">{{date("d M, Y",strtotime($order->created_at))}}</p>
                        </div>
                        <span class="btn bgl-success text-success btn-rounded btn-sm text-uppercase">{{$order->order_status == 1 ? "Deliverd" : "Pending"}}</span>
                    </div>
                    <div class="card-body ">
                        <div class="d-flex align-items-center justify-content-between mb-3 ">
                            <h4 class="fs-20">Products</h4>
                            <a href="" class="text-primary fs-20"><i class="far fa-sticky-note"></i> Receipts</a>
                        </div>
                        @php $total = 0; @endphp
                        @foreach ($childOrder as $items)
                        @php $total += $items->product->discount_price; @endphp
                            <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <img src="/uploads/product_images/product_feature_image/{{$items->product->product_fetaure_img}}" alt="" class="img-fluid rounded-1" width="64"
                                            height="64">
                                    </div>
                                    <div>
                                        <h4 class="mb-0">{{$items->product->product_name}}</h4>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="mb-0"><span class="text-dark">₹{{$items->product->discount_price}}</span></h4>
                                </div>
                            </div>                            
                        @endforeach
                        <div class="bottom-details">
                            <div class="d-flex align-items-center justify-content-between py-1">
                                <span>Subtotal</span>
                                <span class="text-dark">₹{{$total}}</span>
                            </div>
                              <div class="d-flex align-items-center justify-content-between py-1">
                                <span>Coupon Discount</span>
                                <span class="text-dark">₹{{$order->coupon_amount}}</span>
                            </div>
                            <hr>
                            <div class="d-flex align-items-center justify-content-between ">
                                <h5 class="fs-18">Total</h5>
                                <h5 class="fs-18">₹{{$total-$order->coupon_amount}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-12">
                <div class="card h-auto">
                    <div class="card-header">
                        <h4 class="fs-20">Customer Details</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="basic-list-group">
                            <ul class="list-group list-group-flush">
                                @isset($order->user_details)
                                    @php
                                        $order->user_details = json_decode($order->user_details);
                                    @endphp
                                @endisset
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Name</span>
                                    <span class="text-black">{{$order->user_details->name}}</span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Email</span>
                                    <span class="text-black">{{$order->user_details->email}}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Phone Number</span>
                                    <span class="text-black">{{$order->user_details->number}}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Who You Are?</span>
                                    <span class="text-black">{{$order->user_details->buyer_type}}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Locality</span>
                                    <span class="text-black">{{$order->user_details->locality}}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>State</span>
                                    <span class="text-black">{{ Common::getState($order->user_details->state)->name}}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>City</span>
                                    <span class="text-black">{{ Common::getCity($order->user_details->city)->name}}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Post Code</span>
                                    <span class="text-black">{{$order->user_details->postCode ? $order->user_details->postCode : "------" }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                   <span>Payment</span>
                                   <span class="text-black">₹{{$order->payment}}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Status</span>
                                    <span class="badge badge-success light">{{$order->payment_status == 1 ? "Paid" : "Unpaid"}}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection