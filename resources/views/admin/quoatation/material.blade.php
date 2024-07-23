@extends('admin.master')
@section('title')
    All Product
@endsection
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/admin/vendor/sweetalert2/dist/sweetalert2.min.css') }}">
    @endpush
    <section class="content-body">
        <!-- row -->
        <div class="container-fluid">
            <div class="mb-sm-3 d-flex flex-wrap align-items-center text-head">
                <h2 class="mb-3 me-auto">All Product</h2>
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                        <li class="breadcrumb-item"><a href="/admin/all-orders">Product</a></li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <form action="{{route('update-price')}}" autocomplete="off" method="post">
                    @csrf
                    @foreach ($material as $item)
                        <div class="row mb-3">
                            <div class="">
                                <label for="mateial" class="form-label badge badge-danger">{{ $item->purity_grade }}
                                    {{ $item->material_name }}</label>  
                            </div>
                            <div class="col-lg-6">
                                <label for="">Current Price (₹)/({{ $item->unit_of_measurement }})</label>
                                <input type="number" step=".01" class="form-control" name="current_price[{{$item->id}}]" value="{{ $item->current_price_per_unit }}" id="mateial">
                            </div>
                            <div class="col-lg-6">
                                <label for="">Minimum Price (₹)/({{ $item->unit_of_measurement }})</label>
                                <input type="number" step=".01" class="form-control" name="min_price[{{ $item->id }}]"
                                    value="{{ $item->minimun_price }}" id="mateial">
                            </div>
                        </div>
                    @endforeach
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    @push('scripts')
        <script>
            $("#search_btn").on('click', function() {
                var txt = $('#search_txt').val();
                if (txt != '') {
                    window.location.href = "{{ url('admin/all-orders?q=') }}" + txt;
                }
            })
        </script>
    @endpush
@endsection
