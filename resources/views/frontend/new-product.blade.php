@extends('frontend.master')
@section('previous', 'Home')
@section('current', 'Worksheets')
@section('content')
@include('breadcrumbs')

<section class="vs-product-wrapper space-top space-extra-bottom">
    <div class="container">
        <div class="row">
            {{-- <div class="col-xl-3 col-lg-4">
                <div class="filters  mb-3">
                    <div class="filters-header">
                        <h5 class="mb-0 text-dark">Filter By</h5>
                        <a href="/worksheet" class="filters-close btn btn-danger btn-sm">Reset</a>
                    </div>
                    <div class="filters-body">
                        <div class="input-group p-3 pb-0  mb-0">
                            <input type="text" class="form-control" id="seachProduct" placeholder="Search Worksheet">
                            <button class="btn btn-outline-secondary" id="search" type="button" id="button-addon2"><i
                                    class="far fa-search"></i></button>
                        </div>
                        <div class="filters-blocks">
                            <h6>Category</h6>
                            <div class="filterlist">
                                @isset($category)
                                    @foreach ($category as $cat)
                                        <div class="form-check">
                                            <input class="form-check-input category_filter" type="checkbox" value="{{$cat->id}}"
                                                id="categorycheck{{$cat->id}}" />
                                            <label class="form-check-label" for="categorycheck{{$cat->id}}">
                                                {{$cat->cat_name }}
                                            </label>
                                        </div>
                                    @endforeach
                               @endisset
                            </div>
                        </div>
                        <div class="filters-blocks">
                            <h6>Price</h6>
                            <div class="filterlist">
                                <div class="form-check">
                                    <input class="form-check-input pricecheck" type="checkbox" value="10-20" id="pricecheck1" data-id="20" />
                                    <label class="form-check-label" for="pricecheck1">
                                        ₹10 - ₹20
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input pricecheck" type="checkbox" value="20-30" id="pricecheck2" data-id="30" />
                                    <label class="form-check-label" for="pricecheck2">
                                        ₹20 - ₹30
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input pricecheck" type="checkbox" value="30-50" id="pricecheck3" data-id="50" />
                                    <label class="form-check-label" for="pricecheck3">
                                        ₹30 - ₹50
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input pricecheck" type="checkbox" value="50-100" id="pricecheck4" data-id="100" />
                                    <label class="form-check-label" for="pricecheck4">
                                        ₹50 - ₹100
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input pricecheck" type="checkbox" value="100-100" id="pricecheck5" data-id="100" />
                                    <label class="form-check-label" for="pricecheck5">
                                        ₹100 - Above
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="col-lg-12 col-md-12">
                {{-- <div class="row align-items-center justify-content-between mb-3">
                    <div class="col-lg-auto">
                        @isset($totalWorksheet)
                        <p>Showing <b>{{count($products)}}</b> of result from total <b>{{$totalWorksheet}}</b></p>
                        @endisset
                    </div>
                    <div class="col-lg-auto">
                       <div class="d-flex align-items-center mb-3">
                            <label for="" class="form-label text-nowrap me-3 mb-0">Sort By</label>
                            <select class="form-select" style="min-width: 200px;" id="sorted">
                                <option value="0">Latest Worksheet</option>
                                <option value="1">Low to High</option>
                                <option value="2">High to Low</option>
                                <option value="3">Name</option>
                            </select>
                        </div>
                    </div>                  
                </div> --}}
                <div class="d-flex justify-content-between w-100 mb-3">
                    <h1>Products</h1>
                    <button type="button" data-title="Product Listing" data-url="{{url()->full()}}" class="btn-sm copyScriptBtn vs-btn2">
                        <i class="far fa-share me-1"></i> Share
                    </button>
                </div>
                <div class="row justify-content-center" id="worksheet">
                    @if (count($products) > 0)
                        @foreach ($products as $product)

                        {{-- DETAIL PAGE --}}
                        @php
                            $inputObj = new stdClass();
                            $inputObj->params = 'id='.$tempPrice->id."&product_id=".$product->id;
                            $inputObj->url = url('product-details');
                            $encLink = Common::encryptLink($inputObj);
                        @endphp


                        <div class="col-md-4 col-lg-3 col-xl-3">
                            <div class="vs-product product-style1">
                                <div class="product-img">
                                    <a href="{{$encLink}}">
                                        <img src="/uploads/product_images/product_feature_image/{{$product->product_fetaure_img}}"
                                            alt="Image" class="w-100">
                                    </a>
                                </div>
                                <div class="product-content">
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
                                    <span class="product-price mt-2">₹{{number_format($price+$materialCost,2)}}</span>
                                    <h3 class="product-title">
                                        <a class="text-inherit" href="{{$encLink}}">{{$product->product_name}}</a>
                                    </h3>
                                    <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">
                                        <span style="width:100%">Rated <strong class="rating">5.00</strong> out of 5 </span>
                                    </div>
                                    <div class="actions">
                                        <a href="{{$encLink}}" class="icon-btn">Learn More </a>
                                        {{-- <button type="button" data-id="{{$product->id}}" class="vs-btn wishlist">
                                            <i class="far fa-heart"></i>
                                        </button> --}}
                                        <div class="d-none" class="scriptCode">{{$encLink}}</div>
                                        <button type="button" data-title="{{$product->product_name}}" data-url="{{$encLink}}" class="copyScriptBtn vs-btn">
                                            <i class="far fa-share"></i>
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
                                <h5 class="text-danger mb-0">No Product Found</h5>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="vs-pagination">
                    {{-- {{$products->appends(request()->input())->links('frontend.frontendpagination')}} --}}
                </div>
            </div>
        </div>
    </div>
</section>
@push('scripts')
<script>
    $(document).ready(function(){
        $(document).on('click', '.addCart', function(e){
            e.preventDefault();
            $productId = $(this).data('id'); 
            console.log($productId);
            $.ajax({
                url:'{{ url("/add-cart")}}',
                type:'post',
                data: { _token: '{{csrf_token()}}', id: $productId},
                dataType:'json',
                success:function(respond){
                    if(respond.status == 1){
                        iziToast.success({
                            title: 'Success',
                            message: respond.message,
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
    var cat_id = [];
    var priceFilter = [];
    $(document).ready(function(){
        function filterWorksheet(){

            // For Category
            $('.category_filter').each(function() {
                $id = $(this).val(); 
                if ($(this).prop('checked')==true){ 
                    if($.inArray($id, cat_id) === -1 ) {
                        cat_id.push($id);
                    }
                }else{
                    if($.inArray($id, cat_id) !== -1 ) {
                        cat_id.splice($.inArray($id, cat_id), 1);
                    }
                }
            });

            // For Pricing
            $('.pricecheck').each(function() {
                $id = $(this).val(); 
                if ($(this).prop('checked')==true){ 
                    if($.inArray($id, priceFilter) === -1 ) {
                        priceFilter.push($id);
                    }
                }else{
                    if($.inArray($id, priceFilter) !== -1 ) {
                        priceFilter.splice($.inArray($id, priceFilter), 1);
                    }
                }
            });

            // For Search
            $search = $('#seachProduct').val();

            // For Sorting
            $sort_id = $('#sorted').val();

            // Ajax Request For Filter
            $.ajax({
                url:'{{ url("/filter-worksheet")}}',
                type:'post',
                data: {
                    _token: '{{csrf_token()}}',
                    category: JSON.stringify(cat_id),
                    price: JSON.stringify(priceFilter),
                    search: $search,
                    sorted: $sort_id
                },
                success:function(respond){
                    if(respond.status == 1){
                        // console.log(respond.products);
                        $htmlView = "";
                        if(respond['products'].length > 0){
                            for(let i = 0; i < respond['products'].length; i++){
                                $htmlView += `<div class="col-md-6 col-lg-4 col-xl-4">
                                    <div class="vs-product product-style1">
                                        <div class="product-img">
                                            <a href="/worksheet-details/${respond['products'][i].id}">
                                                <img src="/uploads/product_images/product_feature_image/${respond['products'][i].product_fetaure_img}"
                                                    alt="Image" class="w-100">
                                            </a>
                                        </div>
                                        <div class="product-content">
                                            <span class="product-price">₹${respond['products'][i].discount_price} <del>₹${respond['products'][i].price}</del>
                                            </span>
                                            <h3 class="product-title">
                                                <a class="text-inherit" href="/worksheet-details/${respond['products'][i].id}">${respond['products'][i].product_name}</a>
                                            </h3>
                                            <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">
                                                <span style="width:100%">Rated <strong class="rating">5.00</strong> out of 5 </span>
                                            </div>
                                            <div class="actions">
                                                <a href="/worksheet-details/${respond['products'][i].id}" class="icon-btn">Learn More </a>
                                                <button type="button" data-id="${respond['products'][i].id}" class="vs-btn addCart">
                                                    <i class="far fa-shopping-cart"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                               </div>`;
                            }
                            $("#worksheet").html($htmlView);   
                        }else{
                            $("#worksheet").html(`<div class="col-md-12 col-lg-12 col-xl-12 w-100">
                            <div class="text-center">
                                <img src="/assets/frontend/img/no-record.jpg" class="img-fluid" style="width:320px;" alt="">
                                <h5 class="text-danger mb-0">No Product Found</h5>
                            </div>
                        </div>`);
                        }
                    }else{
                        console.log(respond.respond);
                    }
                }
            });
            
        }

    $("#search").click(filterWorksheet);
    $(".category_filter").click(filterWorksheet);
    $(".pricecheck").click(filterWorksheet);
    $("#sorted").change(filterWorksheet);


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
<script>
    // document.getElementById('copyScriptBtn').addEventListener('click', function() {
    //     const scriptCode = document.getElementById('scriptCode').innerText;
    //     const textarea = document.createElement('textarea');
    //     textarea.value = scriptCode;
    //     document.body.appendChild(textarea);
    //     textarea.select();
    //     document.execCommand('copy');
    //     document.body.removeChild(textarea);
    //     iziToast.success({
    //         title: 'Success',
    //         message: 'Script code copied to clipboard!',
    //         position: 'topRight'
    //     });
    // });

    // const btn = document.querySelector(".copyScriptBtn");
    // btn.addEventListener("click", async () => {
    //     try {
    //         await navigator.share($(this).data('url'));
    //         resultPara.textContent = "MDN shared successfully";
    //     } catch (err) {
    //         resultPara.textContent = `Error: ${err}`;
    //     }
    // });

//     document.addEventListener('DOMContentLoaded', (event) => {
//     const shareButton = document.querySelector('.copyScriptBtn');
//     shareButton.addEventListener('click', async () => {
//         $title = $(this).data('title');
//         $url = $(this).data('url');
//         if (navigator.share) {
//             try {
//                 await navigator.share({
//                     title: $title,
//                     url: $url
//                 });
//                 console.log('Product shared successfully');
//             } catch (error) {
//                 console.error('Error sharing the product:', error);
//             }
//         } else {
//             alert('Web Share API is not supported in your browser.');
//         }
//     });
// });
document.addEventListener('DOMContentLoaded', (event) => {
    const shareButtons = document.querySelectorAll('.copyScriptBtn');
    shareButtons.forEach(button => {
        button.addEventListener('click', async function() { // Change arrow function to a regular function
            const productName = this.getAttribute('data-title');
            const productUrl = this.getAttribute('data-url');
            if (navigator.share) {
                try {
                    await navigator.share({
                        title: productName,
                        url: productUrl
                    });
                    console.log(`${productName} shared successfully`);
                } catch (error) {
                    console.error(`Error sharing ${productName}:`, error);
                }
            } else {
                alert('Web Share API is not supported in your browser.');
            }
        });
    });
});

</script>
@endpush
@endsection