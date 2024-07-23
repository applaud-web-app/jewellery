@extends('frontend.master')
@section('previous', 'Home')
@section('current', 'Change Password')
@section('content')
@include('breadcrumbs')
@include('messages')
<section class="space">
    <div class="container">
        <form action="/update-password" method="post" class="form-style3" id="update_password">
            @csrf
            <div class="user-profile">
                <div class="user-img">
                    <img src="uploads/user/{{$userImage->image}}" alt="user" class="img-fluid img-thumbnail">
                </div>
                <hr>
                <div class="row align-items-center py-3 ">
                    <div class="col-lg-4 col-md-4 col-12">
                        <label for="new_password" class="form-label h6 mb-0">Password <span class="text-danger">*</span></label>
                        <span>New Password</span>
                    </div>
                    <div class="col-lg-8 col-md-8 col-12">
                        <input type="password" class="form-control" name="password" id="new_password" placeholder="Enter New Password">
                    </div>
                </div>
                <hr>
                <div class="row align-items-center py-3 ">
                    <div class="col-lg-4 col-md-4 col-12">
                        <label for="retype_password" class="form-label h6 mb-0">Retype Password <span class="text-danger">*</span></label>
                        <span>Confirm Password</span>
                    </div>
                    <div class="col-lg-8 col-md-8 col-12">
                        <input type="password" name="retype_password" class="form-control" id="retype_password"
                            placeholder="Retype Password">
                    </div>
                </div>
                <button type="submit" id="submitBtn" class="btn vs-btn mt-3">Reset Password</button>
            </div>
        </form>
    </div>
</section>

@push('scripts')

<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

<script> 
    $("#update_password").validate({
        rules: {
            password:{required:true,minlength:5},
            retype_password:{required:true,minlength:5,equalTo: "#new_password" },
        },
        messages: {
            retype_password:{equalTo:'Password & Retype Password are not same'}
        },
        errorElement: 'div',
        highlight: function(element, errorClass) {
            $(element).css({ border: '1px solid #f00' });
        },
        unhighlight: function(element, errorClass) {
            $(element).css({ border: '1px solid #c1c1c1' });
        },
        submitHandler: function(form,event) {
            $("#submitBtn").attr('disabled','disabled').text('Updating Password....');
            document.update_password.submit();
        }
    });
</script>

@endpush
@endsection