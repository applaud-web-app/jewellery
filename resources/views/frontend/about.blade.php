@extends('frontend.master')
@section('previous', 'Home')
@section('current', 'About Us')
@section('content')
@include('breadcrumbs')
<section class="space-top space-extra-bottom">
    <div class="container">
        <div class="row align-items-center justify-content-between flex-row-reverse">
            <div class="col-lg-6  text-center text-lg-end">
                <div class="img-box2">
                    <div class="transform-banner"><img src="/assets/frontend/img/about/ab-2-1.jpg" alt="about"></div>
                    <div class="vs-circle jump"></div>
                </div>
            </div>
            <div class="col-lg-6 text-center text-lg-start">
                <h2 class="sec-title me-xxl-5 mb-3">Your child's best start in life</h2>
                <p class="sec-text col-xl-10 pe-4 mb-4">We are constantly expanding the range of services offered,
                    taking children of all ages. Our goal is to carefully educate and develop a fun way. We strive
                    to turn the learning process.</p>
                <div class="row justify-content-center justify-content-lg-start text-start">
                    <div class="col-auto">
                        <div class="list-style1">
                            <ul class="list-unstyled">
                                <li>Comprehensive reporting on individual achievement</li>
                                <li>Educational field trips and school presentations</li>
                                <li>Individual attention in a small-class setting</li>
                                <li>Learning program with after-school care</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="space-extra-bottom">
    <div class="container">
        <div class="row gx-70">
            <div class="col-lg-6 text-center text-lg-end">
                <div class="img-box2 style2">
                    <div class="transform-banner"><img src="/assets/frontend/img/about/ab-5-1.jpg" alt="about"></div>
                    <div class="vs-circle jump"></div>
                </div>
            </div>
            <div class="col-lg-6 align-self-center text-center text-lg-start">
                <h2 class="sec-title pe-xxl-4 mb-3">For every student, every classroom Real results.</h2>
                <p class="sec-text mb-4 pb-2 col-xxl-10">We are constantly expanding the range of services offered,
                    taking children of all ages. Our goal is to carefully educate and develop a fun way. We strive
                    to turn the learning process.</p>
                <div class="row justify-content-center justify-content-lg-start text-start">
                    <div class="col-auto">
                        <div class="list-style1">
                            <ul class="list-unstyled">
                                <li>Comprehensive reporting on individual achievement</li>
                                <li>Educational field trips and school presentations</li>
                                <li>Individual attention in a small-class setting</li>
                                <li>Learning program with after-school care</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="space testimonial-section">
<div class="container">
    <div class="title-area">
        <h2 class="sec-title">Customer Reviews</h2>
        <img src="/assets/frontend/img/headline.png" alt="" class="img-fluid ">
        <p class="sec-text">Discover what our valued customers have to say about their experiences with our
            educational resources.</p>
    </div>
    <div class="row">
        <?php for($i=1;$i<=12;$i++) {?>
        <div class="col-lg-4 col-md-6 col-12">
            <div class="testimonial-style">
                <div class="testi-body">
                    <div class="testi-icon">
                        <i class="fas fa-quote-left"></i>
                    </div>
                    <div class="media-body">
                        <h3 class="testi-name">Mari Jain</h3>
                        <div class="testi-rating">
                            <span>Web developer</span>
                        </div>
                    </div>
                </div>
                <p class="testi-text">From its medieval origins to the digital era, learn everything there is to
                    know about the ubiquitous lorem ipsum passage sometimes known, is dummy.</p>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
</section>
@endsection