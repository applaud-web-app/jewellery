@extends('admin.master')
@section('title')
    Prodct Discounts
@endsection
@push('styles')
    <link rel="stylesheet" href="{{asset("assets/admin/vendor/sweetalert2/dist/sweetalert2.min.css")}}">
@endpush
@section('content')
<section class="content-body">
    <!-- row -->
    <div class="container-fluid">
        <div class="mb-sm-3 d-flex flex-wrap align-items-center text-head">
            <h2 class="mb-3 me-auto">Discount Coupons</h2>
            <div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/dashboard/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/admin/product-discounts">Discount Coupons</a></li>
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
                <a href="{{route('create-coupon')}}" class="btn btn-primary  me-3 mb-2"><i class="fas fa-plus pe-2"></i>Create a Coupon</a>
            </div>
        </div>
        <div class="row">
            @include('messages')
            @forelse ($couponData as $item)
                @php
                    $inputObj = new stdClass();
                    $inputObj->params = 'id='.$item->id;
                    $inputObj->url = url('admin/edit-coupon');
                    $editLink = Common::encryptLink($inputObj);

                    $inputObjS = new stdClass();
                    $inputObjS->params = 'id='.$item->id;
                    $inputObjS->url = url('admin/change-coupon-status');
                    $statusLink = Common::encryptLink($inputObjS);
                @endphp
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="card">
                        <div class="card-header d-block p-3">
                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center mb-3">
                                    <img src="{{asset('assets/admin/images/coupon.png')}}" alt="" class="img-fluid me-2" width="26">
                                    <h4 class="fs-18 mb-0">{{$item->coupon_code}} <a href="javascript:void(0)" onclick="copyToClipboard('{{$item->coupon_code}}')" class="text-primary"><i class="fas fa-copy ps-1"></i></a></h4>
                                </div>
                                <div class="form-check toggle-switch text-end form-switch mx-3">
                                    <input  class="form-check-input change_status" type="checkbox" data-id="{{$statusLink}}" id="flexSwitchCheckDefaul{{$item->id}}" {{$item->status==1 ? 'checked':''}}>
                                </div>
                            </div>


                            <p class="mb-0">{{$item->description}}</p>
                        </div>
                        <div class="card-body p-3">
                            <div class="text-black d-flex align-items-center justify-content-between mb-1">
                                <span>Time Used</span>
                                <span >687</span>
                            </div>
                            <div class="text-black  d-flex align-items-center justify-content-between ">
                                <span>Total Sales Generated</span>
                                <span >₹8787</span>
                            </div>
                        </div>
                        <div class="card-footer ">

                            <div class="d-flex justify-content-center">
                                {{-- <a href="" class="text-primary"><i class="fas fa-share-square pe-2"></i>Share Coupon</a> --}}
                                <a href="{{$editLink}}" class="text-danger"><i class="fas fa-edit pe-2"></i>Edit Coupon</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-12 text-center mt-5">
                    <img src="{{asset('assets/admin/images/empty-box.png')}}">    
                    <h4 class="text-danger mt-4">No Coupons Found</h4>
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
                text: "You want to change coupon status",
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
                                message: 'Coupon status changed successfully...',
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
        $("#search_btn").on('click',function(){
            var str = $("#search_str").val();
            if(str!=''){
                window.location.href = "{{url('admin/product-discounts?str=')}}"+str;
            }
        })
    </script>
    <script>
        function copyToClipboard(text, ele) {
            navigator.clipboard.writeText(text)
                .then(() => {
                    iziToast.success({
                        title: 'success',
                        message: 'Coupon copied successfully...',
                        position:'topRight',
                        timeout: 1000,
                    });
                })
                .catch(err => {
                    console.error('Error copying text to clipboard: ', err);
                });
        }
    </script>
@endpush

