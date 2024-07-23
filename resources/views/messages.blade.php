@push('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/admin/css/iziToast.min.css')}}">
@endpush

<div class="col-md-12">
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show glbl-cust-message">
            <ul style="margin:0;padding:0;list-style:none;">
                @foreach ($errors->all() as $input_error)
                    <li>{{$input_error}}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
        </div>
    @endif
    @if(Session::has('custom_success_msg'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <div class="d-flex justify-content-between">
                <h4 class="mb-0">Error</h4>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <hr>
            {!!Session::get("custom_success_msg")!!}
        </div>
    @endif
</div>
@push('scripts')
<script src="{{asset('assets/admin/js/iziToast.min.js')}}"></script>
@if(Session::has('warning'))
    <script>
        iziToast.warning({
            title: 'warning',
            message: '{{Session::get("warning")}}',
            position:'topRight'
        });
    </script>
@endif  

@if(Session::has('success'))
    <script>
        iziToast.success({
            title: 'Success',
            message: '{{Session::get("success")}}',
            position:'topRight'
        });
    </script>
@endif 

@if(Session::has('error'))
<script>
    iziToast.error({
        title: 'error',
        message: '{{Session::get("error")}}',
        position:'topRight'
    });
</script>
@endif 
@endpush