@extends('frontend.master')
@section('previous', 'Home')
@section('current', 'Order Invoice')
@section('content')
@include('breadcrumbs')
@include('messages')


<style>
   @media print {
    .vs-menu-wrapper,.popup-search-box,header,footer{
        display:none!important;
    }
    #printBox{
        display: block!important;
    }
    }
</style>
<section class="space" >
    <div class="container">
        <div class="title-area text-center">
            <h2 class="sec-title">Invoice</h2>

            <img src="assets/img/headline.png" alt="" class="img-fluid ">
            <p class="sec-text">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sapiente, accusantium. Aliquid
                pariatur dolore dolores, optio nesciunt praesentium esse possimus tempore tenetur magni accusamus nobis
                enim? Vitae exercitationem sequi unde optio.</p>
        </div>
        <div class="card mt-3" id="printBox">
            <div class="card-header"> Invoice <strong>{{date("d M, Y",strtotime($order->created_at))}}</strong> <span class="float-end">
                    <strong>Status:</strong> {{$order->order_status == 1 ? "Completed":"Pending"}}</span> </div>
            <div class="card-body">
                <div class="row  mb-5">
                    <div class="mt-4 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <h6>From:</h6>
                        <div><strong>Printaboo</strong> </div>
                        <div>First Floor, 10A Chandos Street London New Town W1G 9LE</div>
                        <div>Email: user@domainname.com</div>
                        <div>Phone: +44 (0) 207 689 7888</div>
                    </div>
                    <div class="mt-4 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <h6>To:</h6>
                        @isset($order->user_details)
                            @php
                               $details = json_decode($order->user_details);
                            @endphp
                        @endisset
                        <div> <strong>{{$details->name ? $details->name : "" }}</strong> </div>
                        <div>{{$details->email ? $details->email : "" }}</div>
                        <div>{{$details->locality ? $details->locality : "" }} {{$details->state ? $details->state : "" }} {{$details->city ? $details->city : "" }}</div>
                        <div>Email: {{$details->email ? $details->email : "" }}</div>
                        <div>Phone: {{$details->number ? $details->number : "" }}</div>
                    </div>
                    {{-- <div
                        class="mt-4 col-xl-6 col-lg-6 col-md-12 col-sm-12 d-flex justify-content-lg-end justify-content-md-center justify-content-xs-start">
                        <div class="row align-items-center">
                            <div class="col-sm-9">
                                <div class="brand-logo mb-3">
                                    <img class="logo-abbr me-2" width="50" src="./images/logo.png" alt="">
                                    <img class="logo-compact" width="110" src="./images/logo-text.png" alt="">
                                </div>
                                <span>Please send exact amount: <strong class="d-block">0.15050000 BTC</strong>
                                    <strong>1DonateWffyhwAjskoEwXt83pHZxhLTr8H</strong></span><br>
                                <small class="text-muted">Current exchange rate 1BTC = ₹6590 USD</small>
                            </div>
                            <div class="col-sm-3 mt-3"> <img src="images/qr.png" alt="" class="img-fluid width110">
                            </div>
                        </div>
                    </div> --}}
                </div>

                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center" width="100">Image</th>
                                <th>Item</th>

                                <th class="text-end">Total</th>
                                <th class="text-end" width="180">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total = 0;
                            @endphp
                            @foreach ($childOrder as $item)
                              @php 
                                $total += $item->product->discount_price;
                                $inputObj = new stdClass();
                                $inputObj->url = url('download-digital-file');
                                $inputObj->params = 'id='.$item->product->id.'&order_id='.$item->order_id;
                                $encLink = Common::encryptLink($inputObj);
                              
                              @endphp
                                <tr>
                                    <td class="text-center">{{++$loop->index}}</td>
                                    <td class="text-center"><img src="/uploads/product_images/product_feature_image/{{$item->product->product_fetaure_img}}" alt=""
                                            class="img-thumbnail" width="64"></td>
                                    <td class="left strong">{{$item->product->product_name}}</td>
                                    <td class="text-end">₹{{$item->product->discount_price}}</td>
                                    <td class="text-end"><a href="{{$encLink}}" class="btn btn-secondary btn-sm"><i
                                                class="fal fa-download pe-2"></i>Download</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-sm-5"> </div>
                    <div class="col-lg-4 col-sm-5 ms-auto">
                        <table class="table table-clear">
                            <tbody>
                                <tr>
                                    <td class="left"><strong>Subtotal</strong></td>
                                    <td class="text-end">₹{{$total}}</td>
                                </tr>
                                <tr>
                                    <td class="left"><strong>Coupon Discount</strong></td>
                                    <td class="text-end">₹{{$order->coupon_amount}}</td>
                                </tr>
                                <tr>
                                    <td class="left"><strong>Total</strong></td>
                                    <td class="text-end"><strong>₹{{$order->payment}}</strong><br>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-4">
            <a id="printPageArea" class="btn btn-primary">Print Now</a>
            <a href="/" class="btn btn-success mx-2">Go Back</a>
        </div>
    </div>
</section>
@push('scripts')
<script>
    function printPageArea(){
        var printContent = document.getElementById('printBox').innerHTML;
        var originalContent = document.body.innerHTML;
        document.body.innerHTML = printContent;
        window.print();
        document.body.innerHTML = originalContent;
    }
</script>
<script>
    $('#printPageArea').click(function(){
        printPageArea();
    })
</script>
    
@endpush
@endsection