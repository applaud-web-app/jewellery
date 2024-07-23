<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <meta name="robots" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quiz Admin</title>
    <link rel="shortcut icon" type="image/png" href="" />
    <link href="{{ asset('assets/admin/css/style.css') }}" rel="stylesheet">
</head>

<body class="vh-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                           
                            <div class="col-xl-12">
                                @if(Session::has('error_msg'))
                                    <div class="alert alert-danger alert-dismissible fade show mt-4 mx-3" role="alert">
                                        {!!Session::get("error_msg")!!}
                                    </div>
                                @endif
                                <div class="auth-form">

                                    <div class="text-center">
                                        <a href="javascript:void(0);"><img src="{{ asset('assets/admin/images/logo.png') }}" alt="no-data"></a>
                                    </div>
                                    <h4 class="text-center fs-30 mb-4">Sign in your account</h4>
                                    <form action="{{route('admin.auth.check')}}" autocomplete="off" method="post"
                                        id="login_frm">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="mb-1"><strong>Email</strong></label>
                                            <input type="email" class="form-control" name="email"
                                                placeholder="Your Email" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="mb-1"><strong>Password</strong></label>
                                            <input type="password" class="form-control" placeholder="Your Password"
                                                name="password" required>
                                        </div>
                                        <div class="row d-flex justify-content-between mt-4 mb-2">
                                            
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" id="sub_btn" class="btn btn-primary btn-block">Sign Me In</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Required vendors -->
    <script src="{{ asset('assets/admin/vendor/global/global.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/custom.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/deznav-init.js') }}"></script>
    <script>
        document.getElementById("login_frm").addEventListener('submit', function() {
            document.getElementById("sub_btn").setAttribute('disabled', 'disabled');
            document.getElementById("sub_btn").innerText = 'Processing...';
        });
    </script>
</body>

</html>
