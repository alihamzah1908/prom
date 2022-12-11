
<div id="menu2" class="content_header">
    <div class="content_menu">
        <h4 class="title_2">Admin</h4>
        <button type="button" style="margin-bottom: 10px" class="btn btn-sm btn-primary" data-toggle="modal"
            data-target="#adminModal">New Admin
        </button>
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 74px"></th>
                            <th>Name</th>
                            <th>Login Name</th>
                            <th>Email</th>
                            <th>Departement Name</th>
                            <th>Employe ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="vertical-align: middle">
                                <a href="#"><i class="fas fa-pen icon_color"></i></a>&nbsp;
                                <a href="#"><i class="fas fa-trash icon_color"></i></a>
                            </td>
                            <td class="text_name">
                                Agus Budi Susilo
                            </td>
                            <td class="text_name">
                                Agusbudi@gmail.com
                            </td>
                            <td class="text_name">
                                Agusbudi@gmail.com
                            </td>
                            <td class="text_name">
                                ICON+
                            </td>
                            <td class="text_name">

                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <div class="modal fade" id="adminModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Admin</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label class="text_name form-control-label">Name</label>
                            <select class="form-control select2" name="name">
                                <option selected="selected">Username</option>
                                <option>Alaska</option>
                                <option>California</option>
                                <option>Delaware</option>
                                <option>Tennessee</option>
                                <option>Texas</option>
                                <option>Washington</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description" class="text_name">Description</label>
                            <input name="description" type="text" value=""
                                class="placeholder_color form-control @error('description') is-invalid invalid @enderror"
                                id="description" aria-describedby="namaHelp" placeholder="Description">
                            @error('description')
                            <span class="invalid"><i>{{$message}}</i></span>
                            @enderror
                        </div>
                        <div class="modal-footer justify-content-start">
                            <button type="button" class="btn btn-primary" style="width: 70px;">Save</button>
                            <button type="button" class="btn btn-default"
                                style="color: #fff; background: #CECECE">Cancle</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

