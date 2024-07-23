@extends('frontend.master')
@section('previous', 'Home')
@section('current', isset($product->product_name) ? $product->product_name : '')
@section('content')
@include('breadcrumbs')
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
               @php 
                    $materialCost = 0;
                    $updatedPrices = json_decode($tempPrice->temp_price,true);
                @endphp
                @if (isset($product->materials))
                    @foreach ($product->materials as $material)
                        @php
                            $quantity = $material->pivot->quantity_used;
                            $perGramRate = $updatedPrices[$material->id] * $quantity;
                            $materialCost += $perGramRate;
                        @endphp
                        <span class="vs-btn px-3 py-1 mx-1 mb-1 small text-left" style="font-size: 12px;">{{$material->purity_grade}} {{$material->material_name}} : {{$quantity}}  {{$material->unit_of_measurement}}</span>
                    @endforeach
                @endif
                @php
                    $price = (float)$product->price + (float)$product->discount_price;
                @endphp
               <p class="product-price">₹{{number_format($price+$materialCost,2)}}</del></p>
               {{-- <div class="product_meta">
                  <span class="posted_in">
                     <a rel="tag"> @isset($product->product_seo->meta_keywords) {{$product->product_seo->meta_keywords}}  @endisset</a>
                  </span>
               </div> --}}
               <div class="actions">
                  <button type="button" data-id="{{$product->id}}" class="vs-btn wishlist" disabled>
                     <i class="far fa-heart"></i> Wishlist
                  </button>
                  <button type="button" data-id="{{$product->id}}" class="vs-btn addCart" disabled>
                     <i class="far fa-shopping-cart"></i> Add to Cart
                  </button>
               </div>
               <div class="product-getway">
                  <span class="getway-title">GUARANTEED SAFE CHECKOUT:</span>
                  <img src="/assets/frontend/img/widget/cards-2.png" alt="cards">
               </div>
            </div>
         </div>
      </div>
</section>
@endsection