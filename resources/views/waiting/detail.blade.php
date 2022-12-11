@extends('template.default')
@section('submenu')
<div class="row mb-2 pb-3">
    <div class="col-sm-6">
        <h3 class="m-0 text-dark"><strong>Task</strong></h3>
      
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

<link rel="stylesheet" href="/css/adminlte.min.css">
<div class="card" style="border-top-left-radius: 0; border-top-right-radius: 0;">
    <div class="card-header">
        <h3 class="card-title">Waiting Approval Detail</h3>
    </div>
    <div class="card-body" style="background-color: #f1f1f1;">
        <div class="card-body" style="border-bottom: 1px solid rgba(0, 0, 0, .125);">
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Template Name</label>
                        <input class="form-control" readonly value="{{\App\Model\TaskType::where('id_type', $task->id_task_type)->first()->type_name}}">
                    </div>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control select2" style="width: 100%;" name="id_status">
                            @foreach(\App\Model\Status::get() as $s)
                            <option value="{{$s->id_status}}" {{$task->id_status == $s->id_status ? 'selected':''}}>{{$s->status_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        @include($task_type)
        <div class="card-footer bg-transparent">
            <button type="button" class="btn btn-primary float-right btn-approval-task" data-status="APPROVED">APPROVE</button>
            <button type="button" class="btn btn-danger mr-2 float-right btn-approval-task" data-status="REJECTED">REJECT</button>
        </div>
    </div>
</div>

<div class="modal fade" id="modalApproval">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="/waiting_approval/approval/{{$task->id_task}}" class="form-approval-task">
            @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Task Approval</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group text-center">
                        <img src="/images/approve.png">
                        <h5 class="mt-3 mb-4">
                           Task( {{$task->task_uid}} ) will be <span class="task_approval_status"></span>!
                           <br>
                           Please leave note: 
                        </h5>
                        <input hidden value="" name="approval_status">
                        <textarea class="form-control" name="note" required autofocus></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary float-right">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $(document).on('click', '.btn-approval-task', function(e){
            e.preventDefault();
            var ini = $(this),
                status = ini.data('status');
            $('.task_approval_status').html(status);
            $('input[name=approval_status]').val(status);
            $('#modalApproval').modal('show');
        });
    });
</script>
@endsection
