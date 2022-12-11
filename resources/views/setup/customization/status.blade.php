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

<div id="menu2" class="content_header">
    <div class="content_menu">
        <h4 class="title_2">{{ __('setup-customization-status.status_language') }}</h4>
        <button type="button" style="margin-bottom: 10px" class="btn btn-sm btn-primary" data-toggle="modal"
            data-target="#newStatus">{{ __('setup-customization-status.new-status_language') }}
        </button>
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 52px"></th>
                            <th>{{ __('setup-customization-status.name_language') }}</th>
                            <th>{{ __('setup-customization-status.desc_language') }}</th>
                            <th>{{ __('setup-customization-status.group_language') }}</th>
                            <th>{{ __('setup-customization-status.color_language') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($status as $c)
                        <tr>
                            
                            <td>
                             
                                <a href="#" class="btn-edit-data" data-id="{{$c->id_status}}"><i class="fas fa-pen icon_color"></i></a>
                            
                            </td>
                            
                            <td class="text_name">
                                {{$c->status_name}}
                            </td>
                            <td class="text_name">
                                {{$c->status_desc}}
                            </td>
                            
                            <td class="text_name">
                                {{$c->group_status}}
                            </td>
                            <td>
                                <div style="background: {{$c->color}}; width: 100px; height: 10px; border-radius: 10px;"></div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td></td>
                            <td class="text_name">
                                {{ __('setup-customization-status.message_language') }}
                            </td>
                            <td class="text_name"></td>
                            <td class="text_name"></td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <div class="modal fade" id="newStatus">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="new_status">
                @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">{{ __('setup-customization-status.new-status_language') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>{{ __('setup-customization-status.status2_language') }}</label>
                            <input class="form-control" name="status_name" placeholder="{{ __('setup-customization-status.status3_language') }}" required autofocus>
                        </div>
                        <div class="form-group">
                            <label>{{ __('setup-customization-status.color2_language') }}</label>
                            <input class="form-control" name="color" placeholder="{{ __('setup-customization-status.color3_language') }}" required autofocus type="color">
                        </div>
                        
                    
                        
                         <div class="form-group">
                            <label>{{ __('setup-customization-status.type_language') }}</label>
                            <br>
                            <input type="radio" name="statusProgress" id='idProgress' value="InProgress"> {{ __('setup-customization-status.in-progress_language') }}<br>
                            <input type="radio" name="statusProgress" id='idCompleted' value="Completed"> {{ __('setup-customization-status.completed_language') }} <br> 
                            </br>
                        </div>
                        
                         <div class="form-group">
                            <label>{{ __('setup-customization-status.stop-timer_language') }}</label>
                            <br>
                           <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="switch" checked>
                             <label class="onoffswitch-label" for="switch">
                        <span class="onoffswitch-inner"></span>
                           <span class="onoffswitch-switch"></span>
    </label>
            
                            </br>
                        </div>
                        
                        <div class="form-group">
                            <label>{{ __('setup-customization-status.desc2_language') }}</label>
                            <textarea class="form-control" name="status_desc" placeholder="{{ __('setup-customization-status.desc3_language') }}" required autofocus rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!--<a href="#" class="btn btn-info btn-sm text-light" style="font-weight:bold; font-size:15px" data-dismiss="modal">Close</a>-->
                        <button type="submit" style="font-weight:bold; font-size:15px" class="btn btn-sm btn-success">{{ __('setup-customization-status.save_language') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="approverModalEdit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('setup-customization-status.edit-data_language') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/{{$path}}/update_status" method="POST" enctype="multipart/form-data" class="form-update-data">
                          {{csrf_field()}}
                          <div class="modal-body">
                        <div class="form-group">
                            <label>{{ __('setup-customization-status.status4_language') }}</label>
                            <input class="form-control" name="status_name" placeholder="{{ __('setup-customization-status.status5_language') }}" required autofocus>
                            <input  name="id_type" type='hidden'  value ="{{$id_type}}" >
                        </div>
                        <div class="form-group">
                            <label>{{ __('setup-customization-status.color4_language') }}</label>
                            <input class="form-control" name="color" placeholder="{{ __('setup-customization-status.color5_language') }}" required autofocus type="color">
                        </div>
                        
                    
                        
                         <div class="form-group">
                            <label>{{ __('setup-customization-status.type2_language') }}</label>
                            <br>
                            <input type="radio" name="statusProgress" id='idProgress' value="InProgress"> {{ __('setup-customization-status.in-progress2_language') }}<br>
                            <input type="radio" name="statusProgress" id='idCompleted' value="Completed"> {{ __('setup-customization-status.completed2_language') }} <br> 
                            </br>
                        </div>
                        
                         <div class="form-group">
                            <label>{{ __('setup-customization-status.stop-timer2_language') }}</label>
                            <br>
                           <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="switch" checked>
                             <label class="onoffswitch-label" for="switch">
                        <span class="onoffswitch-inner"></span>
                           <span class="onoffswitch-switch"></span>
    </label>
            
                            </br>
                        </div>
                        
                        <div class="form-group">
                            <label>{{ __('setup-customization-status.desc4_language') }}</label>
                            <textarea class="form-control" name="status_desc" placeholder="{{ __('setup-customization-status.desc5_language') }}" required autofocus rows="2"></textarea>
                        </div>
                    </div>
                       
                        <div class="modal-footer justify-content-start">
                            <button type="submit" class="btn btn-primary" style="width: 70px;">{{ __('setup-customization-status.save2_language') }}</button>
                            <button type="button" class="btn btn-default" style="color: #fff; background: #CECECE">{{ __('setup-customization-status.cancel_language') }}</button>
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
    $(document).ready(function() {
        $(document).on('click', '.btn-edit-data', function(e){
            e.preventDefault();
            var ini = $(this),
                id = ini.data('id'),
                form = $('.form-update-data');
            if($.isNumeric(id)) {
                console.log('/{{$path}}/getStatus');
                var e_modal_wait = $("#modalWait");
                showLoading(e_modal_wait);
                $.ajax({
                    url: '/{{$path}}/getStatus',
                    type: "get",
                    data: {
                            id: id
                    
                          }
                           
                })
                
               
                .done(function (result) {
                    console.log(result.data);
                    hideLoading(e_modal_wait);
                    if(result.data[0]){
                        data = result.data[0];
                        form.find('input[name=id]').val(data.id_status);
                        form.find('input[name=status_name]').val(data.status_name);
                        form.find('input[name=color]').val(data.color);
                        form.find('select[name=statusProgress]').val(data.group_status);
                        form.find('textarea[name=status_desc]').val(data.status_desc);
                        
                        $('#approverModalEdit').modal('show');
                    
                    }else{
                           hideLoading(e_modal_wait);
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

