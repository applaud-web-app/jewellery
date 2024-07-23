@extends('admin.master')
@section('title')
All Product
@endsection
@section('content')
@push('styles')
<link rel="stylesheet" href="{{asset("assets/admin/vendor/sweetalert2/dist/sweetalert2.min.css")}}">
@endpush
<section class="content-body">
    <!-- row -->
    <div class="container-fluid">
        <div class="mb-sm-3 d-flex flex-wrap align-items-center text-head">
            <h2 class="mb-3 me-auto">All Product</h2>
            <div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                    <li class="breadcrumb-item"><a href="/admin/all-orders">Product</a></li>
                </ol>
            </div>
        </div>
        <div class="row">
            @forelse ($product as $item)
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="menu-product d-flex">
                                <img src="/uploads/product_images/product_feature_image/{{$item->product_fetaure_img}}">
                                <div class="content-detail-wrap">
                                    <div class="d-flex justify-content-between mb-2">
                                        <div>
                                            <h4 class="mb-0">{{$item->product_name}}</h4>
                                            <p class="mb-0">Category: <span class="text-danger">{{$item->category->cat_name}}</span></p>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-start flex-wrap">
                                        @php 
                                            $materialCost = 0;
                                            $updatedPrices = json_decode($tempPrice->temp_price,true);
                                        @endphp
                                        @if (isset($item->materials))
                                            @foreach ($item->materials as $material)
                                                @php
                                                    $quantity = $material->pivot->quantity_used;
                                                    $perGramRate = $updatedPrices[$material->id] * $quantity;
                                                    $materialCost += $perGramRate;
                                                @endphp
                                                <span class="badge badge-danger mx-1 mb-1 small">{{$material->purity_grade}} {{$material->material_name}} : {{$quantity}}  {{$material->unit_of_measurement}}</span>
                                            @endforeach
                                        @endif
                                        <div>
                                            @php
                                                $price = (float)$item->price + (float)$item->discount_price;
                                            @endphp
                                            <h4 class="mt-2 mb-0 text-primary">₹{{number_format($price+$materialCost,2)}}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-12 text-center mt-5">
                    <img src="{{asset('assets/admin/images/empty-box.png')}}">    
                    <h4 class="text-danger mt-4">No Products Found</h4>
                </div>    
            @endforelse
        </div>
    </div>
</section>
@push('scripts')
<script>
    $("#search_btn").on('click',function(){
        var txt = $('#search_txt').val();
        if(txt!=''){
            window.location.href = "{{url('admin/all-orders?q=')}}"+txt;
        }
    })
</script>
@endpush
@endsection