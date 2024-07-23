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
    @include('messages')
    <!-- row -->
    <div class="container-fluid">
        <div class="mb-sm-3 d-flex flex-wrap align-items-center text-head">
            <h2 class="mb-3 me-auto">All Reviews</h2>
            <div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                    <li class="breadcrumb-item"><a href="/admin/all-reviews">All Reviews</a></li>
                </ol>
            </div>
        </div>
        <div class="card">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div class="mb-sm-0 mb-3">
                        <div class="card-action coin-tabs mt-3 mt-sm-0">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link navTab active" data-bs-toggle="tab" data-id="" href="#AllReviews"
                                        role="tab" aria-selected="false">All</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link navTab" data-bs-toggle="tab" data-id="0" href="#Unpublished"
                                        role="tab" aria-selected="false">Unpublished</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link navTab" data-bs-toggle="tab" data-id="1" href="#Published"
                                        role="tab" aria-selected="false">Published</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="d-flex align-items-center flex-wrap">
                        <a href="/admin/create-reviews" class="btn btn-primary  me-3 mb-2"><i
                                class="fas fa-plus pe-2"></i>Add
                            New</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="customer-search mb-sm-0 mb-3">
                            <div class="input-group search-area">
                                <input type="text" class="form-control" placeholder="Search here......"
                                    id="searchReviews">
                                <span class="input-group-text" id="search"><a href="javascript:void(0)"><i
                                            class="flaticon-381-search-2"></i></a></span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center flex-wrap">
                            <div class="me-3">
                                <select name="" id="rating" class="form-control form-select ">
                                    <option value="">All Ratings</option>
                                    <option value="1">Rating 1</option>
                                    <option value="2">Rating 2</option>
                                    <option value="3">Rating 3</option>
                                    <option value="4">Rating 4</option>
                                    <option value="5">Rating 5</option>
                                </select>
                            </div>
                            <div class="me-3">
                                <select name="" id="time_period" class="form-control form-select ">
                                    <option value="">Select Time Period</option>
                                    <option value="0">Last 10 Days</option>
                                    <option value="1">Last 30 Days</option>
                                    <option value="2">3 Months</option>
                                    <option value="3">2 Months</option>
                                </select>
                            </div>
                            <div class="me-3">
                                <select name="" id="bulk_action" class="form-control form-select ">
                                    <option value="">Bulk Action</option>
                                    <option value="1">Approved</option>
                                    <option value="0">Unapproved</option>
                                    <option value="2">Delete</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <div class="table-responsive">
                            <table id="example5" class="display table" style="min-width: 100%">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="form-check custom-checkbox ms-2">
                                                <input type="checkbox" class="form-check-input" id="checkAll"
                                                    required="">
                                                <label class="form-check-label" for="checkAll"></label>
                                            </div>
                                        </th>
                                        <th>Review/Ratings</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="review">
                                    @foreach ($reviews as $item)
                                    <tr>
                                        <td class="vertical-top">
                                            <div class="form-check custom-checkbox ms-2">
                                                <input type="checkbox" class="form-check-input review_id"
                                                    value="{{$item->id}}" id="customCheckBox{{$item->id}}" required="">
                                                <label class="form-check-label" for="customCheckBox2"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <h5 class=" text-black  mb-1">{{substr($item->description,0,70)}}...
                                                    <span class="rating">
                                                        @for ($i = 0; $i < $item->rating; $i++)
                                                            <i class="fa fa-star text-warning"></i>
                                                            @endfor
                                                            @for ($i = (5 - $item->rating); $i > 0; $i--)
                                                            <i class="fa fa-star"></i>
                                                            @endfor
                                                    </span></h5>

                                                <p class="text-muted mb-1">by {{$item->review_user->name}} on <span
                                                        class="text-primary">{{$item->review_product->product_name}}</span>
                                                </p>

                                                <a href="/admin/update-status/{{$item->id}}"
                                                    class="btn btn-outline-primary btn-xs update_status"><i
                                                        class="fab fa-telegram-plane"></i>
                                                    {{$item->approval == 1 ? "Unpublish" : "Publish"}}</a>

                                                <a href="/admin/review-edit/{{$item->id}}"
                                                    class="btn btn-outline-warning btn-xs"><i class="fas fa-reply"></i>
                                                    Edit</a>

                                                <a href="/admin/review-delete/{{$item->id}}"
                                                    class="btn btn-outline-danger btn-xs delete_reviews"><i
                                                        class="fas fa-trash-alt"></i> Delete</a>
                                            </div>
                                        </td>
                                        <td class="wspace-no">{{date("d M, Y",strtotime($item->created_at))}}</td>

                                        <td>
                                            <span class=" {{$item->approval == 1 ? "text-primary" : "text-danger"}}">
                                                <i class="fa fa-circle {{$item->approval == 1 ? "text-primary" : "text-danger"}}  me-1"></i>
                                                {{$item->approval == 1 ? "Approved" : "Unapproved"}}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="w-100 mt-3 num_pagination">
                                {{$reviews->appends(request()->input())->links('pagination')}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="{{asset('assets/admin/vendor/sweetalert2/dist/sweetalert2.min.js')}}"></script>
<script>
    $(document).on('click', '.delete_reviews', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete this item",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value == true) {
                window.location = $(this).attr('href');
            } else {
                return false;
            }
        });
    })
</script>
<script>
    $(document).on('click', '.update_status', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to make changes?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value == true) {
                window.location = $(this).attr('href');
            } else {
                return false;
            }
        });
    })
</script>
<script>
    function filterReviews() {
        $search = $('#searchReviews').val();
        $timePeriod = $('#time_period').val();
        $rating = $('#rating').val();
        $tab = $('.navTab.active').data('id');
        $.ajax({
            url: '{{ url("/admin/filter-reviews")}}',
            type: 'post',
            data: {
                _token: '{{csrf_token()}}',
                search: $search,
                timePeriod: $timePeriod,
                rating: $rating,
                tab: $tab
            },
            success: function(respond) {
                console.log(respond);
                if(respond['reviews'].length > 0){
                    $htmlView = "";
                    for(let i = 0; i < respond['reviews'].length; i++){
                        console.log(respond['reviews']);
                        $htmlView += `<tr>
                            <td class="vertical-top">
                                <div class="form-check custom-checkbox ms-2">
                                    <input type="checkbox" class="form-check-input review_id"
                                        value="${respond['reviews'][i].id}" id="customCheckBox${respond['reviews'][i].id}" required="">
                                    <label class="form-check-label" for="customCheckBox2"></label>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <h5 class=" text-black  mb-1">${respond['reviews'][i].description}...
                                        <span class="rating">
                                            ${respond['reviews'][i].rating}
                                        </span></h5>

                                    <p class="text-muted mb-1">by  ${respond['reviews'][i].review_user.name} on <span
                                            class="text-primary">${respond['reviews'][i].review_product.product_name}</span>
                                    </p>

                                    <a href="/admin/update-status/${respond['reviews'][i].id}"
                                        class="btn btn-outline-primary btn-xs update_status"><i
                                            class="fab fa-telegram-plane"></i>
                                        ${respond['reviews'][i].approval == 1 ? "Unpublish" : "Publish"}</a>

                                    <a href="/admin/review-edit/${respond['reviews'][i].id}"
                                        class="btn btn-outline-warning btn-xs"><i class="fas fa-reply"></i>
                                        Edit</a>

                                    <a href="/admin/review-delete/${respond['reviews'][i].id}"
                                        class="btn btn-outline-danger btn-xs delete_reviews"><i
                                            class="fas fa-trash-alt"></i> Delete</a>
                                </div>
                            </td>
                            <td class="wspace-no">${respond['reviews'][i].created_at}</td>

                            <td>
                                <span class=" ${respond['reviews'][i].approval == 1 ? "text-primary" : "text-danger"} ">
                                    <i
                                        class="fa fa-circle ${respond['reviews'][i].approval == 1 ? "text-primary" : "text-danger"}  me-1"></i>
                                        ${respond['reviews'][i].approval == 1 ? "Approved" : "Unapproved"}
                                </span>
                            </td>
                        </tr>`;
                    }
                    $("#review").html($htmlView);   
                }else{
                    $("#review").html(`<div class="col-md-12 col-lg-12 col-xl-12 w-100">
                    <div class="text-center">
                        <img src="/assets/frontend/img/no-record.jpg" class="img-fluid" style="width:320px;" alt="">
                        <h5 class="text-danger mb-0">No Review Found</h5>
                    </div>
                </div>`);
                }
            }
        });
    }

    $('#time_period').change(filterReviews);
    $('#rating').change(filterReviews);
    $('#search').click(filterReviews);
    $('.navTab').click(filterReviews);

    
    $("#bulk_action").on('change', function() {
        var action = $(this).val();
        var cat_id = [];
        $('.review_id').each(function() {
            $id = $(this).val();
            if ($(this).prop('checked') == true) {
                if ($.inArray($id, cat_id) === -1) {
                    cat_id.push($id);
                }
            } else {
                if ($.inArray($id, cat_id) !== -1) {
                    cat_id.splice($.inArray($id, cat_id), 1);
                }
            }
        });
        if (action != null && (cat_id.length > 0)) {
            console.log(action);
            console.log(cat_id);
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to make changes?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.value == true) {
                    $.ajax({
                        url: '{{ url("/admin/review-bulk-action")}}',
                        type: 'post',
                        data: {
                            _token: '{{csrf_token()}}',
                            action: action,
                            id: JSON.stringify(cat_id),
                        },
                        success: function(respond) {
                            iziToast.success({
                                title: 'Success',
                                message: respond.message,
                                position: 'topRight'
                            });
                        }
                    });
                    setTimeout(function() {
                        window.location.href = "{{url('admin/all-reviews')}}";
                    }, 1000);
                }else{
                    $("#bulk_action").val($("#bulk_action option:first").val());
                }
            })
        } else {
            $("#bulk_action").val($("#bulk_action option:first").val());
            iziToast.error({
                title: 'error',
                message: 'Item\'s Not Selected',
                position: 'topRight'
            });
        }
    });
</script>
@endpush