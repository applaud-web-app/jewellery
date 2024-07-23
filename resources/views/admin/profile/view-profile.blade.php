@extends('admin.master')
@section('title')
My Profile
@endsection
@section('content')
@push('styles')
<link type="text/css" rel="stylesheet"
    href="{{asset('assets/admin/vendor/ui-upload/jquery.plupload.queue/css/jquery.plupload.queue.css')}}" />
@endpush
<section class="content-body">
    <!-- row -->
    <div class="container-fluid">
        <div class="mb-sm-3 d-flex flex-wrap align-items-center text-head">
            <h2 class="mb-3 me-auto">My Profile</h2>
            <div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="/admin/profile">My Profile</a></li>
                </ol>
            </div>
        </div>
        <form action="{{url('admin/update-profile')}}" class="position-relative" id="product_frm" name="product_frm"
            method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header ">
                            <h4 class="card-title fs-20 mb-0">Personal Information </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @include('messages')
                                <div class="col-lg-4 mb-3">
                                    <img src="/uploads/user/{{$user->image}}" class="rounded-circle" height="100px" width="100px" alt="">
                                </div>
                                <div class="col-lg-12 col-md-12 col-12 mb-3">
                                    <div class="form-group">
                                        <label for="profile_image">Profile Image</label>
                                        <input type="file" value="" class="form-control"
                                            name="profile_image" id="profile_image" placeholder="Upload Your Profile Image">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12 mb-3">
                                    <div class="form-group">
                                        <label for="name">Name <span class="text-danger">*</span></label>
                                        <input type="text" value="{{$user->name}}" class="form-control"
                                            name="name" id="name" placeholder="Enter Name" required>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12 mb-3">
                                    <div class="form-group">
                                        <label for="email">Email <span class="text-danger">*</span></label>
                                        <input type="email" value="{{$user->email}}" class="form-control"
                                            name="email" id="email" placeholder="Enter Email" required>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12 mb-3">
                                    <div class="form-group">
                                        <label for="password">Update Password</label>
                                        <input type="password" value="" class="form-control"
                                            name="password" id="password" placeholder="Update Password">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12 mb-3">
                                    <div class="form-group">
                                        <label for="number">Number <span class="text-danger">*</span></label>
                                        <input type="number" value="{{$user->number}}" class="form-control"
                                            name="number" id="number" placeholder="Enter Number" required>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12 mb-3">
                                    <div class="form-group">
                                        <label for="name">State</label>
                                        <select class="form-control" name="state" id="state">
                                            <option value="">Select State</option>
                                            @foreach ($state as $item)
                                                <option value="{{$item->id}}" {{$item->id == $user->state ? "selected" : ""}}>{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12 mb-3">
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <select class="form-control" name="city" id="city">
                                            <option value="">Please Select State First</option>
                                            <input type="hidden" id="userCity" value="{{$user->city ?$user->city : 0 }}">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-12 mb-3">
                                    <div class="form-group">
                                        <label for="name">Locality</label>
                                        <textarea name="locality" id="locality" cols="30" rows="30" class="form-control" placeholder="Enter Locality">{{$user->locality}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 ">
                    <button type="submit" class="btn btn-primary  mb-2"><i
                            class="far fa-check-square pe-2"></i>Update Profile</button>
                    <a href="{{url('/admin/profile')}}" class="btn btn-dark  mb-2"><i
                            class="far fa-window-close pe-2"></i>Cancel</a>
                </div>
            </div>
        </form>
    </div>
</section>

@push('scripts')
<script>
    $(document).ready(function() {
        $(document).on('change', '#state', function loadcity() {
            $id = $(this).val();
            $user_city = $('#userCity').val();
            $.ajax({
                url: '/fetch-city',
                method: 'post',
                data: {
                    _token: '{{csrf_token()}}',
                    state: $id
                },
                dataType: 'json',
                success: function(respond) {
                    $htmlView = "<option value=''>Select City</option>";
                    if (respond['citys'].length > 0) {
                        for (let i = 0; i < respond['citys'].length; i++) {
                            $htmlView +=
                                `<option value="${respond['citys'][i].id}" ${$user_city == respond['citys'][i].id ? "selected" : "" }>${respond['citys'][i].name}</option>`;
                        }
                        $("#city").html($htmlView);
                    }
                }
            });
        })
    });
</script>
@isset($user->state)
<script>
    jQuery(function(){
        $('#state').change();
    });
</script>
@endisset
@endpush
@endsection