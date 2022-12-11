@extends('template.default')
@section('title', 'Aktivasi')
@section('submenu')
<div class="row mb-2">
    <!--<div class="col-sm-6">-->
    <!--    <h3 class="m-0 text-dark"><strong>Waiting Approval</strong></h3>-->
    <!--</div>-->
</div>
@endsection
@section('content')
@if(Session::has('message'))
    <div class="alert {{Session::get('alert-class')}} alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        {{ Session::get('message') }}
    </div>
@endif
<div class="card">
    <!--<div class="card-header">-->
    <!--    <h3 class="card-title"> <strong>Waiting Approval Aktivasi</strong></h3>-->
    <!--</div>-->
    <div class="card-body">
        <div class="row">
            <div class="col-md-2 form-group">
                <select class="form-control btn-default select_type" type="text">
                    <option value="" selected disabled> -- {{ __('sidebar-waiting_approval-activation-index1.activation-type_language') }} -- </option>
                    @foreach(\App\Model\AktivasiType::get() as $type)
                        <option value="{{$type->id_service}}">{{$type->service_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 form-group">
                <select class="form-control btn-default select_customer">
                    <option value="" selected disabled> -- {{ __('sidebar-waiting_approval-activation-index1.customer_language') }} -- </option>
                    @foreach(\App\Model\Customer::get() as $type)
                        <option value="{{$type->id_customer}}">{{$type->name_customer}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 form-group">
                <select class="form-control select2 btn-default select_region" style="width: 100%;">
                    <option selected="selected" disabled value="">-- {{ __('sidebar-waiting_approval-activation-index1.select-region_language') }} --</option>
                    @foreach(\App\Model\Region::get() as $region)
                        <option value="{{$region->region_id}}">{{$region->region_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 form-group">
                <button type="button" class="form-control btn-default btn-refresh" style="color: #828282">
                    <i class="fas fa-redo-alt"></i>&nbsp;&nbsp; {{ __('sidebar-waiting_approval-activation-index1.refresh_language') }}
                </button>
            </div>
            <div class="col-md-2 form-group"></div>
            <div class="col-md-2 form-group">
                <span class="icon"><i class="fas fa-search"></i></span>
                <input class="form-control btn-default" id="search" type="text" placeholder="{{ __('sidebar-waiting_approval-activation-index1.search_language') }}" aria-label="Search">
            </div>
        </div>
        <table id="data_table" class="display table table-striped table-border-gray" style="width:100%">
            <thead>
                <tr>
                    <th style="width: 10px">No</th>
                    <th>{{ __('sidebar-waiting_approval-activation-index1.activity-no_language') }}</th>
                    <th>{{ __('sidebar-waiting_approval-activation-index1.customer-name_language') }}</th>
                    <th>{{ __('sidebar-waiting_approval-activation-index1.project-name_language') }}</th>
                    <th>{{ __('sidebar-waiting_approval-activation-index1.type-of-service_language') }}</th>
                    <th>{{ __('sidebar-waiting_approval-activation-index1.status_language') }}</th>
                    <!--<th>Option</th>-->
                </tr>
            </thead>
        </table>
    </div>
</div>


<script>
    var param = {}
    $(document).ready(function() {
        initData(param);
        
        $(document).on('click', '.btn-refresh', function(e){
            e.preventDefault();
            param.id_type_service = '';
            param.id_region = '';
            param.id_customer = '';
            
            $('.select_type').val('');
            $('.select_region').val('');
            $('.select_customer').val('');
            initData(param);
        });
        
        $(document).on('change', '.select_region', function(e){
            e.preventDefault();
            param.id_region = $(this).val();
            initData(param);
        });
        $(document).on('change', '.select_customer', function(e){
            e.preventDefault();
            param.id_customer = $(this).val();
            initData(param);
        });
        $(document).on('change', '.select_type', function(e){
            e.preventDefault();
            param.id_type_service = $(this).val();
            initData(param);
        });
    });
    function initData(param){
        var table = $('#data_table').DataTable( {
            "destroy": true,
            "bDestroy": true,
            "ajax": {
                "url": "/api/waiting_approval/getAktivasiWaitingApproval",
                "data": param,
                "error": function (xhr, error, thrown) {
                    ajax_fail(xhr, error);
                }
            },
            "columns": [
                { "data": "id" },
                { "data": "active_uid" },
                { "data": "customer.name_customer"},
                { "data": "region.region_name" },
                { "data": "type.service_name" },
                { "data": "status.name" },
                // {
                //     "className":      'detail-option',
                //     "orderable":      false,
                //     "data":           null,
                //     "defaultContent": ''
                // },
            ],
            "columnDefs": [
                {
                    "targets" : 1,
                    "data": "id",
                    "render" : function (data, type, row) {
                       return '<a href="/waiting_approval/aktivasi/detail/'+row.id+'">'+row.active_uid+'</a>';
                    }
                },
                // {
                //     "targets" : 6,
                //     "data": "id",
                //     "render" : function (data, type, row) {
                //       return '';
                //     }
                // },
            ],
            "order": [[1, 'asc']],
            "sDom": 't<"row view-pager"<"col-sm-12"<"pull-left"i><"pull-right"p>>>',
        });
        
        oTable = $('#data_table').DataTable();
        $('#search').keyup(function(){
              oTable.search($(this).val()).draw() ;
        })
    }
</script>
@endsection
