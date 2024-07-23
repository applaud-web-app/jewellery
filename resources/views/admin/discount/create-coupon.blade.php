@extends('admin.master')
@section('title')
    Add Coupon
@endsection

@section('content')
<section class="content-body">
    <!-- row -->
    <div class="container-fluid">
        <div class="mb-sm-3 d-flex flex-wrap align-items-center text-head">
            <h2 class="mb-3 me-auto">Create Coupon</h2>
            <div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/dashboard/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/admin/product-discounts">Discounts</a></li>
                    <li class="breadcrumb-item active"><a href="/admin/create-coupon">Create Coupon</a></li>
                </ol>
            </div>
        </div>
        <form action="{{route('store-coupon')}}" method="POST" enctype="multipart/form-data" id="coupon_frm" name="coupon_frm">
            @csrf
            <div class="row">
                @include('messages')
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header ">
                            <h4 class="card-title fs-20 mb-0">Coupon Overview </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                
                                <div class="col-lg-6 col-md-6 col-12 mb-3">
                                    <div class="form-group">
                                        <label for="coupon_code">Coupon Code</label>
                                        <input type="text" class="form-control" name="coupon_code" id="coupon_code" placeholder="Enter Coupon name" required>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12 mb-3">
                                    <div class="form-group">
                                        <label for="usage_type">User Per Customer</label>
                                    <select name="usage_type" id="usage_type" class="form-control" required>
                                            <option value="" selected disabled>Choose Options</option>
                                            <option value="1">Only Once</option>
                                            <option value="2">Multiple Times</option>
                                            
                                    </select>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-12 mb-3">
                                    
                                    <div class="form-group">
                                    
                                            <label for="description"> Description </label>
                                            <textarea name="description" id="description" class="form-control" style="height: 100px;" required></textarea>
                                    
                                    </div>
                                </div>

                                
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header ">
                            <h4 class="card-title fs-20 mb-0">Coupon Details </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                            <div class="col-lg-12 col-md-12 col-12 mb-3">
                                    <h5>Minimum Order Conditions</h5>
                                    <div class="form-check me-3 ">
                                        <input type="checkbox" class="form-check-input" name="is_order_value" id="is_order_value" value="1">
                                        <label class="form-check-label" for="is_order_value">Order Value</label>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-12 mb-3" style="display: none;" id="min_order_val">
                                    <div class="form-group">
                                        <label for="min_order">Minimum Order Value</label>
                                        <input type="text" class="form-control" name="min_order" id="min_order"  placeholder="Enter amount">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-12 mb-3">
                                    <div class="form-group mb-2">
                                        <label for="discount_amount">Discount Amount</label>
                                        <input type="text" class="form-control" name="discount_amount" id="discount_amount" placeholder="Enter amount" onkeypress="return isNumberKey(event,this)" required>
                                    </div>
                                </div>

                            
            
                                
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-12 ">
                    <button type="submit" class="btn btn-primary  mb-2"><i
                            class="far fa-check-square pe-2"></i>Submit</button>
                    <a href="{{url('admin/product-discounts')}}" class="btn btn-dark  mb-2"><i
                            class="far fa-window-close pe-2"></i>Cancel </a>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@push('scripts')
<script src="{{asset('assets/admin/js/jquery.validate.min.js')}}"></script>
<script>
    $("#coupon_frm").validate({
        rules: {
        },
        messages: {},
        errorElement: 'div',
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        },
        highlight: function(element, errorClass) {
            $(element).css({ border: '1px solid #f00' });
        },
        unhighlight: function(element, errorClass) {
            $(element).css({ border: '1px solid #c1c1c1' });
        },
        submitHandler: function() {
            document.coupon_frm.submit();
            $('button[type="submit"]').attr('disabled','disabled').text('Processing...');           
        }
    });
</script>
<script>
    $("#is_order_value").on('click',function(){
        if($(this).is(":checked")){
            $("#min_order_val").show();
            $("#min_order").attr('required','required');
        }else{
            $("#min_order_val").hide();
            $("#min_order").removeAttr('required');
        }
    })
</script>
@endpush

