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
    <link rel="stylesheet" href="{{asset('assets/frontend/css/iziToast.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/style.css')}}">
    @stack('styles')
</head>

<body>
    <div class="vs-menu-wrapper">
        <div class="vs-menu-area text-center"><button class="vs-menu-toggle"><i class="fal fa-times"></i></button>
            <div class="mobile-logo"><a href="/"><img src="{{asset('assets/frontend/img/logo.png')}}" alt="printaboo"
                        width="150px"></a></div>
            <div class="vs-mobile-menu">
                <ul>
                    <li><a href="/">Home </a></li>
                    <li><a href="/about-us">About Us</a></li>
                    <li><a href="/worksheet">Worksheets</a></li>
                    <li><a href="/blog">Blog</a></li>
                    <li><a href="/faq">FAQ</a></li>
                    <li><a href="/contact">Contact Us</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="popup-search-box d-none d-lg-block"><button class="searchClose"><i class="fal fa-times"></i></button>
        <form action="#"><input type="text" class="border-theme" placeholder="What are you looking for"> <button
                type="submit"><i class="fal fa-search"></i></button></form>
    </div>
    <header class="vs-header header-layout1">
        <div class="sticky-wrap">
            <div class="sticky-active">
                <div class="container">
                    <div class="row gx-3 align-items-center justify-content-between">
                        <div class="col-8 col-sm-auto">
                            <div class="header-logo"><a href="/"><img src="{{asset('assets/frontend/img/logo.png')}}" alt="logo"></a>
                            </div>
                        </div>
                        <div class="col text-end text-lg-center">
                            <nav class="main-menu menu-style1 d-none d-lg-block">
                                <ul>
                                    <li><a href="/">Home </a></li>
                                    <li><a href="/about-us">About Us</a></li>
                                    <li><a href="/worksheet">Worksheets</a></li>
                                    <li><a href="/blog">Blog</a></li>
                                    <li><a href="/faq">FAQ</a></li>
                                    <li><a href="/contact">Contact Us</a></li>
                                </ul>
                            </nav>
                            <button class="vs-menu-toggle d-inline-block d-lg-none"><i class="fal fa-bars"></i></button>
                        </div>
                        <div class="col-auto d-none d-lg-block">
                            <div class="header-icons"><a href="/wishlist" class="simple-icon "><span id="wishlist_items"></span><i class="fal fa-heart"></i></a>
                            </div>
                        </div>
                        <div class="col-auto d-none d-lg-block">
                            <div class="header-icons"><a href="/cart" class="simple-icon"><span id="cart_items"></span><i class="fal fa-cart-plus"></i></a></div>
                        </div>
                        @if (Auth::check())
                        <div class="col-auto d-none d-lg-block">
                            <div class="header-icons ">
                                <div class="dropdown">
                                <a class="simple-icon dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fal fa-user"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
                                    <li><a class="dropdown-item" href="/my-profile"><i class="fal fa-user-alt"></i> My Profile</a></li>
                                    <li><a class="dropdown-item" href="/change-password"><i class="fal fa-key"></i> Change Password</a></li>
                                    <li><a class="dropdown-item" href="/order-history"><i class="fal fa-history"></i> Order History</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="/logout"><i class="fal fa-sign-out"></i> Logout</a></li>
                                </ul>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="col-auto d-none d-xl-block"><a href="/login" class="vs-btn ">Login</a></div>
                        @endif
                        
                    </div>
                </div>
            </div>
        </div>
    </header>

    @yield('content')

    <footer class="footer-wrapper footer-layout1" data-bg-src="{{asset('assets/frontend/img/bg/footer-bg-1-1.png')}}">
    <div class="widget-area">
        <div class="container">
            <div class="row justify-content-center gx-60">
                <div class="col-lg-4">
                    <div class="widget footer-widget">
                        <div class="widget-about">
                            <a href="/"><img src="{{asset('assets/frontend/img/logo.png')}}" alt="logo" class="footer-logo img-fluid"
                                    width="200 mb-3"></a>
                            <p>We're committed to providing top-quality educational resources that inspire young minds
                                and empower educators.</p>
                            <p class="map-link"><img src="{{asset('assets/frontend/img/icon/map.svg')}}" alt="svg">First Floor, 10A
                                Chandos Street London New Town W1G 9LE</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="widget footer-widget">
                        <h3 class="widget_title">Get In Touch</h3>
                        <div>
                            <p class="footer-text">Monday to Friday: <span class="time">8.30am – 02.00pm</span></p>
                            <p class="footer-text">Saturday, Sunday: <span class="time">Close</span></p>
                            <p class="footer-info"><i class="fal fa-envelope"></i>Email: <a
                                    href="mailto:user@domainname.com">user@domainname.com</a></p>
                            <p class="footer-info"><i class="fas fa-mobile-alt"></i>Phone: <a
                                    href="tel:+4402076897888">+44 (0) 207 689 7888</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="widget widget_nav_menu footer-widget">
                        <h3 class="widget_title">Useful Services</h3>
                        <div class="menu-all-pages-container footer-menu">
                            <ul class="menu">
                                <li><a href="/">Home</a></li>
                                <li><a href="/about-us">About Us</a></li>
                                <li><a href="/worksheet">Worksheet</a></li>
                                <li><a href="/blog">Blog</a></li>
                                <li><a href="/contact">Contact</a></li>
                                <?php $pages = Common::showPage() ?>
                                @if ($pages != Null)
                                    @foreach ($pages as $page)
                                    <li><a href="/pages/{{$page->slug}}">{{$page->title}}</a></li>  
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright-wrap">
        <div class="container">
            <div class="row flex-row-reverse gy-3 justify-content-between align-items-center">
                <div class="col-lg-auto">
                    <div class="footer-social"><a href="#"><i class="fab fa-facebook-f"></i></a> <a href="#"><i
                                class="fab fa-twitter"></i></a> <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a></div>
                </div>
                <div class="col-lg-auto">
                    <p class="copyright-text">Copyright &copy; 2023 <a href="https://applaudwebmedia.com/">Applaud Web
                            Media</a>. All Rights
                        Reserved </p>
                </div>
            </div>
        </div>
    </div>
</footer><a href="#" class="scrollToTop scroll-btn"><i class="far fa-arrow-up"></i></a>
<script src="{{asset('assets/frontend/js/vendor/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/app.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/layerslider.utils.js')}}"></script>
<script src="{{asset('assets/frontend/js/layerslider.transitions.js')}}"></script>
<script src="{{asset('assets/frontend/js/layerslider.kreaturamedia.jquery.js')}}"></script>
<script src="{{asset('assets/frontend/js/iziToast.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/main.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function(){
        $.ajax({
            url:'{{ url("/view-cart")}}',
            type:'post',
            data: { _token: '{{csrf_token()}}'},
            dataType:'json',
            success:function(respond){
                if(respond.status == 1){
                    $('#cart_items').html(respond.cart_items);
                }else{
                    $('#cart_items').html(0);
                }
            }
        });
    });

    $(document).ready(function(){
        $.ajax({
            url:'{{ url("/view-wishlist")}}',
            type:'post',
            data: { _token: '{{csrf_token()}}'},
            dataType:'json',
            success:function(respond){
                if(respond.status == 1){
                    $('#wishlist_items').html(respond.wishlist_items);
                }else{
                    $('#wishlist_items').html(0);
                }
            }
        });
    });
</script>
@stack('scripts')
</body>
</html>