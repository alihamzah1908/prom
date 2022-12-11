@extends('setup.template.default')
@section('title_menu', 'Data Administration')
@section('navbar')
<nav class="main-header navbar navbar-expand navbar-white navbar-light" style="padding: 0px !important">
    <ul class="navbar-nav menu_servicedesk">
        <li class="nav-item">
            <a href="{{ route('archive') }}" class="{{  request()->is('setup/servicedesk/data-administration/data-archive') ? 'active' : '' }} nav-link text-header">Data archive</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('systemLog') }}" class="{{  request()->is('setup/servicedesk/data-administration/system-log') ? 'active' : '' }} nav-link text-header">System Log</a>
        </li>
    </ul>
</nav>
@endsection
@section('content')
<div id="menu2" class="content_header">
    <div class="content_menu">
        <h4 class="title_2">System Log</h4>
        <a href="#" style="margin-bottom: 10px; width: 70px;" class="btn btn-sm btn-primary" data-toggle="modal"
            data-target="#adminModal">Export
        </a>
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 50px"></th>
                            <th>System Log Message </th>
                            <th>Module</th>
                            <th>Sub Module</th>
                            <th>Action</th>
                            <th>Type</th>
                            <th>Time of Ocuurence</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <a href="#"><i class="fas fa-trash icon_color"></i></a>
                            </td>
                            <td class="text_name">
                                System trying to delete the...
                            </td>
                            <td class="text_name">
                                Admin
                            </td>
                            <td class="text_name">
                                Export
                            </td>
                            <td class="text_name">
                                Update
                            </td>
                            <td class="text_name">
                                Info
                            </td>
                            <td class="text_name">
                                Sept 2, 2020 11:08
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <div class="modal fade" id="adminModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Admin</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="nama" class="text_name">Nama</label>
                            <input name="nama_program" type="text" value=""
                                class="placeholder_color form-control @error('nama_program') is-invalid invalid @enderror"
                                id="nama" aria-describedby="namaHelp" placeholder="Name">
                            @error('nama_program')
                            <span class="invalid"><i>{{$message}}</i></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description" class="text_name">Description</label>
                            <input name="description" type="text" value=""
                                class="placeholder_color form-control @error('description') is-invalid invalid @enderror"
                                id="description" aria-describedby="namaHelp" placeholder="Description">
                            @error('description')
                            <span class="invalid"><i>{{$message}}</i></span>
                            @enderror
                        </div>
                        <div class="modal-footer justify-content-start">
                            <button type="button" class="btn btn-primary" style="width: 70px;">Save</button>
                            <button type="button" class="btn btn-default"
                                style="color: #fff; background: #CECECE">Cancle</button>
                        </div>
                    </form>
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
