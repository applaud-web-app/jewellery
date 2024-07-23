

<div class="breadcumb-wrapper" >
    <div class="container z-index-common">
        <div class="breadcumb-content">
         
            <div class="breadcumb-menu-wrap">
                <ul class="breadcumb-menu">
                    <li><a href="{{url('/')}}">@yield('previous')</a></li>
                    <li class="active"><a href="{{url()->current(); }}">@yield('current')</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>