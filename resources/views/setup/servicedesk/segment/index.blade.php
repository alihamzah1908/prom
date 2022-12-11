@extends('setup.servicedesk.service_desk')
@section('title_menu', 'Servicedesk Configurations')
@section('title', 'Segment')
@section('service_desk_content')
@include('sweetalert::alert')
<div class="content_header">
    <div class="content_menu">
        <h4 class="title_2">Segment</h4>
        <button type="button" style="margin-bottom: 10px" class="btn btn-sm btn-primary" data-toggle="modal"
            data-target="#segmentModal">New Segment
        </button>
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 87px"></th>
                            <th>Segment Name</th>
                            <th>Segment Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($segments as $segment)
                        <tr>
                            <td>
                                <a href="{{ route('segment.edit',$segment->id_segment)}}"><i
                                        class="fas fa-pen icon_color"></i></a>&nbsp;
                                <button style="background-color: Transparent;background-repeat:no-repeat;border: none;cursor:pointer;overflow: hidden;   " id="delete" data-title="{{ $segment->segment_name}}"
                                    href="{{ route('segment.delete',$segment->id_segment)}}"><i
                                        class="fa fa-trash"></i></button>
                                <form action="" method="post" id="deleteForm">
                                    @csrf
                                    <input type="submit" value="" style="display:none">
                                </form>
                            </td>
                            <td class="text_name">{{ $segment->segment_name }}</td>
                            <td class="text_name">{{ $segment->segment_desc }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <div class="modal fade" id="segmentModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Segment</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('segment.add') }}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="segment_name" class="text_name">Segment Name</label>
                            <input name="segment_name" type="text" value="{{ old('segment_name') }}"
                                class="placeholder_color form-control @error('segment_name') is-invalid invalid @enderror"
                                id="segment_name" aria-describedby="namaHelp" placeholder="Name" required>
                            @error('segment_name')
                            <span class="invalid" style="color: red"><i>{{$message}}</i></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="segment_desc" class="text_name">Segment Description</label>
                            <input name="segment_desc" type="text" value="{{ old('segment_desc') }}"
                                class="placeholder_color form-control @error('segment_desc') is-invalid invalid @enderror"
                                id="segment_desc" aria-describedby="namaHelp" placeholder="segment_Desc" required>
                            @error('segment_desc')
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
    $('button#delete').on('click', function () {
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
