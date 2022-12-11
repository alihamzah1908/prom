@extends('setup.template.default')
@section('title_menu', 'User & Permissions')
@section('navbar')
<?php 
$nav = getUserPermissionsNav();
?>
<nav class="main-header navbar navbar-expand navbar-white navbar-light" style="padding: 0px !important; overflow-x:auto">
    <ul class="navbar-nav menu_servicedesk">
        @foreach($nav as $key => $val)
        <?php
        $current_path = '?view='.request()->view;
        $url = "/setup/userpermission".$val['url'];  ?>
        <li class="nav-item">
            <a href="{{$url}}"
                class="{{ $current_path == $val['url'] ? 'bg-primary' : '' }} nav-link text-header1">{{$val['name']}}</a>
        </li>
        @endforeach
    </ul>
</nav>
@endsection
@section('content')
@if(Session::has('message'))
<div class="alert {{Session::get('alert-class')}} alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
    {{ Session::get('message') }}
</div>
@endif

@include($include)

@endsection
@push('scripts')
<script>
    $('.select2').select2()
</script>
@endpush
