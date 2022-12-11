@extends('setup.servicedesk.service_desk')
@section('title', 'Aktivasi Approver')
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
        <h4 class="title_2">Aktivasi Approver</h4>
        <div class="row">
            <div class="col-md-2 form-group">
                <button type="button" class="form-control bg-primary" data-toggle="modal" data-target="#approverModal"> <i
                        class="fa fa-plus nav-icon"></i>&nbsp;&nbsp;Create
                </button>
            </div>
            <div class="col-md-2 form-group" style="display:none">
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
            <!--<div class="col-md-2 form-group">-->
            <!--    <span class="icon"><i class="fas fa-search"></i></span>-->
            <!--    <input class="form-control btn-default" id="search" type="text" placeholder="Search" aria-label="Search">-->
            <!--</div>-->
        </div>
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th width="8%"></th>
                            <th>Region</th>
                            <th>Type</th>
                            <th>Approver I</th>
                            <th>Approver II</th>
                            <th>Approver III</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Model\AktivasiApprover::get() as $d)
                        <tr>
                            <td>
                                <a href="#" class="btn-edit-data" data-id="{{$d->id_approver}}"><i class="fas fa-pen icon_color"></i></a>&nbsp;
                            </td>
                            <td class="text_name">{{isset($d->region)?$d->region->region_name:'-'}}</td>
                            <td class="text_name">{{isset($d->type)?$d->type->service_name:'-'}}</td>
                            <td class="text_name">{{isset($d->approver1)?$d->approver1->name:''}}</td>
                            <td class="text_name">{{isset($d->approver2)?$d->approver2->name:''}}</td>
                            <td class="text_name">{{isset($d->approver3)?$d->approver3->name:''}}</td>
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
                    <form action="/setup/servicedesk/aktivasi_approver/new_approver" method="POST" enctype="multipart/form-data">
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
                            <label for="segment" class="text_name form-control-label">Type</label>
                            <select class="form-control btn-default" name="id_type" required autofocus>
                                <option selected value="" disabled>Task Type</option>
                                @foreach(\App\Model\AktivasiType::get() as $d)
                                <option value="{{$d->id_service}}">{{$d->service_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="segment" class="form-control-label" style="    font-family: Montserrat;
                            line-height: 17px;">Approver</label>
                        </div>
                        <div class="form-group">
                            <label for="layer" class="text_name form-control-label">Approver I</label>
                            <select class="form-control select2 btn-default" name="approver_1" required autofocus>
                                <option selected disabled value="">-- Select --</option>
                                @foreach($users as $u)
                                <option value="{{$u->id}}">{{$u->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="layer" class="text_name form-control-label">Approver II</label>
                            <select class="form-control select2 btn-default" name="approver_2" required autofocus>
                                <option selected disabled value="">-- Select --</option>
                                @foreach($users as $u)
                                <option value="{{$u->id}}">{{$u->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="layer" class="text_name form-control-label">Approver III</label>
                            <select class="form-control select2 btn-default" name="approver_3" required autofocus>
                                <option selected disabled value="">-- Select --</option>
                                @foreach($users as $u)
                                <option value="{{$u->id}}">{{$u->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer justify-content-start">
                            <button type="submit" class="btn btn-primary" style="width: 70px;">Save</button>
                            <button type="button" class="btn btn-default" style="color: #fff; background: #CECECE">Close</button>
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
                    <form action="/setup/servicedesk/aktivasi_approver/edit_approver" method="POST" enctype="multipart/form-data" class="form-update-data">
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
                            <label for="segment" class="text_name form-control-label">Type</label>
                            <select class="form-control btn-default" name="id_type" required autofocus>
                                <option selected value="" disabled>Task Type</option>
                                @foreach(\App\Model\AktivasiType::get() as $d)
                                <option value="{{$d->id_service}}">{{$d->service_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="segment" class="form-control-label" style="font-family: Montserrat;
                            line-height: 17px;">Approver</label>
                        </div>
                        <div class="form-group">
                            <label for="layer" class="text_name form-control-label">Approver I</label>
                            <select class="form-control select2 btn-default" name="approver_1" required autofocus>
                                <option selected disabled value="">-- Select --</option>
                                @foreach($users as $u)
                                <option value="{{$u->id}}">{{$u->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="layer" class="text_name form-control-label">Approver II</label>
                            <select class="form-control select2 btn-default" name="approver_2" required autofocus>
                                <option selected disabled value="">-- Select --</option>
                                @foreach($users as $u)
                                <option value="{{$u->id}}">{{$u->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="layer" class="text_name form-control-label">Approver III</label>
                            <select class="form-control select2 btn-default" name="approver_3" required autofocus>
                                <option selected disabled value="">-- Select --</option>
                                @foreach($users as $u)
                                <option value="{{$u->id}}">{{$u->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer justify-content-start">
                            <button type="submit" class="btn btn-primary" style="width: 70px;">Save</button>
                            <button type="button" class="btn btn-default" style="color: #fff; background: #CECECE">Close</button>
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
        $('.select2').select2();
        
        $(document).on('click', '.btn-edit-data', function(e){
            e.preventDefault();
            var ini = $(this),
                id = ini.data('id'),
                form = $('.form-update-data');
            if($.isNumeric(id)) {
                var e_modal_wait = $("#modalWait");
                showLoading(e_modal_wait);
                $.ajax({
                    url: '/setup/servicedesk/aktivasi_approver/getApprover',
                    type: "get",
                    data: {
                            id: id
                          }
                })
                .done(function (result) {
                    hideLoading(e_modal_wait);
                    if(result.data[0]){
                        data = result.data[0];
                        form.find('input[name=id]').val(data.id_approver);
                        form.find('select[name=id_site]').val(data.id_site).trigger('change');
                        form.find('select[name=id_type]').val(data.id_type).trigger('change');
                        form.find('select[name=approver_1]').val(data.approver_1).trigger('change');
                        form.find('select[name=approver_2]').val(data.approver_2).trigger('change');
                        form.find('select[name=approver_3]').val(data.approver_3).trigger('change');
                        $('#approverModalEdit').modal('show');
                    
                    }else{
                        var message = result.message || 'Not found!';
                        failedAlert(message);
                    }
                })
                .fail(ajax_fail);
            }
        })
    </script>
@endpush
