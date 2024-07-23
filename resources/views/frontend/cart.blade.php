@extends('frontend.master')
@section('previous', 'Home')
@section('current', 'Cart')
@section('content')
@include('breadcrumbs')
<section class="vs-cart-wrapper space">
    <div class="container">
        @if (isset($products))

        
        @if (count($products) > 0)
            <form action="#" class="woocommerce-cart-form">
                <table class="cart_table">
                    <thead>
                        <tr>
                            <th class="cart-col-image">Image</th>
                            <th class="cart-col-productname">Product Name</th>
                            <th class="cart-col-price">Price</th>

                            <th class="cart-col-total">Total</th>
                            <th class="cart-col-remove">Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total =0; ?>
                        @foreach ($products as $product)
                            <tr class="cart_item">
                                <td data-title="Product"><a class="cart-productimage" href="/worksheet-details/{{$product->id}}"><img
                        width="91" height="91" src="/uploads/product_images/product_feature_image/{{$product->product_fetaure_img}}" alt="product"></a>
                                </td>
                                <td data-title="Name"><a class="cart-productname" href="/worksheet-details/{{$product->id}}">{{$product->product_name}}</a></td>
                                <td data-title="Price"><span class="amount"><bdi><span>₹</span>{{$product->discount_price}}</bdi></span></td>

                                <td data-title="Total"><span class="amount"><bdi><span>₹</span>{{$total += $product->discount_price}}</bdi></span></td>
                                <td data-title="Remove"><a href="/remove-product/{{$product->id}}" class="remove"><i class="fal fa-trash-alt"></i></a></td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="12" class="actions ">
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="/worksheet" class="vs-btn" style="background:#03b98c;">Continue Shopping</a>
                                    @if (count($products) > 0)
                                    <div class="wc-proceed-to-checkout "><a href="/checkout" class="vs-btn">Proceed to
                                        checkout</a></div>                                        
                                    @endif
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        @else
        <div class="no-items">
            <div class="text-center">
                <img src="{{asset('assets/frontend/img/empty-box.png')}}" alt="" class="img-fluid">
                <h4 class="mt-3">Your Cart List Is Empty</h4>
                <p>Cart is empty. Please go to your home page for listing it.</p>
            </div>
        </div>
        @endif
        @else
        <div class="no-items">
            <div class="text-center">
                <img src="{{asset('assets/frontend/img/empty-box.png')}}" alt="" class="img-fluid">
                <h4 class="mt-3">Your Cart List Is Empty</h4>
                <p>Cart is empty. Please go to your home page for listing it.</p>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection