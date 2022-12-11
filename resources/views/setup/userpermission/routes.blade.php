@extends('setup.template.default')
@section('title_menu', 'User & Permissions')
@section('navbar')
<nav class="main-header navbar navbar-expand navbar-white navbar-light" style="padding: 0px !important">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav menu_servicedesk">
            <li class="nav-item">
                <a href="?view=role" class="{{  $view == 'role' ? 'active bg-primary' : '' }} nav-link text-header">Role</a>
            </li>
            <li class="nav-item">
                <a href="?view=admin" class="{{  $view == 'admin' ? 'active bg-primary' : '' }} nav-link text-header1">Admin</a>
            </li>
            <li class="nav-item">
                <a href="?view=technicians" class="{{  $view == 'technician' ? 'active bg-primary' : '' }} nav-link text-header1">Technicians</a>
            </li>
            <li class="nav-item">
                <a href="?view=validator" class="{{  $view == 'validator' ? 'active bg-primary' : '' }} nav-link text-header1">Validator</a>
            </li>
            <li class="nav-item">
                <a href="?view=visitor" class="{{  $view == 'visitor' ? 'active bg-primary' : '' }} nav-link text-header1">Visitor</a>
            </li>
            <li class="nav-item">
                <a href="?view=group_internal" class="{{  $view == 'group_internal' ? 'active bg-primary' : '' }} nav-link text-header1">Group Internal</a>
            </li>
            <li class="nav-item">
                <a href="?view=group_external" class="{{  $view == 'group_external' ? 'active bg-primary' : '' }} nav-link text-header1">Group External</a>
            </li>
            <li class="nav-item">
                <a href="?view=routes" class="{{  $view == 'routes' ? 'active bg-primary' : '' }} nav-link text-header1">Routes</a>
            </li>

        </ul>
    </div>
</nav>
@endsection
@section('content')
<link href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<style>
    td.details-control {
        background: url('/images/details_open.png') no-repeat center center;
        cursor: pointer;
    }
    tr.shown td.details-control {
        background: url('/images/details_close.png') no-repeat center center;
    }
    td.sub-details-control {
        background: url('/images/details_open.png') no-repeat center center;
        cursor: pointer;
    }
    tr.shown td.sub-details-control {
        background: url('/images/details_close.png') no-repeat center center;
    }
</style>

@if(Session::has('message'))
<div class="alert {{Session::get('alert-class')}} alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
    {{ Session::get('message') }}
</div>
@endif

<div id="menu3" class="content_header">
    <div class="content_menu">
        <h4 class="title_2">Routes</h4>
        <button type="button" style="margin-bottom: 10px" class="btn btn-sm btn-primary" data-toggle="modal"
            data-target="#technicianModal">New Routes
        </button>
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <table id="data_table" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th width="10%"></th>
                            <th width="10%"></th>
                            <th>Name</th>
                            <th>Route</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <div class="modal fade" id="technicianModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Route</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/setup/userpermission/new_route" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label class="text_name form-control-label">Name</label>
                            <input class="form-control" name="name" required autofocus>
                        </div>
                        <div class="form-group">
                            <label class="text_name form-control-label">Route</label>
                            <input class="form-control" name="route" required autofocus>
                        </div>
                        <div class="form-group">
                            <label class="text_name form-control-label">Parent (Optional)</label>
                            <select class="form-control" name="id_parent">
                                <option value="" selected disabled>Parent Route</option>
                                @foreach(\App\Model\Routes::where('id_parent', null)->get() as $route)
                                <option value="{{$route->id_route}}">{{$route->name}}</option>
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
</div>
<script>
$(document).ready(function(){
    function setSubTable(d) {
        var table = '<table id="sub_data_table'+d.id_route+'" class="display sub_data_table" style="width:100%">' +
                        '<thead>' +
                            '<tr>' +
                                '<th></th>' +
                                '<th>Route Name</th>' +
                                '<th>Route</th>' +
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
    var table = $('#data_table').DataTable( {
            "ajax": "/setup/userpermission/getRoute?type=PARENT",
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
                { "data": "name" },
                { "data": "route" },
                { "data": "created_at" },
            ],
            "createdRow": function (row, data, dataIndex) {
                $(row).attr('data-id_route', data.id_route);
            },
            "columnDefs": [
                {
                    "targets" : 0,
                    "data": "id_route",
                    "render" : function (data, type, row) {
                       return '<a href="#"><i class="fas fa-pen icon_color"></i></a>&nbsp;<a href="#"><i class="fas fa-trash icon_color"></i></a>';
                    }
                },
                {
                    "targets" : 2,
                    "data": "id_route",
                    "render" : function (data, type, row) {
                       return '<a href="#" class="id_route_click" data-id_route="'+row.id_route+'">'+row.name+'</a>';
                    }
                },
            ],
            "order": [[1, 'asc']]
        });
    
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
    
    function initSubTable(data){
        var table = $('#sub_data_table'+data.id_route).DataTable( {
            "ajax": {
                "url": "/setup/userpermission/getRoute?id_parent="+data.id_route,
            },
            "columns": [
                {
                    "className":      '',
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ''
                },
                { "data": "name" },
                { "data": "route" }
            ],
            
            "columnDefs": [
                {
                    "targets" : 1,
                    "data": "id_route",
                    "render" : function (data, type, row) {
                       return '<a href="#" class="sub_route_click" data-id_route="'+row.id_route+'">'+row.name+'</a>';
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
})

</script>
@endsection