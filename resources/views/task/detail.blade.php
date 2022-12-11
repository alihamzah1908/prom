@extends('template.default')
@section('submenu')
<div class="row mb-2 pb-3"><div class="col-sm-6"><h3 class="m-0 text-dark"><strong>Detail</strong></h3><small>Task</small></div></div>
@endsection
@section('content')
@if(Session::has('message'))<div class="alert {{Session::get('alert-class')}} alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>{{ Session::get('message') }}</div>@endif

<link rel="stylesheet" href="/css/adminlte.min.css">
<div class="card col-md-12" style="border-top: 2px solid #ddd; margin-left: 0px; padding:0.1rem; margin-bottom: 2px !important; border-bottom-left-radius: 0; border-bottom-right-radius: 0;">
    <ul class="nav nav-pills row text-center col-md-10" style="margin-left: 0;margin-right: 0;">
        <li class="nav-item col-md-2"><a style="border-radius:0" class="nav-link active" href="#detail" data-toggle="tab">Detail</a></li>
        @if(!$technician)
        <li class="nav-item col-md-2"><a style="border-radius:0" class="nav-link" href="#log" data-toggle="tab">Log</a></li>
        @if(auth()->user()->role_id != 14)
        <li class="nav-item col-md-2"><a style="border-radius:0" class="nav-link" href="#edit" data-toggle="tab">Edit</a></li>
        @endif
        @endif
        <li class="nav-item col-md-2"><a style="border-radius:0" class="nav-link" href="#chats" data-toggle="tab">Chats</a></li>
    </ul>
</div>
<div class="card" style="border-top-left-radius: 0; border-top-right-radius: 0;">
    <div class="card-body" style="background-color: #f1f1f1;">
        <div class="tab-content">
            <div class="active tab-pane" id="detail">
                @include('task.task_detail')
            </div>
            @if(!$technician)
            <div class="tab-pane" id="log" style="padding: 1rem;"> 
                @include('task.task_log')
            </div>
            <div class="tab-pane" id="edit">
                <form method="POST" action="/task/update_task/{{$task->id_task}}" enctype="multipart/form-data"> 
                @csrf
                    @include('task.task_edit')
                    <div class="card-footer bg-transparent">
                        <button type="submit" class="btn btn-primary float-right">Update</button>
                    </div>
                </form>
            </div>
            @endif
            
            <div class="tab-pane" id="chats">
                @include('task.task_inbox')
            </div>
        </div>
    </div>
    <div class="card-footer">
        <a class="btn btn-md btn-default col-md-2" href="/task">BACK</a>
        @if($technician && $next_status)
            @csrf
            <a class="btn btn-md btn-primary float-right col-md-2 btn-teknisi-update-status" data-next_status="{{$next_status}}" href="/task/update_status/{{$task->id_task}}">{{$next_status_name}}</a>
        @endif
    </div>
</div>

<script>
    $(document).on('click', '.btn-teknisi-update-status', function(e){
        e.preventDefault();
        var e_modal_wait = $("#modalWait");
        showLoading(e_modal_wait);
    
        var ini = $(this), url = ini.attr('href'), input_token = $('input[name=_token]'), id_status = ini.data('next_status');
        
        var post_data = {
            is_ajax: true,
            _token: input_token.val(),
            id_status: id_status
        };
    
        $.ajax({
            url: url,
            type: "post",
            data: post_data
        })
        .done(function (result) {
            hideLoading(e_modal_wait);
            input_token.val(result.newtoken);
            if (result.status) {
                var message = result.message || 'Success';
                successAlert(message);
                location.reload();
            } else {
                var message = result.message || 'Api connection problem';
                failedAlert(message);
            }
            input_token.val(result.newtoken);
        })
        .fail(ajax_fail);
    });
</script>
@endsection
