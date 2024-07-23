@extends('admin.master')
@section('title')
All Reviews
@endsection
@section('title')
All Reviews
@endsection
@section('content')
@push('styles')
<link rel="stylesheet" href="{{asset("assets/admin/vendor/sweetalert2/dist/sweetalert2.min.css")}}">
@endpush
<section class="content-body">
    <!-- row -->
    <div class="container-fluid">
        <div class="mb-sm-3 d-flex flex-wrap align-items-center text-head">
            <h2 class="mb-3 me-auto">Add Reviews</h2>
            <div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                    <li class="breadcrumb-item"><a href="/admin/all-reviews">All Reviews</a></li>
                    <li class="breadcrumb-item active"><a href="/admin/create-reviews">Add Reviews</a></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <form action="/admin/add-review" method="POST">
                @csrf
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header ">
                            <h4 class="card-title fs-20 mb-0">Reviews</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-12 mb-3">
                                    <div class="form-group">
                                        <label for="product">Product Name</label>
                                    <select name="product_name" id="" class="form-control" required>
                                        <option value="">Select Product</option>
                                        @foreach ($products as $item)
                                        <option value="{{$item->id}}">{{$item->product_name}}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12 mb-3">
                                    <div class="form-group">
                                        <label for="rating">Rating</label>
                                    <select name="rating" id="" class="form-control">
                                            <option value="1">Star ⭐</option>
                                            <option value="2">Star ⭐⭐</option>
                                            <option value="3">Star ⭐⭐⭐</option>
                                            <option value="4">Star ⭐⭐⭐⭐</option>
                                            <option value="5">Star ⭐⭐⭐⭐⭐</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12 mb-3">
                                    <div class="form-group">
                                        <label for="rating">Status</label>
                                    <select name="status" id="" class="form-control">
                                            <option value="1" selected>Approved</option>
                                            <option value="0">Unapproved</option>                                     
                                    </select>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-12 mb-3">
                                    <div class="form-group">
                                        <label for="reviedescrip">Review Description</label>
                                        <textarea style="height:120px" class="form-control" name="description"
                                            placeholder="Enter Description"></textarea>
                                    </div>
                                </div>                    
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 ">
                    <button type="submit" class="btn btn-primary  mb-2"><i
                            class="far fa-check-square pe-2"></i>Submit</button>
                    <button type="button" class="btn btn-dark  mb-2"><i
                            class="far fa-window-close pe-2"></i>Cancel </button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection