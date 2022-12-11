@extends('template.default')
@section('title', 'Site Permit')
@section('submenu')
<div class="row mb-2">
    <!--<div class="col-sm-6">-->
    <!--    <h3 class="m-0 text-dark"><strong>Site Permit</strong></h3>-->
    <!--    <small>Site Permit</small>-->
    <!--</div>-->
</div>
@endsection
@section('content')
@if(Session::has('message'))
    <div class="alert {{Session::get('alert-class')}} alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        {{ Session::get('message') }}
    </div>
@endif
<div class="card">
    <!-- /.card-header -->
    <!--<div class="card-header">-->
    <!--    <h3 class="card-title"> <strong>Lists</strong></h3>-->
    <!--</div>-->
    {{-- card body --}}
    <div class="card-body">
        <div class="row">
            <div class="col-md-2 form-group">
                <select class="form-control btn-default select_site" name="site">
                    <option selected="selected" disabled value="">-- {{ __('sidebar-waiting_approval-site_permit-index1.site_language') }} --</option>
                    @foreach(\App\Model\Site::get() as $region)
                        <option value="{{$region->site_id}}">{{$region->name_site}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 form-group">
                <select class="form-control btn-default select_type">
                    <option value="site-entry">-- {{ __('sidebar-waiting_approval-site_permit-index1.site-entry_language') }} --</option>
                    <option value="permit-letter">-- {{ __('sidebar-waiting_approval-site_permit-index1.permit-letter_language') }} --</option>
                </select>
            </div>
            <div class="col-md-1 form-group"></div>
            <div class="col-md-2 form-group"></div>
            <div class="col-md-2 form-group">
                <button type="button" class="form-control btn-default btn-refresh" style="color: #828282">
                    <i class="fas fa-redo-alt"></i>&nbsp;&nbsp; {{ __('sidebar-waiting_approval-site_permit-index1.refresh_language') }}
                </button>
            </div>
            <div class="col-md-3 form-group">
                <span class="icon"><i class="fas fa-search"></i></span>
                <input class="form-control btn-default" id="search" type="text" placeholder="{{ __('sidebar-waiting_approval-site_permit-index1.search_language') }}" aria-label="Search">
            </div>
        </div>
        <div class="site_permit_table">
            
        </div>
    </div>
</div>

<script>
    var param = {};
    var wrapper = $('.site_permit_table');
    var type = $('.select_type').val();
    
    function setEntry(){
        var table = '<table id="data_table" class="display data_table table-border-gray" style="width:100%">' +
                        '<thead>' +
                            '<tr>' +
                                '<th>{{ __('sidebar-waiting_approval-site_permit-index1.id_language') }}</th>' +
                                '<th class="text-dark">{{ __('sidebar-waiting_approval-site_permit-index1.status_language') }}</th>' +
                                '<th>{{ __('sidebar-waiting_approval-site_permit-index1.region_language') }}</th>' +
                                '<th>{{ __('sidebar-waiting_approval-site_permit-index1.site_language') }}</th>' +
                                '<th>{{ __('sidebar-waiting_approval-site_permit-index1.time_language') }}</th>' +
                                '<th>{{ __('sidebar-waiting_approval-site_permit-index1.officer_language') }}</th>' +
                                '<th>{{ __('sidebar-waiting_approval-site_permit-index1.created-by_language') }}</th>' +
                                '<th class="text-center"> </th>' +
                            '</tr>' +
                        '</thead>' +
                    '</table>';
        return table;
    }
    function setPermit(){
        var table = '<table id="data_table" class="display data_table table-border-gray" style="width:100%">' +
                        '<thead>' +
                            '<tr>' +
                                '<th>{{ __('sidebar-waiting_approval-site_permit-index1.id2_language') }}</th>' +
                                '<th class="text-dark">{{ __('sidebar-waiting_approval-site_permit-index1.activity-no_language') }}</th>' +
                                '<th>{{ __('sidebar-waiting_approval-site_permit-index1.site3_language') }}</th>' +
                                '<th>{{ __('sidebar-waiting_approval-site_permit-index1.applicant_language') }}</th>' +
                                '<th>{{ __('sidebar-waiting_approval-site_permit-index1.date-of-filing_language') }}</th>' +
                                '<th>{{ __('sidebar-waiting_approval-site_permit-index1.status2_language') }}</th>' +
                                '<th> </th>' +
                            '</tr>' +
                        '</thead>' +
                    '</table>';
        return table;
    }
    
    $(document).ready(function(){
        if(type === 'permit-letter'){
            table = setPermit();
            wrapper.html(table);
            initPermit(param)
        }else{
            table = setEntry();
            wrapper.html(table);
            initEntry(param)
        }
        
        $(document).on('change', '.select_site', function(e){
            e.preventDefault();
            var ini = $(this);
            param.id_site = ini.val();
            type = $('.select_type').val();
            if(type === 'permit-letter'){
                console.log(1);
                initPermit(param);
            }else{
                initEntry(param);
                console.log(2);
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
            "destroy": true,
            "bDestroy": true,
            "ajax": {
                "url": "/api/waiting_approval/site-permit/getSiteEntry",
                "data": param,
                "error": function (xhr, error, thrown) {
                    ajax_fail(xhr, error);
                }
            },
            "columns": [
                { "data": "id_site_entry" },
                { "data": "status" },
                { "data": "region.region_name" },
                { "data": "site.name_site" },
                { "data": "entry_datetime" },
                { "data": "jumlah_petugas" },
                { "data": "created_by_name" },
                { "data": "id_site_entry" }
            ],
            "columnDefs": [
                    {
                        "targets" : 1,
                        "data": "id_site_entry",
                        "render" : function (data, type, row) {
                           return '<a href="/waiting_approval/site-permit/site-entry-detail/'+row.id_site_entry+'">'+row.status+'</a>';
                        }
                    },
                    {
                        "targets" : 7,
                        "data": "id_site_entry",
                        "render" : function (data, type, row) {
                            if(row.approver_1_status != "APPROVED"){
                                return '<a class="btn btn-sm col-md-12 btn-transparent cursor-default" href="#">Waiting for Approval</a>';
                            }else if(row.approver_2_status != "APPROVED"){
                                return '<a class="btn btn-sm col-md-12 btn-transparent cursor-default" href="#">Waiting for Approval</a>';
                            }
                            if(row.approver_1_status == "APPROVED" && row.approver_2_status == "APPROVED"){
                                return '<a class="btn btn-sm col-md-12 btn-default" target="new" href="/site-permit/site-entry-pdf?id='+row.id_site_entry+'">DOWNLOAD</a>';
                            }
                            return '<a class="btn btn-sm col-md-12 btn-transparent cursor-default" href="#">Waiting for Approval</a>';
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
    function initPermit(param){
        var table = $('#data_table').DataTable( {
            "destroy": true,
            "bDestroy": true,
            "ajax": {
                "url": "/api/waiting_approval/site-permit/getPermitLetter",
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
                           return '<a href="/waiting_approval/site-permit/permit-letter-detail/'+row.id_permit_letter+'">'+row.activity_no+'</a>';
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
