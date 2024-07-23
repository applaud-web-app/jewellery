@extends('admin.master')
@section('title')
    All Categories
@endsection
@section('content')
@push('styles')
    <link rel="stylesheet" href="{{asset("assets/admin/vendor/sweetalert2/dist/sweetalert2.min.css")}}">
@endpush
    <section class="content-body">
        <!-- row -->
        <div class="container-fluid">
            <div class="mb-sm-3 d-flex flex-wrap align-items-center text-head">
                <h2 class="mb-3 me-auto">Category</h2>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/dashboard/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/admin/categories/">Category</a></li>
                    </ol>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                <div class="customer-search mb-sm-0 mb-3">
                    <div class="input-group search-area">
                        <input type="text" class="form-control" placeholder="Search here......" id="search_txt" value="{{$searchStr}}">
                        <span class="input-group-text" id="search_btn"><a href="javascript:void(0)"><i
                                    class="flaticon-381-search-2"></i></a></span>
                    </div>
                </div>
                <div class="d-flex align-items-center flex-wrap">
                    <a href="{{url('admin/categories/create')}}" class="btn btn-primary  mb-2"><i class="fas fa-plus pe-2"></i>Add New
                        Category</a>
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
                                            <th>Category</th>
                                            <th>Product</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($categories as $value)
                                            <tr>
                                                <td>
                                                    <?= $i ?>
                                                </td>
                                                <td class="wspace-no">

                                                    <div class="d-flex align-items-center">
                                                        @if(!$value->child_category->isEmpty())
                                                            <a class="text-primary" href="javascript:void(0);"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#collapsesubcategory<?= $i ?>" role="button"
                                                            aria-expanded="false"
                                                            aria-controls="collapsesubcategory<?= $i ?>"><i
                                                                class="fas fa-plus-circle fs-18"></i></a>
                                                        @else
                                                            <a class="text-warning" href="javascript:void(0);" role="button" aria-expanded="false"
                                                            aria-controls="collapsesubcategory<?= $i ?>"></a>
                                                        @endif

                                                            <div class="d-flex align-items-center ps-2">
                                                                <img src="{{asset('uploads/category_image/'.$value->primary_img)}}" alt="" width="36"
                                                                    class="rounded">
                                                                <h4 class="my-1 ps-1">{{$value->cat_name}}</h4>
                                                            </div>
                                                    </div>
                                                    <div class="subcategory py-1 ps-3 fs-14 border collapse mt-3"
                                                        id="collapsesubcategory<?= $i ?>">
                                                        @if(!$value->child_category->isEmpty())
                                                            @foreach ($value->child_category as $item)
                                                                @php
                                                                    $inputObjC = new stdClass();
                                                                    $inputObjC->params = 'id='.$item->id;
                                                                    $inputObjC->url = url('admin/remove-category');
                                                                    $encLinkC = Common::encryptLink($inputObjC);
            
                                                                    $inputObjEC = new stdClass();
                                                                    $inputObjEC->params = 'id='.$item->id;
                                                                    $inputObjEC->url = url('admin/edit-category');
                                                                    $encLinkEC = Common::encryptLink($inputObjEC);
                                                                @endphp
                                                                <div class="d-flex align-items-center ps-2">
                                                                    <img src="{{asset('uploads/category_image/'.$item->primary_img)}}" alt="" width="24"
                                                                        class="rounded">
                                                                    <p class="my-1 ps-1">{{$item->cat_name}}</p>
                                                                   <div class="ms-3 text-end">
                                                                    <a href="{{$encLinkEC}}" class="text-primary"><i class="fas fa-edit"></i></a>
                                                                    <a href="javascript:void(0)" data-id="{{$encLinkC}}" class="remove_dlt text-danger"><i class="fas fa-trash-alt"></i></a>
                                                                   </div>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="wspace-no">{{$value->worksheet_count}}</td>

                                                <td class="wspace-no">
                                                    @if($value->status==1)
                                                        <span class="badge light badge-success">Active</span>
                                                    @else
                                                        <span class="badge light badge-danger">De-Activated</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                        $inputObj = new stdClass();
                                                        $inputObj->params = 'id='.$value->id;
                                                        $inputObj->url = url('admin/remove-category');
                                                        $encLink = Common::encryptLink($inputObj);

                                                        $inputObjE = new stdClass();
                                                        $inputObjE->params = 'id='.$value->id;
                                                        $inputObjE->url = url('admin/edit-category');
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
                                            @php
                                                $i++;
                                            @endphp
                                        @empty
                                            <tr>
                                                <td colspan="5"><h4 class="text-center text-danger">NO CATEGORIES</h4></td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <div class="w-100 mt-3 num_pagination">
                                    {{$categories->appends(request()->input())->links('pagination')}}
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
            // if(confirm('Are you sure ? you want to remove this category')){
            //     window.location.href = rmv;
            // }
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
                window.location.href = "{{url('admin/categories?q=')}}"+txt;
            }
        })
    </script>
@endpush
