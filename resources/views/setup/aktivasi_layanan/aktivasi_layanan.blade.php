@extends('setup.template.default')
@section('title_menu', __('setup-customization-activation_services-index.title_language'))

@section('navbar')
<nav class="main-header navbar navbar-expand navbar-white navbar-light" style="padding: 0px !important; overflow-x:auto">
    <ul class="navbar-nav menu_servicedesk">
        <li class="nav-item">
            <a href="/setup/aktivasi_layanan/cord" 
                class="{{ '/'.request()->path() == '/setup/aktivasi_layanan/cord' ? 'bg-primary' : '' }} nav-link text-header1">{{ __('setup-customization-activation_services-index.cord_language') }}</a>
        </li>
        <li class="nav-item">
            <a href="/setup/aktivasi_layanan/cid" 
                class="{{ '/'.request()->path() == '/setup/aktivasi_layanan/cid' ? 'bg-primary' : '' }} nav-link text-header1">{{ __('setup-customization-activation_services-index.cid_language') }}</a>
        </li>
        <li class="nav-item">
            <a href="/setup/aktivasi_layanan/slot" 
                class="{{ '/'.request()->path() == '/setup/aktivasi_layanan/slot' ? 'bg-primary' : '' }} nav-link text-header1">{{ __('setup-customization-activation_services-index.slot_language') }}</a>
        </li>
        <li class="nav-item">
            <a href="/setup/aktivasi_layanan/shelf" 
                class="{{ '/'.request()->path() == '/setup/aktivasi_layanan/shelf' ? 'bg-primary' : '' }} nav-link text-header1">{{ __('setup-customization-activation_services-index.shelf_language') }}</a>
        </li>
        <li class="nav-item">
            <a href="/setup/aktivasi_layanan/status" 
                class="{{ '/'.request()->path() == '/setup/aktivasi_layanan/status' ? 'bg-primary' : '' }} nav-link text-header1">{{ __('setup-customization-activation_services-index.service-status_language') }}</a>
        </li>
        <li class="nav-item">
            <a href="/setup/aktivasi_layanan/status_collocation" 
                class="{{ '/'.request()->path() == '/setup/aktivasi_layanan/status_collocation' ? 'bg-primary' : '' }} nav-link text-header1">{{ __('setup-customization-activation_services-index.status-collocation_language') }}</a>
        </li>
         <li class="nav-item">
            <a href="/setup/aktivasi_layanan/layanan" 
                class="{{ '/'.request()->path() == '/setup/aktivasi_layanan/layanan' ? 'bg-primary' : '' }} nav-link text-header1">{{ __('setup-customization-activation_services-index.services_language') }}</a>
        </li>
        <li class="nav-item">
            <a href="/setup/aktivasi_layanan/totalcapacity" 
                class="{{ '/'.request()->path() == '/setup/aktivasi_layanan/totalcapacity' ? 'bg-primary' : '' }} nav-link text-header1">{{ __('setup-customization-activation_services-index.total-capacity_language') }}</a>
        </li>
    </ul>
</nav>
@endsection
@section('content')

    @yield('aktivasi_layanan_content')
    
@endsection