<div class="row justify-content-around ">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Status</h3></div>
            <div class="card-body" id="card_by_status"></div>
            <div class="donut-legend text-center"></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header"><h3 class="card-title">This Week</h3></div>
            <div class="card-body" id="card_this_week"></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Count per Region</h3></div>
            <div class="card-body" id="card_by_region"></div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><h3 class="card-title">This Month</h3></div>
            <div class="card-body" id="card_this_month"></div>
        </div>
    </div>

    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Count per Site</h3></div>
            <div class="card-body" id="card_by_site"></div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    var param = {id_task_type:1}
    initDashboard(param);
    
    function emptyCharts(){
        $('#card_by_status').html('')
        $('#card_this_week').html('')
        $('#card_this_month').html('')
        $('#card_by_region').html('')
        $('#card_by_site').html('')   
    }
    
    function initDashboard(param){
        $.get('/api/getPermitLetterDashboardData', param, function(response){
            var data = response;
            
            by_status = data.by_status;
            putChart($('#card_by_status'), 'by_status', 'Status', by_status.colors, by_status.labels, by_status.dataset, 'DONUT', 'PERMIT_LETTER_STATUS');
            
            this_week = data.this_week;
            putChart($('#card_this_week'), 'this_week', 'ThisWeek', '#007bff', this_week.labels, this_week.dataset, 'LINE');
            
            this_month = data.this_month;
            putChart($('#card_this_month'), 'this_month', 'ThisMonth', '#007bff', this_month.labels, this_month.dataset, 'LINE');
            
            by_region = data.by_region;
            putChart($('#card_by_region'), 'by_region', 'by_region', '#007bff', by_region.labels, by_region.dataset, 'BAR', 'PERMIT_LETTER_REGION');
            
            by_site = data.by_site;
            putChart($('#card_by_site'), 'by_site', 'by_site', '#007bff', by_site.labels, by_site.dataset, 'BAR', 'PERMIT_LETTER_SITE');
        });
    }
    
</script>
@endpush