@extends('admin.master')
@section('title')
    Edit Product
@endsection
@section('content')
@push('styles')
<link type="text/css" rel="stylesheet" href="{{asset('assets/admin/vendor/ui-upload/jquery.plupload.queue/css/jquery.plupload.queue.css')}}"/>
<style>
    .plupload_button.plupload_start{
        display: none;
    }
</style>
<link rel="stylesheet" href="{{asset("assets/admin/vendor/sweetalert2/dist/sweetalert2.min.css")}}">
@endpush

    @php
        $digitalFiles = $productData->product_files!=null ? json_decode($productData->product_files,true) : [];
        $demoFiles = $productData->product_demo_files!=null ? json_decode($productData->product_demo_files,true) : [];
        $mediaFiles = $productData->product_media!=null ? json_decode($productData->product_media,true) : [];
    @endphp

    <section class="content-body">
        <!-- row -->
        <div class="container-fluid">
            <div class="mb-sm-3 d-flex flex-wrap align-items-center text-head">
                <h2 class="mb-3 me-auto">Add Product</h2>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                        <li class="breadcrumb-item"><a href="/admin/all-products">All Product</a></li>
                        <li class="breadcrumb-item active"><a href="{{url()->full()}}">Edit Product</a></li>
                    </ol>
                </div>
            </div>
            <form action="{{$encLink}}" class="position-relative" id="product_frm" name="product_frm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header ">
                                <h4 class="card-title fs-20 mb-0">Information </h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @include('messages')

                                    <div class="col-lg-6 col-md-6 col-12 mb-3">
                                        <div class="form-group">
                                            <label for="product_name">Product Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="product_name" id="product_name" placeholder="Enter Product name" value="{{$productData->product_name}}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12 mb-3">
                                        <div class="form-group">
                                            <label for="category_id">Product Category <span class="text-danger">*</span></label>
                                            @php
                                                $catTree = count($categories) ? Common::buildTree($categories) : [];
                                            @endphp
                                            <select name="category_id" id="category_id" class="form-control" required>
                                                <option value="">Select Category</option>
                                                {{Common::printTree($catTree,0,null,$productData->category_id)}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12 mb-3">
                                        <div class="form-group">
                                            <label for="price">Price(₹) <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="price" id="price" placeholder="Enter price" value="{{$productData->price + 0}}" onkeypress="return isNumberKey(event,this)" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12 mb-3">
                                        <div class="form-group">
                                            <label for="discount_price">Discount Price(₹) <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="discount_price" id="discount_price" value="{{$productData->discount_price + 0}}" onkeypress="return isNumberKey(event,this)" placeholder="Enter discount price" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-12 mb-3">
                                        <div class="form-group">
                                            <label for="content"> Description <span class="text-danger">*</span></label>
                                            <textarea name="description" id="content" class="my_tinyeditor" style="height: 400px;">{!!$productData->description!!}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-12 mb-3">
                                        <div class="form-group">
                                            <label for="featured_product">Featured Product <span class="text-danger">*</span></label>
                                            <select name="featured_product" id="featured_product" class="form-control" required>
                                                <option value="1" {{$productData->feature_product == 1 ? "selected" : ""}}>Yes</option>
                                                <option value="0" {{$productData->feature_product == 0 ? "selected" : ""}}>No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header ">
                                <h4 class="card-title fs-20 mb-0">Digital Product File <span class="text-danger">*</span></h4>
                            </div>
                            <div class="card-body">
                                
                                <div class="col-lg-12 col-md-12 col-12">
                                    <div id="uploader_orig" class="mb-3">
                                    </div>
                                    <input type="hidden" id="uploaded-docs_orig" name="uploaded_file_str_orig">
                                </div>

                                <div class="mt-3 d-flex">
                                    @foreach ($digitalFiles as $item)
                                        <div class="m-1 p-2 border">
                                                <a class="text-success me-3" href="{{url('admin/preview-product-image/'.$item)}}" target="_blank">{{$item}}</a><i class="fas fa-trash-alt remove_files text-danger" data-id="{{url('admin/remove-digital-file?id='.$productData->id.'&file='.$item)}}" style="cursor: pointer;"></i>
                                        </div>  
                                    @endforeach
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header ">
                                <h4 class="card-title fs-20 mb-0">Sample Product File </h4>
                            </div>
                            <div class="card-body">
                                <div class="col-lg-12 col-md-12 col-12">
                                    <div id="uploader_sample" class="mb-3">
                                    </div>
                                    <input type="hidden" id="uploaded-docs_sample" name="uploaded_file_str_sample">
                                </div>
                                <div class="mt-3 d-flex">
                                    @foreach ($demoFiles as $item)
                                        <div class="m-1 p-2 border">
                                            <a class="text-success me-3" href="{{asset("uploads/product_images/samples/".$item)}}" target="_blank">{{$item}}</a><i class="fas fa-trash-alt remove_files text-danger" data-id="{{url('admin/remove-demo-file?id='.$productData->id.'&file='.$item)}}" style="cursor: pointer;"></i>
                                        </div>  
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header ">
                                <h4 class="card-title fs-20 mb-0">Product Media </h4>
                            </div>
                            <div class="card-body">
                                <div class="mb-3 col-lg-12 col-12">
                                    <label for="product_fetaure_img">Featured Image <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="form-file">
                                            <input type="file" data-id="2" name="product_fetaure_img" id="product_fetaure_img"  onchange="loadFilePrev(event)"  class="form-file-input form-control" required>
                                        </div>
                                    </div>
                                    <img src="/uploads/product_images/product_feature_image/{{$productData->product_fetaure_img}}" id="img_prev_2" alt="img" style="height:210px;width:auto;">
                                </div>
                                <div class="col-lg-12 col-md-12 col-12">
                                    <div id="uploader" class="mb-3">
                                    </div>
                                    <input type="hidden" id="uploaded-docs" name="uploaded_file_str">
                                </div>
                                <em class="text-primary d-block mt-2">Note: Recommended file size : 1000 X 1000</em>
                                <div class="mt-3 d-flex">
                                    @foreach ($mediaFiles as $item)
                                        <div class="m-1 p-2 border">
                                            <a class="text-success me-3" href="{{asset("uploads/product_images/media/".$item)}}" target="_blank">{{$item}}</a><i class="fas fa-trash-alt remove_files text-danger" data-id="{{url('admin/remove-media-file?id='.$productData->id.'&file='.$item)}}" style="cursor: pointer;"></i>
                                        </div>  
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                   

                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="card h-auto">
                            <div class="card-header">
                                <h5 class="card-title">Product SEO</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="mb-3 col-lg-12 col-12">
                                        <label for="meta_title">Meta Title <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="meta_title" name="meta_title" placeholder="Enter meta title" value="@isset($productData->product_seo->meta_title) {{$productData->product_seo->meta_title}}@endisset" required>
                                    </div>
                                   
                                    <div class="mb-3 col-lg-12 col-12">
                                        <label for="keyword">Meta Keywords <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Enter keyword" value="@isset($productData->product_seo->meta_keywords) {{$productData->product_seo->meta_keywords}}@endisset" required>
                                    </div>
                                    
                                    <div class="mb-3 col-lg-12 col-12">
                                        <label for="description">Meta Description <span class="text-danger">*</span></label>
                                        <textarea style="height:100px" class="form-control" id="description" name="description" placeholder="Enter description" required>@isset($productData->product_seo->meta_description) {{$productData->product_seo->meta_description}}@endisset</textarea>
                                    </div>
                                    <div class="mb-3 col-lg-12 col-12">
                                        <label for="feature_image">Featured Image <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="form-file">
                                                <input type="file" data-id="2" name="feature_image" id="feature_image"  onchange="loadFilePrev(event)"  class="form-file-input form-control">
                                            </div>
                                        </div>
                                        @isset($productData->product_seo->meta_description) 
                                        <img src="{{asset('uploads/product_images/feature_image/'.$productData->product_seo->feature_image)}}" id="img_prev_2" alt="img" style="height:210px;width:auto;">
                                        @endisset
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 ">
                        <button type="submit" class="btn btn-primary  mb-2"><i
                                class="far fa-check-square pe-2"></i>Submit</button>
                            <a href="{{url('admin/all-products')}}" class="btn btn-dark  mb-2"><i class="far fa-window-close pe-2"></i>Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
<script src="{{asset('assets/admin/vendor/tinymce/tinymce.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/vendor/ui-upload/plupload.full.min.js')}}" charset="UTF-8"></script>
<script type="text/javascript" src="{{asset('assets/admin/vendor/ui-upload/jquery.plupload.queue/jquery.plupload.queue.min.js')}}" charset="UTF-8"></script>
<script src="{{asset('assets/admin/js/jquery.validate.min.js')}}"></script>
<script src="{{asset('assets/admin/vendor/sweetalert2/dist/sweetalert2.min.js')}}"></script>
<script>
    tinymce.init({
            selector: '.my_tinyeditor',
            plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor  insertdatetime advlist lists wordcount  textpattern noneditable help charmap emoticons tiny_mce_wiris',
            menubar: 'file edit view insert format tools table help',
            toolbar: 'token_button | undo redo | bold italic underline strikethrough |  fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | tiny_mce_wiris_formulaEditor | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
            images_upload_url: "{{ url('admin/upload-product-tinymce-image') }}",
            images_upload_handler: function(blobInfo, success, failure) {
                var xhr, formData;
                xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', "{{ url('admin/upload-product-tinymce-image') }}");
                xhr.setRequestHeader("x-csrf-token", "{{ csrf_token() }}");

                xhr.onload = function() {
                    var json;
                    if (xhr.status != 200) {
                        failure('HTTP Error: ' + xhr.status);
                        return;
                    }
                    json = JSON.parse(xhr.responseText);

                    if (!json || typeof json.location != 'string') {
                        failure('Invalid JSON: ' + xhr.responseText);
                        return;
                    }
                    success(json.location);
                };
                formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());
                xhr.send(formData);
            },
            autosave_ask_before_unload: true,
            autosave_interval: '30s',
            autosave_retention: '2m',
            themes: "silver",
            convert_urls: false,
            file_picker_types: 'image file media',
            file_picker_callback: function(cb, value, meta) {
                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');
                input.onchange = function() {
                    var file = this.files[0];
                    var reader = new FileReader();
                    reader.onload = function() {
                        var id = 'blobid' + (new Date()).getTime();
                        var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                        var base64 = reader.result.split(',')[1];
                        var blobInfo = blobCache.create(file.name, file, base64);
                        blobCache.add(blobInfo);
                        cb(blobInfo.blobUri(), {
                            title: file.name
                        });
                    };
                    reader.readAsDataURL(file);
                };
                input.click();
            },
            importcss_append: false,
            branding: false
        });
</script>

<script> 
    $("#product_frm").validate({
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
            event.preventDefault();
            var fileLength = $("#uploader_filelist .plupload_file_name").length;
            var fileLengthO = $("#uploader_orig_filelist .plupload_file_name").length;
            var fileLengthS = $("#uploader_sample_filelist .plupload_file_name").length;
            if(fileLengthO > 0){
                $(".site-loader").css('display','flex');
                $('button[type=submit]').attr('disabled','disabled').text('Processing...');
                $("#uploader_orig_container .plupload_start").click();
            }else if(fileLengthS > 0){
                $(".site-loader").css('display','flex');
                $('button[type=submit]').attr('disabled','disabled').text('Processing...');
                $("#uploader_sample_container .plupload_start").click();
            }else if(fileLength > 0){
                $(".site-loader").css('display','flex');
                $('button[type=submit]').attr('disabled','disabled').text('Processing...');
                $("#uploader_container .plupload_start").click();
            }else{
                document.product_frm.submit();
                $('button[type="submit"]').attr('disabled','disabled').text('Processing...');
            }            
        }
    });
</script>

<script>
    $(function() {
    var docsArr = '';
    var randId = '<?=rand(111,999).time();?>';
    $("#uploader").pluploadQueue({
        runtimes: 'html5,flash,silverlight,html4',
        url: "{{url('admin/upload-dropzone-files-media')}}?str="+randId,
        chunk_size: '1mb',
        multi_selection:true,
        filters: [{
            title: "Image files",
            extensions: "*"
        },
        {
            title: "Audio files",
            extensions: "mp3,wav,aac,m4a"
        },
        {
            title:"Video files",
            extensions:"mp4,mov,wmv,avi,mkv,webm"
        }
        ],
        rename: false,
        sortable: true,
        dragdrop: true,
        views: {
        list: true,
        thumbs: true, // Show thumbs
        active: 'thumbs',
        },
        headers: {
        "x-csrf-token": "{{csrf_token()}}"
        },
        flash_swf_url: '{{asset("admin-assets/vendor/ui-upload/Moxie.swf")}}',
        silverlight_xap_url: '{{asset("admin-assets/vendor/ui-upload/Moxie.xap")}}',
    });
    var uploader = $("#uploader").pluploadQueue();
    uploader.bind('FileUploaded', function(up, file, info) {
        var response;
        response = jQuery.parseJSON(info.response);
        if (response.error.code == '200') {
        if (docsArr == '') {
            docsArr = response.error.id;
        } else {
            docsArr = docsArr + '@@*@@' + response.error.id;
        }
        }
        $("#uploaded-docs").val(docsArr);
        if (this.total.queued == 0) {
            $("#product_frm")[0].submit();
        }
    });
    uploader.bind('UploadProgress', function(up, file) {
        $(".site-loader").css('display','flex');
        $("button[type='submit']").attr('disabled', 'disabled').text('Processing...');
    });
 });
</script>


<script>
    $(function() {
    var docsArr_orig = '';
    var randId = '<?=rand(111,999).time();?>';
    $("#uploader_orig").pluploadQueue({
        runtimes: 'html5,flash,silverlight,html4',
        url: "{{url('admin/upload-dropzone-files')}}?str="+randId,
        chunk_size: '1mb',
        multi_selection:true,
        filters: [{
            title: "Image files",
            extensions: "*"
        },
        {
            title: "Audio files",
            extensions: "mp3,wav,aac,m4a"
        },
        {
            title:"Video files",
            extensions:"mp4,mov,wmv,avi,mkv,webm"
        }
        ],
        rename: false,
        sortable: true,
        dragdrop: true,
        views: {
        list: true,
        thumbs: true, // Show thumbs
        active: 'thumbs',
        },
        headers: {
        "x-csrf-token": "{{csrf_token()}}"
        },
        flash_swf_url: '{{asset("admin-assets/vendor/ui-upload/Moxie.swf")}}',
        silverlight_xap_url: '{{asset("admin-assets/vendor/ui-upload/Moxie.xap")}}',
    });
    var uploader = $("#uploader_orig").pluploadQueue();
    uploader.bind('FileUploaded', function(up, file, info) {
        var response;
        response = jQuery.parseJSON(info.response);
        if (response.error.code == '200') {
        if (docsArr_orig == '') {
            docsArr_orig = response.error.id;
        } else {
            docsArr_orig = docsArr_orig + '@@*@@' + response.error.id;
        }
        }
        $("#uploaded-docs_orig").val(docsArr_orig);
        if (this.total.queued == 0) {
            var fileLength = $("#uploader_filelist .plupload_file_name").length;
            var fileLengthS = $("#uploader_sample_filelist .plupload_file_name").length;
            if(fileLengthS > 0){
                $("#uploader_sample_container .plupload_start").click();
            }else if(fileLength > 0){
                $("#uploader_container .plupload_start").click();
            }else{
                $("#product_frm")[0].submit();
            }
        }
    });
    uploader.bind('UploadProgress', function(up, file) {
        $(".site-loader").css('display','flex');
        $("button[type='submit']").attr('disabled', 'disabled').text('Processing...');
    });
 });
</script>




<script>
    $(function() {
    var docsArr_sample = '';
    var randId = '<?=rand(111,999).time();?>';
    $("#uploader_sample").pluploadQueue({
        runtimes: 'html5,flash,silverlight,html4',
        url: "{{url('admin/upload-dropzone-files-sample')}}?str="+randId,
        chunk_size: '1mb',
        multi_selection:true,
        filters: [{
            title: "Image files",
            extensions: "*"
        },
        {
            title: "Audio files",
            extensions: "mp3,wav,aac,m4a"
        },
        {
            title:"Video files",
            extensions:"mp4,mov,wmv,avi,mkv,webm"
        }
        ],
        rename: false,
        sortable: true,
        dragdrop: true,
        views: {
        list: true,
        thumbs: true, // Show thumbs
        active: 'thumbs',
        },
        headers: {
        "x-csrf-token": "{{csrf_token()}}"
        },
        flash_swf_url: '{{asset("admin-assets/vendor/ui-upload/Moxie.swf")}}',
        silverlight_xap_url: '{{asset("admin-assets/vendor/ui-upload/Moxie.xap")}}',
    });
    var uploader = $("#uploader_sample").pluploadQueue();
    uploader.bind('FileUploaded', function(up, file, info) {
        var response;
        response = jQuery.parseJSON(info.response);
        if (response.error.code == '200') {
        if (docsArr_sample == '') {
            docsArr_sample = response.error.id;
        } else {
            docsArr_sample = docsArr_sample + '@@*@@' + response.error.id;
        }
        }
        $("#uploaded-docs_sample").val(docsArr_sample);
        if (this.total.queued == 0) {
            // $("#product_frm")[0].submit();
            var fileLength = $("#uploader_filelist .plupload_file_name").length;
            if(fileLength > 0){
                $("#uploader_container .plupload_start").click();
            }else{
                $("#product_frm")[0].submit();
            }
        }
    });
    uploader.bind('UploadProgress', function(up, file) {
        $(".site-loader").css('display','flex');
        $("button[type='submit']").attr('disabled', 'disabled').text('Processing...');
    });
 });
</script>

<script>
    $(".remove_files").on('click',function(){
        var lnk = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete this file",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value==true) {
                window.location.href = lnk;
            }
        })
    })
</script>


@endpush
