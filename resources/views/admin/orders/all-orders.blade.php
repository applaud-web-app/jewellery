@extends('admin.master')
@section('title')
All Orders
@endsection
@section('content')
@push('styles')
<link rel="stylesheet" href="{{asset("assets/admin/vendor/sweetalert2/dist/sweetalert2.min.css")}}">
@endpush
<section class="content-body">
    <!-- row -->
    <div class="container-fluid">
        <div class="mb-sm-3 d-flex flex-wrap align-items-center text-head">
            <h2 class="mb-3 me-auto">All Orders</h2>
            <div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                    <li class="breadcrumb-item"><a href="/admin/all-orders">Orders</a></li>
                </ol>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
            <div class="customer-search mb-sm-0 mb-3">
                <div class="input-group search-area">
                    <input type="text" class="form-control" placeholder="Search order id here...." id="search_txt">
                    <span class="input-group-text" id="search_btn"><a href="javascript:void(0)"><i
                                class="flaticon-381-search-2"></i></a></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="table-responsive">
                            <table id="example5" class="display table" style="min-width: 100%">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="form-check custom-checkbox ms-2">
                                                <input type="checkbox" class="form-check-input" id="checkAll"
                                                    required="">
                                                <label class="form-check-label" for="checkAll"></label>
                                            </div>
                                        </th>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Customer </th>
                                        <th>Payment</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($orders) > 0)
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>
                                                <div class="form-check custom-checkbox ms-2">
                                                    <input type="checkbox" class="form-check-input" id="customCheckBox2"
                                                        required="">
                                                    <label class="form-check-label" for="customCheckBox2"></label>
                                                </div>
                                            </td>
                                            <td><a href="/admin/order-detail/{{$order->id}}">{{$order->order_id}}</a></td>
                                            <td>{{date("d M, Y",strtotime($order->created_at))}}</td>
                                            <td>{{$order->customer->name}}</td>
                                            <td><span class="btn {{$order->payment_status == 1 ? "bgl-success text-success" : "bgl-danger text-danger"}}  px-3 btn-sm">{{$order->payment_status == 1 ? "Paid" : "Unpaid"}}</span></td>
                                            <td>
                                                <span class="text-primary">
                                                    <i class="fa fa-circle {{$order->order_status == 1 ? "text-primary" : "text-danger"}}  me-1"></i>
                                                    {{$order->order_status == 1 ? "Deliverd" : "Pending"}}
                                                </span>
                                            </td>
                                            <td>₹{{$order->payment}}</td>
                                            <td>
                                                <a class="btn btn-primary btn-rounded btn-sm" href="/admin/order-detail/{{$order->id}}">View
                                                    Details</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @else 
                                    <tr>
                                        <td colspan="8"><h4 class="text-center text-danger">NO ORDER FOUND</h4></td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@push('scripts')
<script>
    $("#search_btn").on('click',function(){
        var txt = $('#search_txt').val();
        if(txt!=''){
            window.location.href = "{{url('admin/all-orders?q=')}}"+txt;
        }
    })
</script>
@endpush
@endsection