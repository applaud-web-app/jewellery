@extends('frontend.master')
@section('previous', 'Home')
@section('current', 'Order History')
@section('content')
@include('breadcrumbs')
@include('messages')
<section class="space order-history">
    <div class="container">
        @if (count($orders) > 0)
        <div class="d-flex justify-content-between">
            <h5 class="mb-3">Order History</h5>
        </div>
        <div class="table-responsive">
            <table class="table order-table" style="min-width: 100%">
                <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>Product</th>
                        <th>Files</th>
                        <th>Reviews </th>
                        <th>Price </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $item)
                    @php 
                    $inputObj = new stdClass();
                    $inputObj->url = url('download-digital-file');
                    $inputObj->params = 'id='.$item->product->id.'&order_id='.$item->order_id;
                    $encLink = Common::encryptLink($inputObj);
                    @endphp
                    <tr>
                        <td>
                            {{++$loop->index}}
                        </td>
                        <td><a href="/worksheet-details/{{$item->product->id}}">{{$item->product->product_name}}</a></td>
                        <td><a href="{{$encLink}}" class="btn btn-outline-secondary  btn-sm">Download</a></td>
                        <td><a href="/give-review/{{$item->product->id}}" class="btn btn-secondary  btn-sm"> @if ($item->reviews != null) {{"Update Review"}} @else  {{"Give Review"}} @endif</a></td>
                        <td>₹{{$item->product->discount_price}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else 
        <div class="no-items">
            <div class="text-center">
                <img src="{{asset('assets/frontend/img/empty-box.png')}}" alt="" class="img-fluid">
                <h4 class="mt-3">Your Order List Is Empty</h4>
                <p>Order is empty. Please go to your home page for listing it.</p>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection