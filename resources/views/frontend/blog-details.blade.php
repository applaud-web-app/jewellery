@extends('frontend.master')
@section('previous', 'Home')
@section('current', isset($blog->title) ? $blog->title : '')
@section('content')
@include('breadcrumbs')
<section class="vs-blog-wrapper blog-details space-top space-extra-bottom">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="vs-blog blog-single">
                    <div class="blog-img"><img class=" w-100" src="/uploads/blog/{{$blog->image}}" alt="Blog Image"></div>
                    <div class="blog-content">
                        <div class="blog-meta"><a href="blog.html"><i class="far fa-calendar-alt"></i>{{date("d M, Y",strtotime($blog->created_at))}}</a> <span><i class="far fa-comment-alt-dots"></i>{{$blog->blogcatgeory->name}}</span></div>
                        <h2 class="blog-title">{{$blog->title}}</h2>
                        <div>
                            {!! $blog->description!!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection