@extends('frontend.master')
@section('previous', 'Home')
@section('current', isset($product->product_name) ? $product->product_name : '')
@section('content')
@include('breadcrumbs')
{{$total = count($totalReviews) > 0 ? count($totalReviews) : 1}}
@php 
   $star5 = 0;
   $star4 = 0;
   $star3 = 0;
   $star2 = 0;
   $star1 = 0;
@endphp
@foreach ($totalReviews as $review)
<?php 
if($review->rating == 5){
   $star5 += 1;
}
if($review->rating == 4){
   $star4 += 1;
}
if($review->rating == 3){
   $star3 += 1;
}
if($review->rating == 2){
   $star2 += 1;
}
if($review->rating == 1){
   $star1 += 1;
}
?>
@endforeach
<section class="vs-product-wrapper product-details space-top space-extra-bottom">
   <div class="container">
      <div class="row gx-60">
         <div class="col-lg-6">
            <div class="product-big-img vs-carousel" data-slide-show="1" data-fade="true"
               data-asnavfor=".product-thumb-slide">
               <div class="img"><img
                     src="/uploads/product_images/product_feature_image/{{$product->product_fetaure_img}}"
                     alt="Product Image"></div>
               @if ($product->product_media != "")
               @foreach(explode(',', substr($product->product_media, 1, -1)) as $info)
               <div class="img"><img src="/uploads/product_images/media/{{trim($info, '"')}}" alt="Product Image"></div>
               @endforeach
               @endif
            </div>
            <div class="product-thumb-slide row vs-carousel" data-slide-show="4" data-md-slide-show="4"
               data-sm-slide-show="3" data-xs-slide-show="3" data-asnavfor=".product-big-img">
               <div class="col-3">
                  <div class="thumb"><img
                        src="/uploads/product_images/product_feature_image/{{$product->product_fetaure_img}}"
                        alt="Product Image"></div>
               </div>
               @if ($product->product_media != "")
               @foreach(explode(',', substr($product->product_media, 1, -1)) as $info)
               <div class="col-3">
                  <div class="thumb"><img src="/uploads/product_images/media/{{trim($info, '"')}}" alt="Product Image">
                  </div>
               </div>
               @endforeach
               @endif
            </div>
         </div>
         <div class="col-lg-6 align-self-center">
            <div class="product-about">
               <h2 class="product-title">{{$product->product_name}}</h2>
               <div class="product-rating">
                  <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5"><span style="width:100%">Rated
                        <strong class="rating">5.00</strong> out of 5 based on
                        <span class="rating">5</span> customer rating</span>
                  </div>
                  (13)
               </div>
               <p class="product-price">₹{{$product->discount_price}} <del>₹{{$product->price}}</del></p>
               <div class="product_meta">
                  <span class="posted_in">
                     <a rel="tag"> @isset($product->product_seo->meta_keywords) {{$product->product_seo->meta_keywords}}  @endisset</a>
                  </span>
               </div>
               <div class="actions">
                  {{-- <a href="cart.php" class="vs-btn"></a>  --}}
                  <button type="button" data-id="{{$product->id}}" class="vs-btn wishlist">
                     <i class="far fa-heart"></i> Wishlist
                  </button>
                  <button type="button" data-id="{{$product->id}}" class="vs-btn addCart">
                     <i class="far fa-shopping-cart"></i> Add to Cart
                  </button>
               </div>
               <div class="product-getway">
                  <span class="getway-title">GUARANTEED SAFE CHECKOUT:</span>
                  <img src="/assets/frontend/img/widget/cards-2.png" alt="cards">
               </div>

               {{-- <div class="product-special-note">
                  <div class="d-flex justify-content-between flex-wrap ">
                     <span class="special-note-title">Our Back-to-School Special!</span>
                     <span class="special-note-description"><i class="fal fa-clock"></i> 00.12.24.56</span>
                  </div>

                  <p class="special-note-description">Enjoy significant savings on top-quality resources.</p>

               </div> --}}

            </div>
         </div>
      </div>

      <div class="product-description">

         <div class="product-details-tabs">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
               <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="pdescription-tab" data-bs-toggle="tab"
                     data-bs-target="#pdescription" type="button" role="tab" aria-controls="pdescription"
                     aria-selected="true">Product Descriptions</button>
               </li>
               <li class="nav-item" role="presentation">
                  <button class="nav-link" id="ratings-tab" data-bs-toggle="tab" data-bs-target="#ratings" type="button"
                     role="tab" aria-controls="ratings" aria-selected="false">Reviews & Ratings</button>
               </li>
               <li class="nav-item" role="presentation">
                  <button class="nav-link" id="pfiles-tab" data-bs-toggle="tab" data-bs-target="#pfiles" type="button"
                     role="tab" aria-controls="pfiles" aria-selected="false">Printable Files</button>
               </li>
            </ul>
            <div class="tab-content" id="myTabContent">
               <div class="tab-pane fade show active" id="pdescription" role="tabpanel"
                  aria-labelledby="pdescription-tab">
                  <div class="description">
                     {!!$product->description !!}
                  </div>
               </div>
               <div class="tab-pane fade" id="ratings" role="tabpanel" aria-labelledby="ratings-tab">
                  <div class="row">
                     <div class="col-lg-6 col-md-6 col-12">
                        <div class="products-reviews">
                           <h5>Customer Ratings</h5>
                           <div class="title-divider1"></div>
                           <div class="rating">
                              <h3 class="mb-0">
                                 {{ round(( (5*$star5)+(4*$star4)+(3*$star3)+(2*$star2)+(1*$star1) ) / $total ,1) }}
                              </h3>
                              <div>
                                 <div>
                                    <span class="fas fa-star checked"></span>
                                    <span class="fas fa-star checked"></span>
                                    <span class="fas fa-star checked"></span>
                                    <span class="fas fa-star checked"></span>
                                    <span class="fas fa-star"></span>
                                 </div>
                                 <p class="mb-0">{{count($totalReviews)}} Review</p>
                              </div>
                           </div>
                           <div class="rating-count">
                              <span>Total review count and overall rating based on Visitor and Tripadvisior
                                 reviews</span>
                           </div>
                              <div class="rating-row">
                                 <div class="side">
                                    <div>5 <span class="fas fa-star"></span></div>
                                 </div>
                                 <div class="middle">
                                    <div class="bar-container">
                                       <div class="bar-5" style="width:{{$star5/$total*100}}%"></div>
                                    </div>
                                 </div>
                                 <div class="side right">
                                    <div>
                                      {{$star5}}
                                    </div>
                                 </div>
                              </div>
                              <div class="rating-row">
                                 <div class="side">
                                    <div>4 <span class="fas fa-star"></span></div>
                                 </div>
                                 <div class="middle">
                                    <div class="bar-container">
                                       <div class="bar-4" style="width:{{$star4/$total*100}}%"></div>
                                    </div>
                                 </div>
                                 <div class="side right">
                                    <div>
                                       {{$star4}}
                                    </div>
                                 </div>
                              </div>
                              <div class="rating-row">
                                 <div class="side">
                                    <div>3 <span class="fas fa-star" ></span></div>
                                 </div>
                                 <div class="middle">
                                    <div class="bar-container">
                                       <div class="bar-3" style="width:{{$star3/$total*100}}%"></div>
                                    </div>
                                 </div>
                                 <div class="side right">
                                    <div>
                                       {{$star3}}
                                    </div>
                                 </div>
                              </div>
                              <div class="rating-row">
                                 <div class="side">
                                    <div>2 <span class="fas fa-star" ></span></div>
                                 </div>
                                 <div class="middle">
                                    <div class="bar-container">
                                       <div class="bar-2" style="width:{{$star2/$total*100}}%"></div>
                                    </div>
                                 </div>
                                 <div class="side right">
                                    <div>
                                       {{$star2}}
                                    </div>
                                 </div>
                              </div>
                              <div class="rating-row">
                                 <div class="side">
                                    <div>1 <span class="fas fa-star" ></span></div>
                                 </div>
                                 <div class="middle">
                                    <div class="bar-container">
                                       <div class="bar-1" style="width:{{$star1/$total*100}}%"></div>
                                    </div>
                                 </div>
                                 <div class="side right">
                                    <div>
                                       {{$star1}}
                                    </div>
                                 </div>
                              </div>
                         

                        </div>
                     </div>
                     <div class="col-lg-6 col-md-6 col-12">
                        <h5>Reviews</h5>
                        <div class="title-divider1"></div>
                        <div class="woocommerce-Reviews">
                           <div class="vs-comments-wrap">
                              <ul class="comment-list">
                                 @foreach ($reviews as $review)
                                    <li class="review vs-comment-item">
                                       <div class="vs-post-comment">
                                          <div class="comment-content">
                                             <p class="text">{{$review->description}}</p>
                                             <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                   <div class="comment-avater"><img
                                                         src="/uploads/user/{{$review->review_user->image}}"
                                                         alt="Comment Author"></div>
                                                   <div>
                                                      <h4 class="name h4">{{ucfirst($review->review_user->name)}}</h4>
                                                      <span class="commented-on"><i class="fal fa-calendar-alt"></i>{{date("d M, Y",strtotime($review->created_at))}}</span>
                                                   </div>
                                                </div>
                                                <div class="review-rating">
                                                   @for ($i = 0; $i < $review->rating; $i++)
                                                   <i class="fas fa-star"  style="color:rgb(255 165 0)"></i>
                                                   @endfor
                                                   @for ($i = 5; $i > $review->rating; $i--)
                                                   <i class="fas fa-star"></i>
                                                   @endfor
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </li>
                                 @endforeach
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="tab-pane fade" id="pfiles" role="tabpanel" aria-labelledby="pfiles-tab">
                  <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas, alias esse. Asperiores
                     reiciendis culpa nobis vitae repudiandae minus maxime! Amet eius, iusto minima et aspernatur ad
                     quae illo blanditiis perspiciatis. </p>

                  @if ($product->product_demo_files != "")
                  @foreach(explode(',', substr($product->product_demo_files, 1, -1)) as $info)
                  <div class="product-files">
                     <div class="row align-items-center g-3">
                        <div class="col-lg-8 col-md-8 col-12">
                           <div class="d-flex align-items-center">
                              <img src="/uploads/product_images/samples/{{trim($info, '"')}}" alt="" class="flex-shrink-0"
                                 class="flex-shrink-0">
                              <p class="mb-0">{{trim($info, '"')}}</p>
                           </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-12">
                           <div class="d-flex align-items-center">
                              <a href="/uploads/product_images/samples/{{trim($info, '"')}}" target="_blank" class="btn btn-outline-dark  me-3">View Demo</a>
                              <span>
                                 @php
                                 $img = trim($info, '"');
                                 $path = "/uploads/product_images/samples/$img";
                                 $size =   File::size(public_path($path));
                                                                 
                                 @endphp
                                 {{round(($size ? $size : 0) / 1000),2}} KB
                              </span>
                           </div>
                        </div>
                     </div>
                  </div>
                  @endforeach
                  @endif
               </div>
            </div>
         </div>

         <h2>Similar Products</h2>
         <div class="title-divider1"></div>
         <div class="row vs-carousel" data-slide-show="4" data-lg-slide-show="3" data-md-slide-show="2">
            @if (count($similarProduct) > 0)
               @foreach ($similarProduct as $product)
               <div class="col-md-6 col-lg-4 col-xl-3">
                  <div class="vs-product product-style1">
                     <div class="product-img">
                        <a href="/worksheet-details/{{$product->id}}">
                           <img src="/uploads/product_images/product_feature_image/{{$product->product_fetaure_img}}"
                              alt="Image" class="w-100">
                        </a>
                     </div>
                     <div class="product-content">
                        <span class="product-price">₹{{$product->discount_price}} <del>₹{{$product->price}}</del>
                        </span>
                        <h3 class="product-title">
                           <a class="text-inherit"
                              href="/worksheet-details/{{$product->id}}">{{$product->product_name}}</a>
                        </h3>
                        <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">
                           <span style="width:100%">Rated <strong class="rating">5.00</strong> out of 5 </span>
                        </div>
                        <div class="actions">
                           <a href="/worksheet-details/{{$product->id}}" class="icon-btn">Learn More </a>
                           <button type="button" data-id="{{$product->id}}" class="vs-btn addCart">
                              <i class="far fa-shopping-cart"></i>
                           </button>
                        </div>
                     </div>
                  </div>
               </div>
               @endforeach
            @else
            <div class="col-md-12 col-lg-12 col-xl-12 w-100">
               <div class="text-center">
                   <img src="/assets/frontend/img/no-record.jpg" class="img-fluid" style="width:320px;" alt="">
                   <h5 class="text-danger mb-0">No Similar Product Found</h5>
               </div>
            </div>
            @endif
            
         </div>
      </div>
</section>
@push('scripts')
<script>
   $(document).ready(function() {
      $(document).on('click', '.addCart', function(e) {
         e.preventDefault();
         $productId = $(this).data('id');
         //  console.log($productId);
         $.ajax({
            url: '{{ url("/add-cart")}}',
            type: 'post',
            data: {
               _token: '{{csrf_token()}}',
               id: $productId
            },
            dataType: 'json',
            success: function(respond) {
               if (respond.status == 1) {

                  iziToast.success({
                            title: 'Success!!',
                            message: respond.message
                  });

                  $.ajax({
                     url: '{{ url("/view-cart")}}',
                     type: 'post',
                     data: {
                        _token: '{{csrf_token()}}'
                     },
                     dataType: 'json',
                     success: function(respond) {
                        if (respond.status == 1) {
                           $('#cart_items').html(respond.cart_items);
                        } else {
                           $('#cart_items').html(0);
                        }
                     }
                  });
               } else {
                  //  console.log(respond.message);
               }
            }
         });
      });
   });
   $(document).ready(function() {
      $.ajax({
         url: '{{ url("/view-cart")}}',
         type: 'post',
         data: {
            _token: '{{csrf_token()}}'
         },
         dataType: 'json',
         success: function(respond) {
            if (respond.status == 1) {
               $('#cart_items').html(respond.cart_items);
            } else {
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