@extends('setup.template.default')
@section('title_menu', 'Data Administration')
@section('navbar')
<nav class="main-header navbar navbar-expand navbar-white navbar-light" style="padding: 0px !important">
    <ul class="navbar-nav menu_servicedesk">
        <li class="nav-item">
            <a href="{{ route('archive') }}" class="{{  request()->is('setup/servicedesk/data-administration/data-archive') ? 'active' : '' }} nav-link text-header">Data archive</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('systemLog') }}" class="{{  request()->is('setup/servicedesk/data-administration/system-log') ? 'active' : '' }} nav-link text-header">System Log</a>
        </li>
    </ul>
</nav>
@endsection
@section('content')
<div id="menu1"  class="content_header">
    <div class="content_menu">
        <h4 class="title_2">Notif Service Settings</h4>
        <p class="sub_title">Archive requests matching the following rules:</p>
        <form action="#" method="POST" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="text_name form-control-label">Request Status is</label>
                        <select class="form-control select2" name="username">
                            <option selected="selected">Username</option>
                            <option>Alaska</option>
                            <option>California</option>
                            <option>Delaware</option>
                            <option>Tennessee</option>
                            <option>Texas</option>
                            <option>Washington</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="text_name form-control-label">AND</label>
                        <select class="form-control select2" name="username">
                            <option selected="selected">Username</option>
                            <option>Alaska</option>
                            <option>California</option>
                            <option>Delaware</option>
                            <option>Tennessee</option>
                            <option>Texas</option>
                            <option>Washington</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="text_name form-control-label">Is Before</label>
                        <select class="form-control select2" name="username">
                            <option selected="selected">Username</option>
                            <option>Alaska</option>
                            <option>California</option>
                            <option>Delaware</option>
                            <option>Tennessee</option>
                            <option>Texas</option>
                            <option>Washington</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" style="margin-top: 4px;" id="exampleCheck1">
                <label class=" text_name" for="exampleCheck1">Allow Exception</label>
            </div>
            <p class="sub_title">Request mathching following rules, will not be archives</p>
            <div class="modal-footer justify-content-start">
                <button type="button" class="btn btn-primary" style="width: 70px;">Save</button>
                <input type="reset" class="btn btn-danger" style="width: 70px;" value="Reset">
            </div>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $('.select2').select2()
</script>
@endpush
