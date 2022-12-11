@extends('setup.template.default')
@section('title_menu', 'Notif Settings')
@section('navbar')
<nav class="main-header navbar navbar-expand navbar-white navbar-light" style="padding: 0px !important">
    <ul class="navbar-nav menu_servicedesk">
        {{-- <li class="nav-item">
            <a href="#" class="nav-link">PALAPA RING OPERATION & MAINTENEANCE</a>
        </li> --}}
        <li class="nav-item">
            <a href="#menu1" class="nav-link text-header active">Mail Server Setting</a>
        </li>
    </ul>
</nav>
@endsection
@section('content')
<div class="content_menu">
    <h4 class="title_2">Notif Service Settings</h4>
    <div class="row">
        <div class="col-md-5">
            <form action="#" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="nama" class="text_name">Server Name</label>
                    <input name="nama_program" type="text" value=""
                        class="placeholder_color form-control @error('nama_program') is-invalid invalid @enderror" id="nama"
                        aria-describedby="namaHelp" placeholder="Server Name">
                    @error('nama_program')
                    <span class="invalid"><i>{{$message}}</i></span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="text_name form-control-label">Username</label>
                    <select class="form-control select2" name="username">
                        <option selected="selected">Username</option>
                        <option>Alaska</option>
                        <option>California</option>
                        <option>Delaware</option>
                        <option>Tennessee</option>
                        <option>Texas</option>
                        <option>Washington</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="password" class="text_name">Password</label>
                    <input name="password" type="password" value=""
                        class="placeholder_color form-control @error('password') is-invalid invalid @enderror" id="password"
                        aria-describedby="namaHelp" placeholder="password">
                    @error('password')
                    <span class="invalid"><i>{{$message}}</i></span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email" class="text_name">Email Address</label>
                    <input name="email" type="email" value=""
                        class="placeholder_color form-control @error('email') is-invalid invalid @enderror" id="email"
                        aria-describedby="namaHelp" placeholder="Email Address">
                    @error('email')
                    <span class="invalid"><i>{{$message}}</i></span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="text_name form-control-label">Email Type</label>
                    <select class="form-control select2" name="email_type">
                        <option selected="selected">-- Select --</option>
                        <option>Alaska</option>
                        <option>California</option>
                        <option>Delaware</option>
                        <option>Tennessee</option>
                        <option>Texas</option>
                        <option>Washington</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="segment" class="text_name form-control-label">Fetc Email Every</label>
                    <select class="form-control select2">
                        <option selected="selected">5 Minutes</option>
                        <option>Alaska</option>
                        <option>California</option>
                        <option>Delaware</option>
                        <option>Tennessee</option>
                        <option>Texas</option>
                        <option>Washington</option>
                    </select>
                </div>
                <div class="modal-footer justify-content-start">
                    <button type="button" class="btn btn-primary" style="width: 70px;">Save</button>
                </div>
            </form>
        </div>
        <div class="col-md-7"></div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $('.select2').select2()
</script>
@endpush
