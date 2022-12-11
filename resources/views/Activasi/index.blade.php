@extends('template.default')
@section('title', 'Aktivasi')
@section('submenu')
<!--<div class="row mb-2">-->
<!--    <div class="col-sm-6">-->
<!--        <h3 class="m-0 text-dark"><strong>Aktivasi</strong></h3>-->
<!--    </div>-->
<!--</div>-->
@endsection
@section('content')
@if(Session::has('message'))
    <div class="alert {{Session::get('alert-class')}} alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        {{ Session::get('message') }}
    </div>
@endif

<style>
    table.dataTable tbody th, table.dataTable tbody td {
    padding: 0px 0px !important;
    padding-top: 0px !important;
    padding-bottom: 0px !important;
    }
    .container-fluid {
    width: 100%;
    padding-right: 0px;
    padding-left: 0px;
    margin-right: auto;
    margin-left: auto;
    }
    .content-wrapper>.content {
    padding: 0rem;
    }
    .card-header {
    background-color: transparent;
    border-bottom: 0px; 
    padding: .3rem 1.25rem 0rem 1.25rem; /*.75rem 1.25rem*/
    position: relative;
    border-top-left-radius: .25rem;
    border-top-right-radius: .25rem;
    }
    .card-body {
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    padding: 0rem 1.25rem 1.25rem 1.25rem;
    }
</style>

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
              <!--<h3 class="card-title"> <strong>Lists</strong></h3>-->
            </div>
            <div class="col-md-2 form-group"></div>
            <div class="col-md-2 form-group"></div>
            
            <div class="col-md-2 form-group">
                <a href="/aktivasi-layanan/create" type="button" class="form-control bg-primary"> 
                    <i class="fa fa-plus nav-icon"></i>&nbsp;&nbsp;{{ __('sidebar-services-index1.create_language') }}
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            
            <div class="col-md-2 form-group">
                <select class="form-control btn-default select_type" type="text">
                    <option value="" selected disabled> -- {{ __('sidebar-services-index1.activation-type_language') }} -- </option>
                    @foreach(\App\Model\AktivasiType::get() as $type)
                        <option value="{{$type->id_service}}">{{$type->service_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 form-group">
                <select class="form-control btn-default select_customer">
                    <option value="" selected disabled> -- {{ __('sidebar-services-index1.customer_language') }} -- </option>
                    @foreach(\App\Model\Customer::get() as $type)
                        <option value="{{$type->id_customer}}">{{$type->name_customer}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 form-group">
                <select class="form-control select2 btn-default select_region" style="width: 100%;">
                    <option selected="selected" disabled value="">-- {{ __('sidebar-services-index1.select-region_language') }} --</option>
                    @foreach(\App\Model\Region::get() as $region)
                        <option value="{{$region->region_id}}">{{$region->region_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 form-group">
                <select class="form-control select2 btn-default select_segment" style="width: 100%;">
                    <option selected="selected" disabled value="">-- {{ __('sidebar-services-index1.select-segment_language') }} --</option>
                    @foreach(\App\Model\Segment::get() as $segment)
                        <option value="{{$segment->id_segment}}">{{$segment->segment_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 form-group">
                <button type="button" class="form-control btn-default btn-refresh" style="color: #828282">
                    <i class="fas fa-redo-alt"></i>&nbsp;&nbsp; {{ __('sidebar-services-index1.refresh_language') }}
                </button>
            </div>
            <div class="col-md-2 form-group">
                <span class="icon"><i class="fas fa-search"></i></span>
                <input class="form-control btn-default" id="search" type="text" placeholder="{{ __('sidebar-services-index1.search_language') }}" aria-label="Search">
            </div>
        </div>
        <table id="data_table" class="display table table-striped table-border-gray" style="width:100%">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>{{ __('sidebar-services-index1.activity-no_language') }}</th>
                    <th>{{ __('sidebar-services-index1.customer-name_language') }}</th>
                    <th>{{ __('sidebar-services-index1.project-name_language') }}</th>
                    <th>{{ __('sidebar-services-index1.type-of-service-from_language') }}</th>
                    <th>{{ __('sidebar-services-index1.status_language') }}</th>
                    <!--<th>Option</th>-->
                </tr>
            </thead>
        </table>
    </div>
</div>


<script>
    var param = {}
    var id_type_service = '', id_segment = '', id_region = '', id_customer = '', id_status = '', capasity = ''; 
    <?php
        $id_type_service = request()->id_type_service;
        if($id_type_service) echo "id_type_service = $id_type_service;";
        
        $id_segment = request()->id_segment;
        if($id_segment) echo "id_segment = $id_segment;";
        
        $id_region = request()->id_region;
        if($id_region) echo "id_region = $id_region;";
        
        $id_customer = request()->id_customer;
        if($id_customer) echo "id_customer = $id_customer;";
        
        $id_status = request()->id_status;
        if($id_status) echo "id_status = $id_status;";
        
        $capasity = request()->capasity;
        if($capasity) echo "capasity = $capasity;";
    ?>
    $(document).ready(function() {
        var def = true;
        if(id_type_service){
           $('.select_type').val(id_type_service);
           param.id_type_service = id_type_service;
        }
        if(id_region){
           $('.select_region').val(id_region);
           def = false;
           param.id_region = id_region;
           initData(param);
        }
        if(id_segment){
           $('.select_segment').val(id_segment);
           def = false;
           param.id_segment = id_segment;
           initData(param);
        }
        
        if(id_customer){
           $('.select_customer').val(id_customer);
           def = false;
           param.id_customer = id_customer;
           initData(param);
        }
        if(id_status){
        //   $('.select_st').val(id_customer);
           def = false;
           param.id_status = id_status;
           initData(param);
        }
        if(capasity){
        //   $('.select_st').val(id_customer);
           def = false;
           param.capasity = capasity;
           initData(param);
        }
        
        if(def){
           initData(param); 
        }
        
        $(document).on('click', '.btn-refresh', function(e){
            e.preventDefault();
            param.id_type_service = '';
            param.id_region = '';
            param.id_customer = '';
            param.id_segment = '';
            
            $('.select_type').val('');
            $('.select_region').val('');
            $('.select_customer').val('');
            $('.select_segment').val('');
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
             "lengthMenu": [[20, 50, 100, 150, 200, 250, 500], [20, 50, 100, 150, 200, 250, 500]],
            "destroy": true,
            "bDestroy": true,
            "ajax": {
                "url": "/api/aktivasi-layanan/getAktivasi",
                "data": param,
                "error": function (xhr, error, thrown) {
                    ajax_fail(xhr, error);
                }
            },
            "columns": [
                { "data": "id" },
                { "data": "active_uid" },
                { "data": "id_customer"},
                { "data": "region.region_name" },
                { "data": "type.service_name" },
                { "data": "status_name" },
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
                       return '<a href="/aktivasi-layanan/detail/'+row.id+'">'+row.active_uid+'</a>';
                    }
                },
                
                
                //   {
                //     "targets" : 3,
                //     "data": "id",
                //     "render" : function (data, type, row) {
                //       return '<span>'+row.active_+'</a>';
                //     }
                // },
                // {
                //     "targets" : 6,
                //     "data": "id",
                //     "render" : function (data, type, row) {
                //       return '';
                //     }
                // },
            ],
            "order": [[0, 'desc']],
            "sDom": 't<"row view-pager"<"col-sm-12"<"pull-left"i><"pull-right"p>>>',
        });
        
        oTable = $('#data_table').DataTable();
        $('#search').keyup(function(){
              oTable.search($(this).val()).draw() ;
        })
    }
</script>
@endsection
