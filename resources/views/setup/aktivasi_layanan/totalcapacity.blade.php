@extends('setup.aktivasi_layanan.aktivasi_layanan')
@section('title', 'Layanan')
@section('aktivasi_layanan_content')
@if(Session::has('message'))
<div class="alert {{Session::get('alert-class')}} alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
</div>
@endif
<div id="menu4" class="content_header">
    <div class="content_menu">
        <h4 class="title_2">{{ __('setup-customization-activation_services-total_capacity.title_language') }}</h4>
        <div class="row">
            <div class="col-md-2 form-group">
                <button type="button" class="form-control bg-primary" data-toggle="modal" data-target="#approverModal"> <i
                        class="fa fa-plus nav-icon"></i>&nbsp;&nbsp;{{ __('setup-customization-activation_services-total_capacity.create_language') }}
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
                            <th>{{ __('setup-customization-activation_services-total_capacity.name_language') }}</th>
                            <th>{{ __('setup-customization-activation_services-total_capacity.desc_language') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Model\Layanan::get() as $d)
                        <tr>
                            <td>
                                <a href="#" class="btn-edit-data" data-id="{{$d->id_layanan}}"><i class="fas fa-pen icon_color"></i></a>
                                  <a href="#" class="btn btn-md btn-danger btn-delete-user" data-id="{{$d->id_layanan}}" data-name="{{$d->name_layanan}}"><i class="fa fa-trash"></i></a>
                            </td>
                            <td class="text_name">{{isset($d->name_layanan)?$d->name_layanan:''}}</td>
                            <td class="text_name">{{isset($d->desc_layanan)?$d->desc_layanan:''}}</td>
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
                    <h4 class="modal-title">{{ __('setup-customization-activation_services-total_capacity.new-data_language') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/setup/aktivasi_layanan/layanan/new_layanan" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label class="text_name form-control-label">{{ __('setup-customization-activation_services-total_capacity.name2_language') }}</label>
                            <input class="form-control" name="name_layanan" required autofocus placeholder="{{ __('setup-customization-activation_services-total_capacity.name3_language') }}">
                        </div>
                        <div class="form-group">
                            <label class="text_name form-control-label">{{ __('setup-customization-activation_services-total_capacity.desc2_language') }}</label>
                            <textarea rows="2" class="form-control" name="desc_layanan" required autofocus placeholder="{{ __('setup-customization-activation_services-total_capacity.desc3_language') }}"></textarea>
                        </div>
                        <div class="modal-footer justify-content-start">
                            <button type="submit" class="btn btn-primary" style="width: 70px;">{{ __('setup-customization-activation_services-total_capacity.save_language') }}</button>
                            <button type="button" class="btn btn-default" style="color: #fff; background: #CECECE">{{ __('setup-customization-activation_services-total_capacity.cancel_language') }}</button>
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
                    <h4 class="modal-title">{{ __('setup-customization-activation_services-total_capacity.edit-data_language') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/setup/aktivasi_layanan/layanan/edit_layanan" method="POST" enctype="multipart/form-data" class="form-update-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <input name="id" hidden>
                            <label class="text_name form-control-label">{{ __('setup-customization-activation_services-total_capacity.name4_language') }}</label>
                            <input class="form-control" name="name_layanan" required autofocus placeholder="{{ __('setup-customization-activation_services-total_capacity.name5_language') }}">
                        </div>
                        <div class="form-group">
                            <label class="text_name form-control-label">{{ __('setup-customization-activation_services-total_capacity.desc4_language') }}</label>
                            <textarea rows="2" class="form-control" name="desc_layanan" required autofocus placeholder="{{ __('setup-customization-activation_services-total_capacity.desc5_language') }}"></textarea>
                        </div>
                        <div class="modal-footer justify-content-start">
                            <button type="submit" class="btn btn-primary" style="width: 70px;">{{ __('setup-customization-activation_services-total_capacity.save2_language') }}</button>
                            <button type="button" class="btn btn-default" style="color: #fff; background: #CECECE">{{ __('setup-customization-activation_services-total_capacity.cancel2_language') }}</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
     <div class="modal fade" tabindex="-1" id="removeData" role="dialog" aria-labelledby="warning">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">{{ __('setup-customization-activation_services-total_capacity.data_language') }}</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body form-remove-data">
                    <div class="form-group">
                        <label >{{ __('setup-customization-activation_services-total_capacity.name6_language') }}</label>
                        <input type="text" class="form-control" name="name" placeholder="{{ __('setup-customization-activation_services-total_capacity.name7_language') }}" readonly style="background-color: #e9ecef !important">
                    </div>
                    
                    
                    <br>
                    <hr>
                    
                    <div class="text-center">
                        <h5>{{ __('setup-customization-activation_services-total_capacity.message_language') }}</h5>
                        <h5>{{ __('setup-customization-activation_services-total_capacity.continue_language') }}</h5>
                    </div>
                    <hr>
                    <br>
                    
                    <div class="modal-footer justify-content-between">
                        <a href="#" type="button" class="btn btn-info btn-sm text-light" data-dismiss="modal" style="font-weight:bold; font-size:15px">{{ __('setup-customization-activation_services-total_capacity.cancel3_language') }}</a>
                        <a href="#" class="btn btn-sm btn-danger btn-remove-user">{{ __('setup-customization-activation_services-total_capacity.delete_language') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $('.select2').select2();
     $('#user_data_table').DataTable();
    $(document).on('click', '.btn-delete-user', function(e){
        var ini = $(this),
            id = ini.data('id'),
            name = ini.data('name');
          
        mod = $('#removeData');
        form = $('.form-remove-data');
        form.find('input[name=name]').val(name);
        form.find('.btn-remove-user').attr('href','/setup/aktivasi_layanan/layanan/delete_layanan/'+id);
        mod.modal('show');
    });
     $(document).on('click', '.btn-remove-user', function(e){
       e.preventDefault();
       var ini = $(this), url = ini.attr('href');
       
    //   var e_modal_wait = $("#modalWait");
            // showLoading(e_modal_wait);
        $.ajax({
            url: url,
            type: "get",
            data: {}
        })
        .done(function (result) {
            // hideLoading(e_modal_wait);
            if(result.status){
                var message = result.message || 'Success!';
                successAlert(message);
                $('#removeData').modal('hide');
                location.reload();
            }else{
                var message = result.message || 'Not found!';
                failedAlert(message);
            }
        })
        .fail(ajax_fail);
    });
   
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
                        url: '/setup/aktivasi_layanan/layanan/getLayanan',
                        type: "get",
                        data: {
                                id: id
                              }
                    })
                    .done(function (result) {
                        hideLoading(e_modal_wait);
                        if(result.data[0]){
                            data = result.data[0];
                            form.find('input[name=id]').val(data.id_layanan);
                            form.find('input[name=name_layanan]').val(data.name_layanan);
                            form.find('textarea[name=desc_layanan]').val(data.desc_layanan);
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
