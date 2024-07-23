<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Printaboo</title>
    <meta name="author" content="Vecuro">
    <meta name="description" content="Printaboo - Shop for children">
    <meta name="keywords" content="Printaboo - Shop for children">
    <meta name="robots" content="INDEX,FOLLOW">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <link rel="shortcut icon" href="assets/frontend/img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="assets/frontend/img/favicon.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/app.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/fontawesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/iziToast.min.css')}}">
</head>
<style>
    .error{
        color:#ff0000;
    }
</style>
<body>
    <div class="preloader">
        <div class="preloader-inner">
            <div class="loader"></div>
        </div>
    </div>
    <section class="login-wrapper">
        @include('messages')
        <div class="container">
            <div class="login-form">
                <div class="row justify-content-center w-100">
                    <div class="col-xl-6 col-lg-6 ">
                        <div class="text-center mb-5">
                            <img src="assets/frontend/img/logo.png" alt="" class="img-fluid">
                            <h3>Create an Account </h3>
                            <p class="fs-5">Create an account with your mobile number</p>
                        </div>
                        <form action="/user-register" method="POST" class="form-style3" id="register_frm">
                            @csrf
                            <div class="row justify-content-between">
                                <div class="col-md-12 form-group">
                                    <label>Full Name <span class="required">(*)</span></label>
                                    <input type="text" class="form-control" name="name" placeholder="Enter your Full Name">
                                    @error('name') <span class="text-danger">{{$message}}</span>  @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Email Address <span class="required">(*)</span></label>
                                    <input type="email" class="form-control" name="email" placeholder="Enter email address">
                                    @error('email') <span class="text-danger">{{$message}}</span>  @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Mobile Number <span class="required">(*)</span></label>
                                    <input type="tel" class="form-control" name="number" placeholder="Enter Mobile Number">
                                    @error('number') <span class="text-danger">{{$message}}</span>  @enderror
                                </div>
                                <div class="col-md-12 form-group">
                                    <label>Create Password <span class="required">(*)</span></label>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Type Password">
                                    @error('password') <span class="text-danger">{{$message}}</span>  @enderror
                                </div>
                                <div class="col-md-12 form-group">
                                    <label>Confirm Password <span class="required">(*)</span></label>
                                    <input type="password" class="form-control" name="confirm_pass" placeholder="Retype Password">
                                    @error('confirm_pass') <span class="text-danger">{{$message}}</span>  @enderror
                                </div>
                                <div class="col-md-12 form-group"><button class="vs-btn w-100" id="continue_btn" >Log In</button>
                                </div>
                                <div class="col-md-12 form-group">
                                    <h1 class="line">OR</h1>
                                    <a href="" class="social-use-btn  my-3">
                                        <img src="assets/frontend/img/google.png" alt="" class="img-fluid">
                                        <span class="ps-2">Login with Google</span>
                                    </a>
                                    <p class="text-center">Already have an account? <a href="/login">Login Here</a></p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="{{asset('assets/frontend/js/vendor/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('assets/frontend/js/app.min.js')}}"></script>
    <script src="{{asset('assets/frontend/js/main.js')}}"></script>
    <script src="{{asset('assets/frontend/js/iziToast.min.js')}}"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

    <script> 
        $("#register_frm").validate({
            rules: {
                name:{required:true},
                email:{required:true,email:true},
                number:{required:true,minlength:10,maxlength:10},
                password:{required:true,minlength:5},
                confirm_pass:{required:true,minlength:5,equalTo: "#password" },
            },
            messages: {
                mobile_number:{minlength:'Enter valid 10 digit mobile number',maxlength:'Enter valid 10 digit mobile number'},
                confirm_pass:{equalTo:'Password & Confirm Password are not same'}
            },
            errorElement: 'div',
            highlight: function(element, errorClass) {
                $(element).css({ border: '1px solid #f00' });
            },
            unhighlight: function(element, errorClass) {
                $(element).css({ border: '1px solid #c1c1c1' });
            },
            submitHandler: function(form,event) {
                $("#continue_btn").attr('disabled','disabled').text('Generating OTP...');
                document.register_frm.submit();
            }
        });
    </script>
    @if(Session::has('success'))
    <script>
        iziToast.success({
            title: 'Success',
            message: '{{Session::get("success")}}',
            position:'topRight'
        });
    </script>
    @endif 

    @if(Session::has('error'))
    <script>
    iziToast.error({
        title: 'error',
        message: '{{Session::get("error")}}',
        position:'topRight'
    });
    </script>
    @endif 
</body>

</html>