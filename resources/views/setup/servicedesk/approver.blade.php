@extends('setup.servicedesk.service_desk')
@section('title', 'Approver')
@section('title_menu', 'Servicedesk Configurations')
@section('service_desk_content')
@if(Session::has('message'))
<div class="alert {{Session::get('alert-class')}} alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
    {{ Session::get('message') }}
</div>
@endif
<div id="menu4" class="content_header">
    <div class="content_menu">
        <h4 class="title_2">Approver</h4>
        <div class="row">
            <div class="col-md-2 form-group">
                <button type="button" class="form-control bg-primary" data-toggle="modal" data-target="#approverModal"> <i
                        class="fa fa-plus nav-icon"></i>&nbsp;&nbsp;Create
                </button>
            </div>
            <div class="col-md-2 form-group">
                <select class="form-control btn-default" type="text" name="region_name" id="region_id"
                onchange="document.location.href = '?region=' + this.value">
                        <option selected value="">Region</option>
                        @foreach($regions as $region)
                        <option value="{{$region->region_name}}" {{( request('leader') == $region->region_name ) ? 'selected' : '' }}>
                            {{$region->region_name}}
                        </option>
                        @endforeach
                </select>
            </div>
            <div class="col-md-2 form-group">
                <select class="form-control btn-default" type="text" style="" name=""  onchange="#">
                    <option value="" selected disabled></option>
                    @foreach(\App\Model\TaskType::where('id_type', '!=', '3')->get() as $d)
                    <option value="{{$d->id_type}}">{{$d->type_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 form-group">
                <span class="icon"><i class="fas fa-search"></i></span>
                <input class="form-control btn-default" id="search" type="text" placeholder="Search"
                    aria-label="Search">
            </div>
        </div>
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th width="8%"></th>
                            <th>Region</th>
                            <th>Task Type</th>
                            <th>Layer Approver</th>
                            <th>Approvers</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Model\Approver::get() as $d)
                        <tr>
                            <td>
                                <a href="#" class="btn-edit-data" data-id="{{$d->id_approver}}"><i class="fas fa-pen icon_color"></i></a>
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
                    <h4 class="modal-title">New Approver</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/setup/servicedesk/approver/new_approver" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="segment" class="text_name form-control-label">Region</label>
                            <select class="form-control btn-default" name="id_region" required autofocus>
                                <option selected value="" disabled>Region</option>
                                @foreach($regions as $region)
                                <option value="{{$region->region_id}}">{{$region->region_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="segment" class="text_name form-control-label">Task Type</label>
                            <select class="form-control btn-default" name="id_task_type" required autofocus>
                                <option selected value="" disabled>Task Type</option>
                                @foreach(\App\Model\TaskType::where('id_type', '!=', '3')->get() as $d)
                                <option value="{{$d->id_type}}">{{$d->type_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="segment" class="form-control-label" style="    font-family: Montserrat;
                            line-height: 17px;">Approver</label>
                        </div>
                        <div id="items" class="form-group">
                            <button id="add" type="button" class="btn-default float-right rounded"><i class="fa fa-plus nav-icon"></i></button>
                            <button type="button" class="deleteBtn btn-default float-right mr-1 rounded"><i class="fa fa-minus nav-icon"></i></button>
                            <label for="layer" class="text_name form-control-label">Layer 1</label>
                            <select class="form-control btn-default" name="id_approver[]" required autofocus>
                                <option selected disabled value="">-- Select --</option>
                                @foreach(\App\User::get() as $u)
                                <option value="{{$u->id}}">{{$u->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer justify-content-start">
                            <button type="submit" class="btn btn-primary" style="width: 70px;">Save</button>
                            <button type="button" class="btn btn-default" style="color: #fff; background: #CECECE">Cancle</button>
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
                    <h4 class="modal-title">Edit Approver</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/setup/servicedesk/approver/edit_approver" method="POST" enctype="multipart/form-data" class="form-update-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <input name="id" hidden>
                            <label for="segment" class="text_name form-control-label">Region</label>
                            <select class="form-control btn-default" name="id_region" required autofocus>
                                <option selected value="" disabled>Region</option>
                                @foreach($regions as $region)
                                <option value="{{$region->region_id}}">{{$region->region_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="segment" class="text_name form-control-label">Task Type</label>
                            <select class="form-control btn-default" name="id_task_type" required autofocus>
                                <option selected value="" disabled>Task Type</option>
                                @foreach(\App\Model\TaskType::where('id_type', '!=', '3')->get() as $d)
                                <option value="{{$d->id_type}}">{{$d->type_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="segment" class="form-control-label" style="    font-family: Montserrat;
                            line-height: 17px;">Approver</label>
                        </div>
                        <div id="items_edit" class="form-group">
                            <button id="add_edit" type="button" class="btn-default float-right rounded"><i class="fa fa-plus nav-icon"></i></button>
                            <button type="button" class="deleteBtn_edit btn-default float-right mr-1 rounded"><i class="fa fa-minus nav-icon"></i></button>
                            <label for="layer" class="text_name form-control-label">Layer 1</label>
                            <select class="form-control btn-default approver_1" name="id_approver[]" required autofocus>
                                <option selected disabled value="">-- Select --</option>
                                @foreach(\App\User::get() as $u)
                                <option value="{{$u->id}}">{{$u->name}}</option>
                                @endforeach
                            </select>
                            <div class="approvers_div">
                                
                            </div>
                        </div>
                        <div class="modal-footer justify-content-start">
                            <button type="submit" class="btn btn-primary" style="width: 70px;">Save</button>
                            <button type="button" class="btn btn-default" style="color: #fff; background: #CECECE">Cancle</button>
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
        $(document).ready(function() {
            $(".deleteBtn").hide();
            // $(".deleteBtn_edit").hide();
            //when the Add Field button is clicked
            $("#add").click(function(e) {
                $(".deleteBtn").fadeIn("1000");
                //Append a new row of code to the "#items" div
                $("#items").append(
                '<select class="form-control btn-default next_approver mt-2" name="id_approver[]" required autofocus>' +
                    '<option selected disabled value="">-- Select --</option>' +
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
                    '<option selected disabled value="">-- Select --</option>' +
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
                        url: '/setup/servicedesk/approver/getApprover',
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
                                    '<option selected disabled value="">-- Select --</option>' +
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
    </script>
@endpush
