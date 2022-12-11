<style>
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
        width: fit-content;
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
</style>
<div clas="card bg-white">
    <div class="card-header bg-white" style="padding-bottom:0">
        <div>
            <p>
                <b>TASK #{{$task->task_uid}}</b>
                <br>
                <?php 
                $inbox = isset($task->inbox)?$task->inbox->participants:'';
                $inbox = json_decode($inbox);
                if(!is_array($inbox)) $inbox = [$inbox];
                ?>
                @if($inbox)
                    @foreach($inbox as $key=>$inb)
                        <?php $user = \App\User::where('id', $inb)->first()?>
                        @if($user)
                        {{$user->name}},
                        @else
                        --
                        @endif
                    @endforeach
                @else
                -
                @endif
            </p>
        </div>
        <div class="card-tools">
            <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#newUser">Add User</button>
            <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#removeUser">Remove User</button>
        </div>
    </div>
    <div class="card-body chat-container" id="chat_container">
        <!--<div class="send col-md-12"><p class="send_chat chat text-right"><b class="sender_right">Sherlock</b><br>chat</p></div>-->
        <!--<div class="receive col-md-12"><p class="receive_chat chat"><b class="sender_left">Putra teknisi</b><br>ini chat no2 mungkinn</p></div>-->
        <!--<div class="send col-md-12"><p class="send_chat chat text-right"><b class="sender_right">Sherlock</b><br>chat 1</p></div>-->
    </div>
    <div class="card-footer bg-white">
        <form method="POST" action="/task/chats/{{$task->id_task}}" enctype="multipart/form-data" class="form-send-chat"> 
        @csrf
        <div class="input-group">
            <textarea type="text" class="form-control" name="chat" required autofocus title="Cant send empty chat!" rows="1"></textarea>
            <div class="input-group-append">
                <button type="submit" class="input-group-text bg-success"><i class="fa fa-paper-plane"></i></button>
                <button class="input-group-text bg-info btn-refresh"><i class="fa fa-redo-alt"></i></button>
            </div>
        </div>
        </form>
    </div>
</div>


<div class="modal fade" tabindex="-1" id="newUser" role="dialog" aria-labelledby="warning">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="/task/chat/new_user/{{$task->id_task}}" class="form-new-data">
            @csrf
                <div class="modal-header">
                    <h3 class="modal-title">New User to chat</h3>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">User</label>
                        <select class="form-control select2" required autofocus name="id_user">
                            <option value="" selected disabled>User</option>
                            @foreach(\App\User::get() as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-info btn-sm text-light" data-dismiss="modal" style="font-weight:bold; font-size:15px">Cancel</button>
                        <button type="submit" class="btn btn-sm btn-success" style="width: 70px;">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" id="removeUser" role="dialog" aria-labelledby="warning">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="/task/chat/update_user/{{$task->id_task}}" class="form-new-data">
            @csrf
                <div class="modal-header">
                    <h3 class="modal-title">Remove User from chat</h3>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Users</label>
                        
                        @if($inbox)
                            @foreach($inbox as $key=>$inb)
                                <?php $user = \App\User::where('id', $inb)->first()?>
                                @if($user)
                                <div class="row user_row">
                                    <div class="col-md-10">
                                        <input class="form-control" readonly value="{{$user->name}}" name="id_user[{{$user->id}}][]">
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-sm btn-danger btn-remove-user">Remove</button>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        @endif
                
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-info btn-sm text-light" data-dismiss="modal" style="font-weight:bold; font-size:15px">Cancel</button>
                        <button type="submit" class="btn btn-sm btn-success" style="width: 70px;">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function loadChat(){
        $.ajax({
            url: '/task/getChats/{{$task->id_task}}',
            type: "get",
            data: {}
        })
        .done(function (result) {
            if(result.data[0]){
                var data = result.data[0],
                    body = $('.chat-container');
                
                var chats = "";
                $.each(data.chats, function( index, value ) {
                    sender = value.sender.name;
                    chat = value.chat;
                    if(value.type === "NOTIFICATION"){
                            chats += '<div class="send col-md-12">' +
                                        '<div class="col-md-12">' +
                                            '<p class="notif text-center">' +
                                                chat +
                                            '</p>' +
                                        '</div>' +
                                     '</div>';
                    }else{
                        if(value.get_as === "RECEIVE"){
                            chats += '<div class="receive col-md-12">' +
                                        '<p class="receive_chat chat">' +
                                            '<b class="sender_left">'+ sender +'</b><br>' +
                                            chat +
                                        '</p>' +
                                     '</div>';
                        }else{
                            chats += '<div class="send col-md-12">' +
                                        '<div class="col-md-12">' +
                                            '<p class="send_chat chat bg-success">' +
                                                '<b class="sender_right">'+ sender +'</b><br>' +
                                                chat +
                                            '</p>' +
                                        '</div>' +
                                     '</div>';
                        }
                    }
                });
                body.html(chats);
                
                var objDiv = document.getElementById("chat_container");
                objDiv.scrollTop = objDiv.scrollHeight;
            }
        })
        .fail(ajax_fail);
    }
    
    
    $(document).ready(function(){
        loadChat();
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
            
            function postData(data) {
                $.ajax({
                    url: url,
                    type: "post",
                    data: data
                })
                .done(function (result) {
                    hideLoading(e_modal_wait);
                    input_token.val(result.newtoken);
                    if (result.status) {
                        var message = result.message || 'Success';
                        loadChat();
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
            loadChat();
        })
        $(document).on('click', '.btn-remove-user', function(e){
            e.preventDefault();
            $(this).parents('.user_row').remove();
        })
    });
</script>

















