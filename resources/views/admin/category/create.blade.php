@extends('admin.master')
@section('title')
    Add Category
@endsection
@section('content')

<section class="content-body">
    <!-- row -->
    <div class="container-fluid">
        <div class="mb-sm-3 d-flex flex-wrap align-items-center text-head">
            <h2 class="mb-3 me-auto">Add Category</h2>
            <div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/dashboard/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/admin/categories/">Category</a></li>
                    <li class="breadcrumb-item active"><a href="/admin/categories/create">Add Category</a></li>
                </ol>
            </div>
        </div>
        <form action="{{url('admin/categories')}}" method="post" id="category_frm" name="category_frm" enctype="multipart/form-data">
            @csrf
            <div class="row">
                @include('messages')
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header ">
                            <h4 class="card-title fs-20 mb-0">Information </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-12 mb-3">
                                    <label class="category_image" for="category_image">Category Image <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="form-file">
                                            <input type="file" accept="image/*" data-id="1" onchange="loadFilePrev(event)" name="category_image" id="category_image" accept="image/*" class="form-file-input form-control" onchange="previewImage(this)" required>
                                        </div>
                                    </div>
                                    <div id="ci_err" class="text-danger"></div>
                                    <img src="" id="img_prev_1" alt="img" style="display:none;height:140px;width:auto;">
                                </div>
                                <div class="col-lg-12 col-md-12 col-12 mb-3">
                                    <div class="form-group">
                                        <label for="category_name">Category Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="category_name" id="category_name"  placeholder="Enter category name" required>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-12 mb-3">
                                    <div class="form-group">
                                        <label for="status">Status <span class="text-danger">*</span></label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="1">Active</option>
                                            <option value="2">De-Activated</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-lg-6 col-md-6 col-12 mb-3">
                                    <div class="form-check me-3 ">
                                        <input type="checkbox" class="form-check-input" name="is_child_category" id="is_child_category" value="1" >
                                        <label class="form-check-label" for="is_child_category">Add as subcategory</label>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12 col-12 mb-3" id="parent_category" style="display: none;">
                                    <div class="form-group">
                                        <label for="parent_id">Parent Category</label>
                                        <select name="parent_id" id="parent_id" class="form-control">
                                            @foreach ($categories as $item)
                                                <option value="{{$item->id}}">{{$item->cat_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                <div class="card h-auto">
                        <div class="card-header">
                            <h5 class="card-title">Category SEO </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-lg-12 col-12">
                                    <label for="meta_title">Meta Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="meta_title" name="meta_title"  placeholder="Enter meta title" required>
                                </div>
                                <div class="mb-3 col-lg-12 col-12">
                                    <label for="keyword">Meta Keywords <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Enter keyword" required>
                                </div>
                                <div class="mb-3 col-lg-12 col-12">
                                    <label for="description">Meta Description <span class="text-danger">*</span></label>
                                    <textarea style="height:100px" class="form-control" id="description" name="description" placeholder="Enter description" required></textarea>
                                </div>
                                <div class="mb-3 col-lg-12 col-12">
                                    <label for="feature_img">Featured Image <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="form-file">
                                            <input type="file" data-id="2" name="feature_img" id="feature_img" onchange="loadFilePrev(event)" class="form-file-input form-control" required>
                                        </div>
                                    </div>
                                    <img src="" id="img_prev_2" alt="img" style="display:none;height:210px;width:auto;">
                                    <div id="fi_err" class="text-danger"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 ">
                    <button type="submit" class="btn btn-primary  mb-2"><i class="far fa-check-square pe-2"></i>Submit</button>
                    <a href="{{url('admin/categories')}}" class="btn btn-dark  mb-2"><i class="far fa-window-close pe-2"></i>Cancel </a>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@push('scripts')
    <script src="{{asset('assets/admin/js/jquery.validate.min.js')}}"></script>
   
    <script>
        $(".niceselect").niceSelect();
    </script>
    <script> 
        $("#category_frm").validate({
            rules: {
            },
            messages: {},
            errorElement: 'div',
            errorPlacement: function(error, element) {
                if (element.attr("id") == "category_image") {
                   $("#ci_err").text('This field is required')
                }else if(element.attr("id") == "feature_img"){
                    $("#fi_err").text('This field is required')
                }else{
                    error.insertAfter(element);
                }
                
            },
            highlight: function(element, errorClass) {
                $(element).css({ border: '1px solid #f00' });
            },
            unhighlight: function(element, errorClass) {
                $(element).css({ border: '1px solid #c1c1c1' });
            },
            submitHandler: function(form,event) {
                document.category_frm.submit();
                $('button[type="submit"]').attr('disabled','disabled').text('Processing...');
            }
        });
    </script>
    <script>
        $("#is_child_category").on('click',function(){
            if($(this).is(":checked")){
                $("#parent_category").show();
                $("#parent_id").attr('required','required');
            }else{
                $("#parent_category").hide();
                $("#parent_id").removeAttr('required');
            }
        })
    </script>
@endpush
