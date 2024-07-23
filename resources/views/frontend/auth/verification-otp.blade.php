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
    <link rel="shortcut icon" href="{{asset('assets/frontend/img/favicon.ico')}}" type="image/x-icon">
    <link rel="icon" href="{{asset('assets/frontend/img/favicon.ico')}}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/app.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/fontawesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/iziToast.min.css')}}">
</head>
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
                            <h3>Verification Required</h3>
                            <p>Enter the code sent to <span style="font-weight: 500">{{$data['number']}}</span></p>
                            <input type="hidden" id="mobile_number" value="{{$data['number']}}">
                        </div>
                        <form action="#" class="form-style3">
                            <div id="recaptcha-container"></div>
                            <div class="row otp-field mb-3">
                                <div class="col-2 form-group">
                                    <input type="text" class="form-control digit" name="digit-1"
                                        data-next="digit-2" />
                                </div>
                                <div class="col-2 form-group">
                                    <input type="text" class="form-control digit" name="digit-2"
                                        data-next="digit-3" data-previous="digit-1" />
                                </div>
                                <div class="col-2 form-group">
                                    <input type="text" class="form-control digit" name="digit-3"
                                        data-next="digit-4" data-previous="digit-2" />
                                </div>
                                <div class="col-2 form-group">
                                    <input type="text" class="form-control digit" name="digit-4"
                                        data-next="digit-5" data-previous="digit-3" />
                                </div>
                                <div class="col-2 form-group">
                                    <input type="text" class="form-control digit" name="digit-5"
                                        data-next="digit-6" data-previous="digit-4" />
                                </div>
                                <div class="col-2 form-group">
                                    <input type="text" class="form-control digit" name="digit-6"
                                        data-previous="digit-5" />
                                </div>
                                <input type="number" id="checkOTP" value="" class="d-none">
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <button class="vs-btn w-100" type="submit" onclick="sendOtpToMobile()">Send a New Code</button>
                                </div>
                                <div class="col-md-6 form-group">
                                    <button class="btn vs-btn w-100 submit-btn" id="verify_btn" type="button" onclick="verify()">Complete Login</button>
                                </div>
                                <p class="ot_err text-danger"></p>
                            </div>
                            <div class="text-center">
                                <p>Can't access your account? <a href="/">Create Account</a></p>
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
    <script>
        $(document).ready(function(){
            $(document).on('input','.digit',function(){
                $value = "";
                $('.digit').each(function() {
                    $value += $(this).val();
                });
                $('#checkOTP').val($value);
            })
        })
    </script>
    <script>
        $('.otp-field').find('input').each(function() {
            $(this).attr('maxlength', 1);
            $(this).on('keyup', function(e) {
                var elm = $(this).data('next');
                var prev = $(this).data('previous');
                var parent = $($(this).parent());
                if (e.keyCode === 8 || e.keyCode === 37) {
                    if (prev != '') {
                        $("#" + prev).focus();
                    }
                } else if ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <=
                    90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
                    var next = elm;
                    if (next != '') {
                        $("#" + next).focus();
                    }
                }
            });
        });
    </script>
    {{-- <script src="https://code.jquery.com/jquery-3.7.1.js"></script> --}}
    <script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>
    <script>
        var firebaseConfig = {
            apiKey: "AIzaSyCo8KaHu8XZ6jm3ewJXqs0Kma8ZfiSoby4",
            authDomain: "otplogin-5f6f9.firebaseapp.com",
            projectId: "otplogin-5f6f9",
            storageBucket: "otplogin-5f6f9.appspot.com",
            messagingSenderId: "493284471501",
            appId: "1:493284471501:web:55ca067ed947569b2eef84",
            measurementId: "G-0ZJLWFMJMH"
        };
        firebase.initializeApp(firebaseConfig);
    </script>

    <script>
        window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container', {
        'size': 'invisible',
        });
    </script>

    <script>
        var sel_mob_number = '-';
        function sendOtpToMobile(){
            var number = "+91"+$('#mobile_number').val();
            firebase.auth().signInWithPhoneNumber(number, window.recaptchaVerifier).then(function (confirmationResult) {
                    window.confirmationResult = confirmationResult;
                    coderesult = confirmationResult;
                    // $("#otp_frm").show();
            }).catch(function (error) {
                    $("#continue_btn").removeAttr('disabled').text('Register');
                    // $(".ot_err").text('Something went wrong ...mobile number should be a valid 10 digit number');
                    iziToast.error({
                        title: 'Error',
                        message: 'Oops, something went wrong. Please try again later.',
                        position:'topRight'
                    });
            });
        }
    sendOtpToMobile();
    </script>
    <script>
        function verify() {
            var code = $("#checkOTP").val();
            if(code!=""){
                $("#verify_btn").attr('disabled','disabled').text('Processing...');
                coderesult.confirm(code).then(function (result) {
                        $.ajax({
                            url: '{{ url("/registration-completed")}}',
                            type: 'post',
                            data: {
                            _token: '{{csrf_token()}}',
                            name: '{{$data["name"]}}' , 
                            number:'{{$data["number"]}}',
                            email:'{{$data["email"]}}',
                            password:'{{$data["password"]}}',
                            },
                            dataType: 'json',
                            success: function(respond) {
                                console.log(respond.status);
                                if(respond.status == 1){
                                    setTimeout(() => {
                                        window.location.replace("{{url('/')}}");
                                    }, 200);
                                    iziToast.success({
                                        title: 'Success',
                                        message: respond.message,
                                        position:'topRight'
                                    });
                                }else{
                                    iziToast.error({
                                        title: 'Error',
                                        message: respond.message,
                                        position:'topRight'
                                    });
                                    setTimeout(() => {
                                        // window.location.replace("{{url('/login')}}");
                                    }, 200);
                                }
                            }
                        });
                }).catch(function (error) {
                    $("#verify_btn").removeAttr('disabled').text('Continue');
                    iziToast.error({
                        title: 'Error',
                        message: 'Please Enter Valid Otp Sent To Your Mobile Number',
                        position:'topRight'
                    });
                });
            }
        }
    </script>
    


</body>

</html>