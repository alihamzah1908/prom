@extends('setup.customization.customization')
@section('customization')

@if(Session::has('message'))
<div class="alert {{Session::get('alert-class')}} alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
    {{ Session::get('message') }}
</div>
@endif
<?php 
$id_type = isset($id_type)?$id_type:'';
$path = "setup/Customization/$id_type";
?>
<div id="menu5" class="content_header">
    <div class="content_menu">
        <h4 class="title_2">{{ __('setup-customization-priority.priority_language') }}</h4>
        <button type="button" style="margin-bottom: 10px" class="btn btn-sm btn-primary" data-toggle="modal"
            data-target="#newPriority">{{ __('setup-customization-priority.new-priority_language') }}
        </button>
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 52px"></th>
                            <th>{{ __('setup-customization-priority.name_language') }}</th>
                            <th>{{ __('setup-customization-priority.desc_language') }}</th>
                            <th>{{ __('setup-customization-priority.color_language') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($priority as $c)
                        <tr>
                            <td>
                                <a href="#" class="btn-edit-data" data-id="{{$c->id_priority}}"><i class="fas fa-pen icon_color"></i></a>
                                  <a href="#" class="btn btn-md btn-danger btn-delete-user" data-id="{{$c->id_priority}}" data-name="{{$c->priority_name}}">
                            <i class="fa fa-trash"></i>
                            </td>
                            <td class="text_name">
                                {{$c->priority_name}}
                            </td>
                            <td class="text_name">
                                {{$c->priority_desc}}
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-md-1">
                                        <div style="background: {{$c->color}}; width: 10px; height: 10px; margin-top: 2px"></div>
                                    </div>
                                    <div class="col">
                                        <small class="text_name">{{$c->color}}</small>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td>
                                
                            </td>
                            <td class="text_name">
                                {{ __('setup-customization-priority.message_language') }}
                            </td>
                            <td class="text_name">
                                
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <div class="modal fade" id="newPriority">
        <div class="modal-dialog">
            <div class="modal-content">
            <form method="POST" action="new_priority">
            @csrf
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('setup-customization-priority.new-priority2_language') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ __('setup-customization-priority.priority2_language') }}</label>
                        <input class="form-control" name="priority_name" placeholder="{{ __('setup-customization-priority.priority3_language') }}" required autofocus>
                    </div>
                    <div class="form-group">
                        <label>{{ __('setup-customization-priority.color2_language') }}</label>
                        <input class="form-control" name="color" placeholder="{{ __('setup-customization-priority.color3_language') }}" required autofocus type="color">
                    </div>
                    <div class="form-group">
                        <label>{{ __('setup-customization-priority.desc2_language') }}</label>
                        <textarea class="form-control" name="priority_desc" placeholder="{{ __('setup-customization-priority.desc3_language') }}" required autofocus rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="padding-right:20px;">
                    <a href="#" class="btn btn-default" style="color: #fff; background: #CECECE" data-dismiss="modal">{{ __('setup-customization-priority.close_language') }}</a>
                    <button type="submit" class="btn btn-primary" style="width: 70px;">{{ __('setup-customization-priority.save_language') }}</button>
                </div>
            </form>

            </div>
        </div>
    </div>
     <div class="modal fade" tabindex="-1" id="removeData" role="dialog" aria-labelledby="warning">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">{{ __('setup-customization-priority.user_language') }}</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body form-remove-data">
                    <div class="form-group">
                        <label >{{ __('setup-customization-priority.name2_language') }}</label>
                        <input type="text" class="form-control" name="name" placeholder="{{ __('setup-customization-priority.name3_language') }}" readonly style="background-color: #e9ecef !important">
                    </div>
                    
                    
                    <br>
                    <hr>
                    
                    <div class="text-center">
                        <h5>{{ __('setup-customization-priority.message2_language') }}</h5>
                        <h5>{{ __('setup-customization-priority.continue_language') }}</h5>
                    </div>
                    <hr>
                    <br>
                    
                    <div class="modal-footer justify-content-between">
                        <a href="#" type="button" class="btn btn-default" style="color: #fff; background: #CECECE" data-dismiss="modal" style="font-weight:bold; font-size:15px">{{ __('setup-customization-priority.cancel_language') }}</a>
                        <a href="#" class="btn btn-danger btn-remove-user" style="width: 70px;">{{ __('setup-customization-priority.delete_language') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="approverModalEdit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('setup-customization-priority.edit-data_language') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/{{$path}}/update_priority" method="POST" enctype="multipart/form-data" class="form-update-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <input name="id" hidden>
                            <label>{{ __('setup-customization-priority.priority4_language') }}</label>
                            <input class="form-control" name="priority_name" placeholder="{{ __('setup-customization-priority.priority5_language') }}" required autofocus>
                        </div>
                        <div class="form-group">
                            <label>{{ __('setup-customization-priority.color4_language') }}</label>
                            <input class="form-control" name="color" placeholder="{{ __('setup-customization-priority.color5_language') }}" required autofocus type="color">
                        </div>
                        <div class="form-group">
                            <label>{{ __('setup-customization-priority.desc4_language') }}</label>
                            <textarea class="form-control" name="priority_desc" placeholder="{{ __('setup-customization-priority.desc5_language') }}" required autofocus rows="2"></textarea>
                        </div>
                        <div class="modal-footer justify-content-start">
                            <button type="submit" class="btn btn-primary" style="width: 70px;">{{ __('setup-customization-priority.save2_language') }}</button>
                            <button type="button" class="btn btn-default" style="color: #fff; background: #CECECE">{{ __('setup-customization-priority.cancel2_language') }}</button>
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
      $('#user_data_table').DataTable();
    $(document).on('click', '.btn-delete-user', function(e){
        var ini = $(this),
            id = ini.data('id'),
            name = ini.data('name');
          
        mod = $('#removeData');
        form = $('.form-remove-data');
        form.find('input[name=name]').val(name);
        form.find('.btn-remove-user').attr('href','/{{$path}}/delete_priority/'+id);
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
                    url: '/{{$path}}/getPriority',
                    type: "get",
                    data: {
                            id: id
                          }
                })
                .done(function (result) {
                    hideLoading(e_modal_wait);
                    if(result.data[0]){
                        data = result.data[0];
                        form.find('input[name=id]').val(data.id_priority);
                        form.find('input[name=priority_name]').val(data.priority_name);
                        form.find('input[name=color]').val(data.color);
                        form.find('textarea[name=priority_desc]').val(data.priority_desc);
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

