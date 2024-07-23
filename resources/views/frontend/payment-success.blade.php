@extends('frontend.master')
@section('content')
@include('messages')
<section class="vs-error-wrapper space">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 ">
                <div class="error-content text-center">
                    <img src="/assets/frontend/img/thank-you.jpg" style="height:250px;"  alt="shape" class="">
                    <h2 class="error-title text-bolder text-primary">Payment Successfull</h2>
                    <p class="error-text">I just wanted to drop you a quick note to let you know that we have received your recent payment in respect of invoice. Thank you very much. We really appreciate it.</p>
                    @if (Session()->has('orderId'))
                    <a href="/order-invoice/{{Session::get('orderId')}}" class="vs-btn style4">Order Invoice</a>
                    @endif
                    <a href="/" class="vs-btn style4">Back To Homepage</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection