@extends('setup.servicedesk.service_desk')
@section('title', 'Task Type')
@section('title_menu', 'Servicedesk Configurations')
@section('service_desk_content')
@if(Session::has('message'))
<div class="alert {{Session::get('alert-class')}} alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
    {{ Session::get('message') }}
</div>
@endif
@include('sweetalert::alert')
<div id="menu3" class="content_header">
    <div class="content_menu">
        <h4 class="title_2">Task Type</h4>
        <button type="button" style="margin-bottom: 10px" class="btn btn-sm btn-primary" data-toggle="modal"
            data-target="#newSiteModal">New Task Type
        </button>
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 88px"></th>
                            <th>Type Name</th>
                            <th>Type Description</th>
                            <th>Type Status</th>
                            <th>Color</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                            <tr>
                                <td>
                                    <a href="{{ route('taskType.edit',$task->id_type)}}"><i
                                            class="fas fa-pen icon_color"></i></a>&nbsp;
                                    <button style="background-color: Transparent;background-repeat:no-repeat;border: none;  cursor:pointer;overflow: hidden;   " class="delete" data-title="{{ $task->type_name}}"
                                        href="{{ route('taskType.delete',$task->id_type)}}"><i
                                            class="fa fa-trash"></i></button>
                                    <form action="" method="post" id="deleteForm">
                                        @csrf
                                        <input type="submit" value="" style="display:none">
                                    </form>
                                </td>
                                <td class="text_name">{{ $task->type_name }}</td>
                                <td class="text_name">{{ $task->type_desc }}</td>
                                <td class="text_name">{{ $task->type_status }}</td>
                                <td>
                                    <div style="background: {{$task->color}}; width: 100px; height: 10px; border-radius: 10px;"></div>
                                </td>
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
                    <h4 class="modal-title">New Task Type</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('taskType.add') }}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="type_name" class="text_name">Type Nama</label>
                            <input name="type_name" type="text" value="{{ old('type_name') }}"
                                class="placeholder_color form-control @error('type_name') is-invalid invalid @enderror"
                                id="type_name" aria-describedby="namaHelp" placeholder="Type Name">
                            @error('type_name')
                            <span class="invalid" style="color: red"><i>{{$message}}</i></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="type_description" class="text_name">Type Description</label>
                            <input name="type_description" type="text" value="{{ old('type_description') }}"
                                class="placeholder_color form-control @error('type_description') is-invalid invalid @enderror"
                                id="type_description" aria-describedby="namaHelp" placeholder="Type Description">
                            @error('type_description')
                            <span class="invalid" style="color: red><i>{{$message}}</i></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="type_status" class="text_name">Type Status</label>
                            <input name="type_status" type="number" value="{{ old('type_status') }}"
                                class="placeholder_color form-control @error('type_status') is-invalid invalid @enderror"
                                id="type_status" aria-describedby="namaHelp" placeholder="Type status">
                            @error('type_status')
                            <span class="invalid" style="color: red><i>{{$message}}</i></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="color" class="text_name">Color</label>
                            <input name="color" type="text" value="{{ old('color') }}"
                                class="placeholder_color form-control @error('color') is-invalid invalid @enderror"
                                id="color" aria-describedby="namaHelp" placeholder="Type status">
                            @error('color')
                            <span class="invalid" style="color: red><i>{{$message}}</i></span>
                            @enderror
                        </div>
                        <div class=" modal-footer justify-content-start">
                                <button type="submit" class="btn btn-primary" style="width: 70px;">Create</button>
                                <button type="reset" class="btn btn-default"
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
    </script>

@endpush
