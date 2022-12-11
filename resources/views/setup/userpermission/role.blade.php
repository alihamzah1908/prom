<link href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<div id="menu1"  class="content_header">
    <div class="content_menu">
        <h4 class="title_2">{{ __('setup-userpermission-role.roles_language') }}</h4>
        <a href="/setup/userpermission/role/new" style="margin-bottom: 10px" class="btn btn-sm btn-primary">{{ __('setup-userpermission-role.new-role_language') }}</a>
        <!--<button type="button" style="margin-bottom: 10px" class="btn btn-sm btn-primary" data-toggle="modal"-->
        <!--    data-target="#roleModal">New Role-->
        <!--</button>-->
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <table id="data_table" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th width="5%"></th>
                            <th>{{ __('setup-userpermission-role.role-name_language') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Model\Roles::get() as $roles)
                        <tr>
                            <td style="vertical-align: middle">
                                <a href="#" class="icon_color btn-delete-data" data-id="{{$roles->id_role}}"><i class="fas fa-trash"></i></a>
                            </td>
                            <td style="display: grid">
                                <a href="/setup/userpermission/role/{{$roles->id_role}}" class="judul2">{{$roles->role_name}}</a>
                                <!--<small class="user_small">Full control to configure and menage announcment</small>-->
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <div class="modal fade" id="roleModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('setup-userpermission-role.new-role2_language') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/setup/userpermission/new_role" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label class="text_name form-control-label">{{ __('setup-userpermission-role.name_language') }}</label>
                            <input type="text" class="form-control" name="role_name" id="role_name" placeholder="{{ __('setup-userpermission-role.role-name2_language') }}" required autofocus>
                        </div>
                        
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-info btn-sm text-light" data-dismiss="modal" style="font-weight:bold; font-size:15px">{{ __('setup-userpermission-role.cancel_language') }}</button>
                            <button type="submit" class="btn btn-sm btn-success" style="width: 70px;">{{ __('setup-userpermission-role.save_language') }}</button>
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
                    <h5 class="modal-title">{{ __('setup-userpermission-role.delete_language') }}</h5>
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
                                {{ __('setup-userpermission-role.message_language') }}
                                <br>
                                {{ __('setup-userpermission-role.continue_language') }}
                            </span>
                        </p>
                        <hr>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-transparent btn-md text-dark" style="font-weight:bold; font-size:15px" data-dismiss="modal">{{ __('setup-userpermission-role.close_language') }}</a>
                        <a href="#" class="btn btn-primary btn-md text-light col-md-2 btn-delete-ok">{{ __('setup-userpermission-role.ok_language') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).on('click', '.btn-delete-data', function(e){
    e.preventDefault();
    var ini = $(this);
        id = ini.data('id');
        mdl = $('#deleteData');
    mdl.find('.btn-delete-ok').attr('href', '/setup/userpermission/delete_role?id_role='+id);
    mdl.modal('show');
});
$(document).ready(function(){
    var table = $('#data_table').DataTable();
})
</script>



