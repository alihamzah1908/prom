@extends('setup.template.default')
@section('title_menu', 'Chat')
@section('navbar')
<nav class="main-header navbar navbar-expand navbar-white navbar-light" style="padding: 0px !important">
    <ul class="navbar-nav menu_servicedesk">
        {{-- <li class="nav-item">
            <a href="#" class="nav-link">PALAPA RING OPERATION & MAINTENEANCE</a>
        </li> --}}
        <li class="nav-item">
            <a href="#menu1" class="nav-link text-header active">Chat</a>
        </li>
    </ul>
</nav>
@endsection
@section('content')
<div class="content_menu">
    <h4 class="title_2">Chat</h4>
    <div class="card">
        <!-- /.card-header -->
        <div class="card-body p-0">
            <table class="table">
                <thead>
                    <tr>
                        <th class="title-head">Medium</th>
                        <th class="title-head" style="width: 200px">Statu</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <small class="user_small">Web Chat</small>
                        </td>
                        <td>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="customSwitch1">
                                <label class="custom-control-label" for="customSwitch1"></label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <small class="user_small">Mobile Chat</small>
                        </td>
                        <td>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="customSwitch2">
                                <label class="custom-control-label" for="customSwitch2"></label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <small class="user_small">Voice</small>
                        </td>
                        <td>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="customSwitch3">
                                <label class="custom-control-label" for="customSwitch3"></label>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
</div>
@endsection
@push('scripts')
<script>
    $('.select2').select2()
</script>
@endpush
