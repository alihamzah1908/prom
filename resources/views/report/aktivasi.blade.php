@extends('template.default')
@section('title', 'Aktivasi Reports')
@section('submenu')

@endsection
@section('content')

@if(Session::has('message'))
<div class="alert {{Session::get('alert-class')}} alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
    {{ Session::get('message') }}
</div>
@endif
<link href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<link href='/css/dragula.css' rel='stylesheet' type='text/css' />
<link href='/css/dragula_example.css' rel='stylesheet' type='text/css' />
<style>
    td.details-control {
        background: url('/images/details_open.png') no-repeat center center;
        cursor: pointer;
    }
    tr.shown td.details-control {
        background: url('/images/details_close.png') no-repeat center center;
    }
    
    .display-none{
        display:none !important;
    }
    td.details-control {
        background: url('/images/details_open.png') no-repeat center center;
        cursor: pointer;
    }
    tr.shown td.details-control {
        background: url('/images/details_close.png') no-repeat center center;
    }
    
    .display-none{
        display:none !important;
    }
    
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
    border-bottom: 0px /*solid rgba(0, 0, 0, .125) */;
    padding: .3rem 1.25rem 0rem 1.25rem;
    position: relative;
    border-top-left-radius: .25rem;
    border-top-right-radius: .25rem;
    }
    .card-title {
    margin-bottom: 1rem;
    }
    .card-body {
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    padding: 0rem 1.25rem 1.25rem 1.25rem;
    }
</style>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

@if($report_columns)
<div class="card collapsed-card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-7">
                <h3 class="card-title"><a href="/report/aktivasi"><i class="fa fa-arrow-left text-gray"></i></a> <strong>{{ __('sidebar-report-report_activation-index1.query-activation_language') }}</strong></h3>
            </div>
            <div class="col-md-2">
                <button type="button" class="form-control bg-primary" data-toggle="modal" data-target="#taskModal"> 
                    {{ __('sidebar-report-report_activation-index1.column_language') }}
                </button>
            </div>
            <div class="col-md-2">
                <button type="button" class="form-control btn-default btn-refresh" style="color: #828282">
                    <i class="fas fa-redo-alt"></i>&nbsp;&nbsp; {{ __('sidebar-report-report_activation-index1.refresh_language') }}
                </button>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-tool float-right" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3 form-group">
                <select class="form-control btn-default select_task_type" name="aktivasi_type">
                    <option selected="selected" disabled value="">-- {{ __('sidebar-report-report_activation-index1.activation-type_language') }} --</option>
                    @foreach($types as $type)
                        <option value="{{$type->id_service}}">{{$type->service_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3"></div>
            <div class="col-md-3"></div>
            <div class="col-md-3"></div>
            
            <div class="col-md-3 form-group">
                <select class="form-control select2 btn-default" style="width: 100%;" required autofocus name="id_customer">
                    <option selected="selected" disabled value="">-- {{ __('sidebar-report-report_activation-index1.customer_language') }} --</option>
                    @foreach(\App\Model\Customer::get() as $cat)
                        <option value="{{$cat->id_customer}}">{{$cat->name_customer}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 form-group">
                <select class="form-control btn-default select_2" name="region">
                    <option selected="selected" disabled value="">-- {{ __('sidebar-report-report_activation-index1.region_language') }} --</option>
                    @foreach(\App\Model\Region::get() as $region)
                        <option value="{{$region->region_id}}">{{$region->region_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 form-group">
                <select class="form-control btn-default select2" style="width: 100%;" required autofocus name="id_location">
                    <option selected="selected" disabled value="">-- {{ __('sidebar-report-report_activation-index1.location_language') }} --</option>
                    @foreach(\App\Model\Segment::get() as $segment)
                        <option value="{{$segment->id_segment}}">{{$segment->segment_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 form-group">
                <select class="form-control btn-default select2" style="width: 100%;" required autofocus name="id_site">
                    <option selected="selected" disabled value="">-- {{ __('sidebar-report-report_activation-index1.site_language') }} --</option>
                    @foreach(\App\Model\Site::get() as $site)
                        <option value="{{$site->site_id}}">{{$site->name_site}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 form-group">
                <select class="form-control btn-default select2 select_status" style="width: 100%;" required autofocus name="id_status">
                    <option selected="selected" disabled value="">-- {{ __('sidebar-report-report_activation-index1.status_language') }} --</option>
                    <option disabled value="">{{ __('sidebar-report-report_activation-index1.alert_language') }}</option>
                </select>
            </div>
            <div class="col-md-3 form-group">
                <select class="form-control btn-default select2" style="width: 100%;" required autofocus name="capasity_type">
                    <option selected="selected" disabled value="">-- {{ __('sidebar-report-report_activation-index1.capacity-type_language') }} --</option>
                    <option value="Sewa Kapasitas">{{ __('sidebar-report-report_activation-index1.rent-capacity_language') }}</option>
                    <option value="Sewa Dark Fiber">{{ __('sidebar-report-report_activation-index1.rent-dark-fiber_language') }}</option>
                </select>
            </div>
            <div class="col-md-3 form-group">
                <select class="form-control btn-default select2" style="width: 100%;" required autofocus name="capasity">
                    <option selected="selected" disabled value="">-- {{ __('sidebar-report-report_activation-index1.capacity_language') }} --</option>
                    <option value="1 GB">{{ __('sidebar-report-report_activation-index1.1gb_language') }}</option>
                    <option value="10 GB">{{ __('sidebar-report-report_activation-index1.10gb_language') }}</option>
                </select>
            </div>
            <div class="col-md-3 form-group">
                <select class="form-control btn-default select2" style="width: 100%;" required autofocus name="id_cord">
                    <option selected="selected" disabled value="">-- {{ __('sidebar-report-report_activation-index1.cord_language') }} --</option>
                    @foreach(\App\Model\Cord::get() as $d)
                    <option value="{{$d->id_cord}}">{{$d->name_cord}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 form-group"></div>
            <div class="col-md-3 form-group">
                <label for="" class="label">{{ __('sidebar-report-report_activation-index1.creation-time-from_language') }}</label>
                <input type="date" style="color:#828282 !important" class="form-control btn-default select_creation_from">
            </div>
            <div class="col-md-3 form-group">
                <label for="" class="label">{{ __('sidebar-report-report_activation-index1.to_language') }}</label>
                <input type="date" style="color:#828282 !important" class="form-control btn-default select_creation_to">
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h3 class="card-title"> <strong>{{ __('sidebar-report-report_activation-index1.query-result_language') }}</strong></h3>
    </div>
    <div class="card-body">
        
        <div class="table_container" style="overflow-x: auto;">
            <table id="table_task" class="display table table-striped table-responsive2 table-border-gray" style="width:100%;">
                <thead>
                    <tr>
                        @foreach($columns as $k => $val)
                            <th>{{getAktivasiColumns($val)['name']}}</th>
                        @endforeach
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@else
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-3 form-group">
                <label for="" class="label">{{ __('sidebar-report-report_activation-index1.creation-time-from2_language') }}</label>
                <input id="select_date_range" type="text" style="color:#828282 !important" class="form-control btn-default select_date_range" autocomplete="off" placeholder="{{ __('sidebar-report-report_activation-index1.date-range_language') }}">
            </div>
            <div class="col-md-3 form-group"></div>
            <!--<div class="col-md-3 form-group">-->
            <!--    <label for="" class="label">Creation time from</label>-->
            <!--    <input type="date" style="color:#828282 !important" class="form-control btn-default select_creation_from">-->
            <!--</div>-->
            <!--<div class="col-md-3 form-group">-->
            <!--    <label for="" class="label">to</label>-->
            <!--    <input type="date" style="color:#828282 !important" class="form-control btn-default select_creation_to">-->
            <!--</div>-->
            <div class="col-md-3 form-group">
                <label for="" class="label">&nbsp;</label>
                <button type="button" class="form-control btn-default btn-refresh" style="color: #828282"><i class="fas fa-redo-alt"></i>&nbsp;&nbsp; {{ __('sidebar-report-report_activation-index1.refresh_language') }}</button>
            </div>
            <div class="col-md-3 form-group">
                <label for="" class="label">&nbsp;</label>
                <input class="form-control btn-default" id="search" type="text" placeholder="{{ __('sidebar-report-report_activation-index1.search_language') }}" aria-label="Search">
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-10">
                <h3 class="card-title"><strong>{{ __('sidebar-report-report_activation-index1.reports_language') }}</strong></h3>
            </div>
            <div class="col-md-2">
                <button type="button" class="form-control bg-primary" data-toggle="modal" data-target="#taskModal"> 
                    {{ __('sidebar-report-report_activation-index1.new-report_language') }}
                </button>
            </div>
        </div>
    </div>
    <div class="card-body">
        
        <div class="table_container">
            <table id="table_task" class="display table table-striped table-bordered table-border-gray" style="width:100%">
                <thead>
                    <tr>
                        <th>{{ __('sidebar-report-report_activation-index1.name_language') }}</th>
                        <th>{{ __('sidebar-report-report_activation-index1.description_language') }}</th>
                        <th>{{ __('sidebar-report-report_activation-index1.created-at_language') }}</th>
                        <th width="5%"></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endif

<div class="modal fade" id="taskModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="/report/aktivasi_columns" class="form-report-column">
            @csrf
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('sidebar-report-report_activation-index1.set-activation_language') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ __('sidebar-report-report_activation-index1.name2_language') }}</label>
                        <input name="id" value="{{isset($report_columns->id)?$report_columns->id:''}}" hidden>
                        <input class="form-control" name="name" required autofocus placeholder="{{ __('sidebar-report-report_activation-index1.name3_language') }}" value="{{isset($report_columns->name)?$report_columns->name:''}}">
                    </div>
                    <div class="form-group">
                        <label>{{ __('sidebar-report-report_activation-index1.description2_language') }}</label>
                        <textarea class="form-control" name="description" required autofocus placeholder="{{ __('sidebar-report-report_activation-index1.description3_language') }}" rows="3">{{isset($report_columns->description)?$report_columns->description:''}}</textarea>
                    </div>
                    <div class="wrapper row">
                        <div class="col-md-6 container" id="left-rm-spill" style="border: 1px solid; max-height: 75vh; overflow: auto;">
                            @foreach(getAktivasiColumns() as $key => $val)
                                @if(!in_array($val['field'], $columns))
                                    <div id="{{$val['field']}}" data-field="{{$val['field']}}">{{$val['name']}}</div>
                                @endif
                            @endforeach
                        </div>
                        
                        <div class="col-md-6 container" id="right-rm-spill" style="border: 1px solid; max-height: 75vh; overflow: auto;">
                            @foreach(getAktivasiColumns() as $key => $val)
                                @if(in_array($val['field'], $columns))
                                    <div id="{{$val['field']}}" data-field="{{$val['field']}}">{{$val['name']}}</div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-success">{{ __('sidebar-report-report_activation-index1.submit_language') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if($report_columns)
<script>
    var param = {}
    var columns = {};
    var table_columns = [];
    
    
    
    $(document).ready(function() {
        <?php 
        echo "columns = $encode_columns;";
        echo "table_columns = $table_columns;";
        ?>
        initTask(param);
        $('select[name=id_site]').parent('.form-group').addClass('display-none');
        $(document).on('click', '.btn-refresh', function(e){
            e.preventDefault();
            param = {}
            $('select[name=aktivasi_type]').val('').trigger('change');
            $('select[name=id_customer]').val('').trigger('change');
            $('select[name=region]').val('').trigger('change');
            $('select[name=id_location]').val('').trigger('change');
            $('select[name=id_site]').val('').trigger('change');
            $('select[name=id_status]').val('').trigger('change');
            $('select[name=capasity_type]').val('').trigger('change');
            $('select[name=capasity]').val('').trigger('change');
            $('select[name=id_cord]').val('').trigger('change');
            $('.select_creation_from').val('');
            $('.select_creation_to').val('');
            initTask(param);
        });
        
        $(document).on('change', 'select[name=aktivasi_type]', function(e){
            e.preventDefault();
            param.aktivasi_type = $(this).val();
            initTask(param);
            initSelectStatus($(this).val());
        });
        $(document).on('change', 'select[name=id_customer]', function(e){
            e.preventDefault();
            param.id_customer = $(this).val();
            initTask(param);
        });
        $(document).on('change', 'select[name=region]', function(e){
            e.preventDefault();
            param.region = $(this).val();
            initTask(param);
        });
        $(document).on('change', 'select[name=id_location]', function(e){
            e.preventDefault();
            param.id_location = $(this).val();
            initTask(param);
        });
        $(document).on('change', 'select[name=id_site]', function(e){
            e.preventDefault();
            param.id_site = $(this).val();
            initTask(param);
        });
        $(document).on('change', 'select[name=id_status]', function(e){
            e.preventDefault();
            param.id_status = $(this).val();
            initTask(param);
        });
        $(document).on('change', 'select[name=capasity_type]', function(e){
            e.preventDefault();
            param.capasity_type = $(this).val();
            initTask(param);
        });
        $(document).on('change', 'select[name=capasity]', function(e){
            e.preventDefault();
            param.capasity = $(this).val();
            initTask(param);
        });
        $(document).on('change', 'select[name=id_cord]', function(e){
            e.preventDefault();
            param.id_cord = $(this).val();
            initTask(param);
        });
        $(document).on('change input', '.select_creation_from', function(e){
            e.preventDefault();
            param.created_at_from = $(this).val();
            if($('.select_creation_to').val()){
                initTask(param);
            }
        });
        $(document).on('change input', '.select_creation_to', function(e){
            e.preventDefault();
            param.created_at_to = $(this).val();
            if($('.select_creation_from').val()){
                initTask(param);
            }
        });
    });
    
    $(document).on('click', '.buttons-pdf', function(e){
       e.preventDefault();
       
    });
    
    function initSelectStatus(type){
        $(".select_status").select2({
            placeholder: "-- Status --",
        ajax: {
            url: "/api/aktivasi-layanan/getStatus",
            data: {
                'type': type
            },
            dataType: "json",
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data.data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        };
                    })
                };
            },
            cache: false,
            error: function (xhr, error, thrown) {
                ajax_fail(xhr, error);
            }
        }
        })
    }
    function initTask(param){
        var table = $('#table_task').DataTable( {
            "destroy": true,
            "bDestroy": true,
            "ajax": {
                "url": "/api/report/get_aktivasi_layanan",
                "data": param,
                "error": function (xhr, error, thrown) {
                    ajax_fail(xhr, error);
                }
            },
            "columns": table_columns,
            "columnDefs": [ ],
            "buttons": [
                { extend: 'excelHtml5', className: 'btn btn-md bg-success col-md-2' },
            ],
            "sDom": '<"row view-filter"B>t<"row view-pager"<"col-sm-12"<"pull-left"i><"pull-right"p>>>',
        });
        
        $('.dt-buttons').addClass('col-md-12');
        $('.dt-buttons').append('<a href="/report/aktivasi/pdf?id={{request()->id}}" target="new" class="dt-button btn btn-md bg-danger col-md-2">PDF</a>')
    }
</script>
@else
<script>
    function setDateRange(){
        var start = moment().subtract(29, 'days');
        var end = moment();
    
        function cb(start, end) {
            $('#select_date_range span').html(start.format('YYYY/MM/DD') + ' , ' + end.format('YYYY/MM/DD'));
        }
    
        $('#select_date_range').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
               '{{ __('sidebar-report-report_activation-index1.today_language') }}': [moment(), moment()],
               '{{ __('sidebar-report-report_activation-index1.yesterday_language') }}': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
               '{{ __('sidebar-report-report_activation-index1.last-7-days_language') }}': [moment().subtract(6, 'days'), moment()],
               '{{ __('sidebar-report-report_activation-index1.last-30-days_language') }}': [moment().subtract(29, 'days'), moment()],
               '{{ __('sidebar-report-report_activation-index1.this-month_language') }}': [moment().startOf('month'), moment().endOf('month')],
               '{{ __('sidebar-report-report_activation-index1.last-month_language') }}': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);
    
        cb(start, end);
    }
    var param = {}
    $(document).ready(function(){
        setDateRange();
        param.select_date_range = $('#select_date_range').val();
        initTask(param);
        $(document).on('click', '.btn-refresh', function(e){
            e.preventDefault();
            // param = {}
            $('.select_creation_from').val('');
            $('.select_creation_to').val('');
            initTask(param);
        });
        $(document).on('change input', '#select_date_range', function(e){
            e.preventDefault();
            param.select_date_range = $(this).val();
            initTask(param);
        });
        $(document).on('change input', '.select_creation_from', function(e){
            e.preventDefault();
            param.created_at_from = $(this).val();
            if($('.select_creation_to').val()){
                initTask(param);
            }
        });
        $(document).on('change input', '.select_creation_to', function(e){
            e.preventDefault();
            param.created_at_to = $(this).val();
            if($('.select_creation_from').val()){
                initTask(param);
            }
        });
        function initTask(param){
            var table = $('#table_task').DataTable( {
                "destroy": true,
                "bDestroy": true,
                "ajax": {
                    "url": "/api/report/getReport/AKTIVASI",
                    "data": param,
                    "error": function (xhr, error, thrown) {
                        ajax_fail(xhr, error);
                    }
                },
                "columns": [
                    { "data": "name" },
                    { "data": "description" },
                    { "data": "created_at" },
                    { "data": "id" }
                ],
                "columnDefs": [
                        {
                            "targets" : 0,
                            "data": "name",
                            "render" : function (data, type, row) {
                               return '<a href="/report/aktivasi?id='+row.id+'">'+row.name+'</a>';
                            }
                        },
                        {
                            "targets" : 3,
                            "data": "name",
                            "render" : function (data, type, row) {
                               return '<div class="btn-group">' +
                                         '<a href="/report/aktivasi_edit/'+row.id+'" class="btn btn-sm btn-warning text-white"><i class="fa fa-edit"></i></a>' +
                                         '<a href="/report/aktivasi_delete/'+row.id+'" class="btn btn-sm btn-danger text-white"><i class="fa fa-trash-alt"></i></a>' +
                                       '</div>';
                            }
                        },
                    ],
                "order": [[1, 'asc']],
                "sDom": 't<"row view-pager"<"col-sm-12"<"pull-left"i><"pull-right"p>>>',
            });
            oTable = $('#table_task').DataTable();
            $('#search').keyup(function(){
                  oTable.search($(this).val()).draw() ;
            })
        }
    })
</script>
@endif

<script src='https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.2/dragula.min.js'></script>
<script>
    var main_drake = dragula([document.getElementById('left-rm-spill'),document.getElementById('right-rm-spill')], {
      revertOnSpill: true,
      removeOnSpill: false,
    });
    
    main_drake.on('drop', function(el, target, source, sibling){
        var ini = $(el)
    });
    
    $(document).on('submit', '.form-report-column', function(e){
        e.preventDefault();
        $('#modal_new_data').modal('hide');
        var e_modal_wait = $("#modalWait");
        showLoading(e_modal_wait);
        
        var ini = $(this),  input_token = ini.find('input[name=_token]'),   url = ini.attr('action');
        
        var divs = $("#right-rm-spill").children("div");
            fields = []
            $.each(divs, function( index, value ) {
                el = $(value);
                fields.push(el.data('field')); 
            });
        
        $.ajax({
            url: url,
            type: "post",
            data: {
                is_ajax: true,
                _token: input_token.val(),
                id: ini.find('input[name=id]').val(),
                name: ini.find('input[name=name]').val(),
                description: ini.find('textarea[name=description]').val(),
                fields: fields,
            }
        })
        .done(function (result) {
            hideLoading(e_modal_wait);
            input_token.val(result.newtoken);
            if (result.status) {
                var message = result.message || 'Success';
                successAlert(message);
                location.reload()
            } else {
                var message = result.message || 'Api connection problem';
                failedAlert(message);
            }
        })
        .fail(ajax_fail);
    });
</script>
@endsection
