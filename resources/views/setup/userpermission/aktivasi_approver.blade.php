
<div id="menu4" class="content_header">
    <div class="content_menu">
        <h4 class="title_2">{{ __('setup-userpermission-activation_validator-approver.validator_language') }}</h4>
        <div class="row">
            <div class="col-md-2 form-group">
                <button type="button" class="form-control bg-primary" data-toggle="modal" data-target="#approverModal"> <i
                        class="fa fa-plus nav-icon"></i>&nbsp;&nbsp;{{ __('setup-userpermission-activation_validator-approver.create_language') }}
                </button>
            </div>
            <div class="col-md-2 form-group">
                <select class="form-control btn-default" type="text" name="region_name" id="region_id"
                onchange="document.location.href = '?view={{request()->view}}&id_type={{request()->id_type}}&region=' + this.value">
                        <option selected value="">{{ __('setup-userpermission-activation_validator-approver.region_language') }}</option>
                        @foreach($regions as $region)
                        <option value="{{$region->region_id}}" {{( request('region') == $region->region_id ) ? 'selected' : '' }}>
                            {{$region->region_name}}
                        </option>
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
                            <th>{{ __('setup-userpermission-activation_validator-approver.region2_language') }}</th>
                            <th>{{ __('setup-userpermission-activation_validator-approver.type_language') }}</th>
                            <th>{{ __('setup-userpermission-activation_validator-approver.validator2_language') }}</th>
                            <th>{{ __('setup-userpermission-activation_validator-approver.validator3_language') }}</th>
                            <th>{{ __('setup-userpermission-activation_validator-approver.validator10_language') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $data = \App\Model\AktivasiApprover::orderBy('id_approver');
                        if(request()->region) $data = $data->where('id_region', request()->region);
                        if(request()->aktivasi_type) $data = $data->where('id_type', request()->aktivasi_type);
                        
                        $data = $data->get();
                        ?>
                        @foreach($data as $d)
                        <tr>
                            <td>
                                <a href="#" class="btn-edit-data" data-id="{{$d->id_approver}}"><i class="fas fa-pen icon_color"></i></a>&nbsp;
                                <a href="#" class="icon_color btn-delete-data" data-id="{{$d->id_approver}}"><i class="fas fa-trash"></i></a>
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
                    <h4 class="modal-title">{{ __('setup-userpermission-activation_validator-approver.new-validator_language') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/setup/userpermission/aktivasi_approver/new_approver" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="segment" class="text_name form-control-label">{{ __('setup-userpermission-activation_validator-approver.region3_language') }}</label>
                            <select class="form-control btn-default" name="id_region" required autofocus>
                                <option selected value="" disabled>{{ __('setup-userpermission-activation_validator-approver.region4_language') }}</option>
                                @foreach($regions as $region)
                                <option value="{{$region->region_id}}">{{$region->region_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="segment" class="text_name form-control-label">{{ __('setup-userpermission-activation_validator-approver.type2_language') }}</label>
                            <select class="form-control btn-default" name="id_type" required autofocus>
                                <option selected value="" disabled>{{ __('setup-userpermission-activation_validator-approver.type3_language') }}</option>
                                @foreach(\App\Model\AktivasiType::get() as $d)
                                <option value="{{$d->id_service}}">{{$d->service_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="segment" class="form-control-label" style="    font-family: Montserrat;
                            line-height: 17px;">{{ __('setup-userpermission-activation_validator-approver.validator4_language') }}</label>
                        </div>
                        <div class="form-group">
                            <label for="layer" class="text_name form-control-label">{{ __('setup-userpermission-activation_validator-approver.validator5_language') }}</label>
                            <select class="form-control select2 btn-default" name="approver_1" required autofocus>
                                <option selected disabled value="">-- {{ __('setup-userpermission-activation_validator-approver.select_language') }} --</option>
                                @foreach($users as $u)
                                <option value="{{$u->id}}">{{$u->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="layer" class="text_name form-control-label">{{ __('setup-userpermission-activation_validator-approver.validator6_language') }}</label>
                            <select class="form-control select2 btn-default" name="approver_2" required autofocus>
                                <option selected disabled value="">-- {{ __('setup-userpermission-activation_validator-approver.select2_language') }} --</option>
                                @foreach($users as $u)
                                <option value="{{$u->id}}">{{$u->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="layer" class="text_name form-control-label">{{ __('setup-userpermission-activation_validator-approver.validator11_language') }}</label>
                            <select class="form-control select2 btn-default" name="approver_3" required autofocus>
                                <option selected disabled value="">-- {{ __('setup-userpermission-activation_validator-approver.select6_language') }} --</option>
                                @foreach($users as $u)
                                <option value="{{$u->id}}">{{$u->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer justify-content-start">
                            <button type="submit" class="btn btn-primary" style="width: 70px;">{{ __('setup-userpermission-activation_validator-approver.save_language') }}</button>
                            <button type="button" class="btn btn-default" style="color: #fff; background: #CECECE">{{ __('setup-userpermission-activation_validator-approver.close_language') }}</button>
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
                    <h4 class="modal-title">{{ __('setup-userpermission-activation_validator-approver.edit-validator_language') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/setup/userpermission/aktivasi_approver/edit_approver" method="POST" enctype="multipart/form-data" class="form-update-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <input name="id" hidden>
                            <label for="segment" class="text_name form-control-label">{{ __('setup-userpermission-activation_validator-approver.region5_language') }}</label>
                            <select class="form-control btn-default" name="id_region" required autofocus>
                                <option selected value="" disabled>{{ __('setup-userpermission-activation_validator-approver.region6_language') }}</option>
                                @foreach($regions as $region)
                                <option value="{{$region->region_id}}">{{$region->region_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="segment" class="text_name form-control-label">{{ __('setup-userpermission-activation_validator-approver.type4_language') }}</label>
                            <select class="form-control btn-default" name="id_type" required autofocus>
                                <option selected value="" disabled>{{ __('setup-userpermission-activation_validator-approver.type5_language') }}</option>
                                @foreach(\App\Model\AktivasiType::get() as $d)
                                <option value="{{$d->id_service}}">{{$d->service_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="segment" class="form-control-label" style="font-family: Montserrat;
                            line-height: 17px;">{{ __('setup-userpermission-activation_validator-approver.validator7_language') }}</label>
                        </div>
                        <div class="form-group">
                            <label for="layer" class="text_name form-control-label">{{ __('setup-userpermission-activation_validator-approver.validator8_language') }}</label>
                            <select class="form-control select2 btn-default" name="approver_1" required autofocus>
                                <option selected disabled value="">-- {{ __('setup-userpermission-activation_validator-approver.select3_language') }} --</option>
                                @foreach($users as $u)
                                <option value="{{$u->id}}">{{$u->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="layer" class="text_name form-control-label">{{ __('setup-userpermission-activation_validator-approver.validator9_language') }}</label>
                            <select class="form-control select2 btn-default" name="approver_2" required autofocus>
                                <option selected disabled value="">-- {{ __('setup-userpermission-activation_validator-approver.select4_language') }} --</option>
                                @foreach($users as $u)
                                <option value="{{$u->id}}">{{$u->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="layer" class="text_name form-control-label">{{ __('setup-userpermission-activation_validator-approver.validator12_language') }}</label>
                            <select class="form-control select2 btn-default" name="approver_3" required autofocus>
                                <option selected disabled value="">-- {{ __('setup-userpermission-activation_validator-approver.select5_language') }} --</option>
                                @foreach($users as $u)
                                <option value="{{$u->id}}">{{$u->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer justify-content-start">
                            <button type="submit" class="btn btn-primary" style="width: 70px;">{{ __('setup-userpermission-activation_validator-approver.save2_language') }}</button>
                            <button type="button" class="btn btn-default" style="color: #fff; background: #CECECE">{{ __('setup-userpermission-activation_validator-approver.close2_language') }}</button>
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
                    <h5 class="modal-title">{{ __('setup-userpermission-activation_validator-approver.delete_language') }}</h5>
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
                                {{ __('setup-userpermission-activation_validator-approver.message_language') }}
                                <br>
                                {{ __('setup-userpermission-activation_validator-approver.continue_language') }}
                            </span>
                        </p>
                        <hr>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-transparent btn-md text-dark" style="font-weight:bold; font-size:15px" data-dismiss="modal">{{ __('setup-userpermission-activation_validator-approver.close3_language') }}</a>
                        <a href="#" class="btn btn-primary btn-md text-light col-md-2 btn-delete-ok">{{ __('setup-userpermission-activation_validator-approver.ok_language') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
                    url: '/setup/userpermission/aktivasi_approver/getApprover',
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
        $(document).on('click', '.btn-delete-data', function(e){
            e.preventDefault();
            var ini = $(this);
                id = ini.data('id');
                mdl = $('#deleteData');
            mdl.find('.btn-delete-ok').attr('href', '/setup/userpermission/delete_aktivasi_approver?id_approver='+id);
            mdl.modal('show');
        });
    </script>
@endpush
