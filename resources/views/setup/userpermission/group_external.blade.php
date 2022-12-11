
<link href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<style>
    td.details-control {
        background: url('/images/details_open.png') no-repeat center center;
        cursor: pointer;
    }
    tr.shown td.details-control {
        background: url('/images/details_close.png') no-repeat center center;
    }
</style>

<div id="menu6" class="content_header">
    <div class="content_menu">
        <h4 class="title_2">{{ __('setup-userpermission-group_external.group-external_language') }}</h4>
        <button type="button" style="margin-bottom: 10px" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#groupModal">{{ __('setup-userpermission-group_external.new-group_language') }}</button>
        <button type="button" style="margin-bottom: 10px" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#userModal">{{ __('setup-userpermission-group_external.new-user_language') }}</button>
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <table id="data_table" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width: 52px"></th>
                            <th style="width: 52px"></th>
                            <th>{{ __('setup-userpermission-group_external.name_language') }}</th>
                            <th>{{ __('setup-userpermission-group_external.desc_language') }}</th>
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
                    <h3 class="modal-title">Group External</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body form-remove-data">
                    <div class="form-group">
                        <label >Group Name</label>
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
    <div class="modal fade" id="groupModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('setup-userpermission-group_external.new-group2_language') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/setup/userpermission/new_group_customer" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="name" class="text_name">{{ __('setup-userpermission-group_external.name2_language') }}</label>
                            <input name="group_name" type="text" value="" class="form-control" placeholder="{{ __('setup-userpermission-group_external.name3_language') }}" required autofocus>
                        </div>
                        <div class="form-group">
                            <label class="text_name">{{ __('setup-userpermission-group_external.desc2_language') }}</label>
                            <textarea name="group_desc" class="form-control" placeholder="{{ __('setup-userpermission-group_external.desc3_language') }}" required autofocus></textarea>
                        </div>
                        <div class="modal-footer justify-content-start">
                            <button type="submit" class="btn btn-primary" style="width: 70px;">{{ __('setup-userpermission-group_external.submit_language') }}</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close" style="color: #fff; background: #CECECE">{{ __('setup-userpermission-group_external.close_language') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="userModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('setup-userpermission-group_external.new-customer_language') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/setup/userpermission/new_group_user/CUSTOMER" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label class="text_name form-control-label">{{ __('setup-userpermission-group_external.group_language') }}</label>
                            <select class="form-control select2" name="id_group" required autofocus>
                                <option selected="selected" disabled value="">{{ __('setup-userpermission-group_external.group2_language') }}</option>
                                @foreach(\App\Model\GroupCustomer::get() as $group)
                                <option value="{{$group->id_group}}">{{$group->group_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name" class="text_name">{{ __('setup-userpermission-group_external.name4_language') }}</label>
                            <select class="form-control select2" name="id_user" required autofocus>
                                <option selected="selected" disabled value="">-- {{ __('setup-userpermission-group_external.select-customer_language') }} --</option>
                                @foreach(\App\Model\Customer::get() as $group)
                                <option value="{{$group->id_customer}}">{{$group->name_customer}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer justify-content-start">
                            <button type="submit" class="btn btn-primary" style="width: 70px;">{{ __('setup-userpermission-group_external.save_language') }}</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close" style="color: #fff; background: #CECECE">{{ __('setup-userpermission-group_external.close2_language') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
     $(document).on('click', '.btn-delete-user', function(e){
        var init = $(this),
            id = init.data('id'),
            name = init.data('name');
            
            console.log(id);
            console.log(name);
           
        mod = $('#removeData');
        form = $('.form-remove-data');
        form.find('input[name=name]').val(name);
        form.find('.btn-remove-user').attr('href', '/setup/userpermission/delete_group_external/'+id);
        mod.modal('show');
    });
</script>
<script>
    $(document).ready(function() {
        initTable();
    }
   
    );
    function initTable(){
        var table = $('#data_table').DataTable( {
            "ajax": "/setup/userpermission/getGroupCustomer",
            "columns": [
             {
                    "className":      '',
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ''
                },
             
                {
                    "className":      'details-control',
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ''
                },
                 
                { "data": "group_name" },
                { "data": "group_desc" }
            ],
            "createdRow": function (row, data, dataIndex) {
                $(row).attr('data-id_group', data.id_catgory);
            },
            "columnDefs": [
                {
                    "targets" : 2,
                    "data": "id_group",
                    "render" : function (data, type, row) {
                       return '<a href="#" class="id_group" data-id_group="'+row.id_group+'">'+row.group_name+'</a>';
                    }
                },
                 {
                    "targets" : 0,
                    "data": "id_group",
                    "render" : function (data, type, row) {
                       return '<a href="#" style="width: 52px !important" class="btn btn-md btn-danger btn-delete-user" data-id="'+row.id_group+'" data-name="'+row.group_name+'"><i class="fa fa-trash"></i></a>';
                    }
                },
            ],
            "order": [[2, 'asc']]
        });
         
        // Add event listener for opening and closing details
        $('#data_table tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row( tr );
     
            if ( row.child.isShown() ) {
                row.child.hide();
                tr.removeClass('shown');
            }else {
                row.child( setSubTable(row.data()) ).show();
                tr.addClass('shown');
                initSubTable(row.data());
            }
        });
    }
    function setSubTable(d) {
        var table = '<table id="sub_data_table'+d.id_group+'" class="display sub_data_table" style="width:100%">' +
                        '<thead>' +
                            '<tr>' +
                                '<th></th>' +
                                '<th>{{ __('setup-userpermission-group_external.name5_language') }}</th>' +
                                '<th>{{ __('setup-userpermission-group_external.email_language') }}</th>' +
                            '</tr>' +
                        '</thead>' +
                    '</table>';
        var card = '<div class="card">'+
                        '<div class="card-body">' +
                            table +
                        '</div' +
                    '</div>';
        return card;
    }
    function initSubTable(data){
        var table = $('#sub_data_table'+data.id_group).DataTable( {
            "ajax": {
                "url": "/setup/userpermission/getGroupUser",
                "data": {
                    id_group:data.id_group,
                    group_type:"CUSTOMER"
                }
            },
            "columns": [
                {
                    "className":      'sub-details-control',
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ''
                },
                { "data": "name" },
                { "data": "email" }
            ],
            "createdRow": function (row, data, dataIndex) {
                $(row).attr('data-id_group_user', data.id_group_user);
            },
            "columnDefs": [
                {
                    "targets" : 0,
                    "data": "id_group_user",
                    "render" : function (data, type, row) {
                       return '<a href="#" class="id_group_user" data-id_group_user="'+row.id_group_user+'">'+row.name+'</a>';
                    }
                },
            ],
            "order": [[1, 'asc']],
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": false,
            "bSort": true,
            "bInfo": false,
        });
    }
</script>