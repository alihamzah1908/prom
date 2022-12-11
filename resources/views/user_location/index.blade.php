@extends('template.default')
@section('title', 'GPS')
@section('submenu')

@endsection
@section('content')
@if(Session::has('message'))
    <div class="alert {{Session::get('alert-class')}} alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        {{ Session::get('message') }}
    </div>
@endif

<script src='https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.css' rel='stylesheet' />
<style>
    .mapboxgl-popup{
        max-width:700px !important;
    }
    table.dataTable tbody th, table.dataTable tbody td {
    padding: 0px 0px !important;
    padding-top: 0px !important;
    padding-bottom: 0px !important;
    }
    .container-fluid {
    width: 100%;
    padding-right: 0px;
    padding-left: 0px;
    margin-right: auto;
    margin-left: auto;
    }
    .content-wrapper>.content {
    padding: 0rem;
    }
    .card-header {
    background-color: transparent;
    border-bottom: 0px /*solid rgba(0, 0, 0, .125) */;
    padding: .3rem 1.25rem 0rem 1.25rem;
    position: relative;
    border-top-left-radius: .25rem;
    border-top-right-radius: .25rem;
    }
    .card-title {
    margin-bottom: 1rem;
    }
    .card-body {
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    padding: 0rem 1.25rem 1.25rem 1.25rem;
    }
</style>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"> <strong>{{ __('sidebar-gps-index1.gps_language') }}</strong></h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3 form-group">
                <select class="form-control select2 btn-default select_site" style="width: 100%;">
                    <option selected="selected" disabled value="">-- {{ __('sidebar-gps-index1.select-site_language') }} --</option>
                    @foreach(\App\Model\Site::get() as $site)
                        <option value="{{$site->site_id}}">{{$site->name_site}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 form-group">
                <select class="form-control btn-default select_type" style="width: 100%;" onchange="document.location.href='?view='+this.value">
                    <option value="LIST">-- {{ __('sidebar-gps-index1.list_language') }} --</option>
                    <option value="MAP" {{request()->view == "MAP" ? 'selected':''}}>-- {{ __('sidebar-gps-index1.map_language') }} --</option>
                </select>
            </div>
            
            <div class="col-md-2 form-group"></div>
            @if(request()->view == "MAP")
            <div class="col-md-2 form-group"></div>
            @endif
            <div class="col-md-2 form-group">
                <button type="button" class="form-control btn-default btn-refresh" style="color: #828282">
                    <i class="fas fa-redo-alt"></i>&nbsp;&nbsp; {{ __('sidebar-gps-index1.refresh_language') }}
                </button>
            </div>
            @if(request()->view != "MAP")
            <div class="col-md-2 form-group">
                <span class="icon"><i class="fas fa-search"></i></span>
                <input class="form-control btn-default" id="search" type="text" placeholder="{{ __('sidebar-gps-index1.search_language') }}" aria-label="Search">
            </div>
            @endif
        </div>
        <div class="gps_view">
            @if(request()->view == "MAP")
            <div id='map' style='width: 100%; height: 500px;'></div>
            @else
            <table id="data_table" class="display table table-striped table-border-gray" style="width:100%">
                <thead>
                    <tr>
                        <th style="width: 10px">{{ __('sidebar-gps-index1.id_language') }}</th>
                        <th>{{ __('sidebar-gps-index1.technician_language') }}</th>
                        <th>{{ __('sidebar-gps-index1.site_language') }}</th>
                        <th>{{ __('sidebar-gps-index1.latitude_language') }}</th>
                        <th>{{ __('sidebar-gps-index1.longitude_language') }}</th>
                        <th>{{ __('sidebar-gps-index1.last-update_language') }}</th>
                    </tr>
                </thead>
            </table>
            @endif
        </div>
    </div>
</div>
@if(request()->view == "MAP")
<script src='/mapbox/mapbox.js?v={{date("Y-m-d H:i:s")}}'></script>
@else
<script src='/js/location.js?v={{date("Y-m-d H:i:s")}}'></script>
@endif
@endsection
