@extends('setup.template.default')
@section('title_menu', 'User & Permissions')
@section('navbar')

@endsection
@section('content')
<div id="detail_role" class="content_header">
    <div class="content_menu">
        <form role="form" action="/setup/userpermission/role/{{$role->id_role}}/update_access" method="POST" enctype="multipart/form-data">
        {{csrf_field()}}
        <h4 class="title_2">{{ __('setup-userpermission-role-new_role.roles_language') }}</h4>
        <div class="row">
            <div class="col-md-6">
                <label class="user_small">{{ __('setup-userpermission-role-new_role.role-name_language') }}</label>
                <input class="form-control" required autofocus value="{{$role->role_name}}" placeholder="{{ __('setup-userpermission-role-new_role.role-name2_language') }}" name="role_name">
                <br>
                @if(is_admin(Auth::user()))
                <div class="form-group">
                  <label>
                    <input type="checkbox" class="minimal" name="is_admin" {{$role->is_admin == "YES" ? 'checked':''}}>
                    {{ __('setup-userpermission-role-new_role.as-admin_language') }}
                  </label>
                </div>
                @endif
            </div>
        </div>
        
        <!--<h5 class="judul2">{{$role->role_name}}</h5>-->
        <h4 class="title_2">{{ __('setup-userpermission-role-new_role.access_language') }}</h4>
        <div class="row">
            @foreach(\App\Model\Routes::where('id_parent', null)->get() as $route)
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{$route->name}}</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="web_access[]" value="{{$route->id_route}}" 
                                    {{ in_array($route->route, json_decode($role->web_access)) ? 'checked' : '' }}
                                    >
                                <label class="form-check-label">{{$route->name}}</label>
                            </div>
                            @foreach(\App\Model\Routes::where('id_parent', $route->id_route)->get() as $sub_route)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="web_access[]" value="{{$sub_route->id_route}}" 
                                    {{ in_array($sub_route->route, json_decode($role->web_access)) ? 'checked' : '' }}
                                    >
                                <label class="form-check-label">{{$sub_route->name}}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="card-footer bg-white" style="position:fixed; bottom:0px; right:0px; width:100%">
            <button type="submit" class="btn btn-primary btn-md float-right">{{ __('setup-userpermission-role-new_role.submit_language') }}</button>
            <a href="/setup/userpermission" class="btn btn-md btn-default float-right mr-2">{{ __('setup-userpermission-role-new_role.back_language') }}</a>
        </div>
        </form>
    </div>
</div>
@endsection
