@extends('setup.template.default')
@section('title', 'Sites ')
@section('header-title', 'Sites')
@section('title_menu', 'Servicedesk Configurations')
@section('navbar')
<nav class="main-header navbar navbar-expand navbar-white navbar-light" style="padding: 0px !important">
    <ul class="navbar-nav menu_servicedesk">
        <li class="nav-item">
            <a href="{{ route('servicedesk') }}"
                class="{{  request()->is('setup/servicedesk') ? 'active' : '' }} nav-link text-header">Instance Setting</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('region') }}"
                class="{{  request()->is('setup/servicedesk/region') ? 'active' : '' }} nav-link text-header1">Region</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('sites') }}"
                class="{{  request()->is('setup//servicedesk/site') ? 'active' : '' }} nav-link text-header1">Sites</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('approver') }}"
                class="{{  request()->is('setup/servicedesk/approver') ? 'active' : '' }} nav-link text-header1">Approver</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('taskType') }}"
                class="{{  request()->is('setup/servicedesk/task_type') ? 'active' : '' }} nav-link text-header1">Task Type</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('segment') }}"
                class="{{  request()->is('setup/servicedesk/segment') ? 'active' : '' }} nav-link text-header1">Segment</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('rootcaused') }}"
                class="{{  request()->is('setup/servicedesk/rootcaused') ? 'active' : '' }} nav-link text-header1">rootcaused</a>
        </li>
        <!--<li class="nav-item">-->
        <!--    <a href="{{ route('status') }}" class="nav-link text-header1 {{  request()->is('setup/servicedesk/status') ? 'active' : '' }}">Status</a>-->
        <!--</li>-->
    </ul>
</nav>
@endsection
@include('sweetalert::alert')
@section('content')
@if(Session::has('message'))
<div class="alert {{Session::get('alert-class')}} alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
    {{ Session::get('message') }}
</div>
@endif
    <div class="content_header">
        <div class="content_menu">
            <h4 class="title_2">Task Type Edit</h4>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Task Type Form</h3>
                </div>
                <form action="{{ route('taskType.update', $task->id_type) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="type_name" class="text_name">Type Nama</label>
                            <input name="type_name" type="text" value="{{ $task->type_name }}"
                                class="placeholder_color form-control @error('type_name') is-invalid invalid @enderror"
                                id="type_name" aria-describedby="namaHelp" placeholder="Type Name">
                            @error('type_name')
                            <span class="invalid" style="color: red"><i>{{$message}}</i></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="type_description" class="text_name">Type Description</label>
                            <input name="type_description" type="text" value="{{ $task->type_desc }}"
                                class="placeholder_color form-control @error('type_description') is-invalid invalid @enderror"
                                id="type_description" aria-describedby="namaHelp" placeholder="Type Description">
                            @error('type_description')
                            <span class="invalid" style="color: red><i>{{$message}}</i></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="type_status" class="text_name">Type Status</label>
                            <input name="type_status" type="number" value="{{ $task->type_status }}"
                                class="placeholder_color form-control @error('type_status') is-invalid invalid @enderror"
                                id="type_status" aria-describedby="namaHelp" placeholder="Type status">
                            @error('type_status')
                            <span class="invalid" style="color: red><i>{{$message}}</i></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="color" class="text_name">Color</label>
                            <input name="color" type="text" value="{{ $task->color }}"
                                class="placeholder_color form-control @error('color') is-invalid invalid @enderror"
                                id="color" aria-describedby="namaHelp" placeholder="Type status">
                            @error('color')
                            <span class="invalid" style="color: red><i>{{$message}}</i></span>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer" style="margin-bottom: -15px;">
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
    $('.select2').select2()
</script>
@endpush
