@extends('template.default')
@section('title', 'Mode')
@section('submenu')
<div class="row mb-2">
    <div class="col-sm-6">
        <h3 class="m-0 text-dark"><strong>Mode</strong></h3>
    </div>
</div>
@endsection
@section('content')

<div class="card martop-1">
    <div class="card-header">
        <h3 class="card-title">Mode</h3>
        <div class="card-tools">
            <button class="btn btn-sm btn-success btn-new-data">
                <i class="fa fa-plus"></i> New Mode
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive dataTableRow" id="dataTableRow">
            <label class="el-waiting-message">Loading your data. It may take some time..</label>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modal_new_data" role="dialog" aria-labelledby="warning">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="new_mode" class="form-new-data">
            @csrf
                <div class="modal-header">
                    <h3 class="modal-title">New Mode</h3>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Mode</label>
                        <input class="form-control" name="mode_name" placeholder="Mode" required autofocus>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" name="mode_desc" placeholder="Description" required autofocus rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-info btn-sm text-light" style="font-weight:bold; font-size:15px" data-dismiss="modal">Close</a>
                    <button type="submit" class="btn btn-sm btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modal_update_data" role="dialog" aria-labelledby="warning">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="#update" class="form-update-data">
            @csrf
                <div class="modal-header">
                    <h3 class="modal-title">Mode</h3>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Mode</label>
                        <input class="form-control" name="mode_name" placeholder="Mode" required autofocus>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" name="mode_desc" placeholder="Description" required autofocus rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-info btn-sm text-light" style="font-weight:bold; font-size:15px" data-dismiss="modal">Close</a>
                    <button type="submit" class="btn btn-sm btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
var params = {}
$(document).ready(function () {
    loadPage(params);
    
    $(document).on('click', '.btn-new-data', function(e){
        e.preventDefault();
        $('#modal_new_data').modal('show');
    });
    
    $(document).on('click', '.mode_name', function(e){
        e.preventDefault();
        
        var ini = $(this);
            tr = ini.parents('tr'),
            id = tr.find('.id_mode').html(),
            mdl = $('#modal_update_data');
        
        if($.isNumeric(id)) {
            mdl.modal('show');
            form = $('.form-update-data');
            form.attr('action', 'update_mode/'+id);
            var e_modal_wait = $("#modalWait");
            showLoading(e_modal_wait);
            $.ajax({
                url: '/api/getMode',
                type: "get",
                data: {
                        id: id
                      }
            })
            .done(function (result) {
                hideLoading(e_modal_wait);
                if(result.data[0]){
                    var data = result.data[0],
                        form = $('.form-update-data');
                        form.find("input[name=mode_name]").val(data.mode_name);
                        form.find("textarea[name=mode_desc]").val(data.mode_desc);
                }else{
                    var message = result.message || 'Not found!';
                    failedAlert(message);
                }
            })
            .fail(ajax_fail);
        }
    });
    $(document).on('submit', '.form-new-data', function(e){
        e.preventDefault();
        $('#modal_new_data').modal('hide');
        var e_modal_wait = $("#modalWait");
        showLoading(e_modal_wait);
        
        var ini = $(this),  input_token = ini.find('input[name=_token]'),   url = ini.attr('action');
        
        var post_data = {
            is_ajax: true,
            _token: input_token.val(),
            mode_name: ini.find("input[name=mode_name]").val(),
            mode_desc: ini.find("textarea[name=mode_desc]").val(),
        };
        
        postData(post_data);
        function postData(post_data) {
            $.ajax({
                url: url,
                type: "post",
                data: post_data
            })
            .done(function (result) {
                hideLoading(e_modal_wait);
                input_token.val(result.newtoken);
                if (result.status) {
                    var message = result.message || 'Success';
                    successAlert(message);
                    
                    ini.find("textarea[name=mode_desc]").val(null);
                    ini.find("input[name=mode_name]").val(null);
                    
                    loadPage(params);
                } else {
                    var message = result.message || 'Api connection problem';
                    failedAlert(message);
                }
                input_token.val(result.newtoken);
            })
            .fail(ajax_fail);
        }
    });
    
    
    $(document).on('submit', '.form-update-data', function(e){
        e.preventDefault();
        $('#modal_update_data').modal('hide');
        var e_modal_wait = $("#modalWait");
        showLoading(e_modal_wait);
        
        var ini = $(this),  input_token = ini.find('input[name=_token]'),   url = ini.attr('action');
        
        var post_data = {
            is_ajax: true,
            _token: input_token.val(),
            mode_name: ini.find("input[name=mode_name]").val(),
            mode_desc: ini.find("textarea[name=mode_desc]").val(),
        };
        
        postData(post_data);
        function postData(post_data) {
            $.ajax({
                url: url,
                type: "post",
                data: post_data
            })
            .done(function (result) {
                hideLoading(e_modal_wait);
                input_token.val(result.newtoken);
                if (result.status) {
                    var message = result.message || 'Success';
                    successAlert(message);
                    loadPage(params);
                } else {
                    var message = result.message || 'Api connection problem';
                    failedAlert(message);
                }
                input_token.val(result.newtoken);
            })
            .fail(ajax_fail);
        }
    });
});
    
function loadPage(param) {
    // var row_filter_to = $('#tmp_row_filter_wrapper');
    var table = loadThisTable(param);
        url = table.url;
        param = table.param;
        th = table.th;
        col_def = table.col_def;
        columns = table.columns;
            
        loadTable(url, param, th, col_def, columns);
}
    
function loadThisTable(param){
    param = param;
    url = "/api/getMode";
    th = '<th width="5%">ID</th>' +
         '<th class="text-dark cursor-default">Mode</th>' +
         '<th>Desc</th>'+
         '<th>CreatedBy</th>'+
         '<th>LastUpdateBy</th>';
    columns = [
                {"data": "id_mode", className: "id_mode"},
                {"data": "mode_name", className: "mode_name text-link"},
                {"data": "mode_desc"},
                {"data": "created_by_name"},
                {"data": "updated_by_name"},
              ];

    col_def = [];   

    table = {
                "url" : url,
                "param" : param,
                "th" : th,
                "col_def" : col_def,
                "columns" : columns,
               }
    return table;
}
</script>
@endsection

