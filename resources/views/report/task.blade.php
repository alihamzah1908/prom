@extends('template.default')
@section('title', 'Task Reports')
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
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
 
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

@if($report_columns)
<div class="card collapsed-card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-7">
                <h3 class="card-title"><a href="/report/task"><i class="fa fa-arrow-left text-gray"></i></a> <strong>{{ __('sidebar-report-task_report-index1.query-task_language') }}</strong></h3>
            </div>
            <div class="col-md-2">
                <button type="button" class="form-control bg-primary" data-toggle="modal" data-target="#taskModal"> 
                    {{ __('sidebar-report-task_report-index1.column_language') }}
                </button>
            </div>
            <div class="col-md-2">
                <button type="button" class="form-control btn-default btn-refresh" style="color: #828282">
                    <i class="fas fa-redo-alt"></i>&nbsp;&nbsp; {{ __('sidebar-report-task_report-index1.refresh_language') }}
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
                <select class="form-control btn-default select_task_type" name="task_type">
                    <option selected="selected" disabled value="">-- {{ __('sidebar-report-task_report-index1.task-type_language') }} --</option>
                    @foreach($types as $type)
                        <option value="{{$type->id_type}}">{{$type->type_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3"></div>
            <div class="col-md-3"></div>
            <div class="col-md-3"></div>
            
            <div class="col-md-3 form-group">
                <select class="form-control select2 btn-default select_category" style="width: 100%;" required autofocus name="id_category">
                    <option selected="selected" disabled value="">-- {{ __('sidebar-report-task_report-index1.category_language') }} --</option>
                    @foreach(\App\Model\Category::get() as $cat)
                        <option value="{{$cat->id_category}}">{{$cat->category_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 form-group">
                <select class="form-control btn-default select_region" name="region">
                    <option selected="selected" disabled value="">-- {{ __('sidebar-report-task_report-index1.region_language') }} --</option>
                    @foreach(\App\Model\Region::get() as $region)
                        <option value="{{$region->region_id}}">{{$region->region_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 form-group">
                <select class="form-control btn-default select2" style="width: 100%;" required autofocus name="id_priority">
                    <option selected="selected" disabled value="">-- {{ __('sidebar-report-task_report-index1.priority_language') }} --</option>
                    @foreach(\App\Model\Priority::get() as $priority)
                        <option value="{{$priority->id_priority}}">{{$priority->priority_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 form-group">
                <select class="form-control btn-default select_status" type="text" name="id_status">
                    <option selected="selected" disabled value="">-- {{ __('sidebar-report-task_report-index1.status_language') }} --</option>
                    @foreach(\App\Model\Status::orderBy('id_status')->get() as $status)
                        <option value="{{$status->id_status}}">{{$status->status_name}}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-3 form-group">
                <select class="form-control btn-default select2" style="width: 100%;" required autofocus name="id_impact">
                    <option selected="selected" disabled value="">-- {{ __('sidebar-report-task_report-index1.impact_language') }} --</option>
                    @foreach(\App\Model\Impact::get() as $impact)
                        <option value="{{$impact->id_impact}}">{{$impact->impact_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 form-group">
                <select class="form-control btn-default select2" style="width: 100%;" required autofocus name="id_group_internal">
                    <option selected="selected" disabled value="">-- {{ __('sidebar-report-task_report-index1.grup-internal_language') }} --</option>
                    @foreach(\App\Model\GroupInternal::get() as $group)
                        <option value="{{$group->id_group}}">{{$group->name_group}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 form-group">
                <select class="form-control btn-default select2-multiple" style="width: 100%;" required autofocus id="id_group_customer" name="id_group_customer[]" multiple>
                    @foreach(\App\Model\GroupCustomer::get() as $g_customer)
                        <option value="{{$g_customer->id_group}}">{{$g_customer->group_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 form-group">
                <select class="form-control btn-default select2" style="width: 100%;" required autofocus name="id_technician">
                    <option selected="selected" disabled value="">-- {{ __('sidebar-report-task_report-index1.technician_language') }} --</option>
                    @foreach(\App\Model\Technician::get() as $tech)
                        <option value="{{$tech->id_technician}}">{{$tech->name_technician}}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-3 form-group">
                <select class="form-control btn-default select2" style="width: 100%;" required autofocus name="id_location_a">
                    <option selected="selected" disabled value="">-- {{ __('sidebar-report-task_report-index1.location-a_language') }} --</option>
                    @foreach(\App\Model\Segment::get() as $segment)
                        <option value="{{$segment->id_segment}}">{{$segment->segment_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 form-group">
                <select class="form-control btn-default select2" style="width: 100%;" required autofocus name="id_site_a">
                    <option selected="selected" disabled value="">-- {{ __('sidebar-report-task_report-index1.situs-a_language') }} --</option>
                    @foreach(\App\Model\Site::get() as $site)
                        <option value="{{$site->site_id}}">{{$site->name_site}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 form-group">
                <select class="form-control btn-default select2" style="width: 100%;" required autofocus name="id_location_b">
                    <option selected="selected" disabled value="">-- {{ __('sidebar-report-task_report-index1.location-b_language') }} --</option>
                    @foreach(\App\Model\Segment::get() as $segment)
                        <option value="{{$segment->id_segment}}">{{$segment->segment_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 form-group">
                <select class="form-control btn-default select2" style="width: 100%;" required autofocus name="id_site_b">
                    <option selected="selected" disabled value="">-- {{ __('sidebar-report-task_report-index1.site-b_language') }} --</option>
                    @foreach(\App\Model\Site::get() as $site)
                        <option value="{{$site->site_id}}">{{$site->name_site}}</option>
                    @endforeach
                </select>
            </div>
        
            <div class="col-md-3 form-group">
                <select class="form-control btn-default select2" style="width: 100%;" required autofocus name="checklist_periode">
                    <option selected="selected" disabled value="">-- {{ __('sidebar-report-task_report-index1.checklist-period_language') }} --</option>
                    @foreach(\App\Model\ChecklistPeriode::get() as $per)
                        <option value="{{$per->id_periode}}">{{$per->periode_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 form-group">
                <select class="form-control select2-multiple-checklist-category" style="width: 100%;" name="id_checklist_category[]" id="id_checklist_category" multiple>
                    @foreach(\App\Model\ChecklistCategory::get() as $cat)
                        <option value="{{$cat->id_category}}">{{$cat->category_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 form-group">
                <select class="form-control btn-default select2" style="width: 100%;" name="id_root_caused" required autofocus>
                    <option selected="selected" value="" disabled>-- {{ __('sidebar-report-task_report-index1.root-caused_language') }} --</option>
                    @foreach(\App\Model\RootCaused::get() as $root)
                        <option value="{{$root->id_caused}}">{{$root->name_caused}}</option>
                    @endforeach
                </select>
            </div>
            <!--<div class="col-md-3"></div>-->
        </div>
        <div class="row">
            <div class="col-md-3 form-group">
                <label for="" class="label">{{ __('sidebar-report-task_report-index1.creation-time-from_language') }}</label>
                <input type="date" style="color:#828282 !important" class="form-control btn-default select_creation_from">
            </div>
            <div class="col-md-3 form-group">
                <label for="" class="label">{{ __('sidebar-report-task_report-index1.to_language') }}</label>
                <input type="date" style="color:#828282 !important" class="form-control btn-default select_creation_to">
            </div>
            <div class="col-md-3 form-group">
                <label for="" class="label">{{ __('sidebar-report-task_report-index1.completion-time-from_language') }}</label>
                <input type="date" style="color:#828282 !important" class="form-control btn-default select_completion_from">
            </div>
            <div class="col-md-3 form-group">
                <label for="" class="label">{{ __('sidebar-report-task_report-index1.to2_language') }}</label>
                <input type="date" style="color:#828282 !important" class="form-control btn-default select_completion_to">
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h3 class="card-title"> <strong>{{ __('sidebar-report-task_report-index1.query-result_language') }}</strong></h3>
    </div>
    <div class="card-body">
        
        <div class="table_container" style="overflow-x: auto;">
            <table id="table_task" class="display table table-striped table-responsive2 table-border-gray" style="width:100%;">
                <thead>
                    <tr>
                        @foreach($columns as $k => $val)
                            <th>{{getTaskColumns($val)['name']}}</th>
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
                <label for="" class="label">{{ __('sidebar-report-task_report-index1.creation-time-from2_language') }}</label>
                <input id="select_date_range" type="text" style="color:#828282 !important" class="form-control btn-default select_date_range" autocomplete="off" placeholder="{{ __('sidebar-report-task_report-index1.date-range_language') }}">
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
                <button type="button" class="form-control btn-default btn-refresh" style="color: #828282"><i class="fas fa-redo-alt"></i>&nbsp;&nbsp; {{ __('sidebar-report-task_report-index1.refresh_language') }}</button>
            </div>
            <div class="col-md-3 form-group">
                <label for="" class="label">&nbsp;</label>
                <input class="form-control btn-default" id="search" type="text" placeholder="{{ __('sidebar-report-task_report-index1.search_language') }}" aria-label="Search">
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-10">
                <h3 class="card-title"><strong>{{ __('sidebar-report-task_report-index1.reports_language') }}</strong></h3>
            </div>
            <div class="col-md-2">
                <button type="button" class="form-control bg-primary" data-toggle="modal" data-target="#taskModal"> 
                    {{ __('sidebar-report-task_report-index1.new-report_language') }}
                </button>
            </div>
        </div>
    </div>
    <div class="card-body">
        
        <div class="table_container">
            <table id="table_task" class="display table table-striped table-bordered table-border-gray" style="width:100%">
                <thead>
                    <tr>
                        <th>{{ __('sidebar-report-task_report-index1.name_language') }}</th>
                        <th>{{ __('sidebar-report-task_report-index1.description_language') }}</th>
                        <th>{{ __('sidebar-report-task_report-index1.created-at_language') }}</th>
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
            <form method="POST" action="/report/task_columns" class="form-report-column">
            @csrf
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('sidebar-report-task_report-index1.set-task_language') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ __('sidebar-report-task_report-index1.name2_language') }}</label>
                        <input name="id" value="{{isset($report_columns->id)?$report_columns->id:''}}" hidden>
                        <input class="form-control" name="name" required autofocus placeholder="{{ __('sidebar-report-task_report-index1.name3_language') }}" value="{{isset($report_columns->name)?$report_columns->name:''}}">
                    </div>
                    <div class="form-group">
                        <label>{{ __('sidebar-report-task_report-index1.description2_language') }}</label>
                        <textarea class="form-control" name="description" required autofocus placeholder="{{ __('sidebar-report-task_report-index1.description3_language') }}" rows="3">{{isset($report_columns->description)?$report_columns->description:''}}</textarea>
                    </div>
                    <div class="wrapper row">
                        <div class="col-md-6 container" id="left-rm-spill" style="border: 1px solid; max-height: 75vh; overflow: auto;">
                            @foreach(getTaskColumns() as $key => $val)
                                @if(!in_array($val['field'], $columns))
                                    <div id="{{$val['field']}}" data-field="{{$val['field']}}">{{$val['name']}}</div>
                                @endif
                            @endforeach
                        </div>
                        
                        <div class="col-md-6 container" id="right-rm-spill" style="border: 1px solid; max-height: 75vh; overflow: auto;">
                            @foreach(getTaskColumns() as $key => $val)
                                @if(in_array($val['field'], $columns))
                                    <div id="{{$val['field']}}" data-field="{{$val['field']}}">{{$val['name']}}</div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-success">{{ __('sidebar-report-task_report-index1.submit_language') }}</button>
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
    
    $('.select2-multiple').select2({
        placeholder: "Group External"
    });
    $('.select2-multiple-checklist-category').select2({
        placeholder: "Checklist Category"
    });
    $(document).ready(function() {
        <?php 
        echo "columns = $encode_columns;";
        echo "table_columns = $table_columns;";
        ?>
        // table_columns = [];
        // $.each(columns, function( index, value ) {
        //     console.log(value)
        //     table_columns.push({"data": value}); 
        // });
        initTask(param);
        
        $('#id_group_customer').parent('.form-group').addClass('display-none');
        $('select[name=checklist_periode]').parent('.form-group').addClass('display-none');
        $('#id_checklist_category').parent('.form-group').addClass('display-none');
        
        $(document).on('click', '.btn-refresh', function(e){
            e.preventDefault();
            param = {}
            $('.select_task_type').val('');
            $('select[name=id_category]').val('').trigger('change');
            $('.select_region').val('');
            $('select[name=id_priority]').val('');
            $('.select_status').val('');
            $('select[name=id_impact]').val('');
            $('select[name=id_group_internal]').val('');
            $('#id_group_customer').val('');
            $('select[name=id_technician]').val('');
            $('select[name=id_location_a]').val('');
            $('select[name=id_site_a]').val('');
            $('select[name=id_location_b]').val('');
            $('select[name=id_site_b]').val('');
            $('select[name=checklist_periode]').val('');
            $('#id_checklist_category').val('');
            $('select[name=id_root_caused]').val('');
            $('.select_creation_from').val('');
            $('.select_creation_to').val('');
            $('.select_completion_from').val('');
            $('.select_completion_to').val('');
            initTask(param);
        });
        
        $(document).on('change', '.select_task_type', function(e){
            e.preventDefault();
            param.id_type = $(this).val();
            initTask(param);
        });
        
        $(document).on('change', 'select[name=id_category]', function(e){
            e.preventDefault();
            param.id_category = $(this).val();
            initTask(param);
        });
        $(document).on('change', '.select_region', function(e){
            e.preventDefault();
            param.id_region = $(this).val();
            initTask(param);
        });
        $(document).on('change', 'select[name=id_priority]', function(e){
            e.preventDefault();
            param.id_priority = $(this).val();
            initTask(param);
        });
        $(document).on('change', '.select_status', function(e){
            e.preventDefault();
            param.id_status = $(this).val();
            initTask(param);
        });
        $(document).on('change', 'select[name=id_impact]', function(e){
            e.preventDefault();
            param.id_impact = $(this).val();
            initTask(param);
        });
        $(document).on('change', 'select[name=id_group_internal]', function(e){
            e.preventDefault();
            param.id_group_internal = $(this).val();
            initTask(param);
        });
        $(document).on('change', '#id_group_customer', function(e){
            e.preventDefault();
            val = $("#id_group_customer :selected").map(function(i, el) {
                return $(el).val();
            }).get();
            
            param.id_group_customer = val;
            initTask(param);
        });
        $(document).on('change', 'select[name=id_technician]', function(e){
            e.preventDefault();
            param.id_technician = $(this).val();
            initTask(param);
        });
        $(document).on('change', 'select[name=id_location_a]', function(e){
            e.preventDefault();
            param.id_location_a = $(this).val();
            initTask(param);
        });
        $(document).on('change', 'select[name=id_site_a]', function(e){
            e.preventDefault();
            param.id_site_a = $(this).val();
            initTask(param);
        });
        $(document).on('change', 'select[name=id_location_b]', function(e){
            e.preventDefault();
            param.id_location_b = $(this).val();
            initTask(param);
        });
        $(document).on('change', 'select[name=id_site_b]', function(e){
            e.preventDefault();
            param.id_site_b = $(this).val();
            initTask(param);
        });
        $(document).on('change', 'select[name=checklist_periode]', function(e){
            e.preventDefault();
            param.checklist_periode = $(this).val();
            initTask(param);
        });
        $(document).on('change', '#id_checklist_category', function(e){
            e.preventDefault();
            val = $("#id_checklist_category :selected").map(function(i, el) {
                return $(el).val();
            }).get();
            
            param.id_checklist_category = val;
            initTask(param);
        });
        $(document).on('change', 'select[name=id_root_caused]', function(e){
            e.preventDefault();
            param.id_root_caused = $(this).val();
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
        $(document).on('change input', '.select_completion_from', function(e){
            e.preventDefault();
            param.completion_from = $(this).val();
            if($('.select_completion_to').val()){
                initTask(param);
            }
        });
        $(document).on('change input', '.select_completion_to', function(e){
            e.preventDefault();
            param.completion_to = $(this).val();
            if($('.select_completion_from').val()){
                initTask(param);
            }
        });
    });
    
    function initTask(param){
        var table = $('#table_task').DataTable( {
            "destroy": true,
            "bDestroy": true,
            "ajax": {
                "url": "/api/task/getTaskReport",
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
        $('.dt-buttons').append('<a href="/report/task/pdf?id={{request()->id}}" target="new" class="dt-button btn btn-md bg-danger col-md-2">PDF</a>')
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
               '{{ __('sidebar-report-task_report-index1.today_language') }}': [moment(), moment()],
               '{{ __('sidebar-report-task_report-index1.yesterday_language') }}': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
               '{{ __('sidebar-report-task_report-index1.last-7-days_language') }}': [moment().subtract(6, 'days'), moment()],
               '{{ __('sidebar-report-task_report-index1.last-30-days_language') }}': [moment().subtract(29, 'days'), moment()],
               '{{ __('sidebar-report-task_report-index1.this-month_language') }}': [moment().startOf('month'), moment().endOf('month')],
               '{{ __('sidebar-report-task_report-index1.last-month_language') }}': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
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
                    "url": "/api/report/getReport/TASK",
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
                               return '<a href="/report/task?id='+row.id+'">'+row.name+'</a>';
                            }
                        },
                        {
                            "targets" : 3,
                            "data": "name",
                            "render" : function (data, type, row) {
                               return '<div class="btn-group">' +
                                         '<a href="/report/task_edit/'+row.id+'" class="btn btn-sm btn-warning text-white"><i class="fa fa-edit"></i></a>' +
                                         '<a href="/report/task_delete/'+row.id+'" class="btn btn-sm btn-danger text-white"><i class="fa fa-trash-alt"></i></a>' +
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
