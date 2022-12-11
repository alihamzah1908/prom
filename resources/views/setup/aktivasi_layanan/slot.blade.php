@extends('setup.aktivasi_layanan.aktivasi_layanan')
@section('title', 'Slot')
@section('aktivasi_layanan_content')
@if(Session::has('message'))
<div class="alert {{Session::get('alert-class')}} alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
    {{ Session::get('message') }}
</div>
@endif
<div id="menu4" class="content_header">
    <div class="content_menu">
        <h4 class="title_2">{{ __('setup-customization-activation_services-slot.title_language') }}</h4>
        <div class="row">
            <div class="col-md-2 form-group">
                <button type="button" class="form-control bg-primary" data-toggle="modal" data-target="#approverModal"> <i
                        class="fa fa-plus nav-icon"></i>&nbsp;&nbsp;{{ __('setup-customization-activation_services-slot.create_language') }}
                </button>
            </div>
        </div>
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <table id="data_table" class="table">
                    <thead>
                        <tr>
                            <th width="8%"></th>
                            <th>{{ __('setup-customization-activation_services-slot.name_language') }}</th>
                            <th>{{ __('setup-customization-activation_services-slot.desc_language') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Model\Slot::get() as $d)
                        <tr>
                            <td>
                                <a href="#" class="btn-edit-data" data-id="{{$d->id_slot}}"><i class="fas fa-pen icon_color"></i></a>
                            </td>
                            <td class="text_name">{{isset($d->name_slot)?$d->name_slot:''}}</td>
                            <td class="text_name">{{isset($d->desc_slot)?$d->desc_slot:''}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <div class="modal fade" id="approverModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('setup-customization-activation_services-slot.new-data_language') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/setup/aktivasi_layanan/slot/new_data" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label class="text_name form-control-label">{{ __('setup-customization-activation_services-slot.name2_language') }}</label>
                            <input class="form-control" name="name_slot" required autofocus placeholder="{{ __('setup-customization-activation_services-slot.name3_language') }}">
                        </div>
                        <div class="form-group">
                            <label class="text_name form-control-label">{{ __('setup-customization-activation_services-slot.desc2_language') }}</label>
                            <textarea rows="2" class="form-control" name="desc_slot" required autofocus placeholder="{{ __('setup-customization-activation_services-slot.desc3_language') }}"></textarea>
                        </div>
                        <div class="modal-footer justify-content-start">
                            <button type="submit" class="btn btn-primary" style="width: 70px;">{{ __('setup-customization-activation_services-slot.save_language') }}</button>
                            <button type="button" class="btn btn-default" style="color: #fff; background: #CECECE">{{ __('setup-customization-activation_services-slot.cancel_language') }}</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="approverModalEdit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('setup-customization-activation_services-slot.edit-data_language') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/setup/aktivasi_layanan/slot/edit_data" method="POST" enctype="multipart/form-data" class="form-update-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <input name="id" hidden>
                            <label class="text_name form-control-label">{{ __('setup-customization-activation_services-slot.name4_language') }}</label>
                            <input class="form-control" name="name_slot" required autofocus placeholder="{{ __('setup-customization-activation_services-slot.name5_language') }}">
                        </div>
                        <div class="form-group">
                            <label class="text_name form-control-label">{{ __('setup-customization-activation_services-slot.desc4_language') }}</label>
                            <textarea rows="2" class="form-control" name="desc_slot" required autofocus placeholder="{{ __('setup-customization-activation_services-slot.desc5_language') }}"></textarea>
                        </div>
                        <div class="modal-footer justify-content-start">
                            <button type="submit" class="btn btn-primary" style="width: 70px;">{{ __('setup-customization-activation_services-slot.save2_language') }}</button>
                            <button type="button" class="btn btn-default" style="color: #fff; background: #CECECE">{{ __('setup-customization-activation_services-slot.cancel2_language') }}</button>
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
        $('#data_table').DataTable();
        $(document).ready(function() {
            $(document).on('click', '.btn-edit-data', function(e){
                e.preventDefault();
                var ini = $(this),
                    id = ini.data('id'),
                    form = $('.form-update-data');
                    console.log(id);
                if($.isNumeric(id)) {
                    var e_modal_wait = $("#modalWait");
                    showLoading(e_modal_wait);
                    $.ajax({
                        url: '/setup/aktivasi_layanan/slot/getData',
                        type: "get",
                        data: {
                                id: id
                              }
                    })
                    .done(function (result) {
                        hideLoading(e_modal_wait);
                        if(result.data[0]){
                            data = result.data[0];
                            form.find('input[name=id]').val(data.id_slot);
                            form.find('input[name=name_slot]').val(data.name_slot);
                            form.find('textarea[name=desc_slot]').val(data.desc_slot);
                            $('#approverModalEdit').modal('show');
                        
                        }else{
                            var message = result.message || 'Not found!';
                            failedAlert(message);
                        }
                    })
                    .fail(ajax_fail);
                }
            })
        });
    </script>
@endpush
