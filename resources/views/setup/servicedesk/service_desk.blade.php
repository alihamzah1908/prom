@extends('setup.template.default')
@section('navbar')
<?php 
$nav = getServiceDeskNav();
?>
<nav class="main-header navbar navbar-expand navbar-white navbar-light" style="padding: 0px !important; overflow-x:auto">
    <ul class="navbar-nav menu_servicedesk">
        @foreach($nav as $key => $val)
        <?php $url = "/setup/servicedesk".$val['url']  ?>
        <li class="nav-item">
            <a href="{{$url}}"
                class="{{ '/'.request()->path() == $url ? 'bg-primary' : '' }} nav-link text-header1">{{$val['name']}}</a>
        </li>
        @endforeach
    </ul>
</nav>
@endsection
@section('content')

    @yield('service_desk_content')
    
@endsection