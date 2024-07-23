@extends('frontend.master')
@section('content')
@section('previous', 'Home')
@section('current', 'Faq')
@section('content')
@include('breadcrumbs')
<section class="space-top space-extra-bottom">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h2>Got Question <br> Get Answers</h2>
                <div class="title-divider1"></div>
                <p class="fs-5">Visit our <a href="/contact">Support center</a> for more information</p>
            </div>
            <div class="col-lg-6">
                <div class="accordion accordion-style" id="faqVersion3">
                    @if (count($faqs) > 0)
                        @foreach ($faqs as $faq)
                            <div class="accordion-item">
                                <div class="accordion-header" id="headingTwo{{$faq->id}}"><button class="accordion-button collapsed"
                                        type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo{{$faq->id}}"
                                        aria-expanded="false" aria-controls="collapseTwo{{$faq->id}}">{{$faq->question}}</button></div>
                                <div id="collapseTwo{{$faq->id}}" class="accordion-collapse collapse {{ $loop->index == 0 ? "show" : ""}} " aria-labelledby="headingTwo{{$faq->id}}"
                                    data-bs-parent="#faqVersion3">
                                    <div class="accordion-body">
                                        <p>{{$faq->answer}}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection