@extends('template.default')
@section('title', 'User')
@section('submenu')
<!--<div class="row mb-2">-->
<!--    <div class="col-sm-6">-->
<!--        <h3 class="m-0 text-dark"><strong>User Account</strong></h3>-->
<!--        <small>User Account</small>-->
<!--    </div>-->
<!--</div>-->
@endsection
@section('content')
@if(Session::has('message'))
    <div class="alert {{Session::get('alert-class')}} alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        {{ Session::get('message') }}
    </div>
@endif
<div class="card">
    <!-- /.card-header -->
    <div class="card-header">
        <h3 class="card-title"> <strong>{{ __('sidebar-user-index1.lists_language') }}</strong></h3>
    </div>
    {{-- card body --}}
    <div class="card-body">
        <div class="row">
            <div class="col-md-2 form-group">
                <button type="button" style="margin-bottom: 10px" class="btn btn-md btn-primary col-md-12" data-toggle="modal" data-target="#newData">{{ __('sidebar-user-index1.create_language') }}</button>
            </div>
            <div class="col-md-3 form-group">
                <div class="form-group">
                    <select class="form-control select2 select_role" style="width: 100%;">
                        <option selected="selected" value="" disabled>{{ __('sidebar-user-index1.role_language') }}</option>
                        @foreach(\App\Model\Roles::get() as $role)
                        <option value="{{$role->id_role}}" {{request()->id_role == $role->id_role ? 'selected':''}}>{{$role->role_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <table id="user_data_table" class="display table-border-gray" style="width:100%">
            <thead>
                <tr>
                    <th style="width: 10px">{{ __('sidebar-user-index1.id_language') }}</th>
                    <th>{{ __('sidebar-user-index1.name_language') }}</th>
                    <th>{{ __('sidebar-user-index1.e-mail_language') }}</th>
                    <th>{{ __('sidebar-user-index1.role2_language') }}</th>
                    <th>{{ __('sidebar-user-index1.department_language') }}</th>
                    <th>{{ __('sidebar-user-index1.create-date_language') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $is_admin = is_admin(Auth::user());
                if(request()->id_role){
                    $users = \App\User::where('role_id', request()->id_role)->get();
                }else{
                    $users = \App\User::where('is_deleted',0)->get();
                }
                ?>
                @foreach($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>
                        <a href="/user/profile?id={{$user->id}}" data-id="{{$user->id}}">{{$user->name}}</a>
                    </td>
                    <td>{{$user->email}}</td>
                    <td>{{isset($user->role)?$user->role->role_name:''}}</td>
                    <td>{{isset($user->getDepartement)?$user->getDepartement->name_departement:''}}</td>
                    <td>{{date('Y-M-d', strtotime($user->created_at))}}</td>
                    <td>
                        @if($is_admin)
                        <a href="#" class="btn btn-md btn-danger btn-delete-user" data-id="{{$user->id}}" data-name="{{$user->name}}" data-email="{{$user->email}}">
                            <i class="fa fa-trash"></i>
                        </a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="modal fade" tabindex="-1" id="newData" role="dialog" aria-labelledby="warning">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="/user/new_user" class="form-new-data">
                @csrf
                    <div class="modal-header">
                        <h3 class="modal-title">{{ __('sidebar-user-index1.new-user_language') }}</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">{{ __('sidebar-user-index1.name2_language') }}</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="{{ __('sidebar-user-index1.username_language') }}" required autofocus
                            @if(old('name')) value="{{old('name')}}" @endif>
                        </div>
                        <div class="form-group">
                            <label for="email">{{ __('sidebar-user-index1.e-mail2_language') }}</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="{{ __('sidebar-user-index1.e-mail3_language') }}" required autofocus
                            @if(old('email')) value="{{old('email')}}" @endif>
                        </div>
                        <div class="form-group">
                            <label for="email">{{ __('sidebar-user-index1.telephone_language') }}</label>
                            <input type="number" class="form-control" name="telpone" placeholder="{{ __('sidebar-user-index1.telephone2_language') }}" required autofocus
                            @if(old('telpone')) value="{{old('telpone')}}" @endif>
                        </div>
                        <div class="form-group">
                            <label for="email">{{ __('sidebar-user-index1.mobile-phone_language') }}</label><small>{{ __('sidebar-user-index1.optional_language') }}</small>
                            <input type="number" class="form-control" name="mobile" placeholder="{{ __('sidebar-user-index1.mobile-phone2_language') }}" required autofocus
                            @if(old('mobile')) value="{{old('mobile')}}" @endif>
                        </div>
                        <div class="form-group">
                            <label for="password">{{ __('sidebar-user-index1.password_language') }}</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="{{ __('sidebar-user-index1.password2_language') }}" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="password_confirm">{{ __('sidebar-user-index1.password-confirm_language') }}</label>
                            <input type="password" class="form-control" name="password_confirm" id="password_confirm" placeholder="{{ __('sidebar-user-index1.password-confirm2_language') }}" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="departemen">{{ __('sidebar-user-index1.department2_language') }}</label>
                            <select class="form-control select2" style="width: 100%;" name="departement_id" required autofocus>
                                <option selected="selected" value="" disabled>{{ __('sidebar-user-index1.department3_language') }}</option>
                                @foreach(\App\Model\Departement::get() as $d)
                                <option value="{{$d->id_departement}}"
                                @if(old('departement_id') == $d->id_departement) selected @endif
                                >{{$d->name_departement}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="email">{{ __('sidebar-user-index1.role3_language') }}</label>
                            <select class="form-control select2" style="width: 100%;" name="role_id" required autofocus>
                                <option selected="selected" value="" disabled>{{ __('sidebar-user-index1.role4_language') }}</option>
                                @foreach(\App\Model\Roles::get() as $role)
                                <option value="{{$role->id_role}}"
                                @if(old('role_id') == $role->id_role) selected @endif
                                >{{$role->role_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-info btn-sm text-light" data-dismiss="modal" style="font-weight:bold; font-size:15px">{{ __('sidebar-user-index1.cancel_language') }}</button>
                            <button type="submit" class="btn btn-sm btn-success" style="width: 100px;">{{ __('sidebar-user-index1.save_language') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @if($is_admin)
    <div class="modal fade" tabindex="-1" id="removeData" role="dialog" aria-labelledby="warning">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">{{ __('sidebar-user-index1.user_language') }}</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body form-remove-data">
                    <div class="form-group">
                        <label >{{ __('sidebar-user-index1.name3_language') }}</label>
                        <input type="text" class="form-control" name="name" placeholder="{{ __('sidebar-user-index1.name4_language') }}" readonly style="background-color: #e9ecef !important">
                    </div>
                    <div class="form-group">
                        <label >{{ __('sidebar-user-index1.e-mail4_language') }}</label>
                        <input type="email" class="form-control" name="email" placeholder="{{ __('sidebar-user-index1.e-mail5_language') }}" readonly style="background-color: #e9ecef !important">
                    </div>
                    
                    <br>
                    <hr>
                    
                    <div class="text-center">
                        <h5>{{ __('sidebar-user-index1.delete-user_language') }}</h5>
                        <h5>{{ __('sidebar-user-index1.continue_language') }}</h5>
                    </div>
                    <hr>
                    <br>
                    
                    <div class="modal-footer justify-content-between">
                        <a href="#" type="button" class="btn btn-info btn-sm text-light" data-dismiss="modal" style="font-weight:bold; font-size:15px; ">{{ __('sidebar-user-index1.cancel2_language') }}</a>
                        <a href="#" class="btn btn-sm btn-danger btn-remove-user">{{ __('sidebar-user-index1.delete_language') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
@push('scripts')
<script>
    $('.select2').select2();
    $('#user_data_table').DataTable();
    $(document).on('click', '.btn-delete-user', function(e){
        var ini = $(this),
            id = ini.data('id'),
            name = ini.data('name'),
            email = ini.data('email');
        mod = $('#removeData');
        form = $('.form-remove-data');
        form.find('input[name=name]').val(name);
        form.find('input[name=email]').val(email);
        form.find('.btn-remove-user').attr('href', '/user/remove_user/'+id);
        mod.modal('show');
    });
    var params = {}
    $(document).ready(function() {
        // initTable(params);
        
        $(document).on('change', '.select_role', function(e){
            e.preventDefault();
            var ini = $(this);
            params.id_role = ini.val();
            document.location.href='?id_role='+ini.val();
            // initTable(params);
        });
    });
    function initTable(params){
        var dataTable = $('#data_table');
        var table = dataTable.DataTable( {
            "ajax": {
                "url":"/api/user/getUsers",
                "data": params
            },
            "columns": [
                { "data": "id" },
                { "data": "name" },
                { "data": "email" },
                { "data": "role_name" },
                { "data": "departement_name" },
                { "data": "created_date" },
                { "data": "id" },
            ],
            "createdRow": function (row, data, dataIndex) {
                $(row).attr('data-id', data.id);
            },
            "columnDefs": [
                {
                    "targets" : 1,
                    "data": "id",
                    "render" : function (data, type, row) {
                       return '<a href="/user/profile?id='+row.id+'" class="user_name" data-id="'+row.id+'">'+row.name+'</a>';
                    }
                },
            ],
            "order": [[1, 'asc']],
            "destroy": true,
            "bDestroy": true,
        });
         
    }
</script>
@endpush
