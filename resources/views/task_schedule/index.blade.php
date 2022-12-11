@extends('template.default')
@section('title', 'Task')

@section('submenu')
<!--<div class="row mb-2">-->
<!--    <div class="col-sm-6">-->
<!--        <h3 class="m-0 text-dark"><strong>Task</strong></h3>-->
<!--    </div>-->
<!--</div>-->
@endsection
@section('content')

@if(Session::has('message') || session('message'))
    @if(Session::has('data') || session('data'))
        <?php $m_data = Session::get('data'); if(session('data')) $m_data = session('data')?>
        <script>
            $(document).ready(function(){
                var message = '<div>' +
                                '<h3 class="card-title">{{Session::get("message")}}!</h3>' +
                                '<div class="row p-4">' +
                                    '<div class="col-md-6 text-left">' + 
                                        '<strong>Task UID</strong>' +
                                        '<p class="text-muted">{{$m_data->task_uid}}</p>' +
                                        '<hr>' +
                                        '<strong>Subject</strong>' +
                                        '<p class="text-muted">{{$m_data->subject}}</p>' +
                                        '<hr>' +
                                        '<strong>Description</strong>' +
                                        '<p class="text-muted">{{$m_data->description}}</p>' +
                                        '<hr>' +
                                        '<strong>Created At</strong>' +
                                        '<p class="text-muted">{{$m_data->created_at}}</p>' +
                                        '<hr>' +
                                    '</div>' +
                                    '<div class="col-md-6 text-left">' + 
                                        '<strong>Impact Detail</strong>' +
                                        '<p class="text-muted">{{isset($m_data->impact_detail)?$m_data->impact_detail:"-"}}</p>' +
                                        '<hr>' +
                                        '<strong>Subject</strong>' +
                                        '<p class="text-muted">{{isset($m_data->getCategory)?$m_data->getCategory->category_name:"-"}}</p>' +
                                        '<hr>' +
                                        '<strong>Suspect</strong>' +
                                        '<p class="text-muted">-</p>' +
                                        '<hr>' +
                                        '<strong>Update Progress</strong>' +
                                        '<p class="text-muted">-</p>' +
                                        '<hr>' +
                                    '</div>' +
                                '</div>' +
                              '</div>';
                successAlertLarge(message);
            })
        </script>
    @else
        <div class="alert {{Session::get('alert-class')}} alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            {{ Session::get('message') }}
        </div>
    @endif
@endif

<link href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<style>
    td.details-control {
        background: url('/images/details_open.png') no-repeat center center;
        cursor: pointer;
    }
    tr.shown td.details-control {
        background: url('/images/details_close.png') no-repeat center center;
    }
    table.dataTable tbody th, table.dataTable tbody td {
    padding: 0px 0px !important;
    padding-top: 0px !important;
    padding-bottom: 0px !important;
    }
    .container-fluid {
    width: 100%;
    padding: 7px !important;
    margin-right: auto;
    margin-left: auto;
    }
    .card-header {
    background-color: transparent;
    border-bottom: 0px solid rgba(0, 0, 0, .125);
    padding: 0.5rem 0.3rem;
    position: relative;
    border-top-left-radius: .25rem;
    border-top-right-radius: .25rem;
    }
    .card-body {
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    padding: 0.3rem 15px;
    }
    .container-fluid {
    width: 100%;
    padding: 0px !important;
    margin-right: auto;
    margin-left: auto;
    }
    .content-wrapper>.content {
    padding: 0rem;
    }
    .pad {
       padding: 0.3rem 15px; 
    }
    
</style>
<div class="card pad">
    <div class="card-body">
        <div class="row">
        <!-- dozoftware -->
        
            <div class="col-md-6">
                <h3 class="card-title"> <strong>Task Schedule</strong></h3>
            </div>
            
          
            <div class="col-md-2"></div>
            <div class="col-md-2"></div>
        @if(1==2)   
            <div class="col-md-2">
                <!--<label for="" class="label">&nbsp;</label>-->
                <a href="#" class="form-control btn-default" style="color: #828282" data-toggle="modal" data-target="#downloadModal">
                    <i class="fas fa-download"></i>&nbsp;{{ __('sidebar-task-index1.download_language') }}
                </a>
            </div>
            @if(getAccess('/task/link_task'))
            <div class="col-md-2 form-group">
                <a type="button" class="form-control btn-default text-center" data-toggle="modal" data-target="#linkModal">{{ __('sidebar-task-index1.link-request_language') }}</a>
            </div>
            @else
            <div class="col-md-2 form-group"></div>
            @endif
        @endif
            
            @if(getAccess('/task/create_schedule'))
            <div class="col-md-2 form-group">
                <button type="button" class="form-control bg-primary" data-toggle="modal" data-target="#taskModal"> 
                    <i class="fa fa-plus nav-icon"></i>&nbsp;&nbsp;{{ __('sidebar-task-index1.create_language') }}
                </button>
            </div>
            @else
            <div class="col-md-2 form-group"></div>
            @endif
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="removeData" role="dialog" aria-labelledby="warning">
         <?php $m_data = Session::get('data'); if(session('data')) $m_data = session('data')?>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Task</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body form-remove-data">
                    <div class="form-group">
                        <label >Subject</label>
                        <input type="text" class="form-control" name="name" readonly style="background-color: #e9ecef !important">
                    </div>
                    <hr>
                    
                    <div class="text-center">
                        <h5>Task akan dihapus secara permanen</h5>
                        <h5>Lanjutkan ? </h5>
                    </div>
                    <hr>
                    <br>
                    
                    <div class="modal-footer justify-content-between">
                        <a href="#" type="button" class="btn btn-info btn-sm text-light" data-dismiss="modal" style="font-weight:bold; font-size:15px">{{ __('setup-customization-checklist.cancel_language') }}</a>
                        <a href="#" class="btn btn-sm btn-danger btn-remove-user">{{ __('setup-customization-checklist.delete_language') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-header">
    <!-- dozoftware -->
        <!--<form action="{{route('task_schedule')}}" method="get">-->
        <!--<div class="row">-->
            <!--<div class="col-md-2 form-group">-->
            <!--    <select class="form-control btn-default select_task_type" name="task_type">-->
            <!--        <option selected="selected" disabled value="">-- {{ __('sidebar-task-index1.task-type_language') }} --</option>-->
            <!--        @foreach($types as $type)-->
            <!--            <option value="{{$type->id_type}}">{{$type->type_name}}</option>-->
            <!--        @endforeach-->
            <!--    </select>-->
            <!--</div>-->
            
        <!--    <div class="col-md-3 form-group">-->
        <!--        <label>Regional</label>-->
        <!--        <select class="form-control btn-default select_region" name="region">-->
        <!--            <option selected="selected" disabled value="">-- {{ __('sidebar-task-index1.region_language') }} --</option>-->
        <!--            @foreach(\App\Model\Region::get() as $region)-->
        <!--                <option value="{{$region->region_id}}">{{$region->region_name}}</option>-->
        <!--            @endforeach-->
        <!--        </select>-->
        <!--    </div>-->
        <!--    <div class="col-md-3 form-group">-->
        <!--        <label>Status</label>-->
        <!--        <select class="form-control btn-default select_status" type="text" name="id_status">-->
        <!--            <option selected="selected" disabled value="">-- {{ __('sidebar-task-index1.status_language') }} --</option>-->
        <!--            @foreach(\App\Model\Status::orderBy('id_status')->where('task_type_id', '=', 2)->get() as $status)-->
        <!--                <option value="{{$status->id_status}}">{{$status->status_name}}</option>-->
        <!--            @endforeach-->
        <!--        </select>-->
        <!--    </div>-->
            
        <!--    <div class="col-md-3 form-group">-->
        <!--        <label>Priority</label>-->
        <!--        <select class="form-control btn-default select_priority" name="id_priority">-->
        <!--            <option selected="selected" disabled value="">-- {{ __('sidebar-task-index1.priority_language') }} --</option>-->
        <!--            @foreach(\App\Model\Priority::orderBy('priority_name')->get() as $priority)-->
        <!--                <option value="{{$priority->id_priority}}">{{$priority->priority_name}}</option>-->
        <!--            @endforeach-->
        <!--        </select>-->
        <!--    </div>-->
        <!--    <div class="col-md-3 form-group">-->
        <!--        <label>Technician</label>-->
        <!--        <select class="form-control btn-default select_technician" name="id_technician">-->
        <!--            <option selected="selected" disabled value="">-- {{ __('sidebar-task-index1.description_language') }} --</option>-->
        <!--            @foreach(\App\Model\Technician::orderBy('name_technician')->get() as $technician)-->
        <!--                <option value="{{$technician->id_technician}}">{{$technician->name_technician}}</option>-->
        <!--            @endforeach-->
        <!--        </select>-->
        <!--    </div>-->
        <!--</div>-->
        <!--<div class="row">-->
        <!--            <div class="col-md-4 form-group">-->
        <!--                <label>Root Caused</label>-->
        <!--            <select class="form-control btn-default select_caused" name="id_caused">-->
        <!--                <option selected="selected" disabled value="">-- {{ __('sidebar-task-index1.root-caused_language') }} --</option>-->
        <!--                @foreach(\App\Model\RootCaused::orderBy('name_caused')->get() as $caused)-->
        <!--                    <option value="{{$caused->id_caused}}">{{$caused->name_caused}}</option>-->
        <!--                @endforeach-->
        <!--            </select>-->
        <!--        </div>-->
                <!--<div class="col-md-4 form-group">-->
                <!--    <label>Site A</label>-->
                <!--    <select class="form-control btn-default select_subject" name="subject">-->
                <!--        <option selected="selected" disabled value="">-- {{ __('sidebar-task-index1.subject_language') }} --</option>-->
                <!--        @foreach(\App\Model\Task::orderBy('subject')->get() as $subject)-->
                <!--            <option value="{{$subject->subject}}">{{$subject->subject}}</option>-->
                <!--        @endforeach-->
                <!--    </select>-->
                <!--</div>-->
        <!--        <div class="col-md-4 form-group">-->
        <!--            <label for="" class="label">&nbsp;</label>-->
                    <!--<span class="icon"><i class="fas fa-search"></i></span>-->
        <!--            <input class="form-control" id="search" type="text" placeholder="{{ __('sidebar-task-index1.search_language') }}" aria-label="Search">-->
        <!--        </div>-->
        <!--    </div>-->
        <!--<div class="row">-->
        <!--    <div class="col-md-2 form-group">-->
        <!--        <label for="" class="label">{{ __('sidebar-task-index1.creation-time-from_language') }}</label>-->
        <!--        <input type="date"  id="create-from" class="form-control btn-default select_creation_from">-->
        <!--    </div>-->
        <!--    <div class="col-md-2 form-group">-->
        <!--        <label for="" class="label">{{ __('sidebar-task-index1.to_language') }}</label>-->
        <!--        <input type="date" class="form-control btn-default select_creation_to">-->
        <!--    </div>-->
        <!--    <div class="col-md-2 form-group">-->
        <!--        <label for="" class="label">{{ __('sidebar-task-index1.completion-time-from_language') }}</label>-->
        <!--        <input type="date" class="form-control btn-default select_completion_from">-->
        <!--    </div>-->
        <!--    <div class="col-md-2 form-group">-->
        <!--        <label for="" class="label">{{ __('sidebar-task-index1.to2_language') }}</label>-->
        <!--        <input type="date" class="form-control btn-default select_completion_to">-->
        <!--    </div>-->
        <!--    <div class="col-md-2">-->
        <!--        <label for="" class="label">&nbsp;</label>-->
        <!--        <button type="button" class="form-control btn-default btn-refresh">-->
        <!--            <i class="fas fa-redo-alt"></i>&nbsp;&nbsp; {{ __('sidebar-task-index1.refresh_language') }}-->
        <!--        </button>-->
        <!--    </div>-->
            <!--<div class="col-md-2 form-group">-->
            <!--    <label for="" class="label">&nbsp;</label>-->
            <!--    <span class="icon"><i class="fas fa-search"></i></span>-->
            <!--    <input class="form-control" id="search" type="text" placeholder="{{ __('sidebar-task-index1.search_language') }}" aria-label="Search">-->
            <!--</div>-->
        <!--</div>-->
        <!--</form>-->
        
        <!--26-07-22-->
        <form action="{{route('task_schedule')}}" method="get"> 
             
        <div class="row py-1">  
           <div class="col-md-3">
                <label>Regional</label>
                <select class="form-control @if(request()->id_region) border border-success font-weight-bold text-dark  @endif" name="id_region">   
                    <option value="">--Choose Regional Task</option>
                    @foreach(\App\Model\Region::get() as $region)
                    <option value="{{$region->region_id}}" @if(request()->id_region == $region->region_id) selected @endif>{{$region->region_name}}</option>
                    @endforeach
                </select>   
            </div>
            <div class="col-md-3">
                <label>Status</label>
                <select class="form-control @if(request()->id_status) border border-success font-weight-bold text-dark  @endif" name="id_status">   
                    <option value="">--Choose Status Task</option>
                    @foreach(\App\Model\Status::where('task_type_id', '=', 2)->get() as $status)
                    <option value="{{$status->id_status}}" @if(request()->id_status == $status->id_status) selected @endif>{{$status->taskType->type_name}} {{$status->status_name}}</option>
                    @endforeach
                </select>   
            </div>
                <div class="col-md-3">
                <label>Priority</label>
                <select class="form-control @if(request()->id_priority) border border-success font-weight-bold text-dark  @endif" name="id_priority">   
                    <option value="">--Choose Priority Task</option>
                    @foreach(\App\Model\Priority::get() as $priority)
                    <option value="{{$priority->id_priority}}" @if(request()->id_priority == $priority->id_priority) selected @endif>{{$priority->taskType->type_name}} {{$priority->priority_name}}</option>
                    @endforeach
                </select>   
            </div>
            <div class="col-md-3">
                <label>Root Caused</label>
                <select class="form-control @if(request()->id_root) border border-success font-weight-bold text-dark  @endif" name="id_root">   
                    <option value="">--Choose Root Caused Task</option>
                    @foreach(\App\Model\RootCaused::get() as $root)
                    <option value="{{$root->id_caused}}" @if(request()->id_root == $root->id_caused) selected @endif>{{$root->name_caused}}</option>
                    @endforeach
                </select>   
            </div>
        </div>
        <div class="row py-1">
        <div class="col-md-4">
                <label>ID Task</label>
                <input type="text" name="id_task" id="search" placeholder="PM - 1234" class="form-control @if(request()->id_task) border border-success font-weight-bold text-dark @endif" value="{{ request()->id_task}}">
            </div>
            <div class="col-md-4">
                <label>Teknisi</label>
                <select class="form-control btn-default " name="id_technician">
                    <option selected="selected" disabled value="">-- {{ __('sidebar-task-index1.description_language') }} --</option>
                    @foreach(\App\Model\Technician::orderBy('name_technician')->get() as $technician)
                        <option value="{{$technician->id_technician}}" @if(request()->id_technician == $technician->id_technician) selected @endif>{{$technician->name_technician}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row py-1">
            <div class="col-md-4">
                <label>Waktu pembuatan dari</label>
                <input type="date" name="created_at_when" value="{{ request()->created_at_when}}" class="form-control @if(request()->created_at_when) border border-success font-weight-bold text-dark @endif"> 
            </div>
            <div class="col-md-4">
                <label>sampai</label>
                <input type="date" name="created_at_until" value="{{ request()->created_at_until}}" class="form-control @if(request()->created_at_until) border border-success font-weight-bold text-dark @endif">  
            </div>
            <div class="col-md-2">
                <label><small>Cari data</small></label><br>
                <button type="submit" class="btn btn-md btn-success w-100"><i class="fas fa-search"></i></button>   
            </div>
            <div class="col-md-1">
                <label><small>Refresh</small></label><br>
                <a href="{{route('task_schedule', request()->query())}}" class="btn btn-md btn-secondary w-100"><i class="fas fa-sync"></i></a> 
            </div>
            <div class="col-md-1">
                <label><small>Reset filter</small></label><br>
                <a href="{{route('task_schedule')}}" class="btn btn-md btn-warning w-100"><i class="fas fa-redo"></i></a>   
            </div>
        </div>
       </form>

       <div class="row py-4"></div>
       <button type="submit" style="margin-bottom: 10px" class="btn btn-danger delete_all" id="deleteButtonSelected">Delete Selected</button>
        <div class="row py-1">
 
   
        <div class="table-responsive">
            
        
        <table id="table_task" class="display table table-striped table-border-gray dt-responsive" style="width:100%">
            <thead>
                <tr>
                    <th width="50px"><input type="checkbox" id="checkAll"></th>
                    <th style="width: 10px">No.</th>
                    <th class="text-dark">{{ __('sidebar-task-index1.task-id_language') }}</th>
                    <th class="text-dark">{{ __('sidebar-task-index1.status2_language') }}</th>
                    <th class="text-dark" style="width: 8%">{{ __('sidebar-task-index1.subject2_language') }}</th>
                    <th class="text-dark" >{{ __('sidebar-task-index1.priority2_language') }}</th>
                    <th class="text-dark" style="width: 10%">{{ __('sidebar-task-index1.site-a_language') }}</th>
                    <th class="text-dark" style="width: 10%">{{ __('sidebar-task-index1.site-b_language') }}</th>
                    <th class="text-dark">{{ __('sidebar-task-index1.creation-time_language') }}</th>
                    <th class="text-dark">{{ __('sidebar-task-index1.description_language') }}</th>
                    <th class="text-dark">{{ __('sidebar-task-index1.linked-to_language') }}</th>
                     <th class="text-dark"style="width: 5%">Action</th>
                </tr>
            </thead>
        </table>
        </div>
    </div>
</div>

@if(getAccess('/task/create_schedule'))
<div class="modal fade" id="taskModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="#" class="form-new-data">
            @csrf
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('sidebar-task-index1.add_language') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="createTask" class=" form-control-label">{{ __('sidebar-task-index1.task-type2_language') }}</label>
                        <select name="createTask" class="form-control" id="createTask" onchange="document.location.href='/task/create_schedule?id_template='+this.value">
                            <option selected="selected" disabled value="">-- {{ __('sidebar-task-index1.task-type3_language') }} --</option>
                            <option value="2">PM</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@if(getAccess('/task/link_task'))
<div class="modal fade" id="linkModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="/task/link_task">
            @csrf
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('sidebar-task-index1.link-task_language') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="createTask" class=" form-control-label">{{ __('sidebar-task-index1.task-link-from_language') }}</label>
                        <select class="form-control searchTask" style="width: 100%;"  name="id_task_1" required autofocus></select>
                    </div>
                    <div class="form-group">
                        <label for="createTask" class=" form-control-label">{{ __('sidebar-task-index1.task-link-to_language') }}</label>
                        <select class="form-control searchTask" style="width: 100%;"  name="id_task_2" required autofocus></select>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-info btn-sm text-light" data-dismiss="modal" style="font-weight:bold; font-size:15px">{{ __('sidebar-task-index1.cancel_language') }}</button>
                        <button type="submit" class="btn btn-sm btn-success" style="width: 70px;">{{ __('sidebar-task-index1.save_language') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<div class="modal fade" id="downloadModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="GET" action="/task/download">
            @csrf
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('sidebar-task-index1.download2_language') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <select class="form-control btn-default" name="download_type">
                            <option value="PDF">-- {{ __('sidebar-task-index1.pdf_language') }} --</option>
                            <option value="EXCEL">-- {{ __('sidebar-task-index1.excel_language') }} --</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control btn-default" name="id_type">
                            <option selected="selected" disabled value="">-- {{ __('sidebar-task-index1.task-type4_language') }} --</option>
                            @foreach($types as $type)
                                <option value="{{$type->id_type}}">{{$type->type_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control btn-default" name="id_region">
                            <option selected="selected" disabled value="">-- {{ __('sidebar-task-index1.region2_language') }} --</option>
                            @foreach(\App\Model\Region::get() as $region)
                                <option value="{{$region->region_id}}">{{$region->region_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control btn-default" name="id_status">
                            <option selected="selected" disabled value="">-- {{ __('sidebar-task-index1.status3_language') }} --</option>
                            @foreach(\App\Model\Status::orderBy('id_status')->get() as $status)
                                <option value="{{$status->id_status}}">{{$status->status_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="" class="label">{{ __('sidebar-task-index1.creation-time-from2_language') }}</label>
                            <input type="date" name="created_at_from" class="form-control btn-default">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="" class="label">{{ __('sidebar-task-index1.to3_language') }}</label>
                            <input type="date" name="created_at_to" class="form-control btn-default">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="" class="label">{{ __('sidebar-task-index1.completion-time-from2_language') }}</label>
                            <input type="date" name="completion_from" class="form-control btn-default">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="" class="label">{{ __('sidebar-task-index1.to4_language') }}</label>
                            <input type="date" name="completion_to" class="form-control btn-default">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-info btn-sm text-light" data-dismiss="modal" style="font-weight:bold; font-size:15px">{{ __('sidebar-task-index1.close_language') }}</button>
                        <button type="submit" class="btn btn-sm btn-success" style="width: 70px;">{{ __('sidebar-task-index1.download3_language') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var param = {}
    var id_type = '', id_priority = '', id_status = '', id_caused = '', id_subject = '', id_region = '', id_site_frequency = '', id_technician=''; 
    <?php
    if(true){
        $id_type = request()->id_type;
        if($id_type) echo "id_type = $id_type;";
        
        $id_caused = request()->id_caused;
        if($id_caused) echo "id_caused = $id_caused;";
        
        $id_status = request()->id_status;
        if($id_status) echo "id_status = $id_status;";
        
        $id_priority = request()->id_priority;
        if($id_priority) echo "id_priority = $id_priority;";
        
        $id_technician = request()->id_technician;
        if($id_technician) echo "id_technician = $id_technician;";
        
        $id_subject = request()->id_subject;
        if($id_subject) echo "id_subject = $id_subject;";
        
        $id_region = request()->id_region;
        if($id_region) echo "id_region = $id_region;";
        
        $id_site_frequency = request()->id_site_frequency;
        if($id_site_frequency) echo "id_site_frequency = $id_site_frequency;";
    }
    ?>

    var created_at_when = "{{request()->created_at_when}}";
    var created_at_until = "{{request()->created_at_until}}";
    
    
    $(document).ready(function() {
        var def = true;
        if(def){
            if(id_type){
               $('.select_task_type').val(id_type);
               param.id_type = id_type;
            }
            if(id_caused){
               $('.select_caused').val(id_caused);
               def = false;
               param.id_caused = id_caused;
               initTask(param);
            }
            if(id_priority){
               $('.select_priority').val(id_priority);
               def = false;
               param.id_priority = id_priority;
               initTask(param);
            }
            if(id_technician){
               $('.select_technician').val(id_technician);
               def = false;
               param.id_technician = id_technician;
               initTask(param);
            }
            if(id_status){
               $('.select_status').val(id_status);
               def = false;
               param.id_status = id_status;
               initTask(param);
            }
            if(id_region){
               $('.select_region').val(id_region);
               def = false;
               param.id_region = id_region;
               initTask(param);
            }
            if(id_subject){
               $('.select_subject').val(id_subject);
               def = false;
               param.id_subject = id_subject;
               initTask(param);
            }
            if(id_site_frequency){
               def = false;
               param.id_site_frequency = id_site_frequency;
               initTask(param);
            }
             if(created_at_when){
               def = false;
               param.created_at_when = created_at_when;
               initTask(param);
            }
            if(created_at_until){
               def = false;
               param.created_at_until = created_at_until;
               initTask(param);
            }
        }
        
        if(def){
           initTask(param); 
        }
        
        $(document).on('click', '.btn-refresh', function(e){
            e.preventDefault();
            history.pushState({}, null, '/task');
            param = {}
            
            $('.select_task_type').val('');
            $('.select_region').val('');
            $('.select_status').val('');
            $('.select_priority').val('');
            $('.select_technician').val('');
            $('.select_caused').val('');
            $('.select_creation_from').val('');
            $('.select_creation_to').val('');
            $('.select_completion_from').val('');
            $('.select_completion_to').val('');
            $('.select_subject').val('');
            initTask(param);
        });
        
        $(document).on('change', '.select_task_type', function(e){
            e.preventDefault();
            param.id_type = $(this).val();
            initTask(param);
        });
        $(document).on('change', '.select_subject', function(e){
            e.preventDefault();
            param.id_subject = $(this).val();
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
        $(document).on('change', '.select_priority', function(e){
            e.preventDefault();
            param.id_priority = $(this).val();
            initTask(param);
        });
        $(document).on('change', '.select_technician', function(e){
            e.preventDefault();
            param.id_technician = $(this).val();
            initTask(param);
        });
        $(document).on('change', '.select_caused', function(e){
            e.preventDefault();
            param.id_caused = $(this).val();
            initTask(param);
        });
        
        $(document).on('change input', '.select_creation_from', function(e){
            e.preventDefault();
            param.created_at = $(this).val();
            if($('.select_creation_from').val()){
                initTask(param);
            }
        });
        $(document).on('change input', '.select_creation_to', function(e){
            e.preventDefault();
            param.created_at_to = $(this).val();
            if($('.select_creation_to').val()){
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
        
        $(".searchTask").select2({
            placeholder: "Select Task",
            ajax: {
                url: "/task/getTask",
                dataType: "json",
                data:{
                    is_link_task: true
                },
                delay: 250,
                processResults: function (data) {
                    data = data.data;
                    return {
                        results: $.map(data, function (item) {
                                return {
                                    text: item.subject+"("+item.task_uid+")",
                                    id: item.id_task
                                };
                        })
                    };
                },
                cache: false
            }
        });
    });
    function initTask(param){
        var table = $('#table_task').DataTable( {
             "lengthMenu": [[20, 50, 100, 150, 200, 250, 500], [20, 50, 100, 150, 200, 250, 500]],
            "destroy": true,
            "bDestroy": true,
            "ajax": {
                "url": "/task/getTaskSchedule",
                "data": param,
                "error": function (xhr, error, thrown) {
                    ajax_fail(xhr, error);
                }
            },
            "columns": [
                { "data": "id_task" },
                { "data": "task_uid" },
                { "data": "task_status"},
                { "data": "subject" },
                { "data": "priority_name" },
                { "data": "site_name" },
                { "data": "site_b_name" },
                { "data": "created_at" },
                { "data": "technisian" },
                {
                    "className":      'details-control',
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ''
                },
            ],
            "columnDefs": [
                
                {
                    "targets" : 0,
                    "data": "id_task",
                    "render" : function (data, type, row) {
                        if(row.status_read == 0){
                    
                        return '<span style="color:'+row.task_color+'">'+row.id_task+'</span>';
                        }
                        else{
                             return '<strong>'+row.id_task+'</strong>';
                            
                        }
                    }
                }
                ,
                
                
                {
                    "targets" : 1,
                    "data": "task_uid",
                    "render" : function (data, type, row) {
                        if(row.status_read == 0){
                       return '<a href="/task/detail_schedule/'+row.id_task+'" class="task_uid" data-row="'+row+'"> PM - '+row.id_task+'</a>';
                        }
                        else{
                              return '<strong><a href="/task/detail_schedule/'+row.id_task+'" class="task_uid" data-row="'+row+'"> PM - '+row.id_task+'</a></strong>';
                            
                        }
                    }
                },
                {
                    "targets" : 2,
                    "data": "task_status",
                    "render" : function (data, type, row) {
                        if(row.status_read == 0 ){
                       return '<span style="color:'+row.task_color+'">'+row.task_status+'</span>';
                        }
                        else{
                             return '<strong><span style="color:'+row.task_color+'">'+row.task_status+'</span></strong>';
                            
                        }
                    }
                },
                 {
                    "targets" : 3,
                    "data": "subject",
                    "render" : function (data, type, row) {
                        if(row.status_read == 0){
                       return '<span style="color:'+row.subject+'">'+row.subject+'</span>';
                        }
                        else{
                             return '<strong><span style="color:'+row.subject+'">'+row.subject+'</span></strong>';
                            
                        }
                    }
                },
                 {
                    "targets" : 4,
                    "data": "priority_name",
                    "render" : function (data, type, row) {
                        if(row.status_read == 0){
                       return '<span style="color:'+row.priority_name+'">'+row.priority_name+'</span>';
                        }
                        else{
                             return '<strong><span style="color:'+row.priority_name+'">'+row.priority_name+'</span></strong>';
                            
                        }
                    }
                },
                 {
                    "targets" : 5,
                    "data": "site_name",
                    "render" : function (data, type, row) {
                        if(row.status_read == 0){
                       return '<span style="color:'+row.site_name+'">'+row.site_name+'</span>';
                        }
                        else{
                             return '<b><strong><span style="color:'+row.site_name+'">'+row.site_name+'</span></strong></b>';
                            
                        }
                    }
                },
                 {
                    "targets" : 6,
                    "data": "site_b_name",
                    "render" : function (data, type, row) {
                        if(row.status_read == 0){
                       return '<span style="color:'+row.site_b_name+'">'+row.site_b_name+'</span>';
                        }
                        else{
                             return '<strong><span style="color:'+row.site_b_name+'">'+row.site_b_name+'</span></strong>';
                            
                        }
                    }
                },
                {
                    "targets" : 7,
                    "data": "created_at",
                    "render" : function (data, type, row) {
                        
                        if(row.status_read == 0 ){
                             return '<span style="color:'+row.created_at+'">'+row.created_at+'</span>';
                        }
                        else{
                             return '<strong><span style="color:'+row.created_at+'">'+row.created_at+'</span></strong>';
                            
                        }
                        
                     
                    }
                },
                 {
                    "targets" : 8,
                    "data": "description",
                    "render" : function (data, type, row) {
                        
                        if(row.status_read == 0 ){
                             return '<span style="color:'+row.description+'">'+row.name_technician+'</span>';
                        }
                        else{
                             return '<strong><span style="color:'+row.created_at+'">'+row.name_technician+'</span></strong>';
                            
                        }
                        
                     
                    }
                },
                {
                    "targets" : 10,
                    "data": "id_task",
                    "render" : function (data, type, row) {
                       return '<a href="#" class="btn btn-md btn-danger btn-delete-task" data-id="'+row.id_task+'" data-name="'+row.subject+'"><i class="fa fa-trash"></i></a>';
                    }
                },
            ],
            "order": false,
            "sDom": 't<"row view-pager"<"col-sm-12"<"pull-left"i><"pull-right"p>>>',
        });
        
        $('#table_task tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);
            var data = row.data();
            var e_tr = $(tr);
            if(!data){
                var uid = e_tr.find('.task_uid');
                data = uid.data('row');
            }
            if ( row.child.isShown() ) {
                row.child.hide();
                tr.removeClass('shown');
            }else {
                row.child( setLinked(data) ).show();
                tr.addClass('shown');
                initLinked(data);
            }
        });
        
         $('.select2').select2();
    $('#data_table').DataTable();
    $(document).on('click', '.btn-delete-task', function(e){
        var init = $(this),
            id = init.data('id'),
            name = init.data('name');
            
            console.log(id);
            console.log(name);
           
        mod = $('#removeData');
        form = $('.form-remove-data');
        form.find('input[name=name]').val(name);
        form.find('.btn-remove-user').attr('href', '/task/delete_task_schedule/'+id);
        mod.modal('show');
    });
        
        oTable = $('#table_task').DataTable();
        $('#search').keyup(function(){
              oTable.search($(this).val()).draw() ;
        });
        
        // createFrom = $('#table_task').DataTable();
        // $('#create-from').keyup(function(){
        //       createFrom.search($(this).val()).draw() ;
        // });
        
        function setLinked(d) {
            var table = '<table id="table_linked'+d.id_task+'" class="display table_linked" style="width:100%">' +
                            '<thead>' +
                                '<tr>' +
                                    '<th>ID</th>' +
                                    '<th>Task Status</th>' +
                                    '<th>Task ID</th>' +
                                    '<th>Title</th>' +
                                    '<th>Desc</th>' +
                                '</tr>' +
                            '</thead>' +
                        '</table>';
            var card = '<div class="card">'+
                            '<div class="card-body">' +
                                table +
                            '</div' +
                        '</div>';
            return card;
        }
        
        function initLinked(data){
        var table = $('#table_linked'+data.id_task).DataTable( {
                "ajax": {
                    "url": "/task/getLinked",
                    "data": {
                        id_task:data.id_task
                    }
                },
                "columns": [
                    { "data": "id_task" },
                    { "data": "task_status"},
                    { "data": "task_uid" },
                    { "data": "subject" },
                    { "data": "link_type" },
                ],
                "columnDefs": [
                    {
                        "targets" : 1,
                        "data": "id_task",
                        "render" : function (data, type, row) {
                           return '<a href="/task/detail_schedule/'+row.id_task+'">'+row.task_status+'</a>';
                        }
                    },
                    {
                        "targets" : 4,
                        "data": "link_type",
                        "render" : function (data, type, row) {
                           return 'Linked '+ row.link_type + ' <a href="/task/detail_schedule/'+row.task_id_parent+'">'+row.task_uid_parent+'</a>';
                        }
                    },
                ],
                "bPaginate": false,
                "bLengthChange": false,
                "bFilter": false,
                "bSort": true,
                "bInfo": false,
                "order": [[0, 'asc']]
            });
        }
    }

     // checkallbutton
        $(function(e){
        $("#checkAll").click(function(){
            $(".checkBoxClass").prop("checked", $(this).prop("checked"));
        });

        $("#deleteButtonSelected").click(function(e) {
            e.preventDefault();
            var allId = [];

            $("input:checkbox[name=ids]:checked").each(function() {
                allId.push($(this).val());
            });

            $.ajax({
                url: "",
                type: "DELETE",
                data: {
                    _token:$("input[name=_token]").val(),
                    ids:allId
                },
                success:function(response) {
                    $.each(allId, function(key, val) {
                        $("#uid"+val).remove();
                    })
                }
            })
        })
    });
</script>
@endsection
