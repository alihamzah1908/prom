<div id="menu4" class="content_header">
    <div class="content_menu">
        <h4 class="title_2">{{ __('setup-userpermission-task_validator-approver.validator_language') }}</h4>
        <div class="row">
            <div class="col-md-2 form-group">
                <button type="button" class="form-control bg-primary" data-toggle="modal" data-target="#approverModal"> <i
                        class="fa fa-plus nav-icon"></i>&nbsp;&nbsp;{{ __('setup-userpermission-task_validator-approver.create_language') }}
                </button>
            </div>
            <div class="col-md-2 form-group">
                <select class="form-control btn-default" type="text" name="region_name" id="region_id"
                onchange="document.location.href = '?view={{request()->view}}&task_type={{request()->task_type}}&region=' + this.value">
                        <option selected value="">{{ __('setup-userpermission-task_validator-approver.region_language') }}</option>
                        @foreach($regions as $region)
                        <option value="{{$region->region_id}}" {{( request('region') == $region->region_id ) ? 'selected' : '' }}>
                            {{$region->region_name}}
                        </option>
                        @endforeach
                </select>
            </div>
            <div class="col-md-2 form-group">
                <select class="form-control btn-default" type="text" style="" name=""  
                onchange="document.location.href = '?view={{request()->view}}&region={{request()->region}}&task_type=' + this.value">
                    <option value="">{{ __('setup-userpermission-task_validator-approver.task-type_language') }}</option>
                    @foreach(\App\Model\TaskType::where('id_type', '!=', '3')->get() as $d)
                    <option value="{{$d->id_type}}"
                    {{( request('task_type') == $d->id_type ) ? 'selected' : '' }}
                    >{{$d->type_name}}</option>
                    @endforeach
                </select>
            </div>
            
        </div>
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th width="8%"></th>
                            <th>{{ __('setup-userpermission-task_validator-approver.region2_language') }}</th>
                            <th>{{ __('setup-userpermission-task_validator-approver.task-type2_language') }}</th>
                            <th>{{ __('setup-userpermission-task_validator-approver.layer-validator_language') }}</th>
                            <th>{{ __('setup-userpermission-task_validator-approver.validator2_language') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $data = \App\Model\Approver::orderBy('id_approver');
                        if(request()->region) $data = $data->where('id_region', request()->region);
                        if(request()->task_type) $data = $data->where('id_task_type', request()->task_type);
                        
                        $data = $data->get();
                        ?>
                        @foreach($data as $d)
                        <tr>
                            <td>
                                <a href="#" class="btn-edit-data" data-id="{{$d->id_approver}}"><i class="fas fa-pen icon_color"></i></a>
                                <a href="#" class="icon_color btn-delete-data" data-id="{{$d->id_approver}}"><i class="fas fa-trash"></i></a>
                            </td>
                            <td class="text_name">{{isset($d->region)?$d->region->region_name:''}}</td>
                            <td class="text_name">{{isset($d->task_type)?$d->task_type->type_name:''}}</td>
                            <td class="text_name">{{$d->count_layer}}</td>
                            <td class="text_name">
                                <ul>
                                @foreach(\App\Model\ApproverDetail::where('id_approver', $d->id_approver)->get() as $detail)
                                    <li>
                                        {{isset($detail->user)?$detail->user->name:''}}
                                    </li>
                                @endforeach
                                </ul>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <div class="modal fade" id="approverModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('setup-userpermission-task_validator-approver.new-validator_language') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/setup/userpermission/approver/new_approver" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="segment" class="text_name form-control-label">{{ __('setup-userpermission-task_validator-approver.region3_language') }}</label>
                            <select class="form-control btn-default" name="id_region" required autofocus>
                                <option selected value="" disabled>{{ __('setup-userpermission-task_validator-approver.region4_language') }}</option>
                                @foreach($regions as $region)
                                <option value="{{$region->region_id}}">{{$region->region_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="segment" class="text_name form-control-label">{{ __('setup-userpermission-task_validator-approver.task-type3_language') }}</label>
                            <select class="form-control btn-default" name="id_task_type" required autofocus>
                                <option selected value="" disabled>{{ __('setup-userpermission-task_validator-approver.task-type4_language') }}</option>
                                @foreach(\App\Model\TaskType::where('id_type', '!=', '3')->get() as $d)
                                <option value="{{$d->id_type}}">{{$d->type_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="segment" class="form-control-label" style="    font-family: Montserrat;
                            line-height: 17px;">{{ __('setup-userpermission-task_validator-approver.validator3_language') }}</label>
                        </div>
                        <div id="items" class="form-group">
                            <button id="add" type="button" class="btn-default float-right rounded"><i class="fa fa-plus nav-icon"></i></button>
                            <button type="button" class="deleteBtn btn-default float-right mr-1 rounded"><i class="fa fa-minus nav-icon"></i></button>
                            <label for="layer" class="text_name form-control-label">{{ __('setup-userpermission-task_validator-approver.layer_language') }}</label>
                            <select class="form-control btn-default" name="id_approver[]" required autofocus>
                                <option selected disabled value="">-- {{ __('setup-userpermission-task_validator-approver.select_language') }} --</option>
                                @foreach(\App\User::get() as $u)
                                <option value="{{$u->id}}">{{$u->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer justify-content-start">
                            <button type="submit" class="btn btn-primary" style="width: 70px;">{{ __('setup-userpermission-task_validator-approver.save_language') }}</button>
                            <button type="button" class="btn btn-default" style="color: #fff; background: #CECECE">{{ __('setup-userpermission-task_validator-approver.cancel_language') }}</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="approverModalEdit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('setup-userpermission-task_validator-approver.edit-validator_language') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/setup/userpermission/approver/edit_approver" method="POST" enctype="multipart/form-data" class="form-update-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <input name="id" hidden>
                            <label for="segment" class="text_name form-control-label">{{ __('setup-userpermission-task_validator-approver.region5_language') }}</label>
                            <select class="form-control btn-default" name="id_region" required autofocus>
                                <option selected value="" disabled>{{ __('setup-userpermission-task_validator-approver.region6_language') }}</option>
                                @foreach($regions as $region)
                                <option value="{{$region->region_id}}">{{$region->region_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="segment" class="text_name form-control-label">{{ __('setup-userpermission-task_validator-approver.task-type5_language') }}</label>
                            <select class="form-control btn-default" name="id_task_type" required autofocus>
                                <option selected value="" disabled>{{ __('setup-userpermission-task_validator-approver.task-type6_language') }}</option>
                                @foreach(\App\Model\TaskType::where('id_type', '!=', '3')->get() as $d)
                                <option value="{{$d->id_type}}">{{$d->type_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="segment" class="form-control-label" style="    font-family: Montserrat;
                            line-height: 17px;">{{ __('setup-userpermission-task_validator-approver.validator4_language') }}</label>
                        </div>
                        <div id="items_edit" class="form-group">
                            <button id="add_edit" type="button" class="btn-default float-right rounded"><i class="fa fa-plus nav-icon"></i></button>
                            <button type="button" class="deleteBtn_edit btn-default float-right mr-1 rounded"><i class="fa fa-minus nav-icon"></i></button>
                            <label for="layer" class="text_name form-control-label">{{ __('setup-userpermission-task_validator-approver.layer2_language') }}</label>
                            <select class="form-control btn-default approver_1" name="id_approver[]" required autofocus>
                                <option selected disabled value="">-- {{ __('setup-userpermission-task_validator-approver.select2_language') }} --</option>
                                @foreach(\App\User::get() as $u)
                                <option value="{{$u->id}}">{{$u->name}}</option>
                                @endforeach
                            </select>
                            <div class="approvers_div">
                                
                            </div>
                        </div>
                        <div class="modal-footer justify-content-start">
                            <button type="submit" class="btn btn-primary" style="width: 70px;">{{ __('setup-userpermission-task_validator-approver.save2_language') }}</button>
                            <button type="button" class="btn btn-default" style="color: #fff; background: #CECECE">{{ __('setup-userpermission-task_validator-approver.cancel2_language') }}</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="deleteData" role="dialog" aria-labelledby="failed">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('setup-userpermission-task_validator-approver.delete_language') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <div class="modal-body">
                        <img src="{{asset('images/icon_failed.png')}}" >
                        <br>
                        <p class="mt-4">
                            <span style="font-weight:bold" id="f_message">
                                {{ __('setup-userpermission-task_validator-approver.message_language') }}
                                <br>
                                {{ __('setup-userpermission-task_validator-approver.continue_language') }}
                            </span>
                        </p>
                        <hr>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-transparent btn-md text-dark" style="font-weight:bold; font-size:15px" data-dismiss="modal">{{ __('setup-userpermission-task_validator-approver.close_language') }}</a>
                        <a href="#" class="btn btn-primary btn-md text-light col-md-2 btn-delete-ok">{{ __('setup-userpermission-task_validator-approver.ok_language') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        $(document).ready(function() {
            $(".deleteBtn").hide();
            // $(".deleteBtn_edit").hide();
            //when the Add Field button is clicked
            $("#add").click(function(e) {
                $(".deleteBtn").fadeIn("1000");
                //Append a new row of code to the "#items" div
                $("#items").append(
                '<select class="form-control btn-default next_approver mt-2" name="id_approver[]" required autofocus>' +
                    '<option selected disabled value="">-- {{ __('setup-userpermission-task_validator-approver.select3_language') }} --</option>' +
                    '@foreach(\App\User::get() as $u)' +
                    '<option value="{{$u->id}}">{{$u->name}}</option>' +
                    '@endforeach' +
                '</select>'
                );
            });
            $("#add_edit").click(function(e) {
                // $(".deleteBtn_edit").fadeIn("1000");
                //Append a new row of code to the "#items" div
                $("#items_edit").append(
                '<select class="form-control btn-default next_approver_edit mt-2" name="id_approver[]" required autofocus>' +
                    '<option selected disabled value="">-- {{ __('setup-userpermission-task_validator-approver.select4_language') }} --</option>' +
                    '@foreach(\App\User::get() as $u)' +
                    '<option value="{{$u->id}}">{{$u->name}}</option>' +
                    '@endforeach' +
                '</select>'
                );
            });
            $("body").on("click", ".deleteBtn", function(e) {
                $(".next_approve").last().remove();
            });
            $("body").on("click", ".deleteBtn_edit", function(e) {
                $(".next_approver_edit").last().remove();
            });
            
            $(document).on('click', '.btn-edit-data', function(e){
                e.preventDefault();
                var ini = $(this),
                    id = ini.data('id'),
                    form = $('.form-update-data');
                    console.log(id);
                if($.isNumeric(id)) {
                    var e_modal_wait = $("#modalWait");
                    showLoading(e_modal_wait);
                    $.ajax({
                        url: '/setup/userpermission/approver/getApprover',
                        type: "get",
                        data: {
                                id: id
                              }
                    })
                    .done(function (result) {
                        hideLoading(e_modal_wait);
                        if(result.data[0]){
                            data = result.data[0];
                            $('.next_approver_edit').remove();
                            var approvers = data.detail;
                            var wrapper = $('.approvers_div');
                            var approver_sel = "";
                            form.find('input[name=id]').val(data.id_approver);
                            form.find('select[name=id_region]').val(data.id_region);
                            form.find('select[name=id_task_type]').val(data.id_task_type);
                            form.find('.approver_1').val(approvers[0].user_id);
                            
                            for(var i = 1; i < approvers.length; ++i){
                                id = approvers[i].user_id;
                                
                                $("#items_edit").append(
                                '<select class="form-control btn-default next_approver_edit next_approver_edit'+i+' mt-2" name="id_approver[]" required autofocus>' +
                                    '<option selected disabled value="">-- {{ __('setup-userpermission-task_validator-approver.select5_language') }} --</option>' +
                                    '@foreach(\App\User::get() as $u)' +
                                    '<option value="{{$u->id}}" >{{$u->name}}</option>' +
                                    '@endforeach' +
                                '</select>'
                                );
                                $('.next_approver_edit'+i+'').val(id);
                            }
                            
                            $('#approverModalEdit').modal('show');
                        
                        }else{
                            var message = result.message || 'Not found!';
                            failedAlert(message);
                        }
                    })
                    .fail(ajax_fail);
                }
            })
        });

        // searc region
        $(".searchRegion").select2({
            placeholder:"Place your region name",
            ajax: {
                url: "/getRegion",
                dataType: "json",
                delay: 150,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                                item_text =  item.region_name;
                                return {
                                    text: item_text,
                                    id: item.region_id
                                };
                        })
                    };
                },
                cache: false
            }
        }).on('change', function (e) {

        });
        
        $(document).on('click', '.btn-delete-data', function(e){
            e.preventDefault();
            var ini = $(this);
                id = ini.data('id');
                mdl = $('#deleteData');
            mdl.find('.btn-delete-ok').attr('href', '/setup/userpermission/delete_task_approver?id_approver='+id);
            mdl.modal('show');
        });
    </script>
@endpush
