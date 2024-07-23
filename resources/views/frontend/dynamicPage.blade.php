@extends('frontend.master')
@section('content')
@section('previous', 'Home')
@section('current', isset($pages->title) ? $pages->title : '')
@section('content')
@include('breadcrumbs')
<section class="space">
    <div class="container">
        <div class="title-area">
            <h2 class="sec-title">{{$pages->title}}</h2>
        </div>
        <div class="page-content">
            {!! $pages->description !!}
        </div>
    </div>
</section>
@endsection