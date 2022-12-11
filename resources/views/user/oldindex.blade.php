@extends('template.default')
@section('submenu')
<div class="row mb-2">
    <div class="col-sm-6">
        <h3 class="m-0 text-dark"><strong>Users</strong></h3>
    </div>
</div>
@endsection
@section('content')

<div class="card martop-1">
    <div class="card-header">
        <div class="row">
            <div class="col-md-1">
                <h3 class="card-title">Users</h3>
            </div>
            <div class="col-md-2">
                <!--<select class="form-control form-control-sm" id="data_table_length_change">-->
                <!--    <option value="1">1</option>-->
                <!--    <option value="3">3</option>-->
                <!--    <option value="5">5</option>-->
                <!--    <option value="10">10</option>-->
                <!--    <option value="25">25</option>-->
                <!--    <option value="50">50</option>-->
                <!--    <option value="100">100</option>-->
                <!--    <option value="200">200</option>-->
                <!--</select>-->
            </div>
            <div class="col-md-2">
                <!--<input type="text" id="data_table_search" class="form-control form-control-sm" placeholder="Search" autocomplete="off">-->
            </div>
        </div>
        
    </div>
    <div class="card-body">
        <div class="table-responsive dataTableRow" id="dataTableRow">
            <label class="el-waiting-message">Loading your data. It may take some time..</label>
        </div>
    </div>
</div>


<script>
var params = {}
$(document).ready(function () {
    loadPage(params);
    $('#data_table_search').on('change', function(e){
        e.preventDefault()
        params.name = $(this).val();
        loadPage(params);
    })
    // $('#data_table_length_change').on('change', function(e){
    //     e.preventDefault()
    //     params.length = $(this).val();
    //     loadPage(params);
    // })
});
    
function loadPage(param) {
    var row_filter_to = $('#tmp_row_filter_wrapper');
    var table = loadThisTable(param);
        url = table.url;
        param = table.param;
        th = table.th;
        col_def = table.col_def;
        columns = table.columns;
            
        loadTable(url, param, th, col_def, columns, row_filter_to);
}
    
function loadThisTable(param){
    param = param;
    url = "/getUsers";
    th = '<th width="5%">ID</th>' +
         '<th class="text-dark cursor-default">Name</th>' +
         '<th>Email</th>'+
         '<th>Mobile</th>'+
         '<th>Telpone</th>';
    columns = [
                {"data": "id", className: "user_id"},
                {"data": "name", className: "user_name text-link"},
                {"data": "email"},
                {"data": "mobile"},
                {"data": "telpone"},
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




