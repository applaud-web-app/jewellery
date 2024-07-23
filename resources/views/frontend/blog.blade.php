@extends('frontend.master')
@section('previous', 'Home')
@section('current', 'All Blog')
@section('content')
@include('breadcrumbs')

<section class="vs-blog-wrapper space-top space-extra-bottom">
    <div class="container">
        <div class="title-area text-center">
            <h2 class="sec-title">Categories</h2>
        </div>
    <div class="bg_category_wrapper">
        @foreach ($blogcategory as $blogcat)
           <a href="/blog/{{$blogcat->id}}" class="{{request('id') == $blogcat->id ? "active" : ""}} btn categorybtn" data-id="{{$blogcat->id}}">{{$blogcat->name}}</a>
        @endforeach
    </div>
    <div class="row">
        @if (count($blogs) > 0)
            @foreach ($blogs as $blog)
                <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                    <div class="vs-blog blog-style1">
                        <div class="blog-img"><img src="/uploads/blog/{{$blog->image}}" alt="Blog Thumbnail" class="w-100">
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta mb-1"><a href="blog.html"><i class="far fa-calendar-alt"></i>09 Nov, 2023</a> <span><i class="far fa-comment-alt-dots"></i>{{$blog->blogcatgeory->name}}</span></div>
                            <h3 class="blog-title h5"><a href="/blog-details/{{$blog->id}}">{{$blog->title}}</a></h3>
                            <div class="blog-text blog-content_desc">{!! substr($blog->description,0,145) !!}</div>
                            <a href="/blog-details/{{$blog->id}}" class="blog-btn">Read More<i class="far fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>                
            @endforeach
        @else
        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
            <div class="text-center">
                <img src="/assets/frontend/img/no-record.jpg" class="img-fluid" style="width:320px;" alt="">
                <h5 class="text-danger mb-0">No Blogs Found</h5>
            </div>
        </div>
        @endif
       
    </div>
    <div class="vs-pagination">
        {{$blogs->appends(request()->input())->links('frontend.frontendpagination')}}
    </div>
</section>
@endsection