@extends('admin.master')
@section('title')
    Edit Customer Profile
@endsection
@section('content')

<section class="content-body">
    <!-- row -->
    <div class="container-fluid">
        <div class="mb-sm-3 d-flex flex-wrap align-items-center text-head">
            <h2 class="mb-3 me-auto">Edit Customer Profile</h2>
            <div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/dashboard/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/admin/customer/">Customer</a></li>
                    <li class="breadcrumb-item active"><a href="{{url()->full()}}">Edit Customer Profile</a></li>
                </ol>
            </div>
        </div>
        <form action="/admin/update-customer" method="post" id="category_frm" name="category_frm" enctype="multipart/form-data">
            @csrf
            <div class="row">
                @include('messages')
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header ">
                            <h4 class="card-title fs-20 mb-0">Customer Information </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-12 mb-3">
                                    <label class="profile_image" for="profile_image">Customer Profile Image</label>
                                    <div class="input-group">
                                        <div class="form-file">
                                            <input type="file" accept="image/*" data-id="1" onchange="loadFilePrev(event)" name="profile_image" id="profile_image" accept="image/*" class="form-file-input form-control" onchange="previewImage(this)">
                                        </div>
                                    </div>
                                    <div id="ci_err" class="text-danger"></div>
                                    <img src="/uploads/user/{{$customer->image}}" id="img_prev_1" alt="img" style="height:140px;width:auto;">
                                </div>
                                <div class="col-lg-12 col-md-12 col-12 mb-3">
                                    <div class="form-group">
                                        <label for="name">Customer Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name" id="name" value="{{$customer->name}}"  placeholder="Enter Customer name" required>
                                        <input type="hidden" name="cid" value="{{$customer->id}}">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-12 mb-3">
                                    <div class="form-group">
                                        <label for="email">Customer Email <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="email" id="email" value="{{$customer->email}}"  placeholder="Enter Customer email" required>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-12 mb-3">
                                    <div class="form-group">
                                        <label for="number">Customer Number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="number" id="number" value="{{$customer->number}}"  placeholder="Enter Customer number" required>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-12 mb-3">
                                    <div class="form-group">
                                        <label for="status">Status <span class="text-danger">*</span></label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="1" {{$customer->status==1 ? 'selected': ''}}>Active</option>
                                            <option value="0" {{$customer->status==0 ? 'selected': ''}}>De-Activated</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 ">
                    <button type="submit" class="btn btn-primary  mb-2"><i class="far fa-check-square pe-2"></i>Submit</button>
                    <a href="{{url('admin/customer')}}" class="btn btn-dark  mb-2"><i class="far fa-window-close pe-2"></i>Cancel</a>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
