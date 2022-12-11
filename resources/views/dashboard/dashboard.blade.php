@extends('template.default')
@section('submenu')
<!-- <div class="row mb-2">
    <div class="col-sm-6">
        <h3 class="m-0 text-dark">{{ __('dasboard1.dasboard_language') }}</h3>
    </div>
</div> -->
@endsection
@section('content')
<style>
    .display-none{
        display:none;
    }
    .donut-legend > span {
      display: inline-block;
      margin-right: 25px;
      margin-bottom: 10px;
      font-size: 13px;
    }
    .donut-legend > span:last-child {
      margin-right: 0;
    }
    .donut-legend > span > i {
      display: inline-block;
      width: 15px;
      height: 15px;
      margin-right: 7px;
      margin-top: -3px;
      vertical-align: middle;
      border-radius: 1px;
    }
    .no-data{
      display: none;
      position: absolute;
      padding: 50px 0;
      text-align: center;
      font-size: 3rem;
      top: 15%;
      width: 100%;
    }
    .card-title {
    font-style: normal;
    font-weight: 600;
    font-size: 16px;
    line-height: 29px;
    color: #000000;
    opacity: 0.7;
    }
</style>
<iframe width="100%" height="1000"
        src="https://datastudio.google.com/embed/reporting/89b1058e-aebb-4630-9791-942c8f4a543e/page/DRDtC" frameborder="0"
        style="border:0" allowfullscreen></iframe>
<!-- <div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-3">
                <select class="form-control" onchange="document.location.href='?view='+this.value">
                    <option {{$r_view == "TASK" ? 'selected':''}}>{{ __('dasboard1.task_language') }}</option>
                    <option {{$r_view == "AKTIVASI_LAYANAN" ? 'selected':''}}>{{ __('dasboard1.layanan_language') }}</option>
                    <option {{$r_view == "SITE_ENTRY" ? 'selected':''}}>{{ __('dasboard1.site-entry_language') }}</option>
                    <option {{$r_view == "PERMIT_LETTER" ? 'selected':''}}>{{ __('dasboard1.permit-letter_language') }}</option>
                </select>
            </div>
            <div class="col-md-3">
                @if($r_view == "AKTIVASI_LAYANAN")
                <select class="form-control" name="service_type">
                    @foreach(\App\Model\AktivasiType::get() as $type)
                    <option value="{{$type->id_service}}">{{$type->service_name}}</option>
                    @endforeach
                </select>
                @elseif($r_view == "TASK")
                <select class="form-control" name="task_type">
                    @foreach(\App\Model\TaskType::get() as $type)
                    <option value="{{$type->id_type}}">{{$type->type_name}}</option>
                    @endforeach
                </select>
                @else
                @endif
            </div>
            @if($r_view == "TASK")
            <div class="col-md-3">    
                <select class="form-control" name="filter_type">
                    <option value="1">Status</option>
                    <option value="2">Region</option>
                    <option value="3">Technician</option>
                </select>                  
            </div>
            @endif
        </div>
    </div>
</div>
@include($view) -->

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="{{asset('adminlte/plugins/morris/morris.min.js')}}"></script>
<script src="/js/chartSetup.js?d={{random_code(12)}}"></script>
<script>
    $(document).ready(function(){
        $.ajax({
            url: 'https://datastudio.google.com/embed/getReport?appVersion=20221208_02020042',
            dataType: 'json',
            method: 'post'
        }).done(function(response){
            console.log(response)
        })
    })
    </script>
@endpush
