@extends('setup.template.default')
@section('title', 'Segment')
@section('title_menu', 'Servicedesk Configurations')
@section('header-title', 'Segment')
@section('navbar')
<nav class="main-header navbar navbar-expand navbar-white navbar-light" style="padding: 0px !important">
    <ul class="navbar-nav menu_servicedesk">
        <li class="nav-item">
            <a href="{{ route('servicedesk') }}"
                class="{{  request()->is('setup/servicedesk') ? 'active' : '' }} nav-link text-header">Instance Setting</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('asset') }}"
                class="{{  request()->is('setup/servicedesk/asset') ? 'active' : '' }} nav-link text-header1">asset</a>
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
        <li class="nav-item">
            <a href="{{ route('status') }}" class="nav-link text-header1 {{  request()->is('setup/servicedesk/status') ? 'active' : '' }}">Status</a>
        </li>
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
            <h4 class="title_2">Segment Edit</h4>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Segment Form</h3>
                </div>
                <form action="{{ route('segment.update', $segment->id_segment) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="segment_name">Segment Name</label>
                            <input name="segment_name" type="text" value="{{ $segment->segment_name }}" class="form-control" id="segment_name">
                            @error('segment_name')
                            <span class="invalid"><i>{{$message}}</i></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="segment_desc">Segment Description</label>
                            <input name="segment_desc" type="text" value="{{ $segment->segment_desc }}" class="form-control" id="segment_desc">
                            @error('segment_desc')
                            <span class="invalid"><i>{{$message}}</i></span>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer" style="margin-bottom: -15px;">
                        <button type="submit" class="btn btn-success float-right">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
