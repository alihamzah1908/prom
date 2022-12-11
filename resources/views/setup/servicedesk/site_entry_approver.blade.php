@extends('setup.servicedesk.service_desk')
@section('title', 'Site Entry Approver')
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
        <h4 class="title_2">Site Entry Approver</h4>
        <div class="row">
            <div class="col-md-2 form-group">
                <button type="button" class="form-control bg-primary" data-toggle="modal" data-target="#approverModal"> <i
                        class="fa fa-plus nav-icon"></i>&nbsp;&nbsp;Create
                </button>
            </div>
            <div class="col-md-2 form-group" style="display:none">
                <select class="form-control btn-default" type="text" onchange="document.location.href = '?site=' + this.value">
                        <option selected value="">Site</option>
                        @foreach($sites as $site)
                        <option value="{{$site->site_id}}" {{( request('site_id') == $site->name_site ) ? 'selected' : '' }}>
                            {{$site->name_site}}
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
                            <th>Site</th>
                            <th>Approver I</th>
                            <th>Approver II</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Model\SiteEntryApprover::get() as $d)
                        <tr>
                            <td>
                                <a href="#" class="btn-edit-data" data-id="{{$d->id_approver}}"><i class="fas fa-pen icon_color"></i></a>&nbsp;
                            </td>
                            <td class="text_name">{{isset($d->site)?$d->site->name_site:'-'}}</td>
                            <td class="text_name">{{isset($d->approver1)?$d->approver1->name:''}}</td>
                            <td class="text_name">{{isset($d->approver2)?$d->approver2->name:''}}</td>
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
                    <form action="/setup/servicedesk/site_entry_approver/new_approver" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="segment" class="text_name form-control-label">Site</label>
                            <select class="form-control select2 btn-default" name="id_site" required autofocus>
                                <option selected value="" disabled>Site</option>
                                @foreach($sites as $site)
                                <option value="{{$site->site_id}}">{{$site->name_site}}</option>
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
                    <form action="/setup/servicedesk/site_entry_approver/edit_approver" method="POST" enctype="multipart/form-data" class="form-update-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <input name="id" hidden>
                            <label for="segment" class="text_name form-control-label">Site</label>
                            <select class="form-control select2 btn-default" name="id_site" required autofocus>
                                <option selected value="" disabled>Site</option>
                                @foreach($sites as $site)
                                <option value="{{$site->site_id}}">{{$site->name_site}}</option>
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
                    url: '/setup/servicedesk/site_entry_approver/getApprover',
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
                        form.find('select[name=approver_1]').val(data.approver_1).trigger('change');
                        form.find('select[name=approver_2]').val(data.approver_2).trigger('change');
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
