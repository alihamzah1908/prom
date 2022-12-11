<div id="menu6" class="content_header">
    <div class="content_menu">
        <h4 class="title_2">{{ __('setup-userpermission-customer.customer_language') }}</h4>
        <button type="button" style="margin-bottom: 10px" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#userModal">{{ __('setup-userpermission-customer.new-customer_language') }}</button>
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <table id="data_table" class="table" style="width:100%">
                    <thead>
                        <tr>
                            <th width="8%">#</th>
                            <th width="5%">{{ __('setup-userpermission-customer.id_language') }}</th>
                            <th>{{ __('setup-userpermission-customer.name_language') }}</th>
                            <th>{{ __('setup-userpermission-customer.email_language') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $data = \App\Model\Customer::orderBy('id_customer');
                        $data = $data->get();
                        ?>
                        @foreach($data as $d)
                        <tr>
                            <td>
                                <a href="#" class="btn-edit-data" data-id="{{$d->id_customer}}"><i class="fas fa-pen icon_color"></i></a>
                                <a href="#" class="icon_color btn-delete-data" data-id="{{$d->id_customer}}"><i class="fas fa-trash"></i></a>
                            </td>
                            <td class="text_name">{{isset($d->id_customer)?$d->id_customer:''}}</td>
                            <td class="text_name">{{isset($d->name_customer)?$d->name_customer:''}}</td>
                            <td class="text_name">{{isset($d->email)?$d->email:''}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <div class="modal fade" id="userModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('setup-userpermission-customer.new-customer2_language') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/setup/userpermission/new_customer" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="name" class="text_name">{{ __('setup-userpermission-customer.name2_language') }}</label>
                            <input class="form-control" name="name_customer" required autofocus placeholder="{{ __('setup-userpermission-customer.name3_language') }}">
                        </div>
                        <div class="form-group">
                            <label for="name" class="text_name">{{ __('setup-userpermission-customer.email2_language') }}</label>
                            <input type="Ememail" class="form-control" name="email" required autofocus placeholder="{{ __('setup-userpermission-customer.email3_language') }}">
                        </div>
                        <div class="modal-footer justify-content-start">
                            <button type="submit" class="btn btn-primary" style="width: 70px;">{{ __('setup-userpermission-customer.save_language') }}</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close" style="color: #fff; background: #CECECE">{{ __('setup-userpermission-customer.close_language') }}</button>
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
                    <h4 class="modal-title">{{ __('setup-userpermission-customer.edit-customer_language') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/setup/userpermission/edit_customer" method="POST" enctype="multipart/form-data" class="form-update-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="name" class="text_name">{{ __('setup-userpermission-customer.name4_language') }}</label>
                            <input class="form-control" name="name_customer" required autofocus placeholder="{{ __('setup-userpermission-customer.name5_language') }}">
                            <input name="id_customer" hidden>
                        </div>
                        <div class="form-group">
                            <label for="name" class="text_name">{{ __('setup-userpermission-customer.email4_language') }}</label>
                            <input type="Ememail" class="form-control" name="email" required autofocus placeholder="{{ __('setup-userpermission-customer.email5_language') }}">
                        </div>
                        <div class="modal-footer justify-content-start">
                            <button type="submit" class="btn btn-primary" style="width: 70px;">{{ __('setup-userpermission-customer.save2_language') }}</button>
                            <button type="button" class="btn btn-default" style="color: #fff; background: #CECECE">{{ __('setup-userpermission-customer.close2_language') }}</button>
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
                    <h5 class="modal-title">{{ __('setup-userpermission-customer.delete_language') }}</h5>
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
                                {{ __('setup-userpermission-customer.message_language') }}
                                <br>
                                {{ __('setup-userpermission-customer.continue_language') }}
                            </span>
                        </p>
                        <hr>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-transparent btn-md text-dark" style="font-weight:bold; font-size:15px" data-dismiss="modal">{{ __('setup-userpermission-customer.close3_language') }}</a>
                        <a href="#" class="btn btn-primary btn-md text-light col-md-2 btn-delete-ok">{{ __('setup-userpermission-customer.ok_language') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).on('click', '.btn-edit-data', function(e){
        e.preventDefault();
        var ini = $(this),
            id = ini.data('id'),
            form = $('.form-update-data');
        if($.isNumeric(id)) {
            var e_modal_wait = $("#modalWait");
            showLoading(e_modal_wait);
            $.ajax({
                url: '/setup/userpermission/getCustomer',
                type: "get",
                data: {
                        id: id
                      }
            })
            .done(function (result) {
                hideLoading(e_modal_wait);
                if(result.data[0]){
                    data = result.data[0];
                    form.find('input[name=id_customer]').val(data.id_customer);
                    form.find('input[name=name_customer]').val(data.name_customer);
                    form.find('input[name=email]').val(data.email);
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
        mdl.find('.btn-delete-ok').attr('href', '/setup/userpermission/delete_customer?id_customer='+id);
        mdl.modal('show');
    });
</script>