@extends('admin.master')
@section('title')
    All Blogs
@endsection
@section('content')
@push('styles')
    <link rel="stylesheet" href="{{asset("assets/admin/vendor/sweetalert2/dist/sweetalert2.min.css")}}">
@endpush
    <section class="content-body">
        <!-- row -->
        <div class="container-fluid">
            <div class="mb-sm-3 d-flex flex-wrap align-items-center text-head">
                <h2 class="mb-3 me-auto">All Blogs</h2>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                        <li class="breadcrumb-item"><a href="/admin/all-blogs">Blogs</a></li>
                    </ol>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                <div class="customer-search mb-sm-0 mb-3">
                    <div class="input-group search-area">
                        <input type="text" class="form-control" placeholder="Search here......" id="search_txt" value="">
                        <span class="input-group-text" id="search_btn"><a href="javascript:void(0)"><i
                                    class="flaticon-381-search-2"></i></a></span>
                    </div>
                </div>
                <div class="d-flex align-items-center flex-wrap">
                    <a href="{{url('admin/create-blog')}}" class="btn btn-primary  mb-2"><i class="fas fa-plus pe-2"></i>Add New
                        Blog</a>
                </div>
            </div>
            <div class="row">
                @include('messages')
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table display text-black" id="example5">
                                    <thead>
                                        <tr>
                                            <th>
                                                #
                                            </th>
                                            <th>Title</th>
                                            <th>Category</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($blogs as $blog)
                                            <tr>
                                                <td>
                                                    <?= ++$loop->index ?>
                                                </td>
                                                <td class="wspace-no">
                                                    <div class="d-flex align-items-center">
                                                        <div class="d-flex align-items-center ps-2">
                                                            {{-- <img src="{{asset('uploads/blog/'.$blog->image)}}" alt="" width="36"
                                                                class="rounded"> --}}
                                                            <h4 class="my-1 ps-1">{{substr($blog->title,0,30) }}...</h4>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="wspace-no">{{$blog->blogcatgeory->name}}</td>
                                                <td class="wspace-no">{{ substr($blog->description,0,25) }}...</td>
                                                <td class="wspace-no">
                                                    @if($blog->status==1)
                                                        <span class="badge light badge-success">Active</span>
                                                    @else
                                                        <span class="badge light badge-danger">De-Activated</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                        $inputObj = new stdClass();
                                                        $inputObj->params = 'id='.$blog->id;
                                                        $inputObj->url = url('admin/remove-blog');
                                                        $encLink = Common::encryptLink($inputObj);

                                                        $inputObjE = new stdClass();
                                                        $inputObjE->params = 'id='.$blog->id;
                                                        $inputObjE->url = url('admin/edit-blog');
                                                        $encLinkE = Common::encryptLink($inputObjE);
                                                    @endphp
                                                    <div class="d-flex align-items-center">
                                                        <a href="{{$encLinkE}}"
                                                            class="btn btn-success btn-rounded  btn-sm ms-2 "><i
                                                                class="far fa-pencil pe-2"></i>Edit</a>
                                                        <a href="javascript:void(0);" data-id="{{$encLink}}" class="btn btn-danger  btn-rounded btn-sm ms-2 remove_dlt"><i class="far fa-trash-alt pe-2"></i>Delete</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="5"><h4 class="text-center text-danger">NO BLOG FOUND</h4></td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="w-100 mt-3 num_pagination">
                                    {{$blogs->appends(request()->input())->links('pagination')}}
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
        $(".remove_dlt").on('click',function(){
            var rmv = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value==true) {
                    window.location.href = rmv;
                }
            })
        });
    </script>
    <script>
        $("#search_btn").on('click',function(){
            var txt = $('#search_txt').val();
            if(txt!=''){
                window.location.href = "{{url('admin/serachBlog?q=')}}"+txt;
            }
        })
    </script>
@endpush
