<div id="menu3" class="content_header">
    <div class="content_menu">
        <h4 class="title_2">{{ __('setup-userpermission-technicians.technicians_language') }}</h4>
        <button type="button" style="margin-bottom: 10px" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#technicianModal">{{ __('setup-userpermission-technicians.new-technician_language') }}</button>
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <table id="data_table" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width: 74px"></th>
                            <th>{{ __('setup-userpermission-technicians.name_language') }}</th>
                            <th>{{ __('setup-userpermission-technicians.login-name_language') }}</th>
                            <th>{{ __('setup-userpermission-technicians.email_language') }}</th>
                            <th>{{ __('setup-userpermission-technicians.departement-name_language') }}</th>
                            <th>{{ __('setup-userpermission-technicians.employe-id_language') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
        <div class="modal fade" tabindex="-1" id="removeData" role="dialog" aria-labelledby="warning">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Technician</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body form-remove-data">
                    <div class="form-group">
                        <label >Technician Name</label>
                        <input type="text" class="form-control" name="name" readonly style="background-color: #e9ecef !important">
                    </div>
                    <hr>
                    
                   
                    <hr>
                    <br>
                    
                    <div class="modal-footer justify-content-between">
                        <a href="#" type="button" class="btn btn-info btn-sm text-light" data-dismiss="modal" style="font-weight:bold; font-size:15px">{{ __('setup-customization-checklist.cancel_language') }}</a>
                        <a href="#" class="btn btn-sm btn-danger btn-remove-user">{{ __('setup-customization-checklist.delete_language') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="technicianModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('setup-userpermission-technicians.new-technician2_language') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/setup/userpermission/new_technician" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="name">{{ __('setup-userpermission-technicians.name-technician_language') }}</label>
                            <input type="text" class="form-control" name="name_technician" id="name_technician" placeholder="{{ __('setup-userpermission-technicians.name-technician2_language') }}" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="description" class="text_name">{{ __('setup-userpermission-technicians.user_language') }}</label>
                            <select class="form-control select2" style="width: 100%;" name="user_id" required autofocus>
                                <option selected="selected" value="" disabled>{{ __('setup-userpermission-technicians.user2_language') }}</option>
                                @foreach(\App\User::get() as $d)
                                <option value="{{$d->id}}">{{$d->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description" class="text_name">{{ __('setup-userpermission-technicians.region_language') }}</label>
                            <select class="form-control select2" style="width: 100%;" name="region_id" required autofocus>
                                <option selected="selected" value="" disabled>{{ __('setup-userpermission-technicians.region2_language') }}</option>
                                @foreach(\App\Model\Region::get() as $d)
                                <option value="{{$d->region_id}}">{{$d->region_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <!--<button type="button" class="btn btn-info btn-sm text-light" data-dismiss="modal" style="font-weight:bold; font-size:15px">{{ __('setup-userpermission-technicians.cancel_language') }}</button>-->
                            <!--<button type="submit" class="btn btn-sm btn-success" style="width: 70px;">{{ __('setup-userpermission-technicians.save_language') }}</button>-->
      
                            <button type="button" class="btn btn-default" style="color: #fff; background: #CECECE" data-dismiss="modal">{{ __('setup-userpermission-technicians.cancel_language') }}</button>
                            <button type="submit" class="btn btn-primary" style="width: 70px;">{{ __('setup-userpermission-technicians.save_language') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="updateTechnisian">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('setup-userpermission-technicians.new-technician2_language') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/setup/userpermission/new_technician" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="name">{{ __('setup-userpermission-technicians.name-technician_language') }}</label>
                            <input type="text" class="form-control" name="name_technician" id="name_technician" placeholder="{{ __('setup-userpermission-technicians.name-technician2_language') }}" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="description" class="text_name">{{ __('setup-userpermission-technicians.user_language') }}</label>
                            <select class="form-control select2" style="width: 100%;" name="user_id" required autofocus>
                                <option selected="selected" value="" disabled>{{ __('setup-userpermission-technicians.user2_language') }}</option>
                                @foreach(\App\User::get() as $d)
                                <option value="{{$d->id}}">{{$d->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description" class="text_name">{{ __('setup-userpermission-technicians.region_language') }}</label>
                            <select class="form-control select2" style="width: 100%;" name="region_id" required autofocus>
                                <option selected="selected" value="" disabled>{{ __('setup-userpermission-technicians.region2_language') }}</option>
                                @foreach(\App\Model\Region::get() as $d)
                                <option value="{{$d->region_id}}">{{$d->region_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <!--<button type="button" class="btn btn-info btn-sm text-light" data-dismiss="modal" style="font-weight:bold; font-size:15px">{{ __('setup-userpermission-technicians.cancel_language') }}</button>-->
                            <!--<button type="submit" class="btn btn-sm btn-success" style="width: 70px;">{{ __('setup-userpermission-technicians.save_language') }}</button>-->
      
                            <button type="button" class="btn btn-default" style="color: #fff; background: #CECECE" data-dismiss="modal">{{ __('setup-userpermission-technicians.cancel_language') }}</button>
                            <button type="submit" class="btn btn-primary" style="width: 70px;">{{ __('setup-userpermission-technicians.save_language') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var params = {}
    $(document).ready(function() {
        initTable(params);
    });
    function initTable(params){
        var dataTable = $('#data_table');
        var table = dataTable.DataTable( {
            "ajax": {
                "url":"/setup/userpermission/getTechnicians",
                "data": params
            },
            "columns": [
                { "data": "id_technician" },
                { "data": "name_technician" },
                { "data": "user.name" },
                { "data": "user.email" },
                { "data": "user.get_departement.name_departement" },
                { "data": "user.employe_id" },
            ],
            "createdRow": function (row, data, dataIndex) {
                $(row).attr('data-id_technician', data.id_technician);
            },
            "columnDefs": [
                {
                    "targets" : 2,
                    "data": "id_technician",
                    "render" : function (data, type, row) {
                       return '<a href="#" class="name_technician" data-id_technician="'+row.id_technician+'">'+row.name_technician+'</a>';
                    }
                },
               
                 {
                    "targets" : 0,
                    "data": "id_technician",
                    "render" : function (data, type, row) {
                       return '<a href="#" class="btn btn-md btn-danger btn-delete-user" data-id="'+row.id_technician+'" data-name="'+row.name_technician+'"><i class="fa fa-trash"></i></a>';
                    }
                },
            ],
            "order": [[1, 'asc']],
            "destroy": true,
            "bDestroy": true,
        });
         
    }
   </script>


   @push('scripts')
<script>
    $('.select2').select2();
    $('#data_table').DataTable();
    $(document).on('click', '.btn-delete-user', function(e){
        var init = $(this),
            id = init.data('id'),
            name = init.data('name');
            
            console.log(id);
            console.log(name);
           
        mod = $('#removeData');
        form = $('.form-remove-data');
        form.find('input[name=name]').val(name);
        form.find('.btn-remove-user').attr('href', '/setup/userpermission/delete_technician/'+id);
        mod.modal('show');
    });
    
   
</script>
@endpush