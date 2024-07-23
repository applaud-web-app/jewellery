@extends('admin.master')
@section('title')
All Quotation
@endsection
@section('content')
@push('styles')
<link rel="stylesheet" href="{{asset("assets/admin/vendor/sweetalert2/dist/sweetalert2.min.css")}}">
<!--Plugin CSS file with desired skin-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/css/ion.rangeSlider.min.css"/>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
<section class="content-body">
    <!-- row -->
    <div class="container-fluid">
        <div class="mb-sm-3 d-flex flex-wrap align-items-center text-head">
            <h2 class="mb-3 me-auto">Quotation</h2>
            <div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                    <li class="breadcrumb-item"><a href="/admin/all-orders">Quotation</a></li>
                </ol>
            </div>
        </div>
        <form action="" method="GET" autocomplete="off" class="row">
            <div class="col-lg-6">
                <label for="">Search</label>
                <input type="text" class="form-control" value="@isset($filter_productName){{$filter_productName}}@endisset" name="search" placeholder="Search by name or sku...." id="search_txt">
            </div>
            <div class="col-lg-6">
                <label for="">Stock Sheet</label>
                <select name="category" class="form-control">
                    <option>Select Stock Sheet</option>
                    @isset($catgeory)
                        @foreach ($catgeory as $cat)
                            <option value="{{$cat->id}}" {{$filter_category == $cat->id ? "selected" : ""}}>{{$cat->cat_name}}</option>
                        @endforeach
                    @endisset
                </select>
            </div>
            <div class="col-lg-12 my-2">
                <label for="">Stamp</label>
                <select name="material[]" class="form-control js-example-basic-multiple" id="js-example-basic-multiple" multiple="multiple" onchange="functionvab()">
                    @isset($data)
                        @foreach ($data as $mat)
                            <option value="{{$mat->id}}" data-type="{{$mat->unit_of_measurement}}" @if (is_array($filter_material)){{in_array($mat->id,$filter_material)  ? "selected" : ""}}@endif>{{$mat->material_name}} {{$mat->purity_grade}}</option>
                        @endforeach
                    @endisset
                </select>
            </div>
            <div class="col-lg-6">
                <div class="mt-2">
                    <label for="">Weight Range (Grams)</label>
                    <input type="text" id="example_id" data-type="double" data-min="0" data-max="100" data-step="0.100" name="weight_gram"  value="" />
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mt-2">
                    <label for="">Weight Range (Carat)</label>
                    <input type="text" id="example_id2" data-type="double" data-min="0" data-max="100" data-step="0.100" name="weight_carat" value="" />
                </div>
            </div>
            <div class="col-lg-12 d-flex align-items-end justify-content-end mt-3">
                <div class="d-flex">
                    <button type="submit" class="btn btn-primary w-auto me-2">Apply Filter</button>
                    <a href="{{route('quoatation')}}" class="btn btn-danger w-auto me-2">Refresh</a>
                    <button type="button" class="btn btn-success w-auto me-2"  data-bs-toggle="modal" data-bs-target="#exampleModal">Update Price</button>
                </div>
            </div>
        </form>
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap mt-4">
            <div>
                <a href="{{url('admin/add-product')}}" class="d-none btn btn-primary  mb-2"><i class="fas fa-plus pe-2"></i>Add New</a>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="table-responsive">
                            <table id="example5" class="display table" style="min-width: 100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Base Price</th>
                                        <th>Charges</th>
                                        <th>Material Cost</th>
                                        <th>Selling Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $product_id = [];
                                    @endphp
                                    @if (count($products) > 0)
                                    @foreach ($products as $product)
                                        @php
                                            $materialCost = 0;
                                            $product_id[] = $product->id;
                                        @endphp
                                        <tr>
                                            <td>{{$loop->index+1}}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="img-box">
                                                        <img class="img-thumbnail me-2" width="50px" src="/uploads/product_images/product_feature_image/{{$product->product_fetaure_img}}">
                                                    </div>
                                                    <div class="context-box">
                                                        <p class="mb-0">{{$product->product_name}} <span class="text-success small">[SKU : {{$product->sku}}]</span></p>
                                                        @if (isset($product->materials))
                                                            @foreach ($product->materials as $material)
                                                                @php
                                                                    $quantity = $material->pivot->quantity_used;
                                                                    $perGramRate = $material->current_price_per_unit * $quantity;
                                                                    $materialCost += $perGramRate;
                                                                @endphp
                                                                <span class="badge badge-danger mx-1 mb-1 small">{{$material->purity_grade}} {{$material->material_name}} : {{$quantity}}  {{$material->unit_of_measurement}}</span>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{$product->category->cat_name}}</td>
                                            <td>₹{{number_format($product->price,2)}}</td>
                                            <td>₹{{number_format($product->discount_price,2)}}</td>
                                            <td>₹{{number_format($materialCost,2) ?? 0}}</td>
                                            @php
                                                $sellingPrice = $product->price + $product->discount_price + $materialCost;
                                            @endphp
                                            <td>₹{{number_format($sellingPrice,2)}}</td>
                                        </tr>
                                    @endforeach
                                    @else 
                                    <tr>
                                        <td colspan="8"><h4 class="text-center text-danger">NO ORDER FOUND</h4></td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form action="{{route('createQuoatation')}}" method="POST" autocomplete="off">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Price</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="product_id" value="{{json_encode($product_id)}}">
                    <div class="mb-3">
                        @foreach ($data as $item)
                            <div class="row mb-3">
                               <div>
                                <label for="mateial" class="form-label badge badge-danger">{{$item->purity_grade}} {{$item->material_name}}</label>
                               </div>
                                <div class="col-lg-6">
                                    <label for="">Current Price (₹)/({{$item->unit_of_measurement}})</label>
                                    <input type="number" class="form-control" value="{{$item->current_price_per_unit}}" id="mateial" readonly disabled>
                                </div>
                                <div class="col-lg-6">
                                    <label for="">Updated Price (₹)/({{$item->unit_of_measurement}})</label>
                                    <input type="number" step=".01" min="{{$item->minimun_price}}" class="form-control" name="material[{{$item->id}}]" value="{{$item->current_price_per_unit}}" id="mateial" >
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Apply Changes</button>
                </div>
            </div>
        </div>
    </form>
  </div>
@push('scripts')

<!--jQuery-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<!--Plugin JavaScript file-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/js/ion.rangeSlider.min.js"></script> 

<script>
    $("#example_id").ionRangeSlider({
        skin:"square"
    });
    $("#example_id2").ionRangeSlider({
        skin:"square"
    });
</script>
<script>
    $("#search_btn").on('click',function(){
        var txt = $('#search_txt').val();
        if(txt!=''){
            window.location.href = "{{url('admin/all-orders?q=')}}"+txt;
        }
    })
</script>
<script>
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });
</script>
@endpush
@endsection