@extends('template.default')
@section('title', 'Site Permit')
@section('submenu')
 
@endsection
@section('content')
@if(Session::has('message'))
    <div class="alert {{Session::get('alert-class')}} alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        {{ Session::get('message') }}
    </div>
@endif

<style>
    table.dataTable tbody th, table.dataTable tbody td {
    padding: 0px 0px !important;
    padding-top: 0px !important;
    padding-bottom: 0px !important;
    }
    .content-wrapper>.content {
    padding: 0rem;
    }
    .container-fluid {
    width: 100%;
    padding-right: 0px;
    padding-left: 0px;
    margin-right: auto;
    margin-left: auto;
    }
    .card-header {
    background-color: transparent;
    border-bottom: 0px;
    padding: .3rem 1.25rem 0rem 1.25rem;
    position: relative;
    border-top-left-radius: .25rem;
    border-top-right-radius: .25rem;
    }
    .row {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    margin-right: 0px;
    margin-left: 0px;
    }
    .card-body {
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    padding: 0rem 1.25rem 1.25rem 1.25rem;
    }
    
</style>

<div class="card">
    <!-- section row 4
    <div class="row mb-2">
    <div class="col-sm-6">
        <h3 class="m-0 text-dark"><strong>Site Permit</strong></h3>
        <small>Site Permit</small>
    </div>
</div>
    -->
    
    <!-- /.card-header -->
    <div class="card-header">
        <h3 class="card-title"> <strong>{{ __('sidebar-site-permit-index1.lists_language') }}</strong></h3>
    </div>
    {{-- card body --}}
    <div class="card-body">
        <div class="row">
            <div class="col-md-2 form-group">
                <button type="button" class="form-control bg-primary" data-toggle="modal" data-target="#createModal">
                    <i class="fa fa-plus nav-icon"></i>&nbsp;&nbsp;{{ __('sidebar-site-permit-index1.create_language') }}
                </button>
            </div>
            <div class="col-md-2 form-group">
                <select class="form-control btn-default select_site" name="site">
                    <option selected="selected" disabled value="">-- {{ __('sidebar-site-permit-index1.site_language') }} --</option>
                    @foreach(\App\Model\Site::get() as $region)
                        <option value="{{$region->site_id}}">{{$region->name_site}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 form-group">
                <select class="form-control btn-default select_region" name="region">
                    <option selected="selected" disabled value="">-- {{ __('sidebar-site-permit-index1.region_language') }} --</option>
                    @foreach(\App\Model\Region::get() as $region)
                        <option value="{{$region->region_id}}">{{$region->region_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 form-group">
                <select class="form-control btn-default select_type">
                    <option value="site-entry">-- {{ __('sidebar-site-permit-index1.site-entry_language') }} --</option>
                    <option value="permit-letter">-- {{ __('sidebar-site-permit-index1.permit-letter_language') }} --</option>
                </select>
            </div>
            <div class="col-md-1 form-group">
                <!--<button type="button" class="form-control btn-default btn-refresh" style="color: #828282">-->
                <!--    <i class="fas fa-redo-alt"></i>&nbsp;&nbsp; Refresh-->
                <!--</button>-->
            </div>
            <div class="col-md-3 form-group">
                <span class="icon"><i class="fas fa-search"></i></span>
                <input class="form-control btn-default" id="search" type="text" placeholder="{{ __('sidebar-site-permit-index1.search_language') }}" aria-label="Search">
            </div>
        </div>
        <div class="site_permit_table">
            
        </div>
    </div>
</div>

 <div class="modal fade" tabindex="-1" id="removeData" role="dialog" aria-labelledby="warning">
        
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Site Entry</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body form-remove-data">
                    <div class="form-group">
                        <label >ID SiteEntry</label>
                        <input type="text" class="form-control" name="name" readonly style="background-color: #e9ecef !important">
                    </div>
                    <hr>
                    
                    <div class="text-center">
                        <h5>Site entry akan dihapus secara permanen</h5>
                        <h5>Lanjutkan ? </h5>
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
<!-- /.card -->
<div class="modal fade" id="createModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('sidebar-site-permit-index1.add_language') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="createTask" class=" form-control-label">{{ __('sidebar-site-permit-index1.create-activity_language') }}</label>
                    <select name="createTask" class="form-control" id="createTask" onchange="document.location.href='/site-permit/'+this.value">
                        <option value="">-- {{ __('sidebar-site-permit-index1.select_language') }} --</option>
                        <option value="site-entry">{{ __('sidebar-site-permit-index1.site-entry2_language') }}</option>
                        <option value="permit-letter">{{ __('sidebar-site-permit-index1.permit-letter2_language') }}</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var param = {};
    var wrapper = $('.site_permit_table');
    var type = $('.select_type').val();
    
    var id_site = '', id_region = '', r_type='', status = ''; 
    <?php
        $id_site = request()->id_site;
        if($id_site) echo "id_site = $id_site;";
        
        $id_region = request()->id_region;
        if($id_region) echo "id_region = $id_region;";
        
        $type = request()->type;
        if($type) echo "r_type = '$type';";
        
        $status = request()->status;
        if($status) echo "status = '$status';";
    ?>
    
    function setEntry(){
        var table = '<table id="data_table" class="display data_table table-border-gray" style="width:100%">' +
                        '<thead>' +
                            '<tr>' +
                                '<th>{{ __('sidebar-site-permit-index1.id_language') }}</th>' +
                                '<th>{{ __('sidebar-site-permit-index1.name-user-id_language') }}</th>' +
                                '<th class="text-dark">{{ __('sidebar-site-permit-index1.status_language') }}</th>' +
                               
                                '<th>{{ __('sidebar-site-permit-index1.situs_language') }}</th>' +
                                '<th>{{ __('sidebar-site-permit-index1.check-in-time_language') }}</th>' +
                               '<th>{{ __('sidebar-site-permit-index1.checkout-time_language') }}</th>' +
                               
                                '<th class="text-center">{{ __('sidebar-site-permit-index1.deskripsi_language') }}</th>' +
                                 '<th class="text-center">Action</th>' +
                            '</tr>' +
                        '</thead>' +
                    '</table>';
        return table;
    }
    function setPermit(){
        var table = '<table id="data_table" class="display data_table table-border-gray" style="width:100%">' +
                        '<thead>' +
                            '<tr>' +
                                '<th>{{ __('sidebar-site-permit-index1.id2_language') }}</th>' +
                                '<th class="text-dark">{{ __('sidebar-site-permit-index1.activity-no_language') }}</th>' +
                                '<th>{{ __('sidebar-site-permit-index1.site2_language') }}</th>' +
                                '<th>{{ __('sidebar-site-permit-index1.applicant_language') }}</th>' +
                                '<th>{{ __('sidebar-site-permit-index1.date-of-filing_language') }}</th>' +
                                '<th>{{ __('sidebar-site-permit-index1.status_language') }}</th>' +
                                '<th>{{ __('sidebar-site-permit-index1.deskripsi2_language') }}</th>' +
                            '</tr>' +
                        '</thead>' +
                    '</table>';
        return table;
    }
    
    $(document).ready(function(){
        var def = true;
        if(r_type === 'permit-letter'){
            $('.select_type').val(r_type);
            type = r_type;
        }else{
            $('.select_type').val('site-entry');
            type = 'site-entry';
        }
        if(type === 'permit-letter'){
            if(id_region){
               $('.select_region').val(id_region);
               def = false;
               param.id_region = id_region;
               
               table = setPermit();
               wrapper.html(table);
               initPermit(param)
            }
            if(id_site){
               $('.select_site').val(id_site);
               def = false;
               param.id_site = id_site;
               
               table = setPermit();
               wrapper.html(table);
               initPermit(param)
            }
            if(status){
               def = false;
               param.status = status;
               
               table = setPermit();
               wrapper.html(table);
               initPermit(param)
            }
        }else{
            if(id_region){
               $('.select_region').val(id_region);
               def = false;
               param.id_region = id_region;
               
               table = setPermit();
               wrapper.html(table);
               initEntry(param)
            }
            if(id_site){
               $('.select_site').val(id_site);
               def = false;
               param.id_site = id_site;
               
               table = setPermit();
               wrapper.html(table);
               initEntry(param)
            }
            if(status){
               def = false;
               param.status = status;
               
               table = setPermit();
               wrapper.html(table);
               initEntry(param)
            }
        }
        
        if(def){
            if(type === 'permit-letter'){
                table = setPermit();
                wrapper.html(table);
                initPermit(param)
            }else{
                table = setEntry();
                wrapper.html(table);
                initEntry(param)
            }
        }
        
        $(document).on('change', '.select_site', function(e){
            e.preventDefault();
            var ini = $(this);
            param.id_site = ini.val();
            type = $('.select_type').val();
            if(type === 'permit-letter'){
                initPermit(param);
            }else{
                initEntry(param);
            }
        });
        $(document).on('change', '.select_region', function(e){
            e.preventDefault();
            var ini = $(this);
            param.id_region = ini.val();
            type = $('.select_type').val();
            if(type === 'permit-letter'){
                initPermit(param);
            }else{
                initEntry(param);
            }
        });
        $(document).on('change', '.select_type', function(e){
            e.preventDefault();
            var type = $(this).val();
            if(type === 'permit-letter'){
                table = setPermit();
                wrapper.html(table);
                initPermit(param)
            }else{
                table = setEntry();
                wrapper.html(table);
                initEntry(param)
            }
        })
    });
    
    function initEntry(param){
        var table = $('#data_table').DataTable( {
            "lengthMenu": [[20, 50, 100, 150, 200, 250, 500], [20, 50, 100, 150, 200, 250, 500]],
            "destroy": true,
            "bDestroy": true,
            "ajax": {
                "url": "/api/site-permit/getSiteEntry",
                "data": param,
                "error": function (xhr, error, thrown) {
                    ajax_fail(xhr, error);
                }
            },
            "columns": [
                { "data": "id_site_entry" },
                { "data": "personil" },
                { "data": "status" },
                { "data": "site.name_site" },
                { "data": "checkin_time" },
                 { "data": "checkout_time" },
               
                { "data": "id_site_entry" }
            ],
            "columnDefs": [
                 {
                        "targets" : 2,
                        "data": "status",
                        "render" : function (data, type, row) {
                           return '<a href="/site-permit/site-entry-detail/'+row.id_site_entry+'">'+row.status+'</a>';
                        }
                    },
                     {
                    "targets" : 7,
                    "data": "id",
                     "className": "text-center",
                     "width": "4%",
                    "render" : function (data, type, row) {
                       return '<a href="#" class="btn btn-md btn-danger btn-delete-siteEntry text-center" style="align-text:center;" data-id="'+row.id_site_entry+'" data-name="'+row.id_site_entry+'"><i class="fa fa-trash"></i></a>';
                    }
                },
                
                    {
                        "targets" : 1,
                        "data": "status",
                        "render" : function (data, type, row) {
                            var datas = row.personil_name;
                            var li = '';
                            
                            $.each(datas, function(key, val){
                                li += '<li>'+datas[key]+'</li>';
                            });
                           
                            
                            return '<ul>'+li+'</ul>';
                        }
                    },
                   
                    {
                        "targets" : 6,
                        "data": "id_site_entry",
                        "render" : function (data, type, row) {
                            if(row.approver_1_status != "APPROVED"){
                                return '<a class="btn btn-sm col-md-12 btn-transparent cursor-default" href="#">No File</a>';
                            }else if(row.approver_2_status != "APPROVED"){
                                return '<a class="btn btn-sm col-md-12 btn-transparent cursor-default" href="#">No File</a>';
                            }
                            if(row.approver_1_status == "APPROVED" && row.approver_2_status == "APPROVED"){
                                return '<a class="btn btn-sm col-md-12 btn-default" target="new" href="/site-permit/site-entry-pdf?id='+row.id_site_entry+'">DOWNLOAD</a>';
                            }
                            return '<a class="btn btn-sm col-md-12 btn-transparent cursor-default" href="#">No File</a>';
                        }
                    },
                ],
            "order": [[1, 'asc']],
            "sDom": 't<"row view-pager"<"col-sm-12"<"pull-left"i><"pull-right"p>>>',
        });
        oTable = $('#data_table').DataTable();
        $('#search').keyup(function(){
              oTable.search($(this).val()).draw() ;
        })
         $('.select2').select2();
    $('#data_table').DataTable();
    $(document).on('click', '.btn-delete-siteEntry', function(e){
        var init = $(this),
            id = init.data('id'),
            name = init.data('name');
            
            console.log(id);
            console.log(name);
           
        mod = $('#removeData');
        form = $('.form-remove-data');
        form.find('input[name=name]').val(name);
        form.find('.btn-remove-user').attr('href', '/site-permit/delete_site_entry/'+id);
        mod.modal('show');
    });
    }
    function initPermit(param){
        var table = $('#data_table').DataTable( {
            "destroy": true,
            "bDestroy": true,
            "ajax": {
                "url": "/api/site-permit/getPermitLetter",
                "data": param,
                "error": function (xhr, error, thrown) {
                    ajax_fail(xhr, error);
                }
            },
            "columns": [
                { "data": "id_permit_letter" },
                { "data": "activity_no" },
                { "data": "site.name_site" },
                { "data": "pemohon" },
                { "data": "tanggal_pengajuan" },
                { "data": "status" },
                { "data": "id_permit_letter" },
            ],
            "columnDefs": [
                    {
                        "targets" : 1,
                        "data": "id_permit_letter",
                        "render" : function (data, type, row) {
                           return '<a href="/site-permit/permit-letter-detail/'+row.id_permit_letter+'">'+row.activity_no+'</a>';
                        }
                    },
                    {
                        "targets" : 6,
                        "data": "id_permit_letter",
                        "render" : function (data, type, row) {
                           return '<a class="btn btn-sm col-md-12 btn-default" target="new" href="/site-permit/permit-letter-pdf?id='+row.id_permit_letter+'">DOWNLOAD</a>';
                        }
                    },
                ],
            "order": [[1, 'asc']],
            "sDom": 't<"row view-pager"<"col-sm-12"<"pull-left"i><"pull-right"p>>>',
        });
        oTable = $('#data_table').DataTable();
        $('#search').keyup(function(){
              oTable.search($(this).val()).draw() ;
        })
    }
</script>
@endsection
