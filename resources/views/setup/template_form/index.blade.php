@extends('setup.template.default')
@section('title_menu', 'Template & Form')
@section('navbar')
<nav class="main-header navbar navbar-expand navbar-white navbar-light" style="padding: 0px !important">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav menu_servicedesk">
            @foreach(\App\Model\TaskType::get() as $type)
            <li class="nav-item">
                <a href="/setup/template-form/{{$type->id_type}}" class="{{  $id_type == $type->id_type ? 'bg-primary' : '' }} nav-link text-header">{{$type->type_name}}</a>
            </li>
            @endforeach
        </ul>
    </div>
</nav>
@endsection
@section('content')
    <?php 

$id_type = isset($id_type)?$id_type:'';
$path = "setup/template-form/$id_type";
?>
<div id="menu1"  class="content_header active">
    <div class="content_menu">
        <h4 class="title_2">{{ __('setup-templateform-index2.template_language') }}</h4>
        <a href="/setup/template-form/{{$id_type}}/create" style="margin-bottom: 10px" class="btn btn-sm btn-primary">{{ __('setup-templateform-index2.new-template_language') }}
        <a href="/setup/template-form/{{$id_type}}/template_addons" style="margin-bottom: 10px" class="btn btn-sm btn-primary ml-2">{{ __('setup-templateform-index2.template-add-ons_language') }}
        </a>
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 75px"></th>
                            <th>{{ __('setup-templateform-index2.name_language') }}</th>
                            <th>{{ __('setup-templateform-index2.created-by_language') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Templates::where('id_task_type', $id_type)->get() as $template)
                            <tr>
                                <td style="vertical-align: middle">
                                    <a href="/setup/template-form/{{$id_type}}/create?id={{$template->id}}&template_name={{$template->template_name}}" class=" icon_color"><i class="fas fa-pen"></i></a>&nbsp;
                                    <a href="#" class="btn btn-md btn-danger btn-delete-user" data-id="{{$template->id}}" data-name="{{$template->template_name}}"><i class="fa fa-trash"></i></a>
                           
                                 </td>
                                <td style="display: grid">
                                    <a href="/setup/template-form/{{$id_type}}/create?id={{$template->id}}&template_name={{$template->template_name}}" class="judul2">{{$template->template_name}}</a>
                                    <small class="user_small">{{$template->template_comments}}</small>
                                </td>
                                <td style="vertical-align: middle">
                                    <small class="user_small">{{$template->creator->name}}</small>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" id="removeData" role="dialog" aria-labelledby="warning">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">{{ __('setup-customization-impact.user_language') }}</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body form-remove-data">
                    <div class="form-group">
                        <label >{{ __('setup-customization-impact.name2_language') }}</label>
                        <input type="text" class="form-control" name="name" placeholder="{{ __('setup-customization-impact.name3_language') }}" readonly style="background-color: #e9ecef !important">
                    </div>
                    
                    
                    <br>
                    <hr>
                    
                    <div class="text-center">
                        <h5>{{ __('setup-customization-impact.message2_language') }}</h5>
                        <h5>{{ __('setup-customization-impact.continue_language') }}</h5>
                    </div>
                    <hr>
                    <br>
                    
                    <div class="modal-footer justify-content-between">
                        <a href="#" type="button" class="btn btn-default" style="color: #fff; background: #CECECE" data-dismiss="modal">{{ __('setup-customization-impact.cancel2_language') }}</a>
                        <a href="#" class="btn btn-danger btn-remove-user" style="width: 70px;">{{ __('setup-customization-impact.delete_language') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    $(document).on('click', '.btn-delete-user', function(e){
        var ini = $(this),
            id = ini.data('id'),
            name = ini.data('name');
          
        mod = $('#removeData');
        form = $('.form-remove-data');
        form.find('input[name=name]').val(name);
        form.find('.btn-remove-user').attr('href','/{{$path}}/delete_template/'+id);
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
</script>
    
@endsection