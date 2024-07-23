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
                            <h3>Log in to Printaboo</h3>
                            <p class="fs-5">Sign in with your mobile number</p>
                        </div>
                        <form action="/user-login" method="POST" class="form-style3">
                            @csrf
                            <div class="row justify-content-between">
                                <div class="col-md-12 form-group">
                                    <label>Mobile Number <span class="required">(*)</span></label>
                                    <input type="tel" class="form-control" name="number" placeholder="Enter Mobile Number" required>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label>Password <span class="required">(*)</span></label>
                                    <input type="password" name="password" class="form-control" placeholder="123456789" required>
                                </div>
                                <div class="col-auto align-self-center form-group">
                                    <input value="0" name="remember" type="checkbox" id="notice" name="notice">
                                    <label for="notice">Remember Me</label>
                                </div>
                                <div class="col-auto align-self-center form-group"><a href="#" class="forgot">Forget
                                        Password?</a></div>
                                <div class="col-md-12 form-group"><button class="vs-btn w-100" type="submit">Log
                                        In</button>
                                </div>
                                <div class="col-md-12 form-group">
                                    <h1 class="line">OR</h1>
                                    <a href="" class="social-use-btn  my-3">
                                        <img src="assets/frontend/img/google.png" alt="" class="img-fluid">
                                        <span class="ps-2">Login with Google</span>
                                    </a>
                                    <p class="text-center">First time here? <a href="/register">Create Account</a></p>
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
    <script>
        const notice = document.getElementById('notice');
        notice.addEventListener('change', e => {
        if(e.target.checked === true) {
           e.target.value = 1;
        }
        if(e.target.checked === false) {
            e.target.value = 0;
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