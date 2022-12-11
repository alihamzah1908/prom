@extends('template.default')
@section('title', 'Profile')
@section('submenu')
<div class="row mb-2">
    <div class="col-sm-6">
        <h3 class="m-0 text-dark"><strong>Profile</strong></h3>
        <small>User > Profile</small>
    </div>
</div>
@endsection
@section('content')
@if(Session::has('message'))
    <div class="alert {{Session::get('alert-class')}} alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        {{ Session::get('message') }}
    </div>
@endif
<div class="card">
    <div class="card-header">
        <h3 class="card-title"> <strong>Profile</strong></h3>
    </div>
    <form method="POST" action="/user/update_profile/{{$user->id}}" class="form-new-data">
    @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="User One" value="{{$user->name}}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="{{$user->email}}" disabled style="background-color: #e9ecef !important">
                    </div>
                    <div class="form-group">
                        <label for="email">Telephone</label>
                        <input type="number" class="form-control" name="telpone" placeholder="Telephone" required autofocus value="{{$user->telpone}}">
                    </div>
                    <div class="form-group">
                        <label for="email">Mobile</label><small>(Optional)</small>
                        <input type="number" class="form-control" name="mobile" placeholder="Mobile" value="{{$user->mobile}}">
                    </div>
                    <div class="form-group">
                        <label for="departemen">Departemen</label>
                        <select class="form-control select2" style="width: 100%;" name="departement_id" required autofocus>
                            <option selected="selected" value="" disabled>Departement</option>
                            @foreach(\App\Model\Departement::get() as $d)
                            <option value="{{$d->id_departement}}" {{$user->departement_id == $d->id_departement ? 'selected':''}}>{{$d->name_departement}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="email">Role</label>
                        <select class="form-control select2" style="width: 100%; background-color: #e9ecef !important" name="role_id" required autofocus>
                            @foreach(\App\Model\Roles::get() as $role)
                            <option value="{{$role->id_role}}" {{$user->role_id == $role->id_role ? 'selected':''}}>{{$role->role_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label> <small>(Leave empty if you dont wish to change your password)</small>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label for="password_confirm">Password Confirm</label>
                        <input type="password" class="form-control" name="password_confirm" id="password_confirm" placeholder="Password Confirm">
                    </div>
                </div>
                <div class="col-md-1"></div>
            </div>
        </div>
        <div class="card-footer" style="    background-color: #fff;">
            @if(is_admin(Auth::user()))
            <button type="submit" class="btn btn-primary btn-md  float-right mr-3">Submit</button>
            @endif
            <a href="/user" class="btn btn-md btn-default mr-3 ml-3" style="color: #ffff; background-color: #CECECE">Back</a>
        </div>
    </form>
</div>
@endsection
@push('scripts')
<script>
    $('.select2').select2();

</script>
@endpush
