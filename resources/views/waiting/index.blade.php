@extends('template.default')
@section('title', 'Waiting Approval')
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
    <!-- /.card-header -->
    <!--<div class="card-header">-->
    <!--    <h3 class="card-title"> <strong>Waiting Approval Task</strong></h3>-->
    <!--</div>-->
    {{-- card body --}}
    <div class="card-body">
        <div class="row">
            <div class="col-md-2 form-group">
                <select class="form-control btn-default select_task_type" name="task_type">
                    <option selected="selected" disabled value="">-- {{ __('sidebar-waiting_approval-task-index1.task-type_language') }} --</option>
                    @foreach($types as $type)
                        <option value="{{$type->id_type}}">{{$type->type_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 form-group">
                <select class="form-control btn-default select_region" name="region">
                    <option selected="selected" disabled value="">-- {{ __('sidebar-waiting_approval-task-index1.region_language') }} --</option>
                    @foreach(\App\Model\Region::get() as $region)
                        <option value="{{$region->region_id}}">{{$region->region_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 form-group"></div>
            <div class="col-md-2 form-group">
                
            </div>
            <div class="col-md-2 form-group">
                
            </div>
            <div class="col-md-2 form-group">
                <span class="icon"><i class="fas fa-search"></i></span>
                <input class="form-control btn-default" id="search" type="text" placeholder="{{ __('sidebar-waiting_approval-task-index1.search_language') }}" aria-label="Search">
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 form-group">
                <label for="" class="label">{{ __('sidebar-waiting_approval-task-index1.creation-time-from_language') }}</label>
                <input type="date" name="" id="" style="color:#828282 !important" class="form-control btn-default select_creation_from">
            </div>
            <div class="col-md-2 form-group">
                <label for="" class="label">{{ __('sidebar-waiting_approval-task-index1.to_language') }}</label>
                <input type="date" name="" id="" style="color:#828282 !important" class="form-control btn-default select_creation_to">
            </div>
            <div class="col-md-2 form-group">
                <label for="" class="label">{{ __('sidebar-waiting_approval-task-index1.completion-time-from_language') }}</label>
                <input type="date" name="" id="" style="color:#828282 !important" class="form-control btn-default select_completion_from">
            </div>
            <div class="col-md-2 form-group">
                <label for="" class="label">{{ __('sidebar-waiting_approval-task-index1.to2_language') }}</label>
                <input type="date" name="" id="" style="color:#828282 !important" class="form-control btn-default select_completion_to">
            </div>
            <div class="col-md-2" style="padding-top: 32px">
                <button type="button" class="form-control btn-default btn-refresh" style="color: #828282">
                    <i class="fas fa-redo-alt"></i>&nbsp;&nbsp; {{ __('sidebar-waiting_approval-task-index1.refresh_language') }}
                </button>
            </div>
            <div class="col-md-2" style="padding-top: 32px">
                <a href="#" class="form-control btn-default" style="color: #828282">
                    <i class="fas fa-download"></i>&nbsp;{{ __('sidebar-waiting_approval-task-index1.download_language') }}
                </a>
            </div>
        </div>
        <table id="table_task" class="display table table-striped table-border-gray" style="width:100%">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th></th>
                    <th class="text-dark">{{ __('sidebar-waiting_approval-task-index1.task-status_language') }}</th>
                    <th>{{ __('sidebar-waiting_approval-task-index1.task-id_language') }}</th>
                    <th>{{ __('sidebar-waiting_approval-task-index1.title_language') }}</th>
                    <th>{{ __('sidebar-waiting_approval-task-index1.site-id_language') }}</th>
                    <th>{{ __('sidebar-waiting_approval-task-index1.creation-time_language') }}</th>
                    <th>{{ __('sidebar-waiting_approval-task-index1.completion-time_language') }}</th>
                </tr>
            </thead>
        </table>
    </div>
    <!-- /.card-body -->
</div>

<script>
    var param = {}
    $(document).ready(function() {
        initTask(param);
        
        $(document).on('click', '.btn-refresh', function(e){
            e.preventDefault();
            param.id_type = '';
            param.id_region = '';
            param.id_status = '';
            param.created_at_from = '';
            param.created_at_to = '';
            param.created_at_from = '';
            param.completion_from = '';
            $('.select_task_type').val('');
            $('.select_region').val('');
            $('.select_status').val('');
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
        
        $(document).on('change', '.select_region', function(e){
            e.preventDefault();
            param.id_region = $(this).val();
            initTask(param);
        });
        
        $(document).on('change', '.select_status', function(e){
            e.preventDefault();
            param.id_status = $(this).val();
            initTask(param);
        });
        
        $(document).on('change input', '.select_creation_from', function(e){
            e.preventDefault();
            param.created_at_from = $(this).val();
            if($('.select_creation_to').val()){
                initTask(param);
            }
            initTask(param);
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
                "url": "/api/waiting_approval/getWaitingApproval",
                "data": param,
                "error": function (xhr, error, thrown) {
                    ajax_fail(xhr, error);
                }
            },
            "columns": [
                { "data": "id_task" },
                { "data": "id_task" , "className": "text-center"},
                { "data": "task_status"},
                { "data": "task_uid" },
                { "data": "subject" },
                { "data": "site_name" },
                { "data": "created_at" },
                { "data": "time_complete" }
            ],
            "columnDefs": [
                {
                    "targets" : 1,
                    "data": "id_task",
                    "render" : function (data, type, row) {
                       return '<input type="checkbox" name="table_task_check">';
                    }
                },
                {
                    "targets" : 2,
                    "data": "id_task",
                    "render" : function (data, type, row) {
                       return '<a href="/waiting_approval/detail/'+row.id_task+'">'+row.task_status+'</a>';
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
</script>
@endsection
