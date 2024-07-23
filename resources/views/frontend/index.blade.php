@extends('frontend.master')
@section('content')
@include('messages')
<section class="hero-wrapper ">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-7 col-lg-6 col-12">
                <div class="banner-content">
                    <div class="title-area">
                        <h2 class="sec-title">We Are Here To Guide And Direct Your Child</h2>
                        <p class="sec-text ">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Libero quo
                            aliquam magnam eum a cum sunt sint voluptatum rem, similique sequi eius reprehenderit
                            aperiam ea itaque ex suscipit placeat. Et?</p>
                    </div>
                    <form action="/serach-worksheet" method="POST" class="form-style layout search-form">
                        @csrf
                        <div class="row g-1">
                            <div class="col-md-6 form-group">
                                <input name="worksheet" id="worksheet" type="text" class="form-control"
                                    placeholder="Search for Worksheet ...">
                            </div>
                            <div class="col-md-4 form-group">
                                <select name="category" id="" class="form-control" required>
                                    <option value="" selected disabled>Choose category</option>
                                    @if ($category != null)
                                        @foreach ($category as $cat)
                                        <option value="{{$cat->id}}">{{$cat->cat_name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-2 form-group">
                                <button class="btn search-btn" type="submit">
                                    <i class="far fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-xl-5 col-lg-6 col-12">
                <div class="banner-img">
                    <img src="{{asset('assets/frontend/img/hero.png')}}" alt="" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
    <div class="cloud-box">
        <img src="{{asset('assets/frontend/img/cloud.svg')}}" alt="" class="img-fluid">
    </div>
</section>
<section class="space grade-category">
    <div class="container">
        <div class="title-area">
            <h2 class="sec-title">Discover By Grade</h2>
           <img src="{{asset('assets/frontend/img/headline.png')}}" alt="" class="img-fluid ">
            <p class="sec-text">Explore Our Educational Wonderland: Learning with ease by discovering our collection of
                kids' worksheets, meticulously organized by class levels and subjects.</p>
        </div>
        <div class="row">
            @if ($category != null)
            <?php $i = 1 ?>
                @foreach ($category as $cat)
                <div class="col-lg-3 col-md-3 col-12">
                    <div class="single-grade-category">
                        <img src="{{asset('assets/frontend/img/layer'.$i++.'.png')}}" alt="" class="img-fluid">
                        <div class="layer-content">
                            <h5 class="layer-title">{{$cat->cat_name}}</h5>
                            <p class="layer-text">({{$cat->worksheet_count}} Worksheet)</p>
                            <a  href="/worksheet/{{$cat->id}}"  class="layer-link">
                                <i class="fal fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php if($i > 7){
                    $i =1;
                } ?>
                @endforeach
            @endif
        </div>
    </div>
</section>
<section class="space service-section">
    <div class="container">
        <div class="title-area ">
            <h2 class="sec-title">How it works</h2>
            <img src="{{asset('assets/frontend/img/headline.png')}}" alt="" class="img-fluid ">
            <p class="sec-text">With 30,000+ digital and printable resources. kids can learn about any topic they're
                curious about.</p>
        </div>
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-3 col-12">
                <div class="service-style step1 ">
                    <img src="{{asset('assets/frontend/img/group1.svg')}}" alt="" class="service-image img-fluid">
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-12">
                <div class="service-style step2">
                    <img src="{{asset('assets/frontend/img/group2.svg')}}" alt="" class="service-image img-fluid">
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-12">
                <div class="service-style step3 ">
                    <img src="{{asset('assets/frontend/img/group3.svg')}}" alt="" class="service-image img-fluid">
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-12">
                <div class="service-style step4 ">
                    <img src="{{asset('assets/frontend/img/group4.svg')}}" alt="" class="service-image img-fluid">
                </div>
            </div>
        </div>
    </div>
</section>
<section class="space">
    <div class="container">
        <div class="title-area ">
            <h2 class="sec-title">Featured Products</h2>
            <img src="{{asset('assets/frontend/img/headline.png')}}" alt="" class="img-fluid ">
            <p class="sec-text">Discover our carefully curated selection of featured educational resources designed for
                children from kindergarten to class 4.</p>
        </div>
        <div class="row justify-content-center">
            @if ($featuredProduct != null)
                @foreach ($featuredProduct as $product)
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="vs-product product-style1">
                            <div class="product-img">
                                <a href="/worksheet-details/{{$product->id}}">
                                    <img src="/uploads/product_images/product_feature_image/{{$product->product_fetaure_img}}" alt="Image" class="w-100">
                                </a>
                            </div>
                            <div class="product-content">
                                <span class="product-price">₹{{$product->discount_price}} <del>₹{{$product->price}}</del>
                                </span>
                                <h3 class="product-title">
                                    <a class="text-inherit" href="/worksheet-details/{{$product->id}}">{{$product->product_name}}</a>
                                </h3>
                                <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">
                                    <span style="width:100%">Rated <strong class="rating">5.00</strong> out of 5 </span>
                                </div>
                                <div class="actions">
                                    <a href="/worksheet-details/{{$product->id}}" class="icon-btn">Learn More </a>
                                    <button type="button" data-id="{{$product->id}}" class="vs-btn wishlist">
                                        <i class="far fa-heart"></i>
                                    </button>
                                    <button type="button" data-id="{{$product->id}}" class="vs-btn addCart">
                                        <i class="far fa-shopping-cart"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
<section class="space testimonial-section">
    <div class="container">
        <div class="title-area">
            <h2 class="sec-title">Customer Reviews</h2>
            <img src="{{asset('assets/frontend/img/headline.png')}}" alt="" class="img-fluid ">
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

@push('scripts')
<script>
    $(document).ready(function(){
        $(document).on('click', '.addCart', function(e){
            e.preventDefault();
            $productId = $(this).data('id'); 
            // console.log($productId);
            $.ajax({
                url:'{{ url("/add-cart")}}',
                type:'post',
                data: { _token: '{{csrf_token()}}', id: $productId},
                dataType:'json',
                success:function(respond){
                    if(respond.status == 1){

                        iziToast.success({
                            title: 'Success!!',
                            message: respond.message
                        });
                        $.ajax({
                            url:'{{ url("/view-cart")}}',
                            type:'post',
                            data: { _token: '{{csrf_token()}}'},
                            dataType:'json',
                            success:function(respond){
                                if(respond.status == 1){
                                    $('#cart_items').html(respond.cart_items);
                                }else{
                                    $('#cart_items').html(0);
                                }
                            }
                        });
                    }else{
                        // console.log(respond.message);
                    }
                }
            });

        });
    });

    $(document).ready(function(){
        $.ajax({
            url:'{{ url("/view-cart")}}',
            type:'post',
            data: { _token: '{{csrf_token()}}'},
            dataType:'json',
            success:function(respond){
                if(respond.status == 1){
                    $('#cart_items').html(respond.cart_items);
                }else{
                    $('#cart_items').html(0);
                }
            }
        });
    });
</script>
<script>
    $(document).ready(function(){
        $(document).on('click','.wishlist',function(){
            $id = $(this).data('id');
            if($id == ""){
                iziToast.error({
                    title: 'Error!!',
                    message: "Please Select Any Product",
                });
            }else{
                console.log($id);
                $.ajax({
                    url:'/add-wishlist',
                    method:'Post',
                    data: { _token: '{{csrf_token()}}', pid:$id},
                    dataType:'json',
                    success:function(respond){
                        if(respond.status == 1){
                            iziToast.success({
                                title: 'Success!!',
                                message: respond.message,
                            });
                            console.log(respond);
                            $.ajax({
                                url:'{{ url("/view-wishlist")}}',
                                type:'post',
                                data: { _token: '{{csrf_token()}}'},
                                dataType:'json',
                                success:function(respond){
                                    if(respond.status == 1){
                                        $('#wishlist_items').html(respond.wishlist_items);
                                    }else{
                                        $('#wishlist_items').html(0);
                                    }
                                }
                            });
                        }else if(respond.status == 2){
                             iziToast.warning({
                                title: 'Warning!!',
                                message: respond.message,
                            });
                            console.log(respond);
                        }else{
                            iziToast.error({
                                title: 'Error!!',
                                message: respond.message,
                            });
                            setTimeout(() => {
                                window.location.href = '{{url('/login')}}';                                
                            }, 1000);
                        }
                    }
                });
            }
        })
    })
</script>
@endpush
@endsection