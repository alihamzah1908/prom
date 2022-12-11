@extends('setup.servicedesk.service_desk')
@section('title_menu', 'Servicedesk Configurations')
@section('title', 'Region')

@section('service_desk_content')
@include('sweetalert::alert')
<div class="content_header">
    <div class="content_menu">
        <h4 class="title_2">{{ __('setup-servicedesk-region-index2.regions_language') }}</h4>
        <button type="button" style="margin-bottom: 10px" class="btn btn-sm btn-primary" data-toggle="modal"
            data-target="#regionModal">{{ __('setup-servicedesk-region-index2.new-region_language') }}
        </button>
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 75px"></th>
                            <th>{{ __('setup-servicedesk-region-index2.region-name_language') }}</th>
                            <th style="width: 40px">{{ __('setup-servicedesk-region-index2.desc_language') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($regions as $region)
                        <tr>
                            <td>
                                <a href="{{ route('region.edit',$region->region_id)}}"><i
                                        class="fas fa-pen icon_color"></i></a>&nbsp;
                                <button style="background-color: Transparent;background-repeat:no-repeat;border: none;cursor:pointer;overflow: hidden;   " id="delete" data-title="{{ $region->region_name}}"
                                    href="{{ route('region.delete',$region->region_id)}}"><i
                                        class="fa fa-trash"></i></button>
                                <form action="" method="post" id="deleteForm">
                                    @csrf
                                    <input type="submit" value="" style="display:none">
                                </form>
                            </td>
                            <td class="text_name">{{ $region->region_name }}</td>
                            <td class="text_name">{{ $region->region_desc }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <div class="modal fade" id="regionModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('setup-servicedesk-region-index2.new-region2_language') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('region.add') }}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="nama_region" class="text_name">{{ __('setup-servicedesk-region-index2.region-name2_language') }}</label>
                            <input name="nama_region" type="text" value="{{ old('nama_region') }}"
                                class="placeholder_color form-control @error('nama_region') is-invalid invalid @enderror"
                                id="nama_region" aria-describedby="namaHelp" placeholder="{{ __('setup-servicedesk-region-index2.name_language') }}">
                            @error('nama_region')
                            <span class="invalid" style="color: red"><i>{{$message}}</i></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description" class="text_name">{{ __('setup-servicedesk-region-index2.desc2_language') }}</label>
                            <input name="description" type="text" value="{{ old('description') }}"
                                class="placeholder_color form-control @error('description') is-invalid invalid @enderror"
                                id="description" aria-describedby="namaHelp" placeholder="{{ __('setup-servicedesk-region-index2.desc3_language') }}">
                            @error('description')
                            <span class="invalid" style="color: red><i>{{$message}}</i></span>
                            @enderror
                        </div>
                        <div class=" modal-footer justify-content-start">
                                <button type="submit" class="btn btn-primary" style="width: 70px;">{{ __('setup-servicedesk-region-index2.create_language') }}</button>
                                <button type="reset" class="btn btn-default"
                                    style="color: #fff; background: #CECECE">{{ __('setup-servicedesk-region-index2.cancel_language') }}</button>
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
                title: "{{ __('setup-servicedesk-region-index2.ask_language') }} " + title + "?",
                text: "{{ __('setup-servicedesk-region-index2.notif_language') }}",
                icon: "warning",
                buttons: ["{{ __('setup-servicedesk-region-index2.cancel2_language') }}", "{{ __('setup-servicedesk-region-index2.yes_language') }}"],
            })
            .then((willDelete) => {
                if (willDelete) {
                    document.getElementById('deleteForm').action = href;
                    document.getElementById('deleteForm').submit();
                    swal("{{ __('setup-servicedesk-region-index2.message_language') }}", {
                        icon: "success",
                    });
                }
            });
    });

</script>
@endpush
