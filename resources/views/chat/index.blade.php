@extends('template.default')
@section('title', 'Task Chats')

@section('content')
@if(Session::has('message'))
    <div class="alert {{Session::get('alert-class')}} alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        {{ Session::get('message') }}
    </div>
@endif
<meta charset="UTF-8">

<style>
    .display-none{
        display: none !important;
    }
    .inbox-box{
        padding: 0.2rem; border-bottom: 1px #000 solid; padding-top: 0; cursor:pointer;
    }
    .inbox-box:hover{
        background: #7f7f7fcc;
    }
    .receive{
        /*height:0 !important;*/
    }
    .send{
        /*height:0 !important;*/
    }
    .chat{
        background: #c1c1c1;
        padding: 0.2rem;
        padding-left: 0.5rem;
        padding-right: 0.5rem;
        border-radius: 0.2rem;
        margin-top: 0.3rem;
        width: fit-content;
        width: intrinsic;           /* Safari/WebKit uses a non-standard name */
        width: -moz-max-content;    /* Firefox/Gecko */
        width: -webkit-max-content; /* Chrome */
    }
    .receive_chat{
        
    }
    .send_chat{
        float:right;
    }
    .sender_right{
        /*text-align:right;*/
    }
    .chat-container{
        background:#eaecef;
        min-height: 25rem;
        max-height: 25rem;
        overflow: auto;
        display: flex;
        flex-direction: column;
    }
    .notif {
        background: transparent;
        padding: 0.2rem;
        padding-left: 0.5rem;
        padding-right: 0.5rem;
        border-radius: 0.2rem;
    }
    .user_name:hover{
        text-decoration: underline;
    }
    .chat_content{
        /*background: white;*/
        margin: 0;
        white-space: pre-line
    }
</style>

<div class="row">
    <div class="col-md-3">
        <div class="card" style="min-height:35.7rem; border-radius:0"> 
            <div class="card-header">
                <h5>{{ __('sidebar-chat-index1.inboxs_language') }}</h5>
            </div>
            <div class="card-body" style="padding: 0rem; overflow:auto">
                @foreach($inboxs as $inbox)
                <div class="inbox-box task_chat_inbox" data-id="{{$inbox['id']}}" data-id_task="{{$inbox['id_task']}}">
                    <p style="margin:0;">
                        <b>{{isset($inbox['subject'])?$inbox['subject']:'-'}}</b>
                        <br>
                        #{{isset($inbox['task_uid'])?$inbox['task_uid']:'-'}}
                    </p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card card_inbox" style="min-height:30rem; border-radius:0"> 
            <div class="inbox_chat_container">
                <div class="card-header bg-white" style="padding-bottom:0">
                    <div class="inbox_title"></div>
                    <div class="btn-group display-none user_man_wrapper" style="position: absolute; top: 0.5rem; right: 0.5rem;">
                        <!--<button class="btn btn-sm btn-success" data-toggle="modal" data-target="#newUser">Add User</button>-->
                        <!--<button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#removeUser">Remove User</button>-->
                    </div>
                </div>
                <div class="card-body chat-container" id="chat_container"></div>
                <div class="card-footer bg-white">
                    <form method="POST" action="#" enctype="multipart/form-data" class="form-send-chat"> 
                    @csrf
                    <div class="input-group">
                        <textarea id="chat_input" type="text" class="form-control" name="chat" required autofocus title="{{ __('sidebar-chat-index1.empty_language') }}" rows="1"></textarea>
                        <div class="input-group-append">
                            <button type="submit" class="input-group-text bg-success"><i class="fa fa-paper-plane"></i></button>
                            <button class="input-group-text bg-info btn-refresh"><i class="fa fa-redo-alt"></i></button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')

<script>
    var param = {};
    <?php 
    $id = request()->id;
    $id_task = request()->id_task;
    if($id && $id_task) echo "param.id = $id; param.id_task = $id_task;";
    ?>
    var overlay = '<div class="overlay" style="background:#c1c1c152"><i class="fa fa-spinner fa-spin"></i></div>';
    var card_inbox = $('.card_inbox');
    function loadChat(param){
        $.ajax({
            url: '/api/task/getChatByInbox',
            type: "get",
            data: param
        })
        .done(function (result) {
            if(result.data[0]){
                var data = result.data[0],
                    body = $('.chat-container');
                
                inbox_title = $('.inbox_title');
                
                var p = '<p><a href="/task/detail/'+data.task.id_task+'" target="new" class="user_name "><b>TASK #'+data.task.task_uid+'</b></a><br>';
                $.each(data.user_participants, function( index, value ) {
                    p += '<a href="/user/profile?id='+value.id+'" target="new" class=" user_name" data-id="'+value.id+'">'+value.name+'</a>, '
                });
                    p += '</p>';
                inbox_title.html(p);
                
                var chats = "";
                $.each(data.chats, function( index, value ) {
                    sender = value.sender;
                    sender = '<a href="/user/profile?id='+sender.id+'" target="new" class=" user_name" data-id="'+sender.id+'">'+sender.name+'</a>';
                    chat = value.chat;
                    if(value.type === "NOTIFICATION"){
                            chats += '<div class="send col-md-12">' +
                                        '<div class="col-md-12">' +
                                            '<p class="notif text-center">' +
                                                urlify(chat) +
                                            '</p>' +
                                        '</div>' +
                                     '</div>';
                    }else{
                        if(value.get_as === "RECEIVE"){
                            chats += '<div class="receive col-md-12">' +
                                        '<div class="receive_chat chat">' +
                                            '<b class="sender_left">'+ sender +'</b><br>' +
                                            '<p class="chat_content">'+urlify(chat)+'</p>' +
                                        '</div>' +
                                     '</div>';
                        }else{
                            chats += '<div class="send col-md-12">' +
                                        '<div class="col-md-12">' +
                                            '<div class="send_chat chat">' +
                                                '<b class="sender_right">'+ sender +'</b><br>' +
                                                '<p class="chat_content">'+urlify(chat)+'</p>' +
                                            '</div>' +
                                        '</div>' +
                                     '</div>';
                        }
                    }
                });
                body.html(chats);
                
                var objDiv = document.getElementById("chat_container");
                objDiv.scrollTop = objDiv.scrollHeight;
                
                $('.overlay').remove();
                $('.user_man_wrapper').removeClass('display-none');
                
                console.log('Re-Loaded')

            }
        })
        .fail(ajax_fail);
    }
    
    
    $(document).ready(function(){
        card_inbox.append(overlay);
        loadChat(param);
        $(document).on('submit', '.form-send-chat', function(e){
            e.preventDefault();
            var e_modal_wait = $("#modalWait");
            showLoading(e_modal_wait);
            
            var ini = $(this),  input_token = ini.find('input[name=_token]'), url = ini.attr('action');
            
            var data = {
                is_ajax: true,
                _token: input_token.val(),
                chat: ini.find("textarea[name=chat]").val()
            };
            id_task = param.id_task;
            function postData(data) {
                $.ajax({
                    url: '/api/task/chats/'+ id_task,
                    type: "post",
                    data: data
                })
                .done(function (result) {
                    hideLoading(e_modal_wait);
                    input_token.val(result.newtoken);
                    if (result.status) {
                        var message = result.message || 'Success';
                        loadChat(param);
                        ini.find("textarea[name=chat]").val('')
                    } else {
                        var message = result.message || 'Api connection problem';
                        failedAlert(message);
                    }
                    input_token.val(result.newtoken);
                })
                .fail(ajax_fail);
            }
            postData(data)
       })
        
        $(document).on('click', '.btn-refresh', function(e){
            e.preventDefault();
            loadChat(param);
        })
        $(document).on('click', '.btn-remove-user', function(e){
            e.preventDefault();
            $(this).parents('.user_row').remove();
        })
        
        $(document).on('click', '.task_chat_inbox', function(e){
            e.preventDefault();
            card_inbox.append(overlay);
            var ini = $(this),
                id = ini.data('id');
                id_task = ini.data('id_task');
            param.id = id;
            param.id_task = id_task;
            loadChat(param);
        });
    });
    
    
</script>


<script>
    $('.select2').select2();
</script>
@endpush
