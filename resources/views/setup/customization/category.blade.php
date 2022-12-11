@extends('setup.customization.customization')
@section('customization')
@if(Session::has('message'))
<div class="alert {{Session::get('alert-class')}} alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
    {{ Session::get('message') }}
</div>
@endif

<link href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<style>
    td.details-control {
        background: url('/images/details_open.png') no-repeat center center;
        cursor: pointer;
    }
    tr.shown td.details-control {
        background: url('/images/details_close.png') no-repeat center center;
    }
    td.sub-details-control {
        background: url('/images/details_open.png') no-repeat center center;
        cursor: pointer;
    }
    tr.shown td.sub-details-control {
        background: url('/images/details_close.png') no-repeat center center;
    }
</style>
<?php 
$id_type = isset($id_type)?$id_type:'';
$path = "setup/Customization/$id_type";
?>
<div  class="content_header">
    <div class="content_menu">
        <h4 class="title_2">{{ __('setup-customization-category.category_language') }}</h4>
        <button type="button" style="margin-bottom: 10px" class="btn btn-sm btn-primary" data-toggle="modal"
            data-target="#newCategory">{{ __('setup-customization-category.new-category_language') }}
        </button>
        @if($id_type != 3)
        <button type="button" style="margin-bottom: 10px" class="btn btn-sm btn-primary" data-toggle="modal"
            data-target="#subCategory">{{ __('setup-customization-category.new-sub-category_language') }}
        </button>
        @endif
        
        @if($id_type != 3)
        <button type="button" style="margin-bottom: 10px" class="btn btn-sm btn-primary" data-toggle="modal"
            data-target="#newItem">{{ __('setup-customization-category.new-item_language') }}
        </button>
         @endif
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <table id="table_category" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width: 52px !important"></th>
                            <th ></th>
                            <th>{{ __('setup-customization-category.category-name_language') }}</th>
                            <th>{{ __('setup-customization-category.desc_language') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="newCategory" role="dialog" aria-labelledby="warning">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="new_category" class="form-new-data">
                @csrf
                    <div class="modal-header">
                        <h3 class="modal-title">{{ __('setup-customization-category.new-category2_language') }}</h3>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>{{ __('setup-customization-category.category2_language') }}</label>
                            <input class="form-control" name="category_name" placeholder="{{ __('setup-customization-category.category3_language') }}" required autofocus>
                        </div>
                        <div class="form-group">
                            <label>{{ __('setup-customization-category.desc2_language') }}</label>
                            <textarea class="form-control" name="category_desc" placeholder="{{ __('setup-customization-category.desc3_language') }}" required autofocus rows="2"></textarea>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" style="color: #fff; background: #CECECE" data-dismiss="modal" style="font-weight:bold; font-size:15px">{{ __('setup-customization-category.cancel_language') }}</button>
                            <button type="submit" class="btn btn-primary" style="width: 70px;">{{ __('setup-customization-category.save_language') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="categoryModalEdit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('setup-customization-category.edit-category_language') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/{{$path}}/update_category" method="POST" enctype="multipart/form-data" class="form-update-category">
                        {{csrf_field()}}
                        <div class="form-group">
                            <input name="id" hidden>
                            <label>{{ __('setup-customization-category.category4_language') }}</label>
                            <input class="form-control" name="category_name" placeholder="{{ __('setup-customization-category.category5_language') }}" required autofocus>
                        </div>
                        <div class="form-group">
                            <label>{{ __('setup-customization-category.desc4_language') }}</label>
                            <textarea class="form-control" name="category_desc" placeholder="{{ __('setup-customization-category.desc5_language') }}" required autofocus rows="2"></textarea>
                        </div>
                        <div class="modal-footer justify-content-start">
                            <button type="submit" class="btn btn-primary" style="width: 70px;">{{ __('setup-customization-category.save2_language') }}</button>
                            <button type="button" class="btn btn-default" style="color: #fff; background: #CECECE">{{ __('setup-customization-category.cancel2_language') }}</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="subCategory">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="new_sub_category" class="form-new-data">
                @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">{{ __('setup-customization-category.new-sub-category2_language') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>{{ __('setup-customization-category.category6_language') }}</label>
                            <select class="form-control searchCategory id_category" name="id_category" required autofocus></select>
                        </div>
                        <div class="form-group">
                            <label>{{ __('setup-customization-category.sub-category_language') }}</label>
                            <input class="form-control" name="sub_category_name" placeholder="{{ __('setup-customization-category.category7_language') }}" required autofocus>
                        </div>
                        <div class="form-group">
                            <label>{{ __('setup-customization-category.desc6_language') }}</label>
                            <textarea class="form-control" name="sub_category_desc" placeholder="{{ __('setup-customization-category.desc7_language') }}" required autofocus rows="2"></textarea>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" style="color: #fff; background: #CECECE" data-dismiss="modal" style="font-weight:bold; font-size:15px">{{ __('setup-customization-category.cancel3_language') }}</button>
                            <button type="submit" class="btn btn-primary" style="width: 70px;">{{ __('setup-customization-category.save3_language') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="subCategoryModalEdit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('setup-customization-category.edit-sub-category_language') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/{{$path}}/update_sub_category" method="POST" enctype="multipart/form-data" class="form-update-sub-category">
                        {{csrf_field()}}
                        <div class="form-group">
                            <input name="id" hidden>
                                <label>{{ __('setup-customization-category.category8_language') }}</label>
                            <select id="sel_cat_sub_update" class="form-control searchCategory id_category" name="id_category" required autofocus></select>
                        </div>
                        <div class="form-group">
                            <label>{{ __('setup-customization-category.sub-category2_language') }}</label>
                            <input class="form-control" name="sub_category_name" placeholder="{{ __('setup-customization-category.category9_language') }}" required autofocus>
                        </div>
                        <div class="form-group">
                            <label>{{ __('setup-customization-category.desc8_language') }}</label>
                            <textarea class="form-control" name="sub_category_desc" placeholder="{{ __('setup-customization-category.desc9_language') }}" required autofocus rows="2"></textarea>
                        </div>
                        <div class="modal-footer justify-content-start">
                            <button type="submit" class="btn btn-primary" style="width: 70px;">{{ __('setup-customization-category.save4_language') }}</button>
                            <button type="button" class="btn btn-default" style="color: #fff; background: #CECECE">{{ __('setup-customization-category.cancel4_language') }}</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="newItem">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('setup-customization-category.new-item2_language') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="new_item" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="item_name" class="text_name">{{ __('setup-customization-category.item_name_language') }}</label>
                            <input name="item_name" type="text" value="{{ old('item_name') }}"
                                class="placeholder_color form-control @error('item_name') is-invalid invalid @enderror"
                                id="item_name" aria-describedby="namaHelp" placeholder="{{ __('setup-customization-category.name_language') }}">
                            @error('item_name')
                            <span class="invalid" style="color: red"><i>{{$message}}</i></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>{{ __('setup-customization-category.category10_language') }}</label>
                            <select class="form-control searchCategory id_category" name="id_category" required autofocus></select>
                        </div>
                        <div class="form-group">
                            <label>{{ __('setup-customization-category.sub-category3_language') }}</label>
                            <select class="form-control searchSubCat id_category" name="id_sub_category" required autofocus></select>
                        </div>
                        <div class="form-group">
                            <label for="description" class="text_name form-control-label">{{ __('setup-customization-category.desc10_language') }}</label>
                            <textarea name="description" class="form-control @error('address') is-invalid invalid @enderror" id="description" rows="3" placeholder="{{ __('setup-customization-category.place-your-address_language') }}">{{ old('description') }}</textarea>
                            @error('description')
                            <span class="invalid" style="color: red"><i>{{$message}}</i></span>
                            @enderror
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" style="color: #fff; background: #CECECE" data-dismiss="modal" style="font-weight:bold; font-size:15px">{{ __('setup-customization-category.cancel5_language') }}</button>
                            <button type="submit" class="btn btn-primary" style="width: 70px;">{{ __('setup-customization-category.save5_language') }}</button>
                        </div>
                        <!--<div class="modal-footer justify-content-start">-->
                        <!--    <button type="submit" class="btn btn-primary" style="width: 70px; margin-right: 35px;">Save</button>-->
                        <!--    <button type="submit" class="btn btn-primary">Save and Add Item</button>-->
                        <!--    <button type="button" class="btn btn-default"-->
                        <!--        style="color: #fff; background: #CECECE; margin-left: 35px" data-dismiss="modal" >Cancle</button>-->
                        <!--</div>-->
                    </form>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="itemModalEdit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('setup-customization-category.edit-item_language') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/{{$path}}/update_item" method="POST" enctype="multipart/form-data" class="form-update-item">
                        {{csrf_field()}}
                        <div class="form-group">
                            <input name="id" hidden>
                            <label for="item_name" class="text_name">{{ __('setup-customization-category.item_name2_language') }}</label>
                            <input name="item_name" type="text" value="{{ old('item_name') }}"
                                class="placeholder_color form-control @error('item_name') is-invalid invalid @enderror"
                                id="item_name" aria-describedby="namaHelp" placeholder="{{ __('setup-customization-category.name2_language') }}">
                            @error('item_name')
                            <span class="invalid" style="color: red"><i>{{$message}}</i></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>{{ __('setup-customization-category.category10_language') }}</label>
                            <select id="sel_cat_item_update" class="form-control searchCategory id_category" name="id_category" required autofocus></select>
                        </div>
                        <div class="form-group">
                            <label>{{ __('setup-customization-category.sub-category4_language') }}</label>
                            <select id="sel_sub_item_update" class="form-control searchSubCat id_category" name="id_sub_category" required autofocus></select>
                        </div>
                        <div class="form-group">
                            <label for="description" class="text_name form-control-label">{{ __('setup-customization-category.desc11_language') }}</label>
                            <textarea name="description" class="form-control @error('address') is-invalid invalid @enderror" id="description" rows="3" placeholder="{{ __('setup-customization-category.place-your-address2_language') }}">{{ old('description') }}</textarea>
                            @error('description')
                            <span class="invalid" style="color: red"><i>{{$message}}</i></span>
                            @enderror
                        </div>
                        <div class="modal-footer justify-content-start">
                            <button type="submit" class="btn btn-primary" style="width: 70px;">{{ __('setup-customization-category.save6_language') }}</button>
                            <button type="button" class="btn btn-default" style="color: #fff; background: #CECECE">{{ __('setup-customization-category.cancel6_language') }}</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!--form buat deleete-->
    <div class="modal fade" tabindex="-1" id="removeData" role="dialog" aria-labelledby="warning">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">{{ __('setup-customization-category.category11_language') }}</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body form-remove-data">
                    <div class="form-group">
                        <label >{{ __('setup-customization-category.name-category_language') }}</label>
                        <input type="text" class="form-control" name="name" readonly style="background-color: #e9ecef !important">
                    </div>
                    <hr>
                    
                    <div class="text-center">
                        <h5>{{ __('setup-customization-category.message_language') }}</h5>
                        <h5>{{ __('setup-customization-category.continue_language') }}</h5>
                    </div>
                    <hr>
                    <br>
                    
                    <div class="modal-footer justify-content-between">
                        <a href="#" type="button" class="btn btn-default" style="color: #fff; background: #CECECE" data-dismiss="modal" style="font-weight:bold; font-size:15px">{{ __('setup-customization-category.cancel7_language') }}</a>
                        <a href="#" class="btn btn-danger btn-remove-user" style="width: 70px;">{{ __('setup-customization-category.delete_language') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function(){
       
        $(document).on('click', '.id_category_click', function(e){
            e.preventDefault();
            var ini = $(this),
                id = ini.data('id_category');
        
            form = $('.form-update-category');
            if($.isNumeric(id)) {
                var e_modal_wait = $("#modalWait");
                showLoading(e_modal_wait);
                $.ajax({
                    url: '/{{$path}}/getCategory',
                    type: "get",
                    data: {
                            id: id
                          }
                })
                .done(function (result) {
                    hideLoading(e_modal_wait);
                    if(result.data[0]){
                        data = result.data[0];
                        form.find('input[name=id]').val(data.id_category);
                        form.find('input[name=category_name]').val(data.category_name);
                        form.find('textarea[name=category_desc]').val(data.category_desc);
                        $('#categoryModalEdit').modal('show');
                    
                    }else{
                        var message = result.message || 'Not found!';
                        failedAlert(message);
                    }
                })
                .fail(ajax_fail);
            }
        });
        
        $(document).on('click', '.id_sub_category_click', function(e){
            e.preventDefault();
            var ini = $(this),
                id = ini.data('id_sub_category');
            
            form = $('.form-update-sub-category');
            if($.isNumeric(id)) {
                var e_modal_wait = $("#modalWait");
                showLoading(e_modal_wait);
                $.ajax({
                    url: '/{{$path}}/getSubCategory',
                    type: "get",
                    data: {
                            id: id
                          }
                })
                .done(function (result) {
                    hideLoading(e_modal_wait);
                    if(result.data[0]){
                        data = result.data[0];
                        form.find('input[name=id]').val(data.id_sub_category);
                        form.find('input[name=sub_category_name]').val(data.sub_category_name);
                        form.find('textarea[name=sub_category_desc]').val(data.sub_category_desc);
                        
                        var $cat = $("<option selected='selected'></option>").val(data.id_category).text(data.category_name)
                        $("#sel_cat_sub_update").append($cat).trigger('change');
                        
                        $('#subCategoryModalEdit').modal('show');
                    
                    }else{
                        var message = result.message || 'Not found!';
                        failedAlert(message);
                    }
                })
                .fail(ajax_fail);
            }
        });
        
        $(document).on('click', '.id_item_click', function(e){
            e.preventDefault();
            var ini = $(this),
                id = ini.data('id_item');
            
            form = $('.form-update-item');
            if($.isNumeric(id)) {
                var e_modal_wait = $("#modalWait");
                showLoading(e_modal_wait);
                $.ajax({
                    url: '/{{$path}}/getItem',
                    type: "get",
                    data: {
                            id: id
                          }
                })
                .done(function (result) {
                    hideLoading(e_modal_wait);
                    if(result.data[0]){
                        data = result.data[0];
                        form.find('input[name=id]').val(data.id_item);
                        form.find('input[name=item_name]').val(data.item_name);
                        form.find('textarea[name=description]').val(data.item_desc);
                        
                        var $cat = $("<option selected='selected'></option>").val(data.id_category).text(data.category_name)
                        $("#sel_cat_item_update").append($cat).trigger('change');
                        
                        var $sub = $("<option selected='selected'></option>").val(data.id_sub_category).text(data.sub_category_name)
                        $("#sel_sub_item_update").append($sub).trigger('change');
                        
                        $('#itemModalEdit').modal('show');
                    
                    }else{
                        var message = result.message || 'Not found!';
                        failedAlert(message);
                    }
                })
                .fail(ajax_fail);
            }
        });
       
    });
</script>
<script>
    function setItem(d) {
        var table = '<table id="table_item'+d.id_sub_category+'" class="display table_item" style="width:100%">' +
                        '<thead>' +
                            '<tr>' +
                                '<th></th>' +
                                '<th>{{ __('setup-customization-category.item_language') }}</th>' +
                                '<th>{{ __('setup-customization-category.desc12_language') }}</th>' +
                            '</tr>' +
                        '</thead>' +
                    '</table>';
        var card = '<div class="card">'+
                        '<div class="card-body">' +
                            table +
                        '</div' +
                    '</div>';
        return card;
    }
    function setSubCategory(d) {
        var table = '<table id="table_sub_category'+d.id_category+'" class="display table_sub_category" style="width:100%">' +
                        '<thead>' +
                            '<tr>' +
                                '<th></th>' +
                                '<th>{{ __('setup-customization-category.sub-category5_language') }}</th>' +
                                '<th>{{ __('setup-customization-category.desc13_language') }}</th>' +
                            '</tr>' +
                        '</thead>' +
                    '</table>';
        var card = '<div class="card">'+
                        '<div class="card-body">' +
                            table +
                        '</div' +
                    '</div>';
        return card;
    }
     
    $(document).ready(function() {
        initCategory();
    });
    function initCategory(){
        var table = $('#table_category').DataTable( {
            "ajax": "getCategory",
            "columns": [
                {
                    "className":      '',
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ''
                },
                {
                    "className":      'details-control',
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ''
                },
                { "data": "category_name" },
                { "data": "category_desc" }
            ],
            "createdRow": function (row, data, dataIndex) {
                $(row).attr('data-id_category', data.id_catgory);
            },
            "columnDefs": [
                {
                    "targets" : 2,
                    "data": "id_category",
                    "render" : function (data, type, row) {
                       return '<a href="#" class="id_category_click" data-id_category="'+row.id_category+'">'+row.category_name+'</a>';
                    }
                },
                {
                    "targets" : 0,
                    "data": "id_category",
                    "render" : function (data, type, row) {
                       return '<a style="width: 52px !important" href="#" class="btn btn-md btn-danger btn-delete-user" data-id="'+row.id_category+'" data-name="'+row.category_name+'"><i class="fa fa-trash"></i></a>';
                    }
                },
            ],
            "order": [[2, 'asc']]
        });
         
        // Add event listener for opening and closing details
        $('#table_category tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row( tr );
     
            if ( row.child.isShown() ) {
                row.child.hide();
                tr.removeClass('shown');
            }else {
                row.child( setSubCategory(row.data()) ).show();
                tr.addClass('shown');
                initSubCategory(row.data());
            }
        });
    }
    function initSubCategory(data){
        var table = $('#table_sub_category'+data.id_category).DataTable( {
            "ajax": {
                "url": "getSubCategory",
                "data": {
                    id_category:data.id_category
                }
            },
            "columns": [
                {
                    "className":      'sub-details-control',
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ''
                },
                { "data": "sub_category_name" },
                { "data": "sub_category_desc" }
            ],
            "createdRow": function (row, data, dataIndex) {
                $(row).attr('data-id_sub_category', data.id_sub_category);
            },
            "columnDefs": [
                {
                    "targets" : 1,
                    "data": "id_sub_category",
                    "render" : function (data, type, row) {
                       return '<a href="#" class="id_sub_category_click" data-id_sub_category="'+row.id_sub_category+'">'+row.sub_category_name+'</a>';
                    }
                },
            ],
            "order": [[1, 'asc']],
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": false,
            "bSort": true,
            "bInfo": false,
        });
         
        // Add event listener for opening and closing details
        $('.table_sub_category tbody').on('click', 'td.sub-details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row( tr );
     
            if ( row.child.isShown() ) {
                row.child.hide();
                tr.removeClass('shown');
            }else {
                row.child( setItem(row.data()) ).show();
                tr.addClass('shown');
                initItem(row.data());
            }
        });
    }
    function initItem(data){
        var table = $('#table_item'+data.id_sub_category).DataTable( {
            "ajax": {
                "url": "getItem",
                "data": {
                    id_category:data.id_category,
                    id_sub_category:data.id_sub_category
                }
            },
            "columns": [
                {
                    "className":      'item-details-control',
                    "orderable":      false,
                    "data":           'id_item',
                    "defaultContent": ''
                },
                { "data": "item_name" },
                { "data": "item_desc" }
            ],
            "columnDefs": [
                {
                    "targets" : 0,
                    "data": "id_item",
                    "render" : function (data, type, row) {
                       return '<a href="#" style="color: #828282"><i class="fas fa-cog"></i></a>';
                    }
                },
                {
                    "targets" : 1,
                    "data": "id_item",
                    "render" : function (data, type, row) {
                       return '<a href="#" class="id_item_click" data-id_item="'+row.id_item+'">'+row.item_name+'</a>';
                    }
                },
            ],
            "createdRow": function (row, data, dataIndex) {
                $(row).attr('data-id_item', data.id_item);
            },
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": false,
            "bSort": true,
            "bInfo": false,
            "order": [[1, 'asc']]
        });
         
        // Add event listener for opening and closing details
        // $('#table_item tbody').on('click', 'td.item-details-control', function () {
        //     var tr = $(this).closest('tr');
        //     var row = table.row( tr );
     
        //     if ( row.child.isShown() ) {
        //         row.child.hide();
        //         tr.removeClass('shown');
        //     }else {
        //         row.child( setItem(row.data()) ).show();
        //         tr.addClass('shown');
        //         initItem();
        //     }
        // });
    }
</script>
<script>
    $('.select2').select2();
    $(".searchCategory").select2({
        placeholder: "{{ __('setup-customization-category.select-category_language') }}",
        ajax: {
            url: "getCategory",
            dataType: "json",
            data:{
            },
            delay: 250,
            processResults: function (data) {
                data = data.data;
                return {
                    results: $.map(data, function (item) {
                            return {
                                text: item.category_name,
                                id: item.id_category
                            };
                    })
                };
            },
            cache: false
        }
    }).on('change', function (e) {
        setSelectSubCategori($(this).val())
    })
    // $(".searchSubCat").select2({
    //     placeholder: "Select Sub Category",
    //     ajax: {
    //         url: "getSubCategory",
    //         dataType: "json",
    //         data:{id :  29
    //         },
    //         delay: 250,
    //         processResults: function (data) {
    //              console.log(data)
    //             data = data.data;
                
               
    //             return {
    //                 results: $.map(data, function (item) {
    //                         return {
    //                             text: item.sub_category_name,
    //                             id: item.id_sub_category
    //                         };
    //                 })
    //             };
    //         },
    //         cache: false
    //     }
    // }).on('change', function (e) {
        
    //      id = $(this).val();
    //      setSelectSubCategori(id)

    // })
    function setSelectSubCategori(id_categori){
            $(".searchSubCat").val('');
            $(".searchSubCat").select2({
                placeholder: "Site",
            ajax: {
                url: "getSubCategory",
                data: {
                    'id_category': id_categori
                },
                dataType: "json",
                delay: 250,
                processResults: function (data) {
                    return {
                        results: $.map(data.data, function (item) {
                            return {
                               text: item.sub_category_name,
                                id: item.id_sub_category
                            };
                        })
                    };
                },
                cache: false
            }
            })
        }
    
     $(document).on('click', '.btn-delete-user', function(e){
        var init = $(this),
            id = init.data('id'),
            name = init.data('name');
            
            console.log(id);
            console.log(name);
           
        mod = $('#removeData');
        form = $('.form-remove-data');
        form.find('input[name=name]').val(name);
        form.find('.btn-remove-user').attr('href', '/setup/Customization/2/delete_category/'+id);
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
                window.location.reload();
            }else{
                var message = result.message || 'Not found!';
                failedAlert(message);
            }
        })
        .fail(ajax_fail);
    });
    
</script>
@endpush

