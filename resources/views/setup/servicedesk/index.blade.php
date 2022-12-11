@extends('setup.servicedesk.service_desk')
@section('title', 'Instance Setting')
@section('title_menu', 'Servicedesk Configurations')
@section('service_desk_content')
<div id="menu1" class="content_header">
    <div class="title_menu">
        <a href="#" class="setting">{{ __('setup-servicedesk-index2.instance-settings_language') }}<i class="fas fa-pen" style="float: right;"></i></a>
    </div>
    <div class="content_menu">
        <div class="row">
            <div class="col-md-">
                <img src="{{url('adminlte/img/logo.png') }}" alt="AdminLTE Logo" class="brand-image">
            </div>
            <div class="col-md-11 title_name">
                <p class="judul">{{ __('setup-servicedesk-index2.pt_language') }}</p>
                <p class="judul2">{{ __('setup-servicedesk-index2.palapa_language') }}</p>
            </div>
        </div>
        <div class="body_menu">
            <div class="list_menu">
                <div class="row">
                    <div class="col-md-3">
                        <div class="row">
                            <div class="col">
                                <label class="list_name">{{ __('setup-servicedesk-index2.url-name_language') }}</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label class="list_name">{{ __('setup-servicedesk-index2.type_language') }}</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label class="list_name">{{ __('setup-servicedesk-index2.time-zone_language') }}</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label class="list_name">{{ __('setup-servicedesk-index2.owner_language') }}</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label class="list_name">{{ __('setup-servicedesk-index2.access-permissions_language') }}</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label class="list_name">{{ __('setup-servicedesk-index2.currency_language') }}</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label class="list_name">{{ __('setup-servicedesk-index2.start-day-of-the-week_language') }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col">
                                <label class="list_name2">itdesk</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label class="list_name2">IT HelpDesk</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label class="list_name2">(GMT 7:0) West Indonesia Time (Asia/Jakarta)</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label class="list_name2">lentelko.noc@gmail.com</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label class="list_name2">User with permission for this Instance</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label class="list_name2">Indonesia Rupiah</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label class="list_name2">Monday</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $('.select2').select2()
</script>
@endpush
