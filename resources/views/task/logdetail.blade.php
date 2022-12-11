@extends('template.default')
@section('submenu')
<div class="row mb-2 pb-3">
    <div class="col-sm-6">
        <h3 class="m-0 text-dark"><strong>Log</strong></h3>
        <small>Task > Log</small>
    </div>
</div>
<div class="row" style="border-top: 2px solid #ddd; margin-left: 0px;">
    <div class="col-md-2">
        <a href="/task/{{$task->id_task}}/summary-detail" class="nav-title {{  request()->is('task/$task->id_task/summary-detail') ? 'active' : '' }}">Summary</a>
    </div>
    <div class="col-md-10">
        <a href="/task/{{$task->id_task}}/log-detail" class="nav-title {{  request()->is('task/$task->id_task/log-detail') ? 'active' : '' }}">Log</a>
    </div>
</div>
@endsection
@section('content')

<div class="card">
    <!-- /.card-header -->
    <div class="card-header">
        <h3 class="card-title"> <strong>Log</strong></h3>
    </div>
    {{-- card body --}}
    <div class="card-body">
        <div class="container">
            <ul class="timeline">
                <li>
                    <div class="timeline-badge"><i class="fas fa-plus" style="margin-top: 13px;"></i></div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h5 class="timeline-title">Title 1</h5>
                        </div>
                        <div class="timeline-body">
                            <div class="row">
                                <div class="col-md-3 sub_title">User1 &nbsp; :</div>
                                <div class="col-md-9 sub_title">BUP Tengah</div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 sub_title">Status &nbsp;:</div>
                                <div class="col-md-9 sub_title">Created</div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 sub_title">Notes &nbsp; :</div>
                                <div class="col-md-9 sub_title">Lorem Ipsum sit amet domets</div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="timeline-inverted">
                    <div class="timeline-badge success"><i class="fas fa-check" style="margin-top: 13px;margin-left: 3px;"></i></div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h5 class="timeline-title">Title 1</h5>
                        </div>
                        <div class="timeline-body">
                            <div class="row">
                                <div class="col-md-3 sub_title">User1 &nbsp; :</div>
                                <div class="col-md-9 sub_title">BUP Tengah</div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 sub_title">Status &nbsp;:</div>
                                <div class="col-md-9 sub_title">Approved</div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 sub_title">Notes &nbsp; :</div>
                                <div class="col-md-9 sub_title">Lorem Ipsum sit amet domets</div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- /.card -->

@endsection
