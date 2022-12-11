@extends('setup.template.default')
@section('title', 'Site')
@section('title_menu', 'Servicedesk Configurations')
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
            <a href="{{ route('sites') }}"
                class="{{  request()->is('setup//servicedesk/site') ? 'active' : '' }} nav-link text-header1">Sites</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('approver') }}"
                class="{{  request()->is('setup/servicedesk/approver') ? 'active' : '' }} nav-link text-header1">Approver</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('taskType') }}"
                class="{{  request()->is('setup/servicedesk/task_type') ? 'active' : '' }} nav-link text-header1">Task Type</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('segment') }}"
                class="{{  request()->is('setup/servicedesk/segment') ? 'active' : '' }} nav-link text-header1">Segment</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('asset') }}"
                class="{{  request()->is('setup/servicedesk/asset') ? 'active' : '' }} nav-link text-header1">Asset</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('rootcaused') }}"
                class="{{  request()->is('setup/servicedesk/rootcaused') ? 'active' : '' }} nav-link text-header1">rootcaused</a>
        </li>

    </ul>
</nav>
@endsection
@section('content')
@include('sweetalert::alert')
<div id="menu3" class="content_header">
    <div class="content_menu">
        <h4 class="title_2">Site</h4>
        <button type="button" style="margin-bottom: 10px" class="btn btn-sm btn-primary" data-toggle="modal"
            data-target="#newSiteModal">New Site
        </button>
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 88px"></th>
                            <th>Site Name</th>
                            <th>Region Name</th>
                            <th>Site Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sites as $site)
                            <tr>
                                <td>
                                    <a href="{{ route('sites.edit',$site->site_id)}}"><i
                                            class="fas fa-pen icon_color"></i></a>&nbsp;
                                    <button style="background-color: Transparent;background-repeat:no-repeat;border: none;  cursor:pointer;overflow: hidden;   " class="delete" data-title="{{ $site->name_site}}"
                                        href="{{ route('sites.delete',$site->site_id)}}"><i
                                            class="fa fa-trash"></i></button>
                                    <form action="" method="post" id="deleteForm">
                                        @csrf
                                        <input type="submit" value="" style="display:none">
                                    </form>
                                </td>
                                <td class="text_name">{{ $site->name_site }}</td>
                                <td class="text_name">{{ $site->region->region_name }}</td>
                                <td class="text_name">{{ $site->site_desc }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <div class="modal fade" id="newSiteModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Site</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('sites.add') }}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="name_site" class="text_name">Site Nama</label>
                            <input name="name_site" type="text" value="{{ old('name_site') }}"
                                class="placeholder_color form-control @error('name_site') is-invalid invalid @enderror"
                                id="name_site" aria-describedby="namaHelp" placeholder="Name">
                            @error('name_site')
                            <span class="invalid" style="color: red"><i>{{$message}}</i></span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="region_name" class="text_name form-control-label">Region Name</label>
                            <select class="form-control searchRegion select2" id="region_name"  name="region_name"></select>
                            <p class="text-danger">{{ $errors->first('participant_id') }}</p>
                        </div>
                        <div class="form-group">
                            <label for="site_cat_name" class="text_name form-control-label">Site Category Name</label>
                            <select class="form-control select2" id="searchCatSite" name="site_cat_name">
                            </select>
                            <p class="text-danger">{{ $errors->first('site_cat_name') }}</p>
                        </div>
                        <div class="form-group">
                            <label for="head_manager" class="text_name">Head Manager</label>
                            <input name="head_manager" type="number" value="{{ old('head_manager') }}"
                                class="placeholder_color form-control @error('head_manager') is-invalid invalid @enderror" id="head_manager"
                                aria-describedby="namaHelp" placeholder="Head Manager">
                            @error('head_manager')
                            <span class="invalid"><i>{{$message}}</i></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea name="address" class="form-control @error('address') is-invalid invalid @enderror" id="address" rows="3" placeholder="Place your Addres">{{ old('address') }}</textarea>
                            @error('address')
                            <span class="invalid">{{ $errors->first('address') }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control @error('description') is-invalid invalid @enderror" id="address" rows="3" placeholder="Place your description">{{ old('description') }}</textarea>
                            @error('description')
                            <span class="invalid">{{ $errors->first('description') }}</span>
                            @enderror
                        </div>
                        <div class="modal-footer justify-content-start">
                            <button type="submit" class="btn btn-primary" style="width: 70px;">Save</button>
                            <button type="submit" class="btn btn-default" style="color: #fff; background: #CECECE">Cancle</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
    $('button.delete').on('click', function () {
        var href = $(this).attr('href');
        var title = $(this).data('title')
        swal({
                title: "Are you sure delete " + title + "?",
                text: "This record and it`s details will be permanantly deleted!",
                icon: "warning",
                buttons: ["Cancel", "Yes!"],
            })
            .then((willDelete) => {
                if (willDelete) {
                    document.getElementById('deleteForm').action = href;
                    document.getElementById('deleteForm').submit();
                    swal("Data Berhasil Dihapus", {
                        icon: "success",
                    });
                }
            });
    });

    $(".searchRegion").select2({
        placeholder:"Place your region name",
        ajax: {
            url: "/getRegion",
            dataType: "json",
            delay: 150,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                            item_text =  item.region_name;
                            return {
                                text: item_text,
                                id: item.region_id
                            };
                    })
                };
            },
            cache: false
        }
    }).on('change', function (e) {

    });
    </script>
    <script>
    $("#searchCatSite").select2({
        placeholder:"Place your category name",
        ajax: {
            url: "/getSiteCat",
            dataType: "json",
            delay: 150,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                            item_text =  item.site_cat_name;
                            return {
                                text: item_text,
                                id: item.site_cat_id
                            };
                    })
                };
            },
            cache: false
        }
    }).on('change', function (e) {

    });
    </script>

@endpush
