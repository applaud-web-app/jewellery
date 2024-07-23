@extends('frontend.master')
@section('previous', 'Home')
@section('current', 'My Profile')
@section('content')
@include('breadcrumbs')
<section class="space">
    @include('messages')
    <div class="container">
        <form action="/update-profile" enctype="multipart/form-data" method="post" class="form-style3">
            @csrf
            <div class="user-profile ">
                <div class="user-img ">
                    <img src="/uploads/user/{{$userDetails->image}}" alt="user" class="img-fluid img-thumbnail">
                </div>
                <div class="row align-items-center py-3 ">
                    <div class="col-lg-4 col-md-4 col-12">
                        <label for="formFile" class="form-label h6 mb-0">Profile Photo </label>
                        <span>Change Profile Photo</span>
                    </div>
                    <div class="col-lg-8 col-md-8 col-12">
                        <input type="file" name="profileImage" class="form-control" id="formFile">
                    </div>
                </div>
                <hr>
                <div class="row align-items-center py-3 ">
                    <div class="col-lg-4 col-md-4 col-12">
                        <label for="name" class="form-label h6 mb-0">Name <span class="text-danger">*</span></label>
                        <span>Your Full Name</span>
                    </div>
                    <div class="col-lg-8 col-md-8 col-12">
                        <input type="text" name="name" class="form-control" value="{{ucfirst(trans($userDetails->name))}}" id="name" placeholder="Enter Full Name" required>
                    </div>
                </div>
                <hr>
                <div class="row align-items-center py-3 ">
                    <div class="col-lg-4 col-md-4 col-12">
                        <label for="email" class="form-label h6 mb-0">Email <span class="text-danger">*</span></label>
                        <span>Email Address</span>
                    </div>
                    <div class="col-lg-8 col-md-8 col-12">
                        <input type="email" name="email" class="form-control" id="email" value="{{$userDetails->email}}" placeholder="Enter Email Address" required>
                    </div>
                </div>
                <hr>
                <div class="row align-items-center py-3 ">
                    <div class="col-lg-4 col-md-4 col-12">
                        <label for="mobilenumber" class="form-label h6 mb-0">Phone <span class="text-danger">*</span></label>
                        <span>Phone Number</span>
                    </div>
                    <div class="col-lg-8 col-md-8 col-12">
                        <input type="tel" name="number" class="form-control" value="{{$userDetails->number}}" id="mobilenumber" placeholder="Enter Phone number" required>
                    </div>
                </div>
                <hr>
                <div class="row align-items-center py-3 ">
                    <div class="col-lg-4 col-md-4 col-12">
                        <label for="address" class="form-label h6 mb-0">State & City <span class="text-danger">*</span></label>
                        <span>Your State & City</span>
                    </div>
                    <div class="col-lg-4 col-md-4 col-6">
                        <select name="state" class="form-control" id="state" required>
                            <option value="">Select State</option>
                            @foreach ($states as $item)
                                <option value="{{$item->id}}" {{$item->id == $userDetails->state ? "selected" :"" }}>{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4 col-md-4 col-6">
                        <select name="city" class="form-control" id="city" required>
                            <option value="">Please Select State First</option>
                            <input type="hidden" id="userCity" value="{{$userDetails->city ? $userDetails->city : 0}}">
                        </select>
                    </div>
                </div>
                <hr>
                <div class="row align-items-center py-3 ">
                    <div class="col-lg-4 col-md-4 col-12">
                        <label for="address" class="form-label h6 mb-0">Locality <span class="text-danger">*</span></label>
                        <span>Your Locality</span>
                    </div>
                    <div class="col-lg-8 col-md-8 col-12">
                        <textarea type="text" name="locality" class="form-control" id="locality"
                            placeholder="Enter Locality" required>{{$userDetails->locality}}</textarea>
                    </div>
                </div>
                <button type="submit" class="btn vs-btn mt-3">Update Profile</button>
            </div>
        </form>
    </div>
</section>

@push('scripts')

<script>
    $(document).ready(function(){
        $(document).on('change','#state',function loadcity(){
            $id = $(this).val();
            console.log($id);
            $user_city = $('#userCity').val();
            $.ajax({
                url:'/fetch-city',
                method:'post',
                data:{ _token: '{{csrf_token()}}', state: $id},
                dataType:'json',
                success:function(respond){
                    $htmlView = "<option value=''>Select City</option>";
                    if(respond['citys'].length > 0){
                        for(let i = 0; i < respond['citys'].length; i++){
                            $htmlView += `<option value="${respond['citys'][i].id}" ${$user_city == respond['citys'][i].id ? "selected" : "" }>${respond['citys'][i].name}</option>`;
                        }
                        $("#city").html($htmlView); 
                    }
                }
            });
        })
    });
</script>

@isset($userDetails->state)
<script>
    jQuery(function(){
        $('#state').change();
    });
</script>
@endisset



@endpush
@endsection