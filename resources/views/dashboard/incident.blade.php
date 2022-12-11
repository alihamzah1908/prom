@extends('template.default')
@section('submenu')
<!-- <div class="row mb-2">
    <div class="col-sm-6">
        <h3 class="m-0 text-dark">{{ __('dasboard1.dasboard_language') }}</h3>
    </div>
</div> -->
@endsection
@section('content')
    <h1>ini test incident</h1>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="{{asset('adminlte/plugins/morris/morris.min.js')}}"></script>
<script src="/js/chartSetup.js?d={{random_code(12)}}"></script>
@endpush
