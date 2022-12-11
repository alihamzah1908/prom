@extends('setup.aktivasi_layanan.aktivasi_layanan')
@section('title', 'Status')
@section('aktivasi_layanan_content')
@if(Session::has('message'))
<div class="alert {{Session::get('alert-class')}} alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
    {{ Session::get('message') }}
</div>
@endif
<div id="menu4" class="content_header">
    <div class="content_menu">
        <h4 class="title_2">{{ __('setup-customization-activation_services-service_status.title_language') }}</h4>
        <div class="row">
            <!--<div class="col-md-2 form-group">-->
            <!--    <button type="button" class="form-control bg-primary" data-toggle="modal" data-target="#approverModal"> <i-->
            <!--            class="fa fa-plus nav-icon"></i>&nbsp;&nbsp;Create-->
            <!--    </button>-->
            <!--</div>-->
        </div>
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <table id="data_table" class="table">
                    <thead>
                        <tr>
                            <th width="8%"></th>
                            <th>{{ __('setup-customization-activation_services-service_status.name_language') }}</th>
                            <th>{{ __('setup-customization-activation_services-service_status.desc_language') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Model\AktivasiStatus::get() as $d)
                        <tr>
                            <td>
                                <!--<a href="#" class="btn-edit-data" data-id="{{$d->id}}"><i class="fas fa-pen icon_color"></i></a>-->
                            </td>
                            <td class="text_name">{{isset($d->name)?$d->name:''}}</td>
                            <td class="text_name">{{isset($d->description)?$d->description:''}}</td>
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
                    <h4 class="modal-title">{{ __('setup-customization-activation_services-service_status.new-data_language') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/setup/aktivasi_layanan/status/new_data" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label class="text_name form-control-label">{{ __('setup-customization-activation_services-service_status.name2_language') }}</label>
                            <input class="form-control" name="name" required autofocus placeholder="{{ __('setup-customization-activation_services-service_status.name3_language') }}">
                        </div>
                        <div class="form-group">
                            <label class="text_name form-control-label">{{ __('setup-customization-activation_services-service_status.desc2_language') }}</label>
                            <textarea rows="2" class="form-control" name="description" required autofocus placeholder="{{ __('setup-customization-activation_services-service_status.desc3_language') }}"></textarea>
                        </div>
                        <div class="modal-footer justify-content-start">
                            <button type="submit" class="btn btn-primary" style="width: 70px;">{{ __('setup-customization-activation_services-service_status.save_language') }}</button>
                            <button type="button" class="btn btn-default" style="color: #fff; background: #CECECE">{{ __('setup-customization-activation_services-service_status.cancel_language') }}</button>
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
                    <h4 class="modal-title">{{ __('setup-customization-activation_services-service_status.edit-data_language') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/setup/aktivasi_layanan/status/edit_data" method="POST" enctype="multipart/form-data" class="form-update-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <input name="id" hidden>
                            <label class="text_name form-control-label">{{ __('setup-customization-activation_services-service_status.name4_language') }}</label>
                            <input class="form-control" name="name" required autofocus placeholder="{{ __('setup-customization-activation_services-service_status.name5_language') }}">
                        </div>
                        <div class="form-group">
                            <label class="text_name form-control-label">{{ __('setup-customization-activation_services-service_status.desc4_language') }}</label>
                            <textarea rows="2" class="form-control" name="description" required autofocus placeholder="{{ __('setup-customization-activation_services-service_status.desc5_language') }}"></textarea>
                        </div>
                        <div class="modal-footer justify-content-start">
                            <button type="submit" class="btn btn-primary" style="width: 70px;">{{ __('setup-customization-activation_services-service_status.save2_language') }}</button>
                            <button type="button" class="btn btn-default" style="color: #fff; background: #CECECE">{{ __('setup-customization-activation_services-service_status.cancel2_language') }}</button>
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
                        url: '/api/setup/aktivasi_layanan/status/getData',
                        type: "get",
                        data: {
                                id: id
                              }
                    })
                    .done(function (result) {
                        hideLoading(e_modal_wait);
                        if(result.data[0]){
                            data = result.data[0];
                            form.find('input[name=id]').val(data.id);
                            form.find('input[name=name]').val(data.name);
                            form.find('textarea[name=description]').val(data.description);
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
