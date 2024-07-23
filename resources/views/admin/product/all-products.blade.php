@extends('admin.master')
@section('title')
    All Products
@endsection
@section('title')
    All Products
@endsection
@section('content')
@push('styles')
    <link rel="stylesheet" href="{{asset("assets/admin/vendor/sweetalert2/dist/sweetalert2.min.css")}}">
@endpush
    <section class="content-body">
        <!-- row -->
        <div class="container-fluid">
            <div class="mb-sm-3 d-flex flex-wrap align-items-center text-head">
                <h2 class="mb-3 me-auto">All Products</h2>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                        <li class="breadcrumb-item"><a href="/admin/all-products">All Products</a></li>
                    </ol>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                <div class="customer-search mb-sm-0 mb-3">
                    <div class="input-group search-area">
                        <input type="text" class="form-control" placeholder="Search here......" id="search_str" value="{{$str}}">
                        <span class="input-group-text" id="search_btn"><a href="javascript:void(0)"><i
                                    class="flaticon-381-search-2"></i></a></span>
                    </div>
                </div>
                <div class="d-flex align-items-center flex-wrap">
                    <div class="form-group me-3 mb-2">
                        @php
                            $catTree = count($categories) ? Common::buildTree($categories) : [];
                        @endphp
                        <select name="category_id" id="category_id" class="form-control" required>
                            <option value="">Select Category</option>
                            {{Common::printTree($catTree,0,null,$category)}}
                        </select>
                    </div>
                    <a href="{{url('admin/add-product')}}" class="btn btn-primary  mb-2"><i class="fas fa-plus pe-2"></i>Add New</a>
                    <a href="{{route('quoatation')}}" class="btn btn-danger ms-2 mb-2"><i class="fas fa-plus pe-2"></i>Quoatation</a>
                </div>
            </div>
            <div class="row">
                @include('messages')
                @forelse ($productData as $item)
                    @php
                        $inputObj = new stdClass();
                        $inputObj->params = 'id='.$item->id;
                        $inputObj->url = url('admin/edit-product');
                        $editLink = Common::encryptLink($inputObj);
                        
                        $inputObjS = new stdClass();
                        $inputObjS->params = 'id='.$item->id;
                        $inputObjS->url = url('admin/change-product-status');
                        $statusLink = Common::encryptLink($inputObjS);
                    @endphp
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
                                            <a href="{{$editLink}}" class="text-primary"><i class="far fa-edit"></i></a>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                @php
                                                    $price = (float)$item->price;    
                                                    $discountPrice = (float)$item->discount_price;    
                                                @endphp
                                                @if($price!=$discountPrice)
                                                    <h4 class="mb-0 text-primary">₹{{$discountPrice}}</h4>
                                                    <strike class="text-muted">₹{{$price}}</strike>
                                                @else
                                                    <h4 class="mb-0 text-primary">₹{{$discountPrice+0}}</h4>
                                                @endif
                                            </div>
                                            <div class="form-check toggle-switch text-end form-switch ms-3 number">
                                                <input class="form-check-input change_status" data-id="{{$statusLink}}" type="checkbox" id="chckStatus_{{$item->id}}" {{$item->status==1 ? 'checked' : ''}}>
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
@endsection

@push('scripts')
<script src="{{asset('assets/admin/vendor/sweetalert2/dist/sweetalert2.min.js')}}"></script>
    <script>
       $(".change_status").on('change',function(){
            var elem = $(this);
            var statusurl = elem.data('id');

            var sts = $(this).is(":checked") ? 2 : 1;
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to change product status",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.value==true) {
                    $.post(statusurl,{'status':sts,'_token':"{{csrf_token()}}"},function(data){
                        if(data.s==1){
                            iziToast.success({
                                title: 'success',
                                message: 'Product status changed successfully...',
                                position:'topRight'
                            });
                        }
                    })
                }else{
                    if(sts==2){
                        elem.prop('checked',false).removeAttr('checked');
                    }else{
                        elem.prop('checked',true).removeAttr('checked');
                    }
                }
            })
       });
    </script>
    <script>
        $("#category_id").on('change',function(){
            var id = $(this).val();
            if(id>0){
                window.location.href = "{{url('admin/all-products?category=')}}"+id;
            }
        })
    </script>
    <script>
        $("#search_btn").on('click',function(){
            var str = $("#search_str").val();
            if(str!=''){
                window.location.href = "{{url('admin/all-products?str=')}}"+str;
            }
        })
    </script>
@endpush
