@extends('admin.master')
@section('title')
Edit Reviews
@endsection
@section('title')
Edit Reviews
@endsection
@section('content')
@push('styles')
<link rel="stylesheet" href="{{asset("assets/admin/vendor/sweetalert2/dist/sweetalert2.min.css")}}">
@endpush
<section class="content-body">
    <!-- row -->
    <div class="container-fluid">
        <div class="mb-sm-3 d-flex flex-wrap align-items-center text-head">
            <h2 class="mb-3 me-auto">Edit Reviews</h2>
            <div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                    <li class="breadcrumb-item"><a href="/admin/all-reviews">All Reviews</a></li>
                    <li class="breadcrumb-item active"><a href="{{url()->full()}}">Edit Reviews</a></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <form action="/admin/update-review" method="Post">
                @csrf
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header ">
                            <h4 class="card-title fs-20 mb-0">Reviews </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-12 mb-3">
                                    <div class="form-group">
                                        <label for="product">Product Name</label>
                                        <select name="product_name" id="product" class="form-control">
                                            @foreach ($products as $item)
                                            <option value="{{$item->id}}"
                                                {{ ($item->id == $review->product_id) ? "selected":""}}>
                                                {{$item->product_name}}</option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="id" value="{{$review->id}}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12 mb-3">
                                    <div class="form-group">
                                        <label for="rating">Rating</label>
                                        <select name="rating" id="rating" class="form-control">
                                            <option value="1" {{$review->rating == 1 ? "selected" : ""}}>Star ⭐</option>
                                            <option value="2" {{$review->rating == 2 ? "selected" : ""}}>Star ⭐⭐
                                            </option>
                                            <option value="3" {{$review->rating == 3 ? "selected" : ""}}>Star ⭐⭐⭐
                                            </option>
                                            <option value="4" {{$review->rating == 4 ? "selected" : ""}}>Star ⭐⭐⭐⭐
                                            </option>
                                            <option value="5" {{$review->rating == 5 ? "selected" : ""}}>Star ⭐⭐⭐⭐⭐
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12 mb-3">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="1" {{$review->approval == 1 ? "selected":""}}>Approved
                                            </option>
                                            <option value="0" {{$review->approval == 0 ? "selected":""}}>Unapproved
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-12 mb-3">
                                    <div class="form-group">
                                        <label for="description">Review Description</label>
                                        <textarea style="height:120px" class="form-control" name="description"
                                            id="description" placeholder="Enter ">{{$review->description}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 ">
                    <button type="submit" class="btn btn-primary  mb-2"><i
                            class="far fa-check-square pe-2"></i>Submit</button>
                    <button type="button" class="btn btn-dark  mb-2"><i class="far fa-window-close pe-2"></i>Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection