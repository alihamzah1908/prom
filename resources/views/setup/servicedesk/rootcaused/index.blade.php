@extends('setup.servicedesk.service_desk')
@section('title_menu', 'Servicedesk Configurations')
@section('title', 'Root caused')
@section('service_desk_content')
@include('sweetalert::alert')
<div class="content_header">
    <div class="content_menu">
        <h4 class="title_2">{{ __('setup-servicedesk-rootcaused-index2.root-caused_language') }}</h4>
        <button type="button" style="margin-bottom: 10px" class="btn btn-sm btn-primary" data-toggle="modal"
            data-target="#rootcausedModal">{{ __('setup-servicedesk-rootcaused-index2.new-root-caused_language') }}
        </button>
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 87px"></th>
                            <th>{{ __('setup-servicedesk-rootcaused-index2.name_language') }}</th>
                            <th>{{ __('setup-servicedesk-rootcaused-index2.desc_language') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($causeds as $caused)
                        <tr>
                            <td>
                                <a href="{{ route('rootcaused.edit',$caused->id_caused)}}"><i
                                        class="fas fa-pen icon_color"></i></a>&nbsp;
                                <button style="background-color: Transparent;background-repeat:no-repeat;border: none;cursor:pointer;overflow: hidden;   " id="delete" data-title="{{ $caused->name_caused}}"
                                    href="{{ route('rootcaused.delete',$caused->id_caused)}}"><i
                                        class="fa fa-trash"></i></button>
                                <form action="" method="post" id="deleteForm">
                                    @csrf
                                    <input type="submit" value="" style="display:none">
                                </form>
                            </td>
                            <td class="text_name">{{ $caused->name_caused }}</td>
                            <td class="text_name">{{ $caused->desc_caused }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <div class="modal fade" id="rootcausedModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('setup-servicedesk-rootcaused-index2.new-root-caused_language') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('rootcaused.add') }}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="nama_rootcaused" class="text_name">{{ __('setup-servicedesk-rootcaused-index2.name2_language') }}</label>
                            <input name="nama_rootcaused" type="text" value="{{ old('nama_rootcaused') }}"
                                class="placeholder_color form-control @error('nama_rootcaused') is-invalid invalid @enderror"
                                id="nama_rootcaused" aria-describedby="namaHelp" placeholder="{{ __('setup-servicedesk-rootcaused-index2.name3_language') }}" required>
                            @error('nama_rootcaused')
                            <span class="invalid" style="color: red"><i>{{$message}}</i></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description" class="text_name">{{ __('setup-servicedesk-rootcaused-index2.desc2_language') }}</label>
                            <input name="description" type="text" value="{{ old('description') }}"
                                class="placeholder_color form-control @error('description') is-invalid invalid @enderror"
                                id="description" aria-describedby="namaHelp" placeholder="{{ __('setup-servicedesk-rootcaused-index2.desc3_language') }}" required>
                            @error('description')
                            <span class="invalid" style="color: red><i>{{$message}}</i></span>
                            @enderror
                        </div>
                        <div class=" modal-footer justify-content-start">
                                <button type="submit" class="btn btn-primary" style="width: 70px;">{{ __('setup-servicedesk-rootcaused-index2.create_language') }}</button>
                                <button type="button" class="btn btn-default"
                                    style="color: #fff; background: #CECECE" data-dismiss="modal">{{ __('setup-servicedesk-rootcaused-index2.cancel_language') }}</button>
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
                title: "{{ __('setup-servicedesk-rootcaused-index2.ask_language') }} " + title + "?",
                text: "{{ __('setup-servicedesk-rootcaused-index2.notif_language') }}",
                icon: "warning",
                buttons: ["{{ __('setup-servicedesk-rootcaused-index2.cancel2_language') }}", "{{ __('setup-servicedesk-rootcaused-index2.yes_language') }}"],
            })
            .then((willDelete) => {
                if (willDelete) {
                    document.getElementById('deleteForm').action = href;
                    document.getElementById('deleteForm').submit();
                    swal("{{ __('setup-servicedesk-rootcaused-index2.message_language') }}", {
                        icon: "success",
                    });
                }
            });
    });

</script>
@endpush
