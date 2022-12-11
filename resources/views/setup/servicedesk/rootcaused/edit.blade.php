@extends('setup.template.default')
@section('title', 'Root caused')
@section('title_menu', 'Servicedesk Configurations')
@section('header-title', 'Root caused')
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
            <a href="{{ route('region') }}"
                class="{{  request()->is('setup/servicedesk/region') ? 'active' : '' }} nav-link text-header1">Region</a>
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
@if(Session::has('message'))
<div class="alert {{Session::get('alert-class')}} alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
    {{ Session::get('message') }}
</div>
@endif
    <div class="content_header">
        <div class="content_menu">
            <h4 class="title_2">Asset Edit</h4>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Asset Form</h3>
                </div>
                <form action="{{ route('rootcaused.update', $rootcaused->id_caused) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama_rootcaused">Name</label>
                            <input name="nama_rootcaused" type="text" value="{{ $rootcaused->name_caused }}" class="form-control" id="nama_rootcaused">
                            @error('nama_rootcaused')
                            <span class="invalid"><i>{{$message}}</i></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input name="description" type="text" value="{{ $rootcaused->desc_caused }}" class="form-control" id="description">
                            @error('description')
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
