@extends('frontend.master')
@section('previous', 'Home')
@section('current', 'Wishlist')
@section('content')
@include('breadcrumbs')
<section class="space order-history">
    <div class="container">
        @if (count($wishlist) > 0)
            <div class="wishlist-table table-responsive">
                <table class="table ">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th scope="col">Product</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Cart</th>
                            <th scope="col">Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($wishlist as $item)
                        <tr>
                            <td>{{++$loop->index}}</td>
                            <td class="product-thumbnail">
                                <a href="/worksheet-details/{{$item->product->id}}">
                                    <img src="/uploads/product_images/product_feature_image/{{$item->product->product_fetaure_img}}"
                                        alt="item">
                                </a>
                            </td>
                            <td class="product-name">
                                <a href="/worksheet-details/{{$item->product->id}}">{{$item->product->product_name}}</a>
                            </td>
                            <td class="product-price">
                                <span class="unit-amount">{{$item->product->discount_price}}</span>
                            </td>

                            <td>
                                <a class="btn vs-btn addCart" data-id="{{$item->product->id}}">Add To Cart</a>
                            </td>
                            <td class="remove">
                                <a href="/remove-wishlist/{{$item->id}}"><i class="far fa-times-circle"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="no-items">
                <div class="text-center">
                    <img src="{{asset('assets/frontend/img/empty-box.png')}}" alt="" class="img-fluid">
                    <h4 class="mt-3">Your Wishlist Is Empty</h4>
                    <p>Wishlist is empty. Please go to your home page for listing it.</p>
                </div>
            </div>
        @endif
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
@endpush
@endsection