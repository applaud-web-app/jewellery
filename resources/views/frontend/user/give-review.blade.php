@extends('frontend.master')
@section('previous', 'Home')
@section('current', 'Give Review')
@section('content')
@include('breadcrumbs')
@include('messages')
<section class="content-body">
    <!-- row -->
    <div class="container my-5">
        <div class="row">
            <form action="/submit-review" method="POST">
                @csrf
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header ">
                            <h4 class="card-title fs-20 mb-0">Reviews</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-12 mb-3">
                                    <div class="form-group">
                                        <label for="product">Product Name</label>
                                        <input type="text" name="product" value="{{$productname->product_name}}" disabled readonly>
                                        <input type="hidden" name="pid" value="{{$productname->id}}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12 mb-3">
                                    <div class="form-group">
                                        <label for="rating">Rating</label>
                                    <select name="rating" id="" class="form-control">
                                            <option value="1"   @isset($review->rating)  {{$review->rating == 1 ? "selected" : ""}}  @endisset>Star ⭐</option>
                                            <option value="2"   @isset($review->rating)  {{$review->rating == 2 ? "selected" : ""}}  @endisset>Star ⭐⭐</option>
                                            <option value="3"   @isset($review->rating)  {{$review->rating == 3 ? "selected" : ""}}  @endisset>Star ⭐⭐⭐</option>
                                            <option value="4"   @isset($review->rating)  {{$review->rating == 4 ? "selected" : ""}}  @endisset>Star ⭐⭐⭐⭐</option>
                                            <option value="5"   @isset($review->rating)  {{$review->rating == 5 ? "selected" : ""}}  @endisset>Star ⭐⭐⭐⭐⭐</option>
                                    </select>
                                    </div>
                                </div>
                              
                                <div class="col-lg-12 col-md-12 col-12 mb-3">
                                    <div class="form-group">
                                        <label for="reviedescrip">Review Description</label>
                                        <textarea style="height:120px" class="form-control" name="description"
                                            placeholder="Enter Description">  @isset($review->description)  {{$review->description}}  @endisset</textarea>
                                    </div>
                                </div>                    
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 ">
                    <button type="submit" class="btn btn-primary  mb-2"><i
                            class="far fa-check-square pe-2"></i>Submit Review</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection