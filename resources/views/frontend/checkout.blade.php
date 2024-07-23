@extends('frontend.master')
@section('previous', 'Home')
@section('current', 'Checkout')
@section('content')
@include('breadcrumbs')
<section class="vs-checkout-wrapper space">
    <div class="container">
        <form action="/submit-payment" id="razorpay-form" method="post" class="woocommerce-checkout mt-40">
            @csrf
            <div class="row">
                <div class="col-lg-8 col-md-8 col-12">
                    <div class="border rounded p-3 mb-3">
                        <h2 class="h4">Billing Information</h2>
                        <div class="title-divider1"></div>
                        <div class="row">

                            <div class="col-md-12 form-group">
                                <label for="" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" value="{{$user_details->name}}"
                                    placeholder="First Name" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" value="{{$user_details->email}}"
                                    placeholder="abc@gmail.com" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="" class="form-label">Confirmation Email Address  <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="confirm_email"
                                    value="{{$user_details->email}}" placeholder="abc@gmail.com" required>
                            </div>
                            <div class="col-12 form-group">
                                <label for="" class="form-label">Who you are?</label>
                                <select class="form-select" name="buyer_type">
                                    <option>teacher</option>
                                    <option>student</option>
                                    <option>other</option>
                                </select>
                            </div>
                            <div class="col-12 form-group">
                                <label for="" class="form-label">Phone Number  <span class="text-danger">*</span></label>
                                <input type="text" name="number" class="form-control" value="{{$user_details->number}}"
                                    placeholder="Enter your phone number (only digits)" required>
                            </div>
                            <div class="col-12 form-group">
                                <label for="" class="form-label">Locality</label>
                                <input type="text" name="locality" class="form-control"
                                    value="{{$user_details->locality}}" placeholder="Street Address">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="" class="form-label">State</label>
                                <select class="form-select" name="state" id="state">
                                    <option value="">Select State</option>
                                    @foreach ($states as $state)
                                    <option value="{{$state->id}}"
                                        {{$user_details->state == $state->id ? "selected" : ""}}>{{$state->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="" class="form-label">City</label>
                                <select class="form-select" name="city" id="city">
                                    <option value="">Please select the state first</option>
                                    <input type="hidden" id="userCity" value="{{$user_details->city ? $user_details->city : 0}}">
                                </select>
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="" class="form-label">Postal Code</label>
                                <input type="text" class="form-control" name="postal_code"
                                    value="{{$user_details->postal_code}}" placeholder="Postcode / Zip">
                            </div>
                        </div>
                    </div>
                    <div class="border rounded p-3 mb-3">
                        <h4>Select payment Details</h4>
                        <div class="title-divider1"></div>
                        <div class="woocommerce-checkout-payment">
                            <ul class="wc_payment_methods payment_methods methods">
                                <li class="wc_payment_method payment_method_cod">
                                    <input id="payment_method_cod" type="radio" class="input-radio"
                                        name="payment_method" value="0"> <label for="payment_method_cod">Credit
                                        Cart</label>
                                    <div class="payment_box payment_method_cod">
                                        <div class="row">
                                            <div class="col-md-12 form-group">
                                                <label for="" class="form-label"></label>
                                                <input type="number" class="form-control" placeholder="Card Number">
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <label for="" class="form-label"></label>
                                                <input type="text" class="form-control" placeholder="Name on card">
                                            </div>
                                            <div class="col-md-6 form-group">

                                                <input type="text" class="form-control"
                                                    placeholder="Expiration date (MM/YY)">
                                            </div>
                                            <div class="col-md-6 form-group">

                                                <input type="text" class="form-control" placeholder="CVV">
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="wc_payment_method payment_method_paypal">
                                    <input id="payment_method_paypal" type="radio" class="input-radio"
                                        name="payment_method" value="1" checked> <label
                                        for="payment_method_paypal">Razor Pay</label>
                                    <div class="payment_box payment_method_paypal">
                                        <p>Pay via PayPal; you can pay with your credit card if you don’t have a PayPal
                                            account.
                                        </p>
                                    </div>
                                </li>
                                <li class="wc_payment_method payment_method_cheque">
                                    <input id="payment_method_cheque" type="radio" class="input-radio"
                                        name="payment_method" value="2"> <label for="payment_method_cheque">American
                                        Express</label>
                                    <div class="payment_box payment_method_cheque">
                                        <p>Please send a check to Store Name, Store Street, Store Town, Store State /
                                            County,
                                            Store Postcode.
                                        </p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="border rounded p-3 mb-3">
                        <h2 class="h4">Your Order</h2>
                        <div class="title-divider1"></div>
                        <div class="apply_coupon d-flex align-items-center mb-3">
                            <input type="text" class="rounded-0" id="couponCode" placeholder="Enter Coupon Code">
                            <button class="vs-btn rounded-0" type="button" id="applyCoupon">Apply</button>
                        </div>
                        <ul class="list-group mb-3">
                            @php $total = 0; @endphp
                            @foreach ($products as $item)
                            @php
                            $total += $item->discount_price
                            @endphp
                            <li class="list-group-item d-flex justify-content-between lh-sm">
                                <div>
                                    <h6 class="my-0">{{$item->product_name}}</h6>
                                    <small class="text-muted">{{substr($item->product_name,40)}}</small>
                                </div>
                                <span class="text-muted">₹{{$item->discount_price}}</span>
                            </li>
                            @endforeach
                            <li class="list-group-item d-flex justify-content-between bg-light" id="couponDetails">
                                <div class="text-success">
                                    <h6 class="my-0">Coupon Code</h6>
                                    <small>EXAMPLECODE</small>
                                </div>
                                <span class="text-success">₹0.00</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Total (USD)</span>
                                <strong id="show_price">₹{{number_format((float)$total, 2, '.', '')}}</strong>
                                <input type="hidden" name="total" id="total"
                                    value="{{number_format((float)$total, 2, '.', '')}}">
                            </li>
                        </ul>
                        <div class="form-row place-order"><button type="submit" class="vs-btn w-100" id="payNow">Place
                                order</button></div>
                    </div>
                </div>
            </div>
    </div>
    @php
    $name = Auth::user()->name;
    @endphp
    <?php
        $feeToken = Common::randomMerchantId(1);
        $card_holder_name = $name;
        $productinfo = 'Product Name';
        $surl = url('razor-pay-payment-success');
        $furl = url('razor-pay-payment-failed');
        $key_id = 'rzp_test_LdST7c06dLfLu5';
        $merchant_order_id = $feeToken;
        $currency = 'INR';
    ?>
    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id" />
    <input type="hidden" name="merchant_order_id" id="merchant_order_id" value="<?php echo $merchant_order_id; ?>" />
    <input type="hidden" name="merchant_surl_id" id="merchant_surl_id" value="<?php echo $surl; ?>" />
    <input type="hidden" name="merchant_furl_id" id="merchant_furl_id" value="<?php echo $furl ?>" />
    <input type="hidden" name="card_holder_name" id="card_holder_name" value="<?php echo $card_holder_name;?>" />
    <input type="hidden" name="merchant_amount" id="merchant_amount" value="0" />
    <input type="hidden" name="merchant_total" id="merchant_total" value="0" />
    <input type="hidden" name="currency_code" id="currency_code" value="<?php echo $currency; ?>" />
    <input type="hidden" name="coupon_id" id="coupon_id" value="0" />
    <input type="hidden" name="coupon_discount" id="coupon_discount" value="0" />
    <input type="hidden" name="total_amount_pay" id="total_amount_pay" value="{{$total}}" />
    <input type="hidden" name="payment_type" id="payment_type" value="1" />
    </form>
</section>

@push('scripts')
<script>
    $(document).ready(function() {
        $(document).on('change', '#state', function loadcity() {
            $id = $(this).val();
            $user_city = $('#userCity').val();
            $.ajax({
                url: '/fetch-city',
                method: 'post',
                data: {
                    _token: '{{csrf_token()}}',
                    state: $id
                },
                dataType: 'json',
                success: function(respond) {
                    $htmlView = "<option value=''>Select City</option>";
                    if (respond['citys'].length > 0) {
                        for (let i = 0; i < respond['citys'].length; i++) {
                            $htmlView +=
                                `<option value="${respond['citys'][i].id}" ${$user_city == respond['citys'][i].id ? "selected" : "" }>${respond['citys'][i].name}</option>`;
                        }
                        $("#city").html($htmlView);
                    }
                }
            });
        })
    });
</script>

@isset($user_details->state)
<script>
    jQuery(function() {
        $('#state').change();
    });
</script>
@endisset

<script>
    $grandTotal = {{$total}}
</script>

<script>
    $(document).ready(function() {
        $(document).on('click', '#applyCoupon', function() {
            if ($('#couponCode').val() == "") {
                iziToast.error({
                    title: 'Error',
                    message: 'Please Enter A Coupon Code!!',
                });
            } else {
                $code = $('#couponCode').val();
                $total = $grandTotal;
                $.ajax({
                    url: '/apply-coupon-code',
                    method: 'post',
                    datatype: 'json',
                    data: {
                        _token: '{{csrf_token()}}',
                        code: $code,
                        total: $total
                    },
                    success: function(respond) {
                        $htmlView = "";
                        if (respond.status == 1) {
                            if (respond['coupon']) {
                                $htmlView += `<div class="text-success">
                                <h6 class="my-0">Coupon Code</h6>
                                <small id="coupon_code">${respond['coupon'].coupon_code}</small>
                                </div>
                                <span class="text-success">₹${respond['coupon'].discount_amount}</span>`;
                                $("#couponDetails").html($htmlView);
                                $('#couponCode').val('');
                                $('#coupon_id').val(`${respond['coupon'].id}`);
                                $discountAmount = $grandTotal -  `${respond['coupon'].discount_amount}`;
                                $('#total').val($discountAmount);
                                $('#show_price').html('₹' + $discountAmount.toFixed(2));
                                $('#coupon_discount').val(`${respond['coupon'].discount_amount}`);
                            }
                            iziToast.success({
                                title: 'Success',
                                message: 'Coupon Added Successfully',
                                position: 'topRight'
                            });
                        } else {
                            iziToast.error({
                                title: 'Error',
                                message: respond.message,
                                position: 'topRight'
                            });
                            $('#couponCode').val('')
                        }
                    }
                });
            }
        })
    })
</script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="https://polyfill.io/v3/polyfill.min.js?version=3.52.1&features=fetch"></script>
<script>
    $("#payNow").on('click', function() {
        $("#payNow").attr('disabled', 'disabled').text('Processing Payment...');
        $.ajax({
            url: '/calculate-total-amount',
            method: 'post',
            dataType: 'json',
            data: {
                '_token': '{{csrf_token()}}',
                'coupon': $("#coupon_code").html()
            },
            success: function(data) {
                if ($('input[name="payment_method"]:checked').val() == 0) {
                    console.log('Pay With Card');
                } else if ($('input[name="payment_method"]:checked').val() == 1) {
                    console.log(data);
                    razorpaySubmit(data.amount);
                } else {
                    console.log('Another Payment Gateway');
                }
            }
        });
    });
</script>
<script>
    var razorpay_submit_btn, razorpay_instance;

    function razorpaySubmit(amount) {
        actualAmnt = amount;
        totalAmount = actualAmnt * 100;
        document.getElementById('merchant_amount').value = Math.round(actualAmnt);
        document.getElementById('merchant_total').value = Math.round(totalAmount);
        var razorpay_options = {
            key: "rzp_test_LdST7c06dLfLu5",
            amount: Math.round(totalAmount),
            name: "Printaboo",
            description: "Order #4444",
            netbanking: true,
            currency: "INR",
            prefill: {
                name: "{{Auth::user()->name}}",
                email: "{{Auth::user()->email}}",
                contact: "{{Auth::user()->number}}"
            },
            handler: function(transaction) {
                document.getElementById('razorpay_payment_id').value = transaction.razorpay_payment_id;
                document.getElementById('razorpay-form').submit();
            },
            "modal": {
                "ondismiss": function() {
                    location.reload()
                }
            }
        };
        if (actualAmnt > 0 && totalAmount > 0) {
            if (typeof Razorpay == 'undefined') {
                setTimeout(razorpaySubmit, 200);
            } else {
                if (!razorpay_instance) {
                    razorpay_instance = new Razorpay(razorpay_options);
                }
                razorpay_instance.open();
            }
        }
    }
</script>
@endpush
@endsection