<div id="menu6" class="content_header">
    <div class="content_menu">
        <h4 class="title_2">Departement</h4>
        <button type="button" style="margin-bottom: 10px" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#userModal">New Departement</button>
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <table id="data_table" class="table" style="width:100%">
                    <thead>
                        <tr>
                            <th width="8%">#</th>
                            <th width="5%">ID</th>
                            <th>Departement Name</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $data = \App\Model\Departement::orderBy('id_departement');
                        $data = $data->get();
                        ?>
                        @foreach($data as $d)
                        <tr>
                            <td>
                                <a href="#" class="btn-edit-data" data-id="{{$d->id_departement}}"><i class="fas fa-pen icon_color"></i></a>
                                <a href="#" class="icon_color btn-delete-data" data-id="{{$d->id_departement}}"><i class="fas fa-trash"></i></a>
                            </td>
                            <td class="text_name">{{isset($d->id_departement)?$d->id_departement:''}}</td>
                            <td class="text_name">{{isset($d->name_departement)?$d->name_departement:''}}</td>
                            <td class="text_name">{{isset($d->desc_departement)?$d->desc_departement:''}}</td>
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
                    <h4 class="modal-title">New Departement</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/setup/userpermission/new_departement" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="name" class="text_name">Departement Name</label>
                            <input class="form-control" name="name_departement" required autofocus placeholder="Departement Name">
                        </div>
                        <div class="form-group">
                            <label for="name" class="text_name">Description</label>
                            <input type="desc_departement" class="form-control" name="desc_departement" required autofocus placeholder="Description">
                        </div>
                        <div class="modal-footer justify-content-start">
                            <button type="submit" class="btn btn-primary" style="width: 70px;">Save</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close" style="color: #fff; background: #CECECE">Cancel</button>
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
                    <h4 class="modal-title">Edit Departement</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/setup/userpermission/edit_departement" method="POST" enctype="multipart/form-data" class="form-update-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="name" class="text_name">Departement Name</label>
                            <input class="form-control" name="name_departement" required autofocus placeholder="Departement Name">
                            <input name="id_departement" hidden>
                        </div>
                        <div class="form-group">
                            <label for="name" class="text_name">Description</label>
                            <input type="text" class="form-control" name="desc_departement" required autofocus placeholder="Description">
                        </div>
                        <div class="modal-footer justify-content-start">
                            <button type="submit" class="btn btn-primary" style="width: 70px;">Save</button>
                            <button type="button" class="btn btn-default" style="color: #fff; background: #CECECE">Cancel</button>
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
                    <h5 class="modal-title">Delete Departement</h5>
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
                                This Departement will be delete permanently!
                                <br>
                                Are you sure to delete this?
                            </span>
                        </p>
                        <hr>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-transparent btn-md text-dark" style="font-weight:bold; font-size:15px" data-dismiss="modal">Cancel</a>
                        <a href="#" class="btn btn-primary btn-md text-light col-md-2 btn-delete-ok">Yes</a>
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
                url: '/setup/userpermission/getDepartement',
                type: "get",
                data: {
                        id: id
                      }
            })
            .done(function (result) {
                hideLoading(e_modal_wait);
                if(result.data[0]){
                    data = result.data[0];
                    form.find('input[name=id_departement]').val(data.id_departement);
                    form.find('input[name=name_departement]').val(data.name_departement);
                    form.find('input[name=desc_departement]').val(data.desc_departement);
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
        mdl.find('.btn-delete-ok').attr('href', '/setup/userpermission/delete_departement?id_departement='+id);
        mdl.modal('show');
    });
</script>