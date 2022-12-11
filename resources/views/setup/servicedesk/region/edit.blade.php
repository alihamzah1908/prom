@extends('setup.template.default')
@section('title', 'Region')
@section('title_menu', 'Servicedesk Configurations')
@section('header-title', 'Region')
@section('navbar')
<nav class="main-header navbar navbar-expand navbar-white navbar-light" style="padding: 0px !important">
    <ul class="navbar-nav menu_servicedesk">
        <li class="nav-item">
            <a href="{{ route('servicedesk') }}"
                class="{{  request()->is('setup/servicedesk') ? 'active' : '' }} nav-link text-header">Instance Setting</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('region') }}"
                class="{{  request()->is('setup/servicedesk/region') ? 'active' : '' }} nav-link text-header1">region</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('sites') }}"
                class="{{  request()->is('setup//servicedesk/site') ? 'active' : '' }} nav-link text-header1">Sites</a>
        </li>
        
       
        <li class="nav-item">
            <a href="{{ route('rootcaused') }}"
                class="{{  request()->is('setup/servicedesk/rootcaused') ? 'active' : '' }} nav-link text-header1">rootcaused</a>
        </li>
       

    </ul>
</nav>
@endsection
@include('sweetalert::alert')
@section('content')
    <div class="content_header">
        <div class="content_menu">
            <h4 class="title_2">Region Edit</h4>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Region Form</h3>
                </div>
                <form action="{{ route('region.update', $region->region_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama_region">Region Name</label>
                            <input name="nama_region" type="text" value="{{ $region->region_name }}" class="form-control" id="nama_region" placeholder="Place your region name">
                            @error('nama_region')
                            <span class="invalid"><i>{{$message}}</i></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input name="description" type="text" value="{{ $region->region_desc }}" class="form-control" id="description" placeholder="Place your description">
                            @error('description')
                            <span class="invalid"><i>{{$message}}</i></span>
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
