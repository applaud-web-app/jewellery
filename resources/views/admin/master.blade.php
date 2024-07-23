<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <meta name="robots" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="" />
    <!-- PAGE TITLE HERE -->
    <title>Printaboo - @yield('title')</title>
    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/admin/images/favicon.ico') }}" />
    <link href="{{ asset('assets/admin/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/responsive.css') }}" rel="stylesheet">
    @stack('styles')
</head>

<body>
    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="gooey">
            <span class="dot"></span>
            <div class="dots">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->
    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">
        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <a href="/admin/dashboard" class="brand-logo main-logo">
                <img src="{{asset('assets/admin/images/logo.png')}}" alt="" class="img-fluid">
            </a>
            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->

        <!--**********************************
            Header start
        ***********************************-->
        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            {{-- <div class="nav-item">
                                <div class="input-group search-area">
                                    <input type="text" class="form-control" placeholder="Search here">
                                    <span class="input-group-text"><a href="javascript:void(0)"><i
                                                class="flaticon-381-search-2"></i></a></span>
                                </div>
                            </div> --}}
                        </div>
                        <ul class="navbar-nav header-right">
                            <li class="nav-item dropdown  header-profile">
                                <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
                                    <img src="/uploads/user/{{Auth::user()->image}}" width="56" alt="" />
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="/admin/profile" class="dropdown-item ai-icon">
                                        <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary"
                                            width="18" height="18" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                        <span class="ms-2">Profile </span>
                                    </a>
                                    {{-- <a href="email-inbox.html" class="dropdown-item ai-icon">
                                        <svg id="icon-inbox" xmlns="http://www.w3.org/2000/svg" class="text-success"
                                            width="18" height="18" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path
                                                d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                            </path>
                                            <polyline points="22,6 12,13 2,6"></polyline>
                                        </svg>
                                        <span class="ms-2">Inbox </span>
                                    </a> --}}
                                    <a href="/admin/logout" class="dropdown-item ai-icon">
                                        <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger"
                                            width="18" height="18" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                            <polyline points="16 17 21 12 16 7"></polyline>
                                            <line x1="21" y1="12" x2="9" y2="12">
                                            </line>
                                        </svg>
                                        <span class="ms-2">Logout </span>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->
        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="deznav">
            <div class="deznav-scroll">
                <ul class="metismenu" id="menu">
                    <li><a class=" ai-icon" href="{{url('admin/dashboard')}}" aria-expanded="false">
                            <i class="flaticon-025-dashboard"></i>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                            <i class="flaticon-072-printer"></i>
                            <span class="nav-text">Order</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{url('admin/all-orders')}}">All Orders({{Common::orderCount()}})</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                            <i class="flaticon-072-printer"></i>
                            <span class="nav-text">Products</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{url('admin/quoatation')}}">All Products({{Common::productCount()}})</a></li>
                            <li><a href="{{url('admin/categories')}}">Categories ({{Common::categoryCount()}})</a></li>
                        </ul>
                    </li>
                    {{-- <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                            <i class="flaticon-072-printer"></i>
                            <span class="nav-text">Analytics</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="sales.php">Sales</a></li>
                            <li><a href="traffic.php">Traffic</a></li>
                            <li><a href="products.php">Products</a></li>
                        </ul>
                    </li> --}}
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="flaticon-072-printer"></i>
                        <span class="nav-text">Blogs</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{url('admin/all-blogs')}}">All Blogs</a></li>
                        <li><a href="{{url('admin/create-blog')}}">Add Blog</a></li>
                        <li><a href="{{url('admin/all-blog-category')}}">Blog Category</a></li>
                    </ul>
                    </li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="flaticon-072-printer"></i>
                        <span class="nav-text">Pages</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{url('admin/all-pages')}}">All Pages</a></li>
                        <li><a href="{{url('admin/add-page')}}">Add Pages</a></li>
                    </ul>
                    </li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="flaticon-072-printer"></i>
                        <span class="nav-text">FAQ</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{url('admin/all-faq')}}">All FAQ</a></li>
                        <li><a href="{{url('admin/add-faq')}}">Add FAQ</a></li>
                    </ul>
                    </li>
                    <li><a class="ai-icon" href="{{url('admin/all-enquiry')}}" aria-expanded="false">
                        <i class="flaticon-050-info"></i>
                        <span class="nav-text">Enquiry</span>
                    </a>
                    </li>
                    {{-- <li><a class="ai-icon" href="payouts.php" aria-expanded="false">
                            <i class="flaticon-050-info"></i>
                            <span class="nav-text">Payouts</span>
                        </a>
                    </li> --}}
                    <li><a class="ai-icon" href="{{route('product-discounts')}}" aria-expanded="false">
                            <i class="flaticon-041-graph"></i>
                            <span class="nav-text">Discounts</span>
                        </a>
                    </li>
                    {{-- <li><a class="ai-icon" href="audience.php" aria-expanded="false">
                            <i class="flaticon-013-checkmark"></i>
                            <span class="nav-text">Audience</span>
                        </a>
                    </li> --}}

                    <li><a class="ai-icon" href="/admin/customer" aria-expanded="false">
                            <i class="flaticon-381-user-9"></i>
                            <span class="nav-text">Customers</span>
                        </a>
                    </li>
                    <li><a href="{{url('admin/all-reviews')}}" class="ai-icon" aria-expanded="false">
                            <i class="flaticon-013-checkmark"></i>
                            <span class="nav-text">Reviews</span>
                        </a>
                    </li>

                    <!-- <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                            <i class="flaticon-043-menu"></i>
                            <span class="nav-text">Table</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="table-bootstrap-basic.html">Bootstrap</a></li>
                            <li><a href="table-datatable-basic.html">Datatable</a></li>
                        </ul>
                    </li> -->

                </ul>
                <div class="plus-box">
                    <img src="{{asset('assets/admin/images/plus.png')}}" alt="">
                    <h5 class="fs-18 font-w700">15.7</h5>
                    <p class="fs-14 font-w400">Available Credits<i class="fas fa-arrow-right ms-3"></i></p>
                </div>

            </div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->

        @yield('content')



        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
                <p>Copyright © Designed &amp; Developed by <a href="https://applaudwebmedia.com/"
                        target="_blank">Applaud Web Media</a> 2023</p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->
    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="{{ asset('assets/admin/vendor/global/global.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/deznav-init.js') }}"></script>
        {{-- <script src="js/demo.js"></script>
        <script src="js/script.js"></script> --}}
        <script src="{{ asset('assets/admin/js/custom.min.js') }}"></script>
        @stack('scripts')
</body>

</html>
