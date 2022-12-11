@extends('template.default')
@section('title', 'Task Reports')
@section('submenu')
<div class="row mb-2">
    <div class="col-sm-6">
        <h3 class="m-0 text-dark"><strong>Task Reports</strong></h3>
    </div>
</div>
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
</style>

@if($report_columns)
<div class="card collapsed-card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-7">
                <h3 class="card-title"><a href="/report/task"><i class="fa fa-arrow-left text-gray"></i></a> <strong>Query Task</strong></h3>
            </div>
            <div class="col-md-2">
                <button type="button" class="form-control bg-primary" data-toggle="modal" data-target="#taskModal"> 
                    Columns
                </button>
            </div>
            <div class="col-md-2">
                <button type="button" class="form-control btn-default btn-refresh" style="color: #828282">
                    <i class="fas fa-redo-alt"></i>&nbsp;&nbsp; Refresh
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
                    <option selected="selected" disabled value="">-- Task Type --</option>
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
                    <option selected="selected" disabled value="">-- Category --</option>
                    @foreach(\App\Model\Category::get() as $cat)
                        <option value="{{$cat->id_category}}">{{$cat->category_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 form-group">
                <select class="form-control btn-default select_region" name="region">
                    <option selected="selected" disabled value="">-- Region --</option>
                    @foreach(\App\Model\Region::get() as $region)
                        <option value="{{$region->region_id}}">{{$region->region_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 form-group">
                <select class="form-control btn-default select2" style="width: 100%;" required autofocus name="id_priority">
                    <option selected="selected" disabled value="">-- Priority --</option>
                    @foreach(\App\Model\Priority::get() as $priority)
                        <option value="{{$priority->id_priority}}">{{$priority->priority_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 form-group">
                <select class="form-control btn-default select_status" type="text" name="id_status">
                    <option selected="selected" disabled value="">-- Status --</option>
                    @foreach(\App\Model\Status::orderBy('id_status')->get() as $status)
                        <option value="{{$status->id_status}}">{{$status->status_name}}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-3 form-group">
                <select class="form-control btn-default select2" style="width: 100%;" required autofocus name="id_impact">
                    <option selected="selected" disabled value="">-- Impact --</option>
                    @foreach(\App\Model\Impact::get() as $impact)
                        <option value="{{$impact->id_impact}}">{{$impact->impact_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 form-group">
                <select class="form-control btn-default select2" style="width: 100%;" required autofocus name="id_group_internal">
                    <option selected="selected" disabled value="">-- Group Internal --</option>
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
                    <option selected="selected" disabled value="">-- Technician --</option>
                    @foreach(\App\Model\Technician::get() as $tech)
                        <option value="{{$tech->id_technician}}">{{$tech->name_technician}}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-3 form-group">
                <select class="form-control btn-default select2" style="width: 100%;" required autofocus name="id_location_a">
                    <option selected="selected" disabled value="">-- Location A --</option>
                    @foreach(\App\Model\Segment::get() as $segment)
                        <option value="{{$segment->id_segment}}">{{$segment->segment_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 form-group">
                <select class="form-control btn-default select2" style="width: 100%;" required autofocus name="id_site_a">
                    <option selected="selected" disabled value="">-- Site A --</option>
                    @foreach(\App\Model\Site::get() as $site)
                        <option value="{{$site->site_id}}">{{$site->name_site}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 form-group">
                <select class="form-control btn-default select2" style="width: 100%;" required autofocus name="id_location_b">
                    <option selected="selected" disabled value="">-- Location B --</option>
                    @foreach(\App\Model\Segment::get() as $segment)
                        <option value="{{$segment->id_segment}}">{{$segment->segment_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 form-group">
                <select class="form-control btn-default select2" style="width: 100%;" required autofocus name="id_site_b">
                    <option selected="selected" disabled value="">-- Site B --</option>
                    @foreach(\App\Model\Site::get() as $site)
                        <option value="{{$site->site_id}}">{{$site->name_site}}</option>
                    @endforeach
                </select>
            </div>
        
            <div class="col-md-3 form-group">
                <select class="form-control btn-default select2" style="width: 100%;" required autofocus name="checklist_periode">
                    <option selected="selected" disabled value="">-- Checklist Periode --</option>
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
                    <option selected="selected" value="" disabled>-- Root Caused --</option>
                    @foreach(\App\Model\RootCaused::get() as $root)
                        <option value="{{$root->id_caused}}">{{$root->name_caused}}</option>
                    @endforeach
                </select>
            </div>
            <!--<div class="col-md-3"></div>-->
        </div>
        <div class="row">
            <div class="col-md-3 form-group">
                <label for="" class="label">Creation time from</label>
                <input type="date" style="color:#828282 !important" class="form-control btn-default select_creation_from">
            </div>
            <div class="col-md-3 form-group">
                <label for="" class="label">to</label>
                <input type="date" style="color:#828282 !important" class="form-control btn-default select_creation_to">
            </div>
            <div class="col-md-3 form-group">
                <label for="" class="label">Completion time from</label>
                <input type="date" style="color:#828282 !important" class="form-control btn-default select_completion_from">
            </div>
            <div class="col-md-3 form-group">
                <label for="" class="label">to</label>
                <input type="date" style="color:#828282 !important" class="form-control btn-default select_completion_to">
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h3 class="card-title"> <strong>Query Result</strong></h3>
    </div>
    <div class="card-body">
        
        <div class="table_container" style="overflow-x: auto;">
            <table id="table_task" class="display table table-striped table-responsive2" style="width:100%;">
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
    <div class="card-header">
        <div class="row">
            <div class="col-md-10">
                <h3 class="card-title"><strong>Reports</strong></h3>
            </div>
            <div class="col-md-2">
                <button type="button" class="form-control bg-primary" data-toggle="modal" data-target="#taskModal"> 
                    New Report
                </button>
            </div>
        </div>
    </div>
    <div class="card-body">
        
        <div class="table_container">
            <table id="table_task" class="display table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th width="5%"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(\App\Model\ReportColumn::where('type', 'TASK')->get() as $rc)
                    <tr>
                        <td>
                            <a href="/report/task?id={{$rc->id}}" data-id="{{$rc->id}}" class="report_name">{{$rc->name}}</a>
                        </td>
                        <td>{{$rc->description}}</td>
                        <td>
                            <div class="btn-group">
                                <a href="/report/task_edit/{{$rc->id}}" class="btn btn-sm btn-warning text-white"><i class="fa fa-edit"></i></a>
                                <a href="/report/task_delete/{{$rc->id}}" class="btn btn-sm btn-danger text-white"><i class="fa fa-trash-alt"></i></a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
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
                    <h4 class="modal-title">Set Task</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input name="id" value="{{isset($report_columns->id)?$report_columns->id:''}}" hidden>
                        <input class="form-control" name="name" required autofocus placeholder="Name" value="{{isset($report_columns->name)?$report_columns->name:''}}">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" name="description" required autofocus placeholder="Description" rows="3">{{isset($report_columns->description)?$report_columns->description:''}}</textarea>
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
                    <button type="submit" class="btn btn-md btn-success">Submit</button>
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
        // var container = $('.table_container'),
        //     table     = '<table id="table_task" class="display table table-striped" style="width:100%">' +
        //                     '<thead>' +
        //                         '<tr>' +
        //                             '<th class="text-dark">Task ID</th>' +
        //                             '<th class="text-dark">Task Status</th>' +
        //                             '<th>Title</th>' +
        //                             '<th>Site ID</th>' +
        //                             '<th>Creation Time</th>' +
        //                             '<th>Completion Time</th>' +
        //                         '</tr>' +
        //                     '</thead>' +
        //                 '</table>';
        // container.html(table);
        
        setTask(param)
    }
    function setTask(param){
        var table = $('#table_task').DataTable( {
            "destroy": true,
            "bDestroy": true,
            "ajax": {
                "url": "/task/getTask",
                "data": param
            },
            "columns": table_columns,
            "columnDefs": [ ],
            "buttons": [
                { extend: 'excelHtml5', className: 'btn btn-md bg-success col-md-2' },
                { extend: 'pdfHtml5', className: 'btn btn-md bg-danger col-md-2' },
            ],
            "sDom": '<"row view-filter"B>t<"row view-pager"<"col-sm-12"<"pull-left"i><"pull-right"p>>>',
        });
        
        $('.dt-buttons').addClass('col-md-12');
    }
</script>
@else
<script>
    $(document).ready(function(){
        $('#table_task').DataTable()
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
