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

<br>
@if(date('Y-m-d H:i:s') < date('2021-12-13 00:00:00'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <i class="fas fa-exclamation-triangle mr-2"></i>Sorry this feature will be nonactived by system on 01 January 2022. We present to you for new <strong> Task List</strong> <i>Candidate Release (CR) Version</i>, with new interface, system, and speed improvement, <a href="{{route('task.testing')}}" class="text-dark"><strong><i>Click here</i></strong></a>
<!--   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button> -->
</div>
 @else
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <i class="fas fa-exclamation-triangle mr-2"></i>This Feature is <strong>deprecated</strong>. We present to you for new <strong> Task List</strong> <i>Stable Version</i>, with new interface, system, and speed improvement, <a href="{{route('task.testing')}}" class="text-dark"><strong><i>Click here</i></strong></a>
<!--   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button> -->
</div>
 @endif


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
    padding: 0.3rem;
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
    
</style>
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-3">
                <h3 class="card-title"> <strong>{{ __('sidebar-task-index1.query-task_language') }}</strong></h3>
            </div>           
            <div class="col-md-1">
                <!--<label for="" class="label">&nbsp;</label>-->
                <a href="#" class="form-control btn-default" style="color: #828282" data-toggle="modal" data-target="#download7Days">
                    <i class="fas fa-download"></i>&nbsp;7 days
                </a>
            </div>
            <div class="modal fade" id="download7Days">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="GET" action="{{ route('export7days.excel') }}">
                        @csrf
                            <div class="modal-header">
                                <h4 class="modal-title">7 Days</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Apakah ingin download task complete 7 hari terakhir?
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-info btn-sm text-light" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-sm btn-success">Download</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div> 
            <div class="col-md-1">
                <!--<label for="" class="label">&nbsp;</label>-->
                <a href="#" class="form-control btn-default" style="color: #828282" data-toggle="modal" data-target="#filterModal">
                    <i class="fas fa-filter"></i>&nbsp;filter
                </a>
            </div>
            <!--===modal===-->
            <div class="modal fade" id="filterModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" action="{{route('update.filter', Auth::user()->id)}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                            <div class="modal-header">
                                <h4 class="modal-title">Filter</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <select class="form-control btn-default" name="id_task_type">
                                        <option selected="selected" disabled value="">-- {{ __('sidebar-task-index1.task-type_language') }} --</option>
                                        @foreach($types as $type)
                                            <option value="{{$type->id_type}}" @php $a=$type->id_type; @endphp>{{$type->type_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select class="form-control btn-default" name="id_region">
                                        <option selected="selected" disabled value="">-- {{ __('sidebar-task-index1.region2_language') }} --</option>
                                        @foreach($regions as $region)
                                            <option value="{{$region->region_id}}">{{$region->region_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select class="form-control btn-default" name="id_status">
                                        <option selected="selected" disabled value="">-- {{ __('sidebar-task-index1.status3_language') }} --</option>
                                        @foreach($statuses as $status)
                                            <option value="{{$status->id_status}}">{{$status->taskType->type_name}} - {{$status->status_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!--==-->
                                <div class="form-group">
                                    <select class="form-control btn-default" name="id_priority">
                                        <option selected="selected" disabled value="">-- {{ __('sidebar-task-index1.priority_language') }} --</option>
                                        @foreach($priorities as $priority)
                                            <option value="{{$priority->id_priority}}">{{$priority->taskType->type_name}} - {{$priority->priority_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select class="form-control btn-default" name="id_caused">
                                        <option selected="selected" disabled value="">-- {{ __('sidebar-task-index1.root-caused_language') }} --</option>
                                        @foreach($roots as $caused)
                                            <option value="{{$caused->id_caused}}">{{$caused->name_caused}}</option>
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
                                <!--==-->
                                
                                <div class="modal-footer justify-content-between">
                                    <button type="submit" class="btn btn-sm btn-success">Choose Filter</button>
                                    </form>
                                    <form method="POST" action="{{route('update.filter',1)}}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-danger">Reset Filter</button>
                                    </form>
                                </div>
                            </div>
                        
                    </div>
                </div>
            </div>
            <!--===end modal===-->
            <div class="col-md-1">
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
            
            @if(getAccess('/task/create'))
            <div class="col-md-2 form-group">
                <button type="button" class="form-control bg-primary" data-toggle="modal" data-target="#taskModal"> 
                    <i class="fa fa-plus nav-icon"></i>&nbsp;&nbsp;Create Task
                </button>
            </div>
            @else
            <div class="col-md-2 form-group"></div>
            @endif
            @if(getAccess('/task/create_schedule'))
            <div class="col-md-2 form-group">
                <button type="button" class="form-control bg-primary" data-toggle="modal" data-target="#taskModal2"> 
                    <i class="fa fa-plus nav-icon"></i>&nbsp;&nbsp;Create Task Schedule
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
    <div class="card-body">
        <div class="row">
            <div class="col-md-2 form-group">
                <select class="form-control btn-default select_task_type" name="task_type">
                    <option selected="selected" disabled value="">-- {{ __('sidebar-task-index1.task-type_language') }} --</option>
                    @foreach($types as $type)
                        <option value="{{$type->id_type}}">{{$type->type_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 form-group">
                <select class="form-control btn-default select_region" name="region">
                    <option selected="selected" disabled value="">-- {{ __('sidebar-task-index1.region_language') }} --</option>
                    @foreach($regions as $region)
                        <option value="{{$region->region_id}}">{{$region->region_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 form-group">
                <select class="form-control btn-default select_status" name="id_status">
                    <option selected="selected" disabled value="">-- {{ __('sidebar-task-index1.status3_language') }} --</option>
                    @foreach($statuses as $status)
                        <option value="{{$status->id_status}}">{{$status->taskType->type_name}} - {{$status->status_name}}</option>
                    @endforeach
                </select>
            </div>
            <!--==-->
            <div class="col-md-2 form-group">
                <select class="form-control btn-default select_priority" name="id_priority">
                    <option selected="selected" disabled value="">-- {{ __('sidebar-task-index1.priority_language') }} --</option>
                    @foreach($priorities as $priority)
                        <option value="{{$priority->id_priority}}">{{$priority->taskType->type_name}} - {{$priority->priority_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 form-group">
                <select class="form-control btn-default select_caused" name="id_caused">
                    <option selected="selected" disabled value="">-- {{ __('sidebar-task-index1.root-caused_language') }} --</option>
                    @foreach($roots as $caused)
                        <option value="{{$caused->id_caused}}">{{$caused->name_caused}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 form-group">
                <select class="form-control btn-default select_subject" name="subject">
                    <option selected="selected" disabled value="">-- {{ __('sidebar-task-index1.subject_language') }} --</option>
                    @foreach($tasks as $subject)
                        <option value="{{$subject->subject}}">{{$subject->subject}}</option>
                    @endforeach
                </select>
            </div>
            
        </div>
        <div class="row">
            <div class="col-md-2 form-group">
                <label for="" class="label">{{ __('sidebar-task-index1.creation-time-from_language') }}</label>
                <input type="date" class="form-control btn-default select_creation_from">
            </div>
            <div class="col-md-2 form-group">
                <label for="" class="label">{{ __('sidebar-task-index1.to_language') }}</label>
                <input type="date" class="form-control btn-default select_creation_to">
            </div>
            <div class="col-md-2 form-group">
                <label for="" class="label">{{ __('sidebar-task-index1.completion-time-from_language') }}</label>
                <input type="date" class="form-control btn-default select_completion_from">
            </div>
            <div class="col-md-2 form-group">
                <label for="" class="label">{{ __('sidebar-task-index1.to2_language') }}</label>
                <input type="date" class="form-control btn-default select_completion_to">
            </div>
            <div class="col-md-2">
                <label for="" class="label">&nbsp;</label>
                <button type="button" class="form-control btn-default btn-refresh">
                    <i class="fas fa-redo-alt"></i>&nbsp;&nbsp; {{ __('sidebar-task-index1.refresh_language') }}
                </button>
            </div>
            <div class="col-md-2 form-group">
                <label for="" class="label">&nbsp;</label>
                <!--<span class="icon"><i class="fas fa-search"></i></span>-->
                <input class="form-control" id="search" type="text" placeholder="{{ __('sidebar-task-index1.search_language') }}" aria-label="Search">
            </div>
        </div>
        <div class="table-responsive">
            
        
        <table id="table_task" class="display table table-striped table-border-gray dt-responsive" style="width:100%">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
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

@if(getAccess('/task/create'))
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
                        <select name="createTask" class="form-control" id="createTask" onchange="document.location.href='/task/create?id_template='+this.value">
                            <option selected="selected" disabled value="">-- {{ __('sidebar-task-index1.task-type3_language') }} --</option>
                            @foreach($types as $type)
                                <option value="{{$type->id_type}}">{{$type->type_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@if(getAccess('/task/create_schedule'))
<div class="modal fade" id="taskModal2">
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
                            @foreach($regions as $region)
                                <option value="{{$region->region_id}}">{{$region->region_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control btn-default" name="id_status">
                            <option selected="selected" disabled value="">-- {{ __('sidebar-task-index1.status3_language') }} --</option>
                            @foreach($statuses as $status)
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
                        <button type="button" class="btn btn-info btn-sm text-light" data-dismiss="modal" >Close</button>
                        <button type="submit" class="btn btn-sm btn-success">Download</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
var param = {}
    var id_type = '', id_priority = '', id_status = '', id_caused = '', id_subject = '', id_region = '', id_site_frequency = '', created_at_from = '', created_at_to = '', completion_from = '', completion_to = ''; 
    <?php
    if(true){
        $id_type = $filter_fiture->id_type ?? '';
        if($id_type) echo "id_type = $id_type;";
        
        $id_caused = $filter_fiture->id_caused ?? '';
        if($id_caused) echo "id_caused = $id_caused;";
        
        // $id_status = request()->id_status;
        $id_status = $filter_fiture->id_status ?? '';
        if($id_status) echo "id_status = $id_status;";
        
        $id_priority = $filter_fiture->id_priority ?? '';
        if($id_priority) echo "id_priority = $id_priority;";
        
        $id_subject = $filter_fiture->id_subject ?? '';
        if($id_subject) echo "id_subject = $id_subject;";
        
        $id_region = $filter_fiture->id_region ?? '';
        if($id_region) echo "id_region = $id_region;";
        
        $id_site_frequency = request()->id_site_frequency;
        if($id_site_frequency) echo "id_site_frequency = $id_site_frequency;";
        
        $created_at_from = $filter_fiture->created_at_from ?? '';
        if($created_at_from) echo "created_at_from = '$created_at_from';";
        
        $created_at_to = $filter_fiture->created_at_to ?? '';
        if($created_at_to) echo "created_at_to = '$created_at_to';";
        
        $completion_from = $filter_fiture->completion_from ?? '';
        if($completion_from) echo "completion_from = '$completion_from';";
        
        $completion_to = $filter_fiture->completion_to ?? '';
        if($completion_to) echo "completion_to = '$completion_to';";
    }
    ?>
    
    
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
            if(created_at_from){
                def = false;
              $('.select_creation_from').val(created_at_from);
              param.created_at_from = created_at_from;
              initTask(param);
            }
            
            if(created_at_to){
                def = false; 
              $('.select_creation_to').val(created_at_to);
              param.created_at_to = created_at_to;
              initTask(param);
            }
            
            if(completion_from){
              def = false;
              $('.select_completion_from').val(completion_from);
              param.completion_from = completion_from;
              initTask(param);
            }
            
            if(completion_to){
              def = false;
              $('.select_completion_to').val(completion_to);
              param.completion_to = completion_to;
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
            $('.select_caused').val('');
            $('.select_creation_from').val('');
            $('.select_creation_to').val('');
            $('.select_completion_from').val('');
            $('.select_completion_to').val('');
            $('.select_subject').val('');
            initTask(param);
        });
        
        $(document).on('change', '.select_task_type', function(e){
           preventDefault
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
        $(document).on('change', '.select_caused', function(e){
            e.preventDefault();
            param.id_caused = $(this).val();
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
            "lengthMenu": [[10, 20, 50, 100, 150, 200, 250, 500], [10, 20, 50, 100, 150, 200, 250, 500]],
            "destroy": true,
            "bDestroy": true,
          //  "processing": true,
          //  "serverSide": true,
            "ajax": {
                "url": "/api/task/getTask",
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
                    "searchable": true,
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
                       return '<a href="/task/detail/'+row.id_task+'" class="task_uid" data-row="'+row+'">'+row.task_uid+'</a>';
                        }
                        else{
                              return '<strong><a href="/task/detail/'+row.id_task+'" class="task_uid" data-row="'+row+'">'+row.task_uid+'</a></strong>';
                            
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
            // "bPaginate": true,
            // "bLengthChange": true,
            "order": [[0, 'desc']],
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
            form.find('.btn-remove-user').attr('href', '/task/delete_task/'+id);
            mod.modal('show');
        });
        
        oTable = $('#table_task').DataTable();
        $('#search').keyup(function(){
              oTable.search($(this).val()).draw() ;
        });
    }
        
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
                       return '<a href="/task/detail/'+row.id_task+'">'+row.task_status+'</a>';
                    }
                },
                {
                    "targets" : 4,
                    "data": "link_type",
                    "render" : function (data, type, row) {
                       return 'Linked '+ row.link_type + ' <a href="/task/detail/'+row.task_id_parent+'">'+row.task_uid_parent+'</a>';
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
</script>
@endsection
