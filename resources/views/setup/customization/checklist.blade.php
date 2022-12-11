@extends('setup.customization.customization')
@section('customization')

@if(Session::has('message'))



<div class="alert {{Session::get('alert-class')}} alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
    {{ Session::get('message') }}
</div>
@endif
<style>
    .modal-footer {
 padding: 1rem;

} 
</style>
<div id="menu3" class="content_header">
    <div class="content_menu">
        <h4 class="title_2">{{ __('setup-customization-checklist.checklist_language') }}</h4>
        <button type="button" style="margin-bottom: 10px" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#checklistModal">{{ __('setup-customization-checklist.new-checklist_language') }}</button>
        <button type="button" style="margin-bottom: 10px" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#categoryModal">{{ __('setup-customization-checklist.new-category_language') }}</button>
        <button type="button" style="margin-bottom: 10px" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#periodeModal">{{ __('setup-customization-checklist.new-periode_language') }}</button>
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <div class="card-body p-0 mb-4">
                    <div class="row">
                        <div class="col-md-12">
                            <small><i>*please select region first. Refresh your browser to reset your filter browser</i></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <select class="form-control select2 select_region" style="width: 100%;" required autofocus name="id_region">
                                <option selected="selected" disabled value="">-- {{ __('setup-customization-checklist.region_language') }} --</option>
                                <option value="">{{ __('setup-customization-checklist.all_language') }}</option>
                                @foreach($regions as $region)
                                    <option value="{{$region->region_id}}">{{$region->region_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select class="form-control select2 select_periode" style="width: 100%;" required autofocus name="periode_name">
                                <option selected="selected" disabled value="">-- {{ __('setup-customization-checklist.periode_language') }} --</option>
                                <option value="">{{ __('setup-customization-checklist.all2_language') }}</option>
                                @foreach($checklist_periodes as $p)
                                    <option value="{{$p->id_periode}}">{{$p->periode_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select class="form-control select2 select_category" style="width: 100%;" required autofocus name="id_category">
                                <option selected="selected" disabled value="">-- {{ __('setup-customization-checklist.category_language') }} --</option>
                                <option value="">{{ __('setup-customization-checklist.all3_language') }}</option>
                                @foreach($checklist_categories as $c)
                                    <option value="{{$c->id_category}}">{{$c->category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <table class="table" id="data_table">
                    <thead>
                        <tr>
                            <th style="width: 52px"></th>
                            <th style="width: 52px">No.</th>
                            <th style="width: 52px">{{ __('setup-customization-checklist.id_language') }}</th>
                            <th>{{ __('setup-customization-checklist.name_language') }}</th>
                            <th>{{ __('setup-customization-checklist.category2_language') }}</th>
                            <th>{{ __('setup-customization-checklist.periode2_language') }}</th>
                            <th>{{ __('setup-customization-checklist.region2_language') }}</th>
                        </tr>
                    </thead>
                      <tbody>
            </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <div class="modal fade" id="checklistModal">
        <div class="modal-dialog">
            <div class="modal-content">
            <form method="POST" action="/setup/Customization/{{$id_type}}/new_checklist">
            @csrf
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('setup-customization-checklist.new-checklist2_language') }}</h4>
                    <button type="button" class="close" style="font-weight:bold; font-size:15px" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ __('setup-customization-checklist.periode3_language') }}</label>
                        <select class="form-control select2" style="width: 100%;" name="id_periode">
                            <option value="" selected disabled>-- {{ __('setup-customization-checklist.select-periode_language') }} --</option>
                            @foreach($checklist_periodes as $p)
                            <option value="{{$p->id_periode}}">{{$p->periode_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>{{ __('setup-customization-checklist.category3_language') }}</label>
                        <select class="form-control select2" style="width: 100%;" name="id_checklist_category">
                            <option value="" selected disabled>-- {{ __('setup-customization-checklist.select-category_language') }} --</option>
                            @foreach($checklist_categories as $p)
                            <option value="{{$p->id_category}}">{{$p->category_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>{{ __('setup-customization-checklist.region3_language') }}</label>
                        <select class="form-control select2" style="width: 100%;" required autofocus name="id_region">
                            <option selected="selected" disabled value="">-- {{ __('setup-customization-checklist.select-region_language') }} --</option>
                            @foreach($regions as $region)
                                <option value="{{$region->region_id}}">{{$region->region_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>{{ __('setup-customization-checklist.name2_language') }}</label>
                        <input class="form-control" name="checklist_name" placeholder="{{ __('setup-customization-checklist.name3_language') }}" required autofocus>
                    </div>
                    <!-- dari sini -->
                    <div class="form-group">
                        <label for="position">position</label>
                        <input class="form-control {{ $errors->has('position') ? 'is-invalid' : '' }}" type="number" name="position" id="position" value="{{ old('position', '') }}" step="1">
                    </div>
                    <!-- sampai sini -->
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-info btn-sm text-light" style="font-weight:bold; font-size:15px" data-dismiss="modal">{{ __('setup-customization-checklist.close_language') }}</a>
                    <button type="submit" class="btn btn-sm btn-success">{{ __('setup-customization-checklist.save_language') }}</button>
                </div>
            </form>

            </div>
        </div>
    </div>
    <div class="modal fade" id="updateModal">
        <div class="modal-dialog">
            <div class="modal-content">
            <form method="POST" action="/setup/Customization/{{$id_type}}/update_checklist" class="form-update-data">
            @csrf
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('setup-customization-checklist.update_language') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ __('setup-customization-checklist.periode4_language') }}</label>
                        <select class="form-control select2" style="width: 100%;" name="id_periode">
                            @foreach($checklist_periodes as $p)
                            <option value="{{$p->id_periode}}">{{$p->periode_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>{{ __('setup-customization-checklist.category3_language') }}</label>
                        <select class="form-control select2" style="width: 100%;" name="id_checklist_category">
                            @foreach($checklist_categories as $p)
                            <option value="{{$p->id_category}}">{{$p->category_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>{{ __('setup-customization-checklist.region4_language') }}</label>
                        <select class="form-control select2" style="width: 100%;" required autofocus name="id_region">
                            @foreach($regions as $region)
                                <option value="{{$region->region_id}}">{{$region->region_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>{{ __('setup-customization-checklist.name4_language') }}</label>
                        <input class="form-control" name="checklist_name" placeholder="{{ __('setup-customization-checklist.name5_language') }}" required autofocus>
                        <input name="id_checklist" hidden>
                    </div>
                    <div class="form-group">
                        <label for="position">position</label>
                        <input class="form-control {{ $errors->has('position') ? 'is-invalid' : '' }}" type="number" name="position" id="position" step="1">
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-info btn-sm text-light"  data-dismiss="modal">{{ __('setup-customization-checklist.close2_language') }}</a>
                    <button type="submit" class="btn btn-sm btn-success">{{ __('setup-customization-checklist.save2_language') }}</button>
                </div>
            </form>

            </div>
        </div>
    </div>
    <div class="modal fade" id="categoryModal">
        <div class="modal-dialog">
            <div class="modal-content">
            <form method="POST" action="/setup/Customization/{{$id_type}}/new_checklist_category">
            @csrf
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('setup-customization-checklist.name-checklist-category_language') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ __('setup-customization-checklist.name6_language') }}</label>
                        <input class="form-control" name="category_name" placeholder="{{ __('setup-customization-checklist.name7_language') }}" required autofocus>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-info btn-sm text-light" style="font-weight:bold; font-size:15px" data-dismiss="modal">{{ __('setup-customization-checklist.close3_language') }}</a>
                    <button type="submit" class="btn btn-sm btn-success">{{ __('setup-customization-checklist.save3_language') }}</button>
                </div>
            </form>

            </div>
        </div>
    </div>
    <div class="modal fade" id="periodeModal">
        <div class="modal-dialog">
            <div class="modal-content">
            <form method="POST" action="/setup/Customization/{{$id_type}}/new_checklist_periode">
            @csrf
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('setup-customization-checklist.new-checklist-periode_language') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ __('setup-customization-checklist.name8_language') }}</label>
                        <input class="form-control" name="periode_name" placeholder="{{ __('setup-customization-checklist.name9_language') }}" required autofocus>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-info btn-sm text-light" style="font-weight:bold; font-size:15px" data-dismiss="modal">{{ __('setup-customization-checklist.close4_language') }}</a>
                    <button type="submit" class="btn btn-sm btn-success">{{ __('setup-customization-checklist.save4_language') }}</button>
                </div>
            </form>

            </div>
        </div>
    </div>
     <div class="modal fade" tabindex="-1" id="removeData" role="dialog" aria-labelledby="warning">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">{{ __('setup-customization-checklist.checklist2_language') }}</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body form-remove-data">
                    <div class="form-group">
                        <label >{{ __('setup-customization-checklist.name-checklist_language') }}</label>
                        <input type="text" class="form-control" name="name" readonly style="background-color: #e9ecef !important">
                    </div>
                    <hr>
                    
                    <div class="text-center">
                        <h5>{{ __('setup-customization-checklist.message-checklist_language') }}</h5>
                        <h5>{{ __('setup-customization-checklist.name-continue_language') }}</h5>
                    </div>
                    <hr>
                    <br>
                    
                    <div class="modal-footer justify-content-between">
                        <a href="#" type="button" class="btn btn-info btn-sm text-light" data-dismiss="modal" style="font-weight:bold; font-size:15px">{{ __('setup-customization-checklist.cancel_language') }}</a>
                        <a href="#" class="btn btn-sm btn-danger btn-remove-user">{{ __('setup-customization-checklist.delete_language') }}</a>
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
    
    $(document).ready(function(){
        //1 november 2021 inittable buat infinite loop
       // initTable(param) 
        
        $(document).on('change', '.select_region', function(e){
            e.preventDefault();
            param.id_region = $(this).val();
            initTable(param);
        });
        
        $(document).on('change', '.select_periode', function(e){
            e.preventDefault();
            param.checklist_periode = $(this).val();
            initTable(param);
        });
        $(document).on('change', '.select_category', function(e){
            e.preventDefault();
            param.id_checklist_category = $(this).val();
            initTable(param);
        });
        
        $(document).on('click', '.checklist_name', function(e){
            e.preventDefault();
            var ini = $(this),
                id = ini.data('id');
            
            var e_modal_wait = $("#modalWait");
                showLoading(e_modal_wait);
            $.ajax({
                url: '/setup/Customization/2/getChecklist',
                type: "get",
                data: {
                        id_checklist: id
                      }
            })
            .done(function (result) {
                hideLoading(e_modal_wait);
                if(result.data[0]){
                    var data = result.data[0],
                        form = $('.form-update-data');
                        form.find("select[name=id_periode]").val(data.checklist_periode).trigger('change');
                        form.find("select[name=id_checklist_category]").val(data.id_checklist_category).trigger('change');
                        form.find("select[name=id_region]").val(data.id_region).trigger('change');
                        form.find("input[name=checklist_name]").val(data.checklist_name);
                        form.find("input[name=id_checklist]").val(data.id_checklist);
                        form.find("input[name=position]").val(data.position);
                        $('#updateModal').modal('show');
                }else{
                    var message = result.message || 'Not found!';
                    failedAlert(message);
                }
            })
            .fail(ajax_fail);
        });
    });

    $(document).on('click', '.filterModals', function(e){
            e.preventDefault();
            // param.id_checklist_category = $(this).val();
            initTable(param);
        });
        
    function initTable(param){
        var table = $('#data_table').DataTable( {
            "destroy": true,
            "bDestroy": true,
            "ajax": {
                "url":"/setup/Customization/2/getChecklist",
                "data": param
            },
            "columns": [
                { "data": "id_checklist" },
                { "data": "position" },
                { "data": "id_checklist" },
                { "data": "checklist_name" },
                { "data": "category_name" },
                { "data": "periode_name" },
                { "data": "region_name" },
            ],
            "columnDefs": [
                {
                    "targets" : 3,
                    "data": "id_checklist",
                    "render" : function (data, type, row) {
                       return '<a href="#" class="checklist_name" data-id="'+row.id_checklist+'">'+row.checklist_name+'</a>';
                    }
                },
                {
                    "targets" : 0,
                    "data": "id_checklist",
                    "render" : function (data, type, row) {
                       return '<a href="#" class="btn btn-md btn-danger btn-delete-user" data-id="'+row.id_checklist+'" data-name="'+row.checklist_name+'"><i class="fa fa-trash"></i></a>';
                    }
                },
            ],
            "order": [[1, 'desc']]
        });
    }
</script>
@endpush

@push('scripts')
<script>
    $('.select2').select2();
    $('#data_table').DataTable();
    $(document).on('click', '.btn-delete-user', function(e){
        var init = $(this),
            id = init.data('id'),
            name = init.data('name');
            
            console.log(id);
            console.log(name);
           
        mod = $('#removeData');
        form = $('.form-remove-data');
        form.find('input[name=name]').val(name);
        form.find('.btn-remove-user').attr('href', '/setup/Customization/2/delete_checklist/'+id);
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
                initTable(param);
            }else{
                var message = result.message || 'Not found!';
                failedAlert(message);
            }
        })
        .fail(ajax_fail);
    });
    var params = {}
    $(document).ready(function() {
        // initTable(params);
        
        $(document).on('change', '.select_role', function(e){
            e.preventDefault();
            var ini = $(this);
            params.id_role = ini.val();
            document.location.href='?id_role='+ini.val();
            // initTable(params);
        });
    });
   
</script>
@endpush


